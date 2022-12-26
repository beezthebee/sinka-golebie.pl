<?php

	session_start();
	
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true){
		header('Location: index.php');
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
	
	<link rel="stylesheet" href="gin.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />

</head>

<body>
	
	<nav class="menu">
		
		<div class="containerlogo">
			<img src="img/logo.jpg">
		</div>
	
	</nav>
	
	
	<section class="content">
	
		<header class="greet">
		Zaloguj się
		</header>

		<div class="wrapper">
			
			<form action="logging-in.php" method="post">
			<br>Login: <br><input type="text" name="login" class="input"/><br>
			<br>Hasło: <br><input type="password" name="password" class="input"/><br>
			<a href="forgot-password.php" class="forgot-pass">Zapomniałem hasła</a><br><br>
			
			<?php
			
				if (isset($_SESSION['feedback'])) {
					echo $_SESSION['feedback'].'<br>';
					unset($_SESSION['feedback']);
				}
			
			?>
			
			<input type="submit" value="zaloguj się" class="button"/><br>
			<input type="button" onclick="location.href = 'index.php';" value="Wróć" class="button"/>
			</form>
		</div>
	</section>
	
	<?php
		include "footer.php"
	?>
	
</body>
</html>