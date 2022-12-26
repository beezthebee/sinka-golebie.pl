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
	<link rel="stylesheet" href="raceeee.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	
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
		Nowy lot
		</header>
		
		<div class="wrapper">
			
			<?php if (isset($_SESSION['error'])) echo $_SESSION['error'];
				unset ($_SESSION['error']); ?>
			
			<form action="save-added-race.php" method="post" class="textholder-news" style="flex-direction: column; width: 80%;" id="add">
				<div class="content-news">Data:<input type="date" name="date" class="input"/></div>
									
				<div class="content-news">Miasto i dystans:
					<select name="location_id" class="input">
					<?php
						require_once "connect.php";
				
						try {
							$connection = new mysqli($host, $db_user, $db_password, $db_name);
							if ($connection->connect_errno!=0){
								throw new Exception(mysqli_connect_errno());
							}
										
							else {
								$options = $connection->query("SELECT * FROM lista_lotow ORDER BY MIASTO ASC");
								while ($result = $options->fetch_assoc()){
									echo '<option value="'.$result['ID'].'">'.$result['MIASTO'].', '.$result['DYSTANS'].'km</option>';
								}
							}
						}
										
						catch(Exception $e){
							echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
							exit();
						}
						
						$connection->close();
					?>
					</select></div>
											
				<div class="content-news">Wiek:
					<select name="category" class="input"/>
						<option value="D">stare</option>
						<option value="M">młode</option>
					</select>
				</div>
			</form>
					
				<div class="content-news" style="margin: 0 10%; width: 80%;">
				<input type="submit" value="Zapisz" name="submit" class="button" form="add"/>
				<input type="button" onclick="location.href = 'races.php';" value="Lista lotów" class="button"/>
				<input type="button" onclick="location.href = 'results.php';" value="Wyniki" class="button"/>
				</div>
				
		</div>
	</section>
	
	<footer>
		Adam Sinka 2021&copy. Wszelkie prawa zastrzeżone
	</footer>
	
</body>
</html>