<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<meta name="description" content="Adam Sinka - hodowla gołębi" />
	<meta name="keywords" content="gołębie, gołebie, golebie, pocztowe, hodowla, slask, katowice" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="iii.css" type="text/css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;1,100;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fontell/css/fontello.css" type="text/css" />

</head>

<body>
	
	<?php
		include 'header-nav.php';
	?>
	
	<section class="content">
	
		<header class="greet">
			Aktualności
		</header>

		<div class="wrapper" style="flex-direction: column;">
			
			<?php
			
				if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true
				&& $_SESSION['type'] == 'admin'){
					echo '<div class="textholder-news">
				
						<header class="title-news">
							Nowy post
						</header>
								
						<article class="content-news">
							<form action="post.php" method="post" enctype="multipart/form-data">';
							
								if (isset($_SESSION['feedback']) && !isset($_SESSION['edit_id'])) {
									echo $_SESSION['feedback'].'<br><br>';
									unset($_SESSION['feedback']);
								}
							
								echo 'Tytuł: <br><input type="text" name="title" class="input"/><br><br>
								Treść: <br><textarea name="content" rows=10 cols=40 class="input"></textarea><br><br>
								Dodaj zdjęcie: <input type="file" name="media" id="media"><br><br>';
								
								echo '<br><input type="submit" name="submit" value="Utwórz posta" class="button"/>
							</form>
						</article>
					</div>';
				}
			
				include 'display-posts.php';
			?>
			
		</div>
	</section>
	
	<?php include 'footer.php'; ?>
</body>
</html>