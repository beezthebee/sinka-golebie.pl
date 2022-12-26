s<?php
	
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
			$delete_comments = $connection->query("DELETE FROM komentarze WHERE USER_ID = '$user_id'");
			if ($delete_comments){
				$delete_account = $connection->query("DELETE FROM uzytkownicy WHERE ID = '$user_id'");
				if ($delete_account){
					session_unset();
					session_start();
					$_SESSION['deleted'] = true;
					$_SESSION['feedback'] = '<span style="color:green"><br>Pomyślnie usunięto konto.<br></span>';
				}
				else
					$_SESSION['feedback'] = '<span style="color:red">Nie udało się usunąć konta.<br></span>';
				
			}
			else
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się usunąć konta.<br></span>';
			header('location: user-panel.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>