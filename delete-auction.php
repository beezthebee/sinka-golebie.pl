<?php

	session_start();
	
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin' && isset($_POST['submit'])){
	
		require_once "connect.php";
						
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						
		if ($connection->connect_errno!=0){
			echo "Error: ".$connection->connect_errno;
		}
		
		else {
			$auction_id = $_POST['submit'];
			if (!$connection->query("DELETE FROM aukcje WHERE ID='$auction_id'")){
				$_SESSION['error'] = '<span style="color:red">Nie udało się usunąć aukcji!</span>';
			}
			
			header('Location: auctions.php');
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$connection->close();
?>