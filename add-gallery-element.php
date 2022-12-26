<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<meta name="description" content="Adam Sinka - hodowla gołębi" />
	<meta name="keywords" content="gołębie, gołebie, golebie, pocztowe, hodowla, slask, katowice" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="galler.css" type="text/css" />
	<link rel="stylesheet" href="header-nav-footer.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
	
	<script src="main.js"></script>

</head>

<body>
	
	<?php include 'header-nav.php'; ?>
	
	<section class="content">
	
		<header class="greet">
			Nowy element
		</header>
		
		<div class="wrapper">
		
		<?php
	
		if (!isset($_POST['submit'])){
			$_POST['submit'] = 'pick';
		}
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
						
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {				
				echo '<form action="save-gallery-element.php" method="post" id="add">
				<div class="textholder-edit">';
				
				if ($_POST['submit'] == 'pick'){
					echo 'Numer: <select name="id" >';
						if ($result = $connection->query("SELECT ID FROM golebie")){
							while ($row = $result->fetch_assoc()){
								echo '<option value="'.$row['ID'].'">'.$row['ID'].'</option>';
							}
						}
					echo '</select>';
				}
				
				else {
					echo 'Numer: <input type="text" name="id" class="content" />
					Płeć: <select name="sex" class="content" >
							<option value="samiec">samiec</option>
							<option value="samica">samica</option>
						</select>
					Hodowca: <input type="text" name="breeder" class="content" />
					Linia: <input type="text" name="line" class="content" />
					Zdjęcie: <input type="file" name="picture" id="picture" class="content" enctype="multipart/form-data"/>
					Rodowód: <input type="file" name="pedigree" id="pedigree" class="content" enctype="multipart/form-data"/>';
				}
				
				echo '</div></form>
				<br><button type="submit" value="';
					if ($_POST['submit'] == 'pick') echo 'pick';
					else echo 'new';
				echo '" name="submit" form = "add" class="button" />Zapisz</button><br>
				<input type="button" onclick="location.href = \'gallery.php\';" value="Anuluj" class="button" />';
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
			exit();
		}

		$connection->close();
	?>
	</section>
	
	<?php include 'footer.php'; ?>
</body>
</html>