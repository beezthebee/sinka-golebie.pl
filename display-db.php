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
				if ($result = $connection->query(sprintf("SELECT * FROM golebie"))){
					if ($result->num_rows > 0){
						while ($row = $result->fetch_assoc()){
							echo '<form action="more-info.php" method="post" class="textholder-news">
								<input type="submit" class="content-news" value="'.$row['ID'].'" name="id">
								</form>
									
								<br>';
						}
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