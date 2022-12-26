<?php

	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin' || !isset($_POST['submit'])){
		header('Location: login.php');
		exit();
	}
	
	else {
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				$pigeon_id = $_POST['id'];
				$check = $connection->query(sprintf("SELECT * FROM golebie WHERE ID = '%s'", mysqli_real_escape_string($connection, $pigeon_id)))->fetch_assoc();
				if ($check != NULL){
					$_SESSION['feedback'] = "<span style='color:red'>Gołąb jest już obecny w bazie danych!<br><br></span>";
					header("location: add-pigeon.php");
					$connection->close();
					exit();
				}
				
				$sex = $_POST['sex'];
				
				require_once "functions.php";
				if (!empty($_FILES["picture"]["name"])) {
					$picture = valid_file("picture", "picture");
					if (!$picture){
						$connection->close();
						header("location: add-pigeon.php");
					}
				}
				else $picture = '';
				
				if (!empty($_FILES["pedigree"]["name"])) {
					$pedigree = valid_file("pedigree", "pedigree");
					if (!$pedigree){
						$connection->close();
						header("location: add-pigeon.php");
					}
				}
				else $pedigree = '';
				
				if (!$connection->query(sprintf("INSERT INTO golebie (ID, PLEC, RODOWOD, ZDJECIE) VALUES ('%s', '$sex', '$pedigree', '$picture')",
				mysqli_real_escape_string($connection, $pigeon_id)))){
					$_SESSION['feedback'] = "<span style='color:red'>Nie udało się dodać gołębia.<br><br></span>";
					header("location: add-pigeon.php");
					$connection->close();
					exit();
				}
				
				foreach ($_POST['breeders'] as $breeder){
					if (!$connection->query("INSERT INTO `gol-hod` (ID_GOLEBIA, ID_HODOWCY) VALUES ('$pigeon_id', '$breeder')")){
						$_SESSION['feedback'] = "<span style='color:red'>Nie udało się dodać gołębia.<br><br></span>";
						header("location: add-pigeon.php");
						$connection->close();
						exit();
					}
				}
				
				foreach ($_POST['lines'] as $line){
					if (!$connection->query("INSERT INTO `gol-lin` (ID_GOLEBIA, ID_LINII) VALUES ('$pigeon_id', '$line')")){
						$_SESSION['feedback'] = "<span style='color:red'>Nie udało się dodać gołębia.<br><br></span>";
						header("location: add-pigeon.php");
						$connection->close();
						exit();
					}
				}
				
				$_SESSION['feedback'] = "<span style='color:green'>Pomyślnie dodano gołębia.<br><br></span>";
				header('location: add-pigeon.php');
				
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
			exit();
		}
	}
	
	$connection->close();
?>