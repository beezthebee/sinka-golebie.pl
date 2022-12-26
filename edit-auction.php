<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<meta name="description" content="Adam Sinka - hodowla gołębi" />
	<meta name="keywords" content="gołębie, gołebie, golebie, pocztowe, hodowla, slask, katowice" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="auctio.css" type="text/css" />
	<link rel="stylesheet" href="header-nav-f.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontell/css/fontello.css" type="text/css" />
	
	<script src="main.js"></script>

</head>

<?php
	
	include 'header-nav.php';
	
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin' && isset($_POST['submit'])){
		
		require_once "connect.php";
						
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						
		if ($connection->connect_errno!=0){
			echo "Error: ".$newpost_connection->connect_errno;
		}
		
		else {
			$auction_id = $_POST['submit'];
			$result = $connection->query("SELECT ID_GOLEBIA, CENA, LINK, KONIEC FROM aukcje WHERE ID='$auction_id'");
			if ($result){
				$auction = $result->fetch_assoc();
				$pigeon_id = $auction['ID_GOLEBIA'];
				$price = $auction['CENA'];
				$link = $auction['LINK'];
				$end = $auction['KONIEC'];
				
				echo '<section class="content">
			
					<header class="greet">
						Edytuj aukcję
					</header>

					<div class="wrapper" style="flex-direction: column;">
					
						<div class="textholder">
							<form action="save-edited-auction.php" method="post">';
							
							if (isset($_SESSION['feedback'])){
								echo '<br>'.$_SESSION['feedback'].'<br>';
								unset($_SESSION['feedback']);
							}
							
							echo '<br>Cena: <input type="number" name="price" value="'.$price.'" min=1 max=100000 class="input" /><br>
							<br>Kończy się: <input type="date" name="end" value="'.$end.'" class="input" /><br>
							<br>Link: <input type="url" name="link" value="'.$link.'" class="input" />';
								
							echo '<br><br><button type="submit" value="'.$auction_id.'" name="submit" class="button" />Zapisz</button><br>
							<input type="button" onclick="location.href = \'auctions.php\';" value="Wróć"class="button"/>
									
							</form>
						</div>
					</div>
				</section>';
			}
			
			else{
				$_SESSION['feedback'] = "Błąd serwera. Przepraszamy.";
				header("location: index.php");
			}
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$connection->close();
?>