<?php

	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
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
	
	<link rel="stylesheet" href="db-interface.css" />
	<link rel="stylesheet" href="races.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontello-4259d31d/css/fontello.css" type="text/css" />
	
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
	
	
	<section class="content" style="width: 90%;">
	
		<header class="greet">
		Baza danych
		</header>
			
		<div class="navigation">
			<a href="pigeons.php" class="linker-option">
				<div>Gołębie</div>
			</a>
					
			<a href="race-results.php" class="linker-option">
				<div>Wyniki</div>
			</a>
					
			<a href="races.php" class="linker-option">
				<div>Loty</div>
			</a>
				
		</div>
		
		<div class="wrapper">
			
			<?php
			
				include 'display-results.php';
			
			?>
		</div>
	</section>
	
	
	
	<footer>
		Adam Sinka 2021&copy. Wszelkie prawa zastrzeżone
	</footer>
	
</body>
</html>