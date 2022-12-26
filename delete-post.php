<?php
	
	session_start();
	
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
					
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin' && isset($_POST['submit'])){
	
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				$post_id = $_POST['submit'];
				if ($connection->query("DELETE FROM komentarze WHERE POST_ID='$post_id'")){
					if ($connection->query("DELETE FROM posty WHERE ID='$post_id'")){
						$_SESSION['feedback'] = '<span style="color:green">Pomyślnie usunięto posta.</span>';
						header("location: index.php");
					}
					
					else {
						$_SESSION['feedback'] = "Nie udało się usunąć posta.";
						header("location: index.php");
					}
				}
				
				else {
					$_SESSION['feedback'] = "Nie udało się usunąć posta.";
					header("location: index.php");
				}
			}
		}
		
		catch(Exception $e){
			echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
			exit();
		}
	}

	else {
		header("location: index.php");
	}
	$connection->close();
?>