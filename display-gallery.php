<?php

	require_once "connect.php";
		
	mysqli_report(MYSQLI_REPORT_STRICT);
						
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
			
		else {
			if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin') 	$admin = true;
			else $admin = false;
			
			if ($admin){
				echo '<div class="textholder-gallery">
						<header class="title">Dodaj nowy element</header>
						<br>';
						if (isset($_SESSION['feedback'])){
							echo $_SESSION['feedback'];
							unset($_SESSION['feedback']);
						}
						echo 'Wybierz gołębia z bazy danych:
					<form action="save-gallery-element.php" method="post">
						<select name="id" class="input">';
							if ($result = $connection->query("SELECT ID FROM golebie WHERE ID NOT IN (SELECT ID_GOLEBIA FROM galeria)")){
								while ($pigeon = $result->fetch_assoc())
									echo '<option value="'.$pigeon['ID'].'">'.$pigeon['ID'].'</option>';
							}
						
						echo '</select><br>
						<button type="submit" name="submit" value="pick" class="button" >	
							Wybierz
						</button>
					</form>
					<br>lub<br><br>Ręcznie wpisz parametry nowego gołębia:<br>
					<form action="add-pigeon.php" method="post">
						<button type="submit" name="submit" value="new" class="button" >	
							Wpisz
						</button>
					</form>
				</div>';
			}
			
			$result = $connection->query("SELECT * FROM galeria, golebie WHERE golebie.ID = galeria.ID_GOLEBIA ORDER BY galeria.ID DESC");
			if ($result){
					
				while ($row = $result->fetch_assoc()){
						
					echo '<div class="textholder-gallery">';
							
						if (!$admin)
							echo '<form action="gallery-element.php" method="post" id="add">
							<button type="submit" value="'.$row['ID_GOLEBIA'].'" name="submit" style="width: 100%;">
								<div class="imgOverlay"></div>';
							
							echo '<div class="title">';
										
							if ($row['ZDJECIE'] == NULL) echo 'Brak zdjęcia';
							else echo '<img src="'.$row['ZDJECIE'].'" />';
							
							$pigeon_id = $row['ID_GOLEBIA'];
							echo '</div><article class="content">
								<b>'.$pigeon_id.'</b>';
								
							if ($admin){
							echo '<br>
								<form action="delete-gallery-element.php" method="post">
									<button type="submit" value="'.$pigeon_id.'" name="submit"><i class="icon-trash-empty icon" style="font-size: 3rem;"></i></button>
								</form>';
							}
								
							echo '<br><br>';
										
							$breeder_info = $connection->query("SELECT * FROM `gol-hod`, hodowcy WHERE `gol-hod`.`ID_GOLEBIA` = '$pigeon_id' AND hodowcy.ID_HODOWCY = `gol-hod`.`ID_HODOWCY`");
								
							$line_info = $connection->query("SELECT * FROM `gol-lin`, linie WHERE `gol-lin`.`ID_GOLEBIA` = '$pigeon_id' AND linie.ID_LINII = `gol-lin`.`ID_LINII`");
								
							while ($breeder_row = $breeder_info->fetch_assoc())
								echo $breeder_row['IMIE'].' '.$breeder_row['NAZWISKO'].'<br>';
							
							echo '<br>';
							while ($line_row = $line_info->fetch_assoc())
								echo $line_row['NAZWA'].'<br>';
										
							echo '</article>
							</button>
						</form>
					</div>';

				}
			}
		}
	}
		
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
		
	$connection->close();
?>
