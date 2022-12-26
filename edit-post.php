<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<meta name="description" content="Adam Sinka - hodowla gołębi" />
	<meta name="keywords" content="gołębie, gołebie, golebie, pocztowe, hodowla, slask, katowice" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="ind.css" type="text/css" />
	<link rel="stylesheet" href="header-nav-footer.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontell/css/fontello.css" type="text/css" />
	
	<script src="main.js"></script>

</head>

<?php
	
	include 'header-nav.php';
	
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin' && isset($_POST['submit'])){
		
		require_once "connect.php";
						
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						
		if ($connection->connect_errno!=0){
			echo "Error: ".$newpost_connection->connect_errno;
		}
		
		else {
			$post_id = $_POST['submit'];
			
			$result = $connection->query("SELECT TITLE, CONTENT, MEDIA FROM posty WHERE ID='$post_id'");
			
			if ($result){
				
				$post = $result->fetch_assoc();
				
				echo '<section class="content">
			
					<header class="greet">
						Edytuj post
					</header>

					<div class="wrapper" style="flex-direction: column;">
					
						<article class="content-news">
							<form action="save-edited-post.php" method="post" enctype="multipart/form-data">
								
								Tytuł: <input type="text" name="title" value="'.$post['TITLE'].'" class="input"/><br><br>
								Treść: <textarea name="content" rows=10 cols=40 class="input">'.$post['CONTENT'].'</textarea><br><br>
								Wybierz zdjęcie: <input type="file" name="media" id="media"><br><br>
								<img src="'.$post['MEDIA'].'"><br><br>
								Zdjęcie zaktualizuje się automatycznie po zapisaniu posta.<br><br>
								<input type="submit" name="submit" value="Zapisz posta" class="button"/>
								<input type="hidden" name="post_id" value="'.$post_id.'"/><br>';
								
								echo '<input type="button" onclick="location.href = \'index.php\'" value="Wróć"class="button"/>
									
							</form>
						</article>
					</div>
				</section>';
			}
			
			else{
				$_SESSION['error'] = "Błąd serwera. Przepraszamy.";
				header("location: index.php");
			}
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$connection->close();
?>