<?php
	
	session_start();
	
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
					
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && isset($_POST['submit'])){
	
		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			
			if ($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else {
				$comment_id = $_POST['submit'];
				$_SESSION['comm_id'] = $connection->query("SELECT POST_ID FROM komentarze WHERE ID='$comment_id'")->fetch_assoc()['POST_ID'];
				
				if ($connection->query("DELETE FROM komentarze WHERE ID='$comment_id'")){
					$_SESSION['comm_feedback'] = '<span style="color:green">Pomyślnie usunięto komentarz.<br><br></span>';
					
				}
				
				else {
					$_SESSION['comm_feedback'] = '<span style="color:red">Nie udało się usunąć komentarza.<br><br></span>';
					
				}
				header("location: index.php");
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