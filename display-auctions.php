<?php
	
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
					
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		
		else {
			$display_auctions = "SELECT * FROM aukcje ORDER BY KONIEC ASC";
			$result = $connection->query($display_auctions);
			if ($result->num_rows > 0) {
				while($auction = $result->fetch_assoc()) {
					$auction_id = $auction['ID'];
					$pigeon_id = $auction['ID_GOLEBIA'];
					$price = $auction['CENA'];
					$link = $auction['LINK'];
					if ($auction['KONIEC'] == '0000-00-00') $end = '---';
					else $end = $auction['KONIEC'];
					
					$photo = $connection->query("SELECT ZDJECIE FROM golebie WHERE ID='$pigeon_id'")->fetch_assoc();
						
					echo '<div class="textholder">
						<header class="title">
							<img src="'.$photo['ZDJECIE'].'"/>
						</header>
					
						<article class="content">
							<b><font size="6rem">'.$pigeon_id.'</font></b>';
							
						if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin'){	
							
							echo '<form action="edit-auction.php" method="post" style="float: left;">
								<button type="submit" value="'.$auction_id.'" name="submit"><i class="icon-edit-1 icon" style="font-size: 3rem;"></i></button>
							</form>
							
							<form action="delete-auction.php" method="post" style="float: left;">
								<button type="submit" value="'.$auction_id.'" name="submit"><i class="icon-trash-empty icon" style="font-size: 3rem;"></i></button>
							</form>';
						}							
									
							echo '<br/><br/>
							Cena: <b>'.$price.'zł</b><br>
							Zakończenie: <b>'.$end.'</b><br>
							<br/>
							<a href="'.$link.'" target="_blank"><button class="button">Odwiedź aukcję</button></a>
						</article>
					</div>';
				}
			}
			
			else {
				echo '<div class="textholder">
						<header class="title">
							Brak aukcji
						</header>
					
						<article class="content">
							Obecnie nie są prowadzone żadne aukcje. Śledź aktualności na mojej stronie, aby dowiedzieć się o każdej nowej okazji na zakup!
						</article>
					</div>';
			}
		}
	}
	
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}

	$connection->close();
?>