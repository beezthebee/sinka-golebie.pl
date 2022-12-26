<?php
	
	session_start();
	
	if (!isset($_SESSION['logged-in'])){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['submit'])){
		header('Location: user-panel.php');
		exit();
	}
	
	require_once "connect.php";
				
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
					
		else {
			$user_id = $_POST['submit'];
			$login = $_POST['login'];
			$email = $_POST['email'];
			if (isset($_POST['notif'])) $notif = 1;
			else $notif = 0;
			
			$validation = true;
			
			// validating login
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
					$_SESSION['e_login'] = '<span style="color:red">Login może składać się tylko z liter i cyfr (bez polskich znaków)! <br></span>';
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
			
			if ($validation){
				$update = $connection->query("UPDATE uzytkownicy SET LOGIN='$login', EMAIL='$email', NOTIF='$notif' WHERE ID='$user_id'");
				if ($update)
					$_SESSION['feedback'] = '<span style="color:green; margin: 0 auto;">Pomyślnie zapisano zmiany.<br></span>';
					
				else 
					$_SESSION['feedback'] = '<span style="color:red">Nie udało się zapisać zmian.<br></span>';
				header('location: user-panel.php');
			}
			
			else header('location: edit-account.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>