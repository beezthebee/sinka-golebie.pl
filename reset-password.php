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
		Reset hasła
		</header>
		
		<div class="wrapper">
			
			<?php
					
				require_once "connect.php";
		
				try {
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
					if ($connection->connect_errno!=0)
						throw new Exception(mysqli_connect_errno());
						
					else {
						if (isset($_SESSION['logged-in'])){
							$id = $_SESSION['id'];
							echo '<form action="save-password.php" method="post">
							<br>Obecne hasło:<br>
							<input type="password" name="curr_password" class="input" maxlength=20>
							<input type="hidden" name="id" class="input" value="'.$id.'"><br>';
							if (isset($_SESSION['e_password'])){
								echo $_SESSION['e_password'];
								unset($_SESSION['e_password']);
							}
						}
							
						else if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['code']) && !empty($_GET['code'])){
							$email = $_GET['email'];
							$code = $_GET['code'];
							
							$match = $connection->query("SELECT * FROM uzytkownicy WHERE EMAIL='$email' AND RESET_CODE='$code'");
							if ($match->num_rows > 0){
								$info = $match->fetch_assoc();
								
								$id = $info['ID'];
								$expire = $info['RESET_EXPIRE'];
								$date = date('Y-m-d H:i:s', time());
								
								if ($date > $expire){
									echo '<div class="content-news"><br><span style="color: red;">Link przedawnił się. Dokonaj ponownego resetu hasła.</span><br></div>
									<div class="content-news" style="margin: 0 10%; width: 80%;">
									<button class="button" onclick="location.href = \'forgot-password.php\';">Reset hasła</button>
									<button class="button" onclick="location.href = \'index.php\';">Wróć</button>
									</div>';
									$connection->close();
									exit();
								}
								
								else {
									echo '<form action="save-password.php" method="post">
									<input type="hidden" name="curr_password" value="reset_forgotten_password">
									<input type="hidden" name="id" value="'.$id.'">';
								}
							}
							else header('location: index.php');
						}
						
						else {
							header('location: index.php');
							$connection->close();
							exit();
						}
						
						echo '<br>Nowe hasło:<br>
						<input type="password" name="new_password1" class="input">
						<br><br>Powtórz nowe hasło:<br>
						<input type="password" name="new_password2" class="input"><br><br>';
						
						if (isset($_SESSION['e_identity'])){
							echo $_SESSION['e_identity'];
							unset($_SESSION['e_identity']);
						}
						
						if (isset($_SESSION['e_length'])){
							echo $_SESSION['e_length'];
							unset($_SESSION['e_length']);
						}
						
						echo '<button name="submit" class="button">Zapisz</button>
						<button class="button" onclick="location.href = \'edit-account.php\';">Anuluj</button>
						</form>';
						
					}
				}
					
				catch(Exception $e){
					echo '<span style="color:red">Błąd serwera. Spróbuj zresetować hasło w innym terminie.</span>';
				}					
				
				$connection->close();
			
			?>
				
		</div>
	</section>
	
	<footer>
		Adam Sinka 2021&copy. Wszelkie prawa zastrzeżone
	</footer>
	
</body>
</html>