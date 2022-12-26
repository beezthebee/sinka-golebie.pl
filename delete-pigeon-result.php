<?php

	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['delete'])){
		header('Location: race-results.php');
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
				$_SESSION['error'] = 'Wybierz wyniki do usunięcia!';
				header('Location: race-results.php');
				exit();
			}
			
			foreach ($_POST['checkbox'] as $id){
				$connection->query("DELETE FROM wyniki WHERE ID='$id'");
			}
			
			header('Location: race-results.php');
			exit();
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
?>