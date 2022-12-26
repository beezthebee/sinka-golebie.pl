<?php
	
	require_once "connect.php";
		
	mysqli_report(MYSQLI_REPORT_STRICT);
		
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
			
		else {
			unset($_SESSION['id_result']);
			
			if (isset($_SESSION['error'])) echo $_SESSION['error'];
			unset($_SESSION['error']);
			
			echo '<head
					<link rel="stylesheet" href="races.css" />
				</head>
				
				<a href="add-result.php" class="textholder-news" style="min-width: 0; border: none; box-shadow: none; text-decoration: none;">
					<button type="submit" class="submit" >Dodaj nowy element <i class="icon-plus" style="font-size: 2.5rem"></i></button>
				</a>
				
				<div class="textholder-news" style="box-shadow: none; border: none; justify-content: space-between; min-width: 0;">
				<div style="width: 48%;"> 
					<button type="submit" name="delete" class="submit" form="delete">Usuń</button>
				</div>
				
				<form action="search-results.php" method="post" class="submit" style="width: 48%; background-color: white; color: #333; cursor: auto; margin: 10px 0;">
					Szukaj: <input type="text" name="search-results" />
					<button type="submit" name="submit"><i class="icon-edit-1"></i></button>
				</form>
				</div>
				
				<div class="textholder-news" style="box-shadow: none; border: none; justify-content: space-between;  min-width: 0;">
					<form action="sort-results.php" method="post" class="submit" style="background-color: #69befa; color: #fff; cursor: auto; margin: 10px 0;">
						Sortuj: <select name="sort-results">
								<option value="DATA DESC">DATA (od najpóźniejszych)</option>
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
				</div>
				
				<div class="textholder-news" style="background-color: #69befa; color: white; min-width: 2000px;">
					<div class="content-news">
						DATA
					</div>
										
					<div class="content-news">
						NUMER
					</div>
					
					<div class="content-news">
						PŁEĆ
					</div>
					
					<div class="content-news">
						HODOWCA
					</div>
					
					<div class="content-news">
						LINIA
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
						
					<div class="content-news">
						CZAS
					</div>
					
					<div style="width: 90px;"></div>
				</div>';
				
				if (!isset($_SESSION['search-results'])) $_SESSION['search-results'] = "";
				if (!isset($_SESSION['sort-results'])) $_SESSION['sort-results'] = "ORDER BY DATA DESC";	
				
				if ($result = $connection->query("SELECT * FROM wyniki ".$_SESSION['search-results']." ".$_SESSION['sort-results'])){
					if ($result->num_rows > 0){
						unset ($_SESSION['search-results']);
						while ($row = $result->fetch_assoc()){
							echo '<div class="textholder-news" style="min-width: 2000px;">
									<form action="delete-result.php" method="post" class="edit" style="cursor: auto;" id="delete">
										<input type="checkbox" form="delete" name="checkbox[]" value="'.$row['ID'].'"/>
									</form>
									
									<div class="content-news"">
										'.$row['DATA'].'
									</div>
									
									<div class="content-news">
										'.$row['ID_GOLEBIA'].'
									</div>
									
									<div class="content-news">
										'.$row['PLEC'].'
									</div>
									
									<div class="content-news">
										'.$row['HODOWCA'].'
									</div>
									
									<div class="content-news">
										'.$row['LINIA'].'
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

									<div class="content-news">
										'.$row['CZAS'].'
									</div>
									
									<form action="edit-result.php" method="post">
										<button type="submit" value="'.$row['ID'].'" name="id" class="edit" style="width: 64px;"><i class="icon-edit-1"></i></button>
									</form>
								</div>';
						}
					}
					
					else {
						echo '<div class="textholder-news">
								<div class="content-news">Brak wyników!</div>
							</div>';
							unset ($_SESSION['search-results']);
					}
				}
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
			exit();
		}
	unset($_SESSION['query']);
	$connection->close();
?>