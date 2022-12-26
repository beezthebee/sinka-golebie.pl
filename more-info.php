<?php

	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	$id = $_POST['id'];

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
	
	<link rel="stylesheet" href="login.css" />
	<link rel="stylesheet" href="gallery-element.css" />
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
			<?php echo $id; ?>
		</header>
	
	<?php
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				if ($result = $connection->query(sprintf("SELECT PLEC, HODOWCA, LINIA, RODOWOD, ZDJECIE FROM golebie WHERE golebie.ID = '$id'"))){
					while ($row = $result->fetch_assoc()){
						$sex = $row['PLEC'];
						$breeder = $row['HODOWCA'];
						$line = $row['LINIA'];
						$pedigree = base64_encode($row['RODOWOD']);
						$picture = base64_encode($row['ZDJECIE']);
						
						$_SESSION['query'] = "SELECT * FROM wyniki WHERE ID_GOLEBIA = '$id'";
						echo '<div class="wrapper">
			
							<div class="textholder">
								
								<div class="content" style="max-width: 300px;">
									<img src="data:image/png;base64,'.$picture.'"/>
								</div>
								
								<div class="content">
									Linia: <b>'.$line.'</b>
									<br>
									Linia: <b>'.$line.'</b>
									<br>
									Hodowca: <b>'.$breeder.'</b>';
									if ($pigeon_results = $connection->query(sprintf("SELECT MIASTO, DYSTANS, ROK, KATEGORIA, MIEJSCE, CZAS FROM loty, wyniki WHERE wyniki.ID_GOLEBIA = '$id' AND loty.ID = wyniki.ID_LOTU"))){
										while ($a_result = $pigeon_results->fetch_assoc()){
											$place = $a_result['MIEJSCE'];
											$time = $a_result['CZAS'];
											$city = $a_result['MIASTO'];
											$distance = $a_result['DYSTANS'];
											$year = $a_result['ROK'];
											$category = $a_result['KATEGORIA'];
											
										}
									}
								echo '<br><br>Pobierz rodowód:
										<a href="data:image/png;base64,'.$pedigree.'" download="rodowod'.$id.'">Rodowod '.$id.'</a>
								</div>
							</div>
							
							<div class="textholder" style="width: 100%; flex-direction: column; justify-content: center; border-radius: 0; box-shadow: none;">
								<header class="greet">
									Wyniki
								</header>';
								
								include 'display-results.php';
								
							echo '</div>
						</div>';
					}
				}
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
			exit();
		}

?>