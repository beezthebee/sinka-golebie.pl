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
				$_SESSION['feedback'] = '<span style="color:red">Wpisz link!</span>';
				header('location: auctions.php');
				$connection->close();
				exit();
			}
			
			$check = "SELECT * FROM aukcje WHERE ID_GOLEBIA = '$pigeon_id'";
			if ($connection->query($check)->num_rows > 0){
				$_SESSION['feedback'] = '<span style="color:red">Gołąb jest już wystawiony na sprzedaż!</span>';
				header('location: auctions.php');
				$connection->close();
				exit();
			}
			$auction = $connection->query("INSERT INTO aukcje (ID_GOLEBIA, CENA, LINK, KONIEC) VALUES ('$pigeon_id', '$price', '$link', '$end')");
			if ($auction){
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie dodano nową aukcję.</span>';
				$subject = 'Nowy post';
				$message = 'Na stronie w zakładce "Sprzedaż" pojawiła się nowa oferta!
Kliknij, by odwiedzić stronę:
http://localhost/sinka/auctions.php';
				$headers = 'From: sinka.golebie@onet.pl' . "\r\n";
				$notif = $connection->query("SELECT EMAIL FROM uzytkownicy WHERE NOTIF=1");
				while ($email = $notif->fetch_assoc()) mail($email['EMAIL'], $subject, $message, $headers);
			}
			else
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się dodać .</span>';
			header('location: auctions.php');
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>