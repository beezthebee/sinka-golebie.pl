<?php
	
	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['submit'])){
		header('Location: add-race.php');
		exit();
	}
	
	require_once "connect.php";
				
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
					
		else {
			$date = $_POST['date'];
			$location_id = $_POST['location_id'];
			$category = $_POST['category'];
			
			if ($date == '0000-00-00' || $location_id == NULL || $category == NULL) {
				$_SESSION['error'] = 'Wypełnij wszystkie pola!';
				header('Location: add-race.php');
				$connection->close();
				exit();
			}
			
			
			// check if the race is already in the database
			
			$if_present = $connection->query(sprintf("SELECT * FROM loty WHERE DATA='$date' AND ID_LOTU = '$location_id' AND KATEGORIA='$category'", mysqli_real_escape_string($connection, $city)))->num_rows;
			
			if ($if_present > 0){
				$_SESSION['error'] = 'Lot znajduje się już w bazie danych!';
				header('Location: add-race.php');
				$connection->close();
				exit();
			}
			
			if (!$result = $connection->query("INSERT INTO loty (ID_LOTU, DATA, KATEGORIA) VALUES ('$location_id', '$date', '$category'")){
				$_SESSION['error'] = 'Nie udało się dodać lotu!';
			}
			
			header('Location: add-race.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>