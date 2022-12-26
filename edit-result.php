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
		Edytuj wynik
		</header>
		
		<div class="wrapper">
			
			<?php
			
				require_once "connect.php";
				
				mysqli_report(MYSQLI_REPORT_STRICT);
				
				try {
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
					if ($connection->connect_errno!=0){
						throw new Exception(mysqli_connect_errno());
					}
					
					else {
					
					if (!isset($_SESSION['id_result'])) $_SESSION['id_result'] = $_POST['id'];
					$id = $_SESSION['id_result'];
					
					$result = $connection->query(sprintf("SELECT * FROM wyniki WHERE ID = '$id'"));
					$row = $result->fetch_assoc();
					
					if (isset($_SESSION['error'])) echo $_SESSION['error'].'<br>';
					unset($_SESSION['error']);
					
					echo '<form action="save-result.php" method="post" class="textholder-news">
							<input type="text" name="date" value="'.$row['DATA'].'" class="content-news" " />
							
							<input type="text" name="pigeon_id" value="'.$row['ID_GOLEBIA'].'" class="content-news" " />
										
							<input type="text" name="city" value="'.$row['MIASTO'].'" class="content-news" />
											
							<input type="text" name="distance" value="'.$row['DYSTANS'].'" class="content-news" />
											
							<input type="text" name="category" value="'.$row['KATEGORIA'].'" class="content-news"/>
							
							<input type="text" name="time" value="'.$row['CZAS'].'" class="content-news"/>
							
							<input type="hidden" value="'.$id.'" name="id"/>
										
						</div><br><br>
						<input type="submit" value="Zapisz" name="submit"/>
						<input type="button" onclick="history.back();" value="Anuluj" />
						</form>';
					}
				}
					
				catch(Exception $e){
					echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
					exit();
				}
			
			?>
		</div>
	</section>
	
	<footer>
		Adam Sinka 2021&copy. Wszelkie prawa zastrzeżone
	</footer>
	
</body>
</html>