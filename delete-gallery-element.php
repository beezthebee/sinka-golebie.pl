<?php

	session_start();
	
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin' && isset($_POST['submit'])){
	
		require_once "connect.php";
						
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						
		if ($connection->connect_errno!=0){
			echo "Error: ".$connection->connect_errno;
		}
		
		else {
			$pigeon_id = $_POST['submit'];
			if ($connection->query("DELETE FROM galeria WHERE ID_GOLEBIA='$pigeon_id'"))
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie usunięto element z galerii.<br><br></span>';
			
			else
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się usunąć elementu z galerii!<br><br></span>';
			
			header('Location: gallery.php');
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$connection->close();
?>