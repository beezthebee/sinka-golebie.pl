<?php

	session_start();
	
	if (!isset($_POST['submit'])){
		header('location: forgot-password.php');
		exit();
	}
		
	else{
		$email = $_POST['email'];
		$validation = true;
		
		// validating email
		$email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if (filter_var($email_sanitized, FILTER_VALIDATE_EMAIL) == false || $email_sanitized != $email){
			$validation = false;
			$_SESSION['e_email'] = '<span style="color:red">Podaj poprawny adres e-mail! <br></span>';
		}
		
		if ($email == NULL){
			$validation = false;
			$_SESSION['e_email'] = '<span style="color:red">Podaj email!<br></span>';
		}
		
		//checking if given login/email is already present in database
		require_once "connect.php";
		
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				//checking if email is already present
				if ($check_email = $connection->query("SELECT ID FROM uzytkownicy WHERE EMAIL = '$email'")){
					if ($check_email->num_rows == 0){
						$validation = false;
						$_SESSION['feedback'] = '<span style="color:red">Konto o tym adresie e-mail nie istnieje! <br></span>';
					}
				}
				
				//if all tests have been passed
				if ($validation == true){
					$code = md5(rand(0, 1000));
			
					if ($result = $connection->query("UPDATE uzytkownicy SET RESET_CODE='$code', RESET_EXPIRE=now() + INTERVAL 1 DAY WHERE EMAIL='$email'")){
						$to = $email;
						$subject = 'Reset hasła';
						$message = 'Po kliknięciu w poniższy link będziesz mógł ponownie wybrać swoje hasło. 
Informujemy, że po upływie jednego dnia od momentu wysłania maila link przedawni się, a w celu zmiany hasła konieczne będzie otrzymanie nowego linka.

Link do resetu hasła:
http://localhost/sinka/reset-password.php?email='.$email.'&code='.$code;
						$headers = 'From: sinka.golebie@onet.pl' . "\r\n";
						$mail = mail($to, $subject, $message, $headers);
						
						$_SESSION['feedback'] = '<span style="color:green"><br>Zresetuj swoje hasło klikając w link, który został wysłany na Twój adres e-mail.<br></span>';
					}
					else
						$_SESSION['feedback'] = '<span style="color:red">Błąd serwera. Spróbuj dokonać resetu hasła w innym terminie.<br><br></span>';
				}
				header ('Location: forgot-password.php');
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Spróbuj dokonać rejestracji w innym terminie.</span>';
		}
		
		$connection->close();
	}

?>