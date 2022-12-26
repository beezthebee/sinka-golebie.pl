<?php
	
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
					
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		
		else {
			if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin'){
				echo '<div class="textholder">
						<header class="title" style="font-weight: 500;">Dodaj nowy wynik</header>
						<article class="content">';
						
						if (isset($_SESSION['feedback'])){
							echo $_SESSION['feedback'].'<div style="height: 15px;"></div>';
							unset($_SESSION['feedback']);
						}
						
						
							echo '<form action="save-result.php" method="post">
								Lot: <select name="race" class="input">';
									
									$options = $connection->query("SELECT * FROM loty WHERE ID NOT IN (SELECT ID_LOTU FROM wyniki) ORDER BY DATA DESC");
									while ($result = $options->fetch_assoc()){
										$race_id = $result['ID'];
										$location_id = $result['ID_LOTU'];
										$date = $result['DATA'];
										$category = $result['KATEGORIA'];
										if ($category == 'M') $category = 'młode';
										else $category = 'stare';
										
										$info = $connection->query("SELECT * FROM lista_lotow WHERE ID = '$location_id'")->fetch_assoc();
										$city = $info['MIASTO'];
										$distance = $info['DYSTANS'];
										
										echo '<option value="'.$race_id.'">'.$city.', '.$distance.'km ('.$category.') - '.$date.'</option>';
									}
									
								echo '</select><br><br>
								Link: 
								<input type="url" name="link" class="input"><br><br>
								<button type="submit" name="submit" class="button">Dodaj</button>
							&nbsp&nbsplub&nbsp&nbsp
							<input type="button" onclick="location.href = \'add-race.php\'" value="Utwórz nowy lot" class="button">
							</form>
						</article>
				</div>';
			}
			
			for ($year = idate('Y'); $year > 2008; $year--){
				
				$results = $connection->query("SELECT * FROM wyniki WHERE EXISTS (SELECT ID FROM loty WHERE loty.ID = wyniki.ID_LOTU AND DATA LIKE '%$year%')");
				
				if ($results->num_rows > 0) {
					echo '<div class="textholder">
					<header class="title">Sezon '.$year.'</header>';
					
					$category = $connection->query("SELECT * FROM wyniki WHERE EXISTS (SELECT ID FROM loty WHERE loty.ID = wyniki.ID_LOTU AND DATA LIKE '%$year%' AND KATEGORIA = 'D')");
					
					if ($category->num_rows > 0){
						echo '<article class="content"><b>STARE:</b></article>';
						while($result = $category->fetch_assoc()) {
							$race_id = $result['ID_LOTU'];
							$link = $result['LINK'];
									
							$race_info = "SELECT MIASTO, DYSTANS FROM lista_lotow WHERE ID=(SELECT ID_LOTU FROM loty WHERE ID='$race_id')";
							$info = $connection->query($race_info)->fetch_assoc();
							$city = $info['MIASTO'];
							$distance = $info['DYSTANS'];
									
							$date = $connection->query("SELECT DATA FROM loty WHERE ID = '$race_id' AND DATA LIKE '$year%'")->fetch_assoc()['DATA'];
							if ($date != NULL && $_SESSION['logged-in'] && $_SESSION['logged-in'] == true &&
							$_SESSION['type'] == 'admin'){
								echo '<form action="delete-result.php" method="post">
								<article class="content">
								<button type="submit" name="submit" value="'.$result['ID'].'" class="delete">
								<i class="icon-trash"></i></button>';
							}
							else echo '<article class="content">';
							echo $date.': '.$city.', '.$distance.'km - <a href="'.$link.'">'.$link.'</a></article>
							</form>';
						}
					}
					
					$category = $connection->query("SELECT * FROM wyniki WHERE EXISTS (SELECT ID FROM loty WHERE loty.ID = wyniki.ID_LOTU AND DATA LIKE '%$year%' AND KATEGORIA = 'M')");
					
					if ($category->num_rows > 0){
						echo '<article class="content"><b>MŁODE:</b></article>';
						while($result = $category->fetch_assoc()) {
							$race_id = $result['ID_LOTU'];
							$link = $result['LINK'];
									
							$race_info = "SELECT MIASTO, DYSTANS FROM lista_lotow WHERE ID=(SELECT ID_LOTU FROM loty WHERE ID='$race_id')";
							$info = $connection->query($race_info)->fetch_assoc();
							$city = $info['MIASTO'];
							$distance = $info['DYSTANS'];
									
							$date = $connection->query("SELECT DATA FROM loty WHERE ID = '$race_id' AND DATA LIKE '$year%'")->fetch_assoc()['DATA'];
							if ($date != NULL && $_SESSION['logged-in'] && $_SESSION['logged-in'] == true &&
							$_SESSION['type'] == 'admin'){
								echo '<form action="delete-result.php" method="post">
								<article class="content">
								<button type="submit" name="submit" value="'.$result['ID'].'" class="delete">
								<i class="icon-trash"></i></button>';
							}
							else echo '<article class="content">';
							echo $date.': '.$city.', '.$distance.'km - <a href="'.$link.'">'.$link.'</a></article></form>';
						}
					}
					echo '</div>';
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