<?php

	session_start();
	
	if ((!isset($_SESSION['logged-in']) || !$_SESSION['logged-in']) && !isset($_SESSION['deleted'])){
		header('Location: login.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<meta name="description" content="Adam Sinka - hodowla gołębi" />
	<meta name="keywords" content="gołębie, gołebie, golebie, pocztowe, hodowla, slask, katowice" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="l.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontell/css/fontello.css" type="text/css" />

</head>

<body>
	
	<nav class="menu">
		
		<div class="containerlogo">
			<img src="img/logo.jpg">
		</div>
	
	</nav>
	
	
	<section class="content">
	
		<header class="greet">
		Panel użytkownika
		</header>

		<?php
		if (isset($_SESSION['deleted'])){
			unset($_SESSION['deleted']);
			echo $_SESSION['feedback'];
			unset($_SESSION['feedback']);
			echo '<button onclick="location.href = \'index.php\';" class="button">WRÓĆ</button>';
		}
		
		else{
			require_once 'connect.php';
			
			try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
				if ($connection->connect_errno!=0){
					throw new Exception(mysqli_connect_errno());
				}
							
				else {
					$user_id = $_SESSION['id'];
					$info = $connection->query("SELECT * FROM uzytkownicy WHERE ID='$user_id'");
					if (!$info){
						echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
						$connection->close();
						exit();						
					}
					else {
						$result = $info->fetch_assoc();
						$login = $result['LOGIN'];
						$email = $result['EMAIL'];
						$notif = $result['NOTIF'];
						
						echo '<form action="delete-account.php" method="post" id="delete"></form>
						<form action="edit-account.php" method="post">
							<div class="wrapper">
								<br><div class="content-news">Login: <br><b>'.$login.'</b></div>
								<div class="content-news">E-mail: <br><b>'.$email.'</b></div><br>
								<div class="content-news">Zgoda na otrzymywanie powiadomień i informacji handlowej: <br><b>';
								if ($notif) echo '<i class="icon-ok"></i>';
								else echo '<i class="icon-cancel"></i>';
								echo '</b></div><br>';
								
								if (isset($_SESSION['feedback'])){
									echo $_SESSION['feedback'];
									unset($_SESSION['feedback']);
								}
								
								echo '<div class="content-news" style="margin: 0 10%; width: 80%;">
									<button type="submit" name="submit" value="'.$user_id.'" class="button">EDYTUJ KONTO</button>
									<button type="submit" name="submit" form="delete" value="'.$user_id.'" class="button delete">USUŃ KONTO</button>
									<input type="button" onclick="location.href = \'index.php\';" value="Wróć" class="button"/>
								</div>
							</div>
						</form>';
					}
				}
			}
			
						
			catch(Exception $e){
				echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
				exit();
			}
		
			$connection->close();
		}
		?>
	</section>
	
	<footer>
		Adam Sinka 2021&copy. Wszelkie prawa zastrzeżone
	</footer>
	
</body>
</html>