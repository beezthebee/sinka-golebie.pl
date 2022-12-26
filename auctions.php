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

</head>

<body>
	
	<?php include 'header-nav.php'; ?>
	
	<section class="content">
	
		<header class="greet">
		Sprzedaż
		</header>

		<div class="wrapper">
			
			<?php 
			
			if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin'){
			
				require_once "connect.php";
				mysqli_report(MYSQLI_REPORT_STRICT);
				try {
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
				
					if ($connection->connect_errno!=0){
						throw new Exception(mysqli_connect_errno());
					}
					
					echo '<form action="save-auction.php" method="post" id="add" class="textholder">
					<header class="title">Dodaj nową aukcję</header>';
						
					if (isset($_SESSION['feedback'])){
						echo '<br>'.$_SESSION['feedback'];
						unset($_SESSION['feedback']);
					}
					
					echo '<br>Numer: <select name="id" class="input">';
						if ($result = $connection->query("SELECT ID FROM golebie WHERE ID NOT IN (SELECT ID_GOLEBIA FROM aukcje)")){
							while ($row = $result->fetch_assoc()){
								echo '<option value="'.$row['ID'].'">'.$row['ID'].'</option>';
							}
						}
					
					echo '</select><br>
					<br>Cena: <input type="number" name="price" min=1 max=100000 class="input" /><br>
					<br>Kończy się: <input type="date" name="end" class="input" /><br>
					<br>Link: <input type="url" name="link" class="input" />';
						
					echo '<br><br><button type="submit" name="submit" form = "add" class="button" />Zapisz</button><br>
					</form>';
				}
				
				catch(Exception $e){
				echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
				exit();
				}
			}
			
			include 'display-auctions.php'; ?>
			
		</div>
	</section>
	
	<?php include 'footer.php'; ?>
</body>
</html>