<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<meta name="description" content="Adam Sinka - hodowla gołębi" />
	<meta name="keywords" content="gołębie, gołebie, golebie, pocztowe, hodowla, slask, katowice" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="gallery-eleme.css" type="text/css" />
	<link rel="stylesheet" href="header-nav-footer.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	
	<script src="main.js"></script>

</head>

<body>

	<?php include 'header-nav.php';
	
		if (!isset($_POST['submit'])){
			header('Location: gallery.php');
			exit();
		}
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
						
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				
				$pigeon_id = $_POST['submit'];
				
				if ($result = $connection->query("SELECT * FROM golebie WHERE ID='$pigeon_id'")){
					
					$row = $result->fetch_assoc();
					$sex = $row['PLEC'];
					$pedigree = $row['RODOWOD'];
					$picture = $row['ZDJECIE'];
					
					$breeder_info = $connection->query("SELECT * FROM `gol-hod`, hodowcy WHERE `gol-hod`.`ID_GOLEBIA` = '$pigeon_id' AND hodowcy.ID_HODOWCY = `gol-hod`.`ID_HODOWCY`");
								
					$line_info = $connection->query("SELECT * FROM `gol-lin`, linie WHERE `gol-lin`.`ID_GOLEBIA` = '$pigeon_id' AND linie.ID_LINII = `gol-lin`.`ID_LINII`");
				
					echo '<section class="content">

					<header class="greet">
						'.$pigeon_id.'
					</header>

					<div class="wrapper">
						
						<div class="textholder" style="width: 80%;">
							
							<div class="content" style="max-width: 500px;">
								<img src="'.$picture.'" />
							</div>
							
							<div class="content">
								Numer: <b>'.$pigeon_id.'</b>
								<br><br>
								Płeć: <b>'.$sex.'</b>
								<br><br>
								Hodowca(y): ';
								
								$breeder_row = $breeder_info->fetch_assoc();
								if ($breeder_row == NULL) echo '<b>Brak informacji</b>';	
								else {
									echo '<b>'.$breeder_row['IMIE'].' '.$breeder_row['NAZWISKO'].'</b><br>';
									while ($breeder_row = $breeder_info->fetch_assoc())
									echo '<b>'.$breeder_row['IMIE'].' '.$breeder_row['NAZWISKO'].'</b><br>';
								}
								
								echo '<br> Linia(e): ';
								$line_row = $line_info->fetch_assoc();
								if ($line_row == NULL) echo '<b>Brak informacji</b>';
								else {
									echo '<b>'.$line_row['NAZWA'].'</b><br>';
									while ($line_row = $line_info->fetch_assoc())
									echo '<b>'.$line_row['NAZWA'].'</b><br>';
								}
								
								echo '<br><br><br>
								Pobierz rodowód: <a href="'.$pedigree.'" download ="Rodowód '.$pigeon_id.'" > Rodowód </a><br><br>
								<input type="button" onclick="location.href = '."'".'gallery.php'."'".';" value="Wróć" class="button"/>
							</div>
						</div>
						
						<div class="textholder">
							<div class="pedigree">
							<embed src="'.$pedigree.'" width=100% height=100%/>
							</div>
						</div>
					</div>
				</section>';
				}
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
			exit();
		}

		$connection->close();
	
	include 'footer.php';
	
?>
</body>
</html>