<?php

	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	else {
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				unset($_SESSION['id_race']);
				
				if (isset($_SESSION['error'])) echo $_SESSION['error'];
				unset($_SESSION['error']);
				
				include 'organisation.php';
				echo '<option value="DATA DESC">DATA (od najpóźniejszych)</option>
							<option value="DATA ASC">DATA (od najwcześniejszych)</option>
							<option value="MIASTO ASC">MIASTO (A do Z)</option>
							<option value="MIASTO DESC">MIASTO (Z do A)</option>
							<option value="DYSTANS ASC">DYSTANS (od najmniejszych)</option>
							<option value="DYSTANS DESC">DYSTANS (od największych)</option>
							<option value="KATEGORIA ASC">KATEGORIA (D do M)</option>
							<option value="KATEGORIA DESC">KATEGORIA (M do D)</option>
						</select>
						<button type="submit" name="submit"><i class="icon-edit-1"></i></button>
					</form>
				</div>';
				
				echo '<br><br>
				<div class="textholder-news" style="background-color: #69befa; color: white;">
					<div class="content-news">
						DATA
					</div>
									
					<div class="content-news">
						MIASTO
					</div>
									
					<div class="content-news">
						DYSTANS
					</div>
									
					<div class="content-news">
						WIEK
					</div>
					
					<div style="width: 64px;"></div>
				</div>';
				
				if (!isset($_SESSION['search'])) $_SESSION['search'] = "";
				if (!isset($_SESSION['sort'])) $_SESSION['sort'] = "ORDER BY DATA DESC";
				
				if ($result = $connection->query("SELECT * FROM loty, lista_lotow WHERE lista_lotow.ID = loty.ID_LOTU ".$_SESSION['search']." ".$_SESSION['sort'])){
					unset ($_SESSION['search']);
					if ($result->num_rows > 0){
						echo '<form action="delete-race.php" method="post" id="delete" >';
						
						while ($row = $result->fetch_assoc()){
							echo '
									<div class="textholder-news">
										<form action="delete-race.php" method="post" class="edit" style="cursor: auto;">
											<input type="checkbox" form="delete" name="checkbox[]" value="'.$row['ID'].'"/>
										</form>
										
										<div class="content-news">
											'.$row['DATA'].'
										</div>
									
										<div class="content-news">
											'.$row['MIASTO'].'
										</div>
										
										<div class="content-news">
											'.$row['DYSTANS'].' km
										</div>
										
										<div class="content-news">
											'.$row['KATEGORIA'].'
										</div>
										
										<form action="edit-race.php" method="post">
											<button type="submit" value="'.$row['ID'].'" name="id" class="edit" style="width: 64px;"><i class="icon-edit-1"></i></button>
										</form>
									</div>';
						}
						
						echo '</form>';
					}
					
					else {
						echo '<div class="textholder-news">
								<div class="content-news">Brak wyników!</div>
							</div>';
					}
				}
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
			exit();
		}
	}
	
	$connection->close();
?>