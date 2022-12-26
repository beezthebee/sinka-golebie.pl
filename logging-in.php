<?php

	session_start();
	
	if (isset($_SESSION['logged-in'])){
		if ($_SESSION['logged-in'] == true){
			header('Location: index.php');
		}
		
		else {
			header('Location: login.php');
		}
		
		exit();
	}
	
	else {
	
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
		
			else {
				$login = $_POST['login'];
				$password = $_POST['password'];
				
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				
				if ($result = $connection->query(sprintf("SELECT * FROM uzytkownicy WHERE login='%s'",
				mysqli_real_escape_string($connection, $login)))){
					if ($result->num_rows > 0){
						$row = $result->fetch_assoc();
						$active = $row['ACTIVE'];
						
						if (password_verify($password, $row['PASS']) && $active){
						
							$_SESSION['logged-in'] = true;
							$_SESSION['username'] = $row['LOGIN'];
							$_SESSION['id'] = $row['ID'];
							$_SESSION['type'] = $row['TYPE'];
							header('Location: index.php');
						}
						
						else if (!$active){
							$_SESSION['feedback'] = '<span style="color:red">Konto nie zostało aktywowane. Aktywuj konto klikając w link wysłany na twój adres e-mail!</span><br>';
							header('Location: login.php');
						}
						
						else {
							$_SESSION['feedback'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span><br>';
							header('Location: login.php');
						}
					}
					
					else {
						$_SESSION['feedback'] = '<span style="color:red">Nieprawidłowy login lub hasło!<br></span>';
						header('Location: login.php');
					}
				}
			}
		}
		
		catch(Exception $e){
			$_SESSION['feedback'] = '<span style="color:red">Błąd serwera. Spróbuj zalogować się w innym terminie.</span>';
			header('Location: login.php');
		}
	}
	
	$connection->close();
?>