<?php

	session_start();

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
	
	<link rel="stylesheet" href="llll.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontell/css/fontello.css" type="text/css" />
	
	<script src="main.js"></script>

</head>

<body>
	
	<nav class="menu">
		
		<div class="containerlogo">
		
			<div id="containerimg">
				<img src="img/herb.png" width="50" height="60">
			</div>
			
			<div id="containertxt">
				<div id="minilogo1">
					Adam
				</div>
				
				<div id="minilogo2">
					Sinka
				</div>
			</div>
		</div>
	
	</nav>
	
	
	<section class="content">
	
		<header class="greet">
		Aktywacja konta
		</header>
		
		<div class="wrapper">
			
			<?php 
			
				if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['code']) && !empty($_GET['code'])){
					$email = $_GET['email'];
					$code = $_GET['code'];
					
					require_once "connect.php";
		
					try {
						$connection = new mysqli($host, $db_user, $db_password, $db_name);
						if ($connection->connect_errno!=0){
							throw new Exception(mysqli_connect_errno());
						}
						
						else {
							$match = $connection->query("SELECT * FROM uzytkownicy WHERE EMAIL='$email' AND CODE='$code'");
							if ($match->num_rows > 0){
								$expire = $match->fetch_assoc()['EXPIRE'];
								$date = date('Y-m-d H:i:s', time());
								if ($date > $expire){
									echo '<div class="content-news"><br><span style="color: red;">Link 
									przedawnił się. Dokonaj ponownej rejestracji.</span><br></div>
									<div class="content-news" style="margin: 0 10%; width: 80%;">
									<button class="button" onclick="location.href = \'register.php\';">Rejestracja</button>
									<button class="button" onclick="location.href = \'index.php\';">Wróć</button>
									</div>';
								}
								else {
									$activate = $connection->query("UPDATE uzytkownicy SET ACTIVE=1 WHERE EMAIL='$email' AND CODE='$code'");
									if ($activate){
										echo '<div class="content-news"><br><span style="color: green;">Twoje konto zostało aktywowane!</span><br></div>
										<div class="content-news" style="margin: 0 10%; width: 80%;">
										<button class="button" onclick="location.href = \'login.php\';">Zaloguj się</button>
										<button class="button" onclick="location.href = \'index.php\';">Wróć</button>
										</div>';
									}
									
									else echo '<div class="content-news"><br><span style="color: red;">Nie udało się aktywować konta.</span><br></div>
									<div class="content-news" style="margin: 0 10%; width: 80%;">
									<button class="button" onclick="location.href = \'index.php\';">Wróć</button>
									</div>';
								}
							}
							else header('location: index.php');
						}
					}
					
					catch(Exception $e){
						echo '<span style="color:red">Błąd serwera. Spróbuj aktywować konto w innym terminie.</span>';
					}
					
					$connection->close();
				}
				
				else {
					header('location: index.php');
				}
			
			?>
				
		</div>
	</section>
	
	<footer>
		Adam Sinka 2021&copy. Wszelkie prawa zastrzeżone
	</footer>
	
</body>
</html>