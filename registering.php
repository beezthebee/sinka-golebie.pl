<?php

	session_start();
	
	if (!isset($_POST['submit'])){
		header('location: register.php');
		exit();
	}
		
	else{
		$login = $_POST['login'];
		$email = $_POST['email'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		if (isset($_POST['notif'])) $notif = 1;
		else $notif = 0;
		$captcha = "6LdVMnUeAAAAAM_56RPR1eU8LxM2RRsOItL-BQTt";
			
		$validation = true;
			
		if (strlen($login) < 3 || strlen($login) > 25) {
			$validation = false;
			$_SESSION['e_login'] = '<span style="color:red">Login musi posiadać od 3 do 25 znaków! <br></span>';
		}
			
		$allowed = '/aąbcćdeęfghijklłmnńoóprsśtuvwxyzźżAĄBCĆDEĘFGHIJKLŁMNŃOÓPRSŚTUVWXYZŹŻ0123456789 /';
		$space_count = 0;
			
		foreach (mb_str_split($login) as $char){
			$char = '/'.$char.'/';
			if (!preg_match($char, $allowed)){
				$validation = false;
				$_SESSION['e_login'] = '<span style="color:red">Login może składać się tylko z liter, cyfr i spacji! <br></span>';
			}
			if ($char == '/ /') $space_count++;
		}
			
		if ($space_count > 2) {
			$validation = false;
			$_SESSION['e_login'] = '<span style="color:red">Login może zawierać do 2 spacji!<br></span>';
		}
			
		if ($login == NULL || strlen($login) == $space_count){
			$validation = false;
			$_SESSION['e_login'] = '<span style="color:red">Podaj login!<br></span>';
		}
		
		
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
		
		
		// validating password
		if ($password1 != $password2){
			$validation = false;
			$_SESSION['e_password_identity'] = '<span style="color:red">Podane hasła nie są identyczne! <br></span>';
		}
		
		if (strlen($password1) < 8 || strlen($password1) > 20){
			$validation = false;
			$_SESSION['e_password_length'] = '<span style="color:red">Hasło musi posiadać od 8 do 20 znaków! <br></span>';
		}
		
		if ($password1 == NULL && $password2 == NULL){
			$validation = false;
			$_SESSION['e_password_length'] = '<span style="color:red">Podaj hasło!<br></span>';
		}
		
		
		//checking for acceptance of terms of service
		if (!isset($_POST['tos'])){
			$validation = false;
			$_SESSION['e_checkbox'] = '<span style="color:red">Potwierdź akceptację regulaminu! <br></span>';
		}
		
		
		//checking for reCAPTCHA validation
		$captcha_check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$captcha.'&response='.$_POST['g-recaptcha-response']);
		
		$response = json_decode($captcha_check);
		
		if (!$response->success){
			$validation = false;
			$_SESSION['e_captcha'] = '<span style="color:red">Potwierdź, że jesteś człowiekiem! <br><br></span>';
		}
		
		
		//checking if given login/email is already present in database
		require_once "connect.php";
		
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				
				//checking if login is already present
				
				if ($check_login = $connection->query("SELECT ID FROM uzytkownicy WHERE LOGIN = '$login'")){
					if ($check_login->num_rows > 0){
						$validation = false;
						$_SESSION['e_login'] = '<span style="color:red">Ten login jest już zajęty!
						Wybierz inny.<br></span>';
					}
				}
				
				//checking if email is already present
				if ($check_email = $connection->query("SELECT ID FROM uzytkownicy WHERE EMAIL = '$email'")){
					if ($check_email->num_rows > 0){
						$validation = false;
						$_SESSION['e_email'] = '<span style="color:red">Konto o tym adresie e-mail już istnieje! <br></span>';
					}
				}
				
				if (!$check_login || !$check_email){
					$_SESSION['feedback'] = '<span style="color:red">Błąd serwera. Spróbuj dokonać rejestracji w innym terminie. <br></span>';
					$connection->close();
					header ('Location: register.php');
				}
				
				//if all tests have been passed
				if ($validation == true){
					$code = md5(rand(0, 1000));
			
					if ($result = $connection->query(sprintf("INSERT INTO uzytkownicy (LOGIN, PASS, EMAIL, NOTIF, TYPE, CODE, EXPIRE, ACTIVE) VALUES ('%s', '%s', '%s', '$notif', 'common', '$code', now() + INTERVAL 1 DAY, 0)",
					mysqli_real_escape_string($connection, $login),
					mysqli_real_escape_string($connection, password_hash($password1, PASSWORD_DEFAULT)),
					mysqli_real_escape_string($connection, $email)))){
						$to = $email;
						$subject = 'Aktywacja konta';
						$message = 'Dziękujemy za założenie konta!
Po kliknięciu w poniższy link Twoje konto zostanie aktywowane. Informujemy, że po upływie jednego dnia od momentu rejestracji link przedawni się, a w celu aktywacji konta konieczna będzie ponowna rejestracja.

Link aktywacyjny:
http://localhost/sinka/activate-account.php?email='.$email.'&code='.$code;
						$headers = 'From: sinka.golebie@onet.pl' . "\r\n";
						$mail = mail($to, $subject, $message, $headers);
						
						$_SESSION['feedback'] = '<span style="color:green"><br>Rejestracja udana!<br>Aktywuj konto klikając w link, który został wysłany na Twój adres e-mail.<br></span>';
					}
					else
						$_SESSION['feedback'] = '<span style="color:red">Błąd serwera. Spróbuj dokonać rejestracji w innym terminie.<br><br></span>';
				}
				header ('Location: register.php');
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Spróbuj dokonać rejestracji w innym terminie.</span>';
		}
		
		$connection->close();
	}

?>