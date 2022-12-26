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
			$price = $_POST['price'];
			$end = $_POST['end'];
			$link = $_POST['link'];
			
			if (!$connection->query("UPDATE aukcje SET CENA='$price', LINK='$link', KONIEC='$end' WHERE ID='$auction_id'")){
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się zedytować aukcji!<br><br></span>';
			}
			else{
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie zedytowano aukcję.<br><br></span>';
			}
			
			header('Location: auctions.php');
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$connection->close();
?>