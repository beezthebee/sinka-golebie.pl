<?php

	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['submit'])){
		header('Location: races.php');
		exit();
	}
  
    require_once "connect.php";
				
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
					
		else {
			if ($_POST['search'] == NULL){
				$_SESSION['error'] = 'Wpisz szukane hasło!';
				header('Location: races.php');
				exit();
			}
			
			$search = htmlspecialchars($_POST['search']);
			
			$_SESSION['search'] = "WHERE DATA LIKE '%$search%' OR MIASTO LIKE '%$search%' OR DYSTANS LIKE '%$search%' OR KATEGORIA LIKE '%$search%'";
			
			header('Location: races.php');
			exit();
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
?>