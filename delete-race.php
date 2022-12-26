<?php

	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['delete'])){
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
			if (!isset($_POST['checkbox'])){
				$_SESSION['error'] = 'Wybierz loty do usunięcia!';
				header('Location: races.php');
				exit();
			}
			
			foreach ($_POST['checkbox'] as $id){
				$connection->query("DELETE FROM wyniki WHERE ID_LOTU='$id'");
				$connection->query("DELETE FROM loty WHERE ID='$id'");
			}
			
			header('Location: races.php');
			exit();
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
?>