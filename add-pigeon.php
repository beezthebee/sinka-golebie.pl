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
	<link rel="stylesheet" href="raceeeee.css" />
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
		Nowy gołąb
		</header>
		
		<div class="wrapper">
			

			
			<form action="save-new-pigeon.php" method="post" class="textholder-news" style="flex-direction: column; width: 80%;" id="add" enctype="multipart/form-data">
				<div class="content-news">
					<?php 
						if (isset($_SESSION['feedback'])) {
							echo $_SESSION['feedback'];
							unset ($_SESSION['feedback']);
						}
					?>
					<b>Numer:</b><input type="text" name="id" class="input"/>
				</div>
				<?php 
					if (isset($_SESSION['e_id'])) {
						echo $_SESSION['e_id'];
						unset ($_SESSION['e_id']);
					}
				?>
									
				<div class="content-news"><b>Płeć:</b><select name="sex" class="input"/>
						<option value="samiec">samiec</option>
						<option value="samica">samica</option>
					</select>
				</div>
				
				<?php
					require_once "connect.php";
		
					mysqli_report(MYSQLI_REPORT_STRICT);
		
					try {
						$connection = new mysqli($host, $db_user, $db_password, $db_name);
						
						if ($connection->connect_errno!=0){
							throw new Exception(mysqli_connect_errno());
						}
			
						else {
							$breeders = $connection->query("SELECT * FROM hodowcy");
							if ($breeders){
								echo '<div class="content-news"><b>Hodowca(y): </b></div>';
								while ($breeder_info = $breeders->fetch_assoc()){
									echo '<div class="content-news">
									<input type="checkbox" form="add" name="breeders[]" value="'.$breeder_info['ID_HODOWCY'].'"/>'.$breeder_info['IMIE'].' '.$breeder_info['NAZWISKO'].'
									</div>';
								}
								echo '<br>';
							}
							
							$lines = $connection->query("SELECT * FROM linie");
							if ($breeders){
								echo '<div class="content-news"><b>Linia(e): </b></div>';
								while ($line_info = $lines->fetch_assoc()){
									echo '<div class="content-news">
									<input type="checkbox" form="add" name="lines[]" value="'.$line_info['ID_LINII'].'"/>'.$line_info['NAZWA'].'
									</div>';
								}
								echo '<br><br>';
							}
						}
					}
					catch(Exception $e){
						echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
						exit();
					}
				?>
											
				<div class="content-news"><b>Zdjęcie:</b><input type="file" name="picture" id="picture"/></div>
				<?php 
					if (isset($_SESSION['e_picture'])) {
						echo $_SESSION['e_picture'];
						unset ($_SESSION['e_picture']);
					}
				?>
				
				<div class="content-news"><b>Rodowód:</b><input type="file" name="pedigree" id="pedigree"/></div>
				<?php 
					if (isset($_SESSION['e_pedigree'])) {
						echo $_SESSION['e_pedigree'];
						unset ($_SESSION['e_pedigree']);
					}
				?>
				
				
			</form>
				<div class="content-news" style="margin: 0 10%; width: 80%;">
				<input type="submit" value="Zapisz" name="submit" form="add" class="button"/>
				<input type="button" onclick="location.href = 'pigeons.php'" value="Lista gołębi" class="button"/>
				<input type="button" onclick="location.href = 'gallery.php'" value="Galeria" class="button"/>
				</div>
				
		</div>
	</section>
	
	<footer>
		Adam Sinka 2021&copy. Wszelkie prawa zastrzeżone
	</footer>
	
</body>
</html>
</html>
</html>