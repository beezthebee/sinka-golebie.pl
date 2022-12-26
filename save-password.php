<?php

	session_start();
	
	if (!isset($_POST['submit'])){
		header('location: forgot-password.php');
		exit();
	}
	
	require_once "connect.php";
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
				
		else {
			$id = $_POST['id'];
			$info = $connection->query("SELECT * FROM uzytkownicy WHERE ID='$id'")->fetch_assoc();
			$curr_password = $_POST['curr_password'];
			if ($curr_password != "reset_forgotten_password"){
				$user_id = $_SESSION['id'];
				if (!password_verify($curr_password, $info['PASS'])){
					$_SESSION['e_password'] = '<span style="color:red">Niepoprawne hasło.</span><br>';
					header('location: http://localhost/sinka/reset-password.php?email='.$info['EMAIL'].'&code='.$info['RESET_CODE']);
					$connection->close();
					exit();
				}
			}
				
			$new_password1 = $_POST['new_password1'];
			$new_password2 = $_POST['new_password2'];
			$validation = true;
				
			if ($new_password1 != $new_password2){
				$validation = false;
				$_SESSION['e_identity'] = '<span style="color:red">Podane hasła nie są identyczne! <br></span>';
				header('location: http://localhost/sinka/reset-password.php?email='.$info['EMAIL'].'&code='.$info['RESET_CODE']);
			}
				
			if (strlen($new_password1) < 8 || strlen($new_password1) > 20){
				$validation = false;
				$_SESSION['e_length'] = '<span style="color:red">Hasło musi posiadać od 8 do 20 znaków! <br></span>';
				header('location: http://localhost/sinka/reset-password.php?email='.$info['EMAIL'].'&code='.$info['RESET_CODE']);
			}
				
			if ($new_password1 == NULL && $new_password2 == NULL){
				$validation = false;
				$_SESSION['e_length'] = '<span style="color:red">Podaj hasło!<br></span>';
				header('location: http://localhost/sinka/reset-password.php?email='.$info['EMAIL'].'&code='.$info['RESET_CODE']);
			}
				
			if ($validation){
				$update = $connection->query(sprintf("UPDATE uzytkownicy SET PASS='%s', RESET_CODE='' WHERE ID='$id'",
				mysqli_real_escape_string($connection, password_hash($new_password1, PASSWORD_DEFAULT))));
				if ($update)
					$_SESSION['feedback'] = '<span style="color:green">Pomyślnie zresetowano hasło.<br></span>';
				else
					$_SESSION['feedback'] = '<span style="color:red">Nie udało się zresetować hasła.<br></span>';
				if (isset($_SESSION['logged-in'])) header('location: edit-account.php');
				else header('location: login.php');
			}
		}
	}
			
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Spróbuj dokonać rejestracji w innym terminie.</span>';
	}
	$connection->close();
?>