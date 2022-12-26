<?php

	session_start();
	
	if (isset($_SESSION['logged-in']) && $_SESSION['type'] == 'admin' && isset($_POST['submit'])){
		
		if ($_POST['title'] == NULL){
			$_SESSION['feedback'] = '<span style="color:red">Podaj tytuł!</span>';
			header("location: edit-post.php");
			exit();
		}
		if ($_POST['content'] == NULL){
			$_SESSION['feedback'] = '<span style="color:red">Podaj treść!</span>';
			header("location: edit-post.php");
			exit();
		}
	
		require_once "connect.php";
						
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						
		if ($connection->connect_errno!=0){
			echo "Error: ".$connection->connect_errno;
		}
		
		else {
			$title = $_POST['title'];
			$content = $_POST['content'];
			$date = date('Y-m-d', time());
			
			if (!empty($_FILES["media"]["name"])) {
				require_once "functions.php";
				$file = valid_file("media", "picture");
				if (!$file){
					$connection->close();
					header("location: edit-post.php");
				}
			}
			else $file="";
			
			if ($result = $connection->query(sprintf("INSERT INTO posty (TITLE, CONTENT, MEDIA, DATE) VALUES ('%s', '%s', '$file', '$date')",
			mysqli_real_escape_string($connection, $title),
			mysqli_real_escape_string($connection, $content)))){
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie dodano posta.</span>';
				
				$subject = 'Nowy post';
				$message = 'Na stronie w zakładce "Strona główna" pojawił się nowy post!
				Kliknij, by odwiedzić stronę:
				http://localhost/sinka/index.php';
				$headers = 'From: sinka.golebie@onet.pl' . "\r\n";
				$notif = $connection->query("SELECT EMAIL FROM uzytkownicy WHERE NOTIF=1");
				while ($email = $notif->fetch_assoc()) mail($email['EMAIL'], $subject, $message, $headers);
			}
			
			else {
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się dodać posta!</span>';
			}
			
			header('Location: index.php');
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$newpost_connection->close();
?>