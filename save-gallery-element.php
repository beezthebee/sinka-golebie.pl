<?php
	
	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['submit'])){
		header('Location: add-gallery-element.php');
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
			
			if ($result = $connection->query("INSERT INTO galeria (ID_GOLEBIA) VALUES ('$pigeon_id')")) {
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie dodano element do galerii.<br><br></span>';
				
				$subject = 'Nowy gołąb w galerii';
				$message = 'Na stronie w zakładce "Galeria" pojawił się nowy gołąb!
Kliknij, by odwiedzić stronę:
http://localhost/sinka/gallery.php';
				$headers = 'From: sinka.golebie@onet.pl' . "\r\n";
				$notif = $connection->query("SELECT EMAIL FROM uzytkownicy WHERE NOTIF=1");
				while ($email = $notif->fetch_assoc()) mail($email['EMAIL'], $subject, $message, $headers);
			}
			
			else
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się dodać elementu do galerii!<br><br></span>';
			
			header('location: gallery.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>