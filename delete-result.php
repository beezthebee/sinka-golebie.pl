<?php
	
	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['submit'])){
		header('Location: results.php');
		exit();
	}
	
	require_once "connect.php";
				
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
					
		else {
			$result_id = $_POST['submit'];
			$delete = $connection->query("DELETE FROM wyniki WHERE ID='$result_id'");
			if ($delete)
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie usunięto wynik.</span>';
			else
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się usunąć wyniku.</span>';
			header('location: results.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>