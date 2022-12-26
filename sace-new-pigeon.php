<?php
	
	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['submit'])){
		header('Location: auctions.php');
		exit();
	}
	
	require_once "connect.php";
				
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
					
		else {
			$pigeon_id = $_POST['id'];
			$price = $_POST['price'];
			$end = $_POST['end'];
			$link = $_POST['link'];
			if ($link == NULL) {
				$_SESSION['error'] = '<span style="color:red">Wpisz link!</span>';
				header('location: auctions.php');
				$connection->close();
				exit();
			}
			
			$check = "SELECT * FROM aukcje WHERE ID_GOLEBIA = '$pigeon_id'";
			if ($connection->query($check)->num_rows > 0){
				$_SESSION['error'] = '<span style="color:red">Gołąb jest już wystawiony na sprzedaż!</span>';
				header('location: auctions.php');
				$connection->close();
				exit();
			}
			$connection->query("INSERT INTO aukcje (ID_GOLEBIA, CENA, LINK, KONIEC) VALUES ('$pigeon_id', '$price', '$link', '$end')");
			header('location: auctions.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>