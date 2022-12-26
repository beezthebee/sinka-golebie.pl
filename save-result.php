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
	
	if ($_POST['link'] == NULL){
		$_SESSION['feedback'] = '<span style="color:red">Podaj link!</span>';
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
			$race_id = $_POST['race'];
			$link = $_POST['link'];
				
			$insert = $connection->query("INSERT INTO wyniki (ID_LOTU, LINK) VALUES ('$race_id', '$link')");
			if ($insert){
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie dodano wynik.</span>';
				$subject = 'Nowy wynik';
				$message = 'Na stronie w zakładce "Wyniki" pojawił się nowy wynik!
Kliknij, by odwiedzić stronę:
http://localhost/sinka/results.php';
				$headers = 'From: sinka.golebie@onet.pl' . "\r\n";
				$notif = $connection->query("SELECT EMAIL FROM uzytkownicy WHERE NOTIF=1");
				while ($email = $notif->fetch_assoc()) mail($email['EMAIL'], $subject, $message, $headers);
			}
			else 
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się dodać wyniku.</span>';
			header('location: results.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>