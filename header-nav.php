<?php

	session_start();
	require_once 'connect.php';
		
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
						
		else {
			$id = session_id();
			$present = $connection->query("SELECT * FROM sesje WHERE ID='$id'")->num_rows;
			if ($present == 0)
				$connection->query("INSERT INTO sesje (ID) VALUES ('$id')");
			$views = $connection->query("SELECT * FROM sesje")->num_rows;
			$users = $connection->query("SELECT * FROM uzytkownicy")->num_rows;
		}
	}
						
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();

?>

<link rel="stylesheet" href="header-nav-fo.css" type="text/css" />
<link rel="stylesheet" href="fontello/css/fontello.css" type="text/css" />
<! PAGE HEADER >
<div class="background-img">
	
	<! BLACK OVERLAY >
	<div class="overlay"></div>
		
	<div id="logotxt1">
		Adam Sinka
	</div>
		
	<div id="logotxt2">
		Hodowla Gołębi
	</div>
</div>

	
<! MENU BAR >
<nav class="menu">
	
	<! USER ICON >
	<?php
		
		if (isset($_SESSION['logged-in'])){
			
			echo '<div class="user-icon-login">
				<i class="icon-user-circle-o"></i>
			</div>';
		}
	?>
	
	<! USER ICON >
	<div class="user-icon">
		<i class="icon-user-circle-o"></i>
	</div>
		
		
	<! LOGO >
	<div class="containerlogo">
		<img src="img/logo-white.jpg">
	</div>
	
	
	<! NAVIGATION ICON >
	<button	class = "nav-icon">
		<i class = "icon-menu"></i>
	</button>
		
		
	<! NAVIGATION LIST >
	
	<ul class="navigation">
		<a href="index.php" class="linker-option">
			<li>Strona główna</li>
		</a>
			
		<a href="gallery.php" class="linker-option">
			<li>Galeria</li>
		</a>
			
		<a href="results.php" class="linker-option">
			<li>Osiągnięcia</li>
		</a>
			
		<a href="auctions.php" class="linker-option">
			<li>Sprzedaż</li>
		</a>
			
		<a href="about-me.php" class="linker-option">
			<li>O mnie</li>
		</a>
			
		<a href="contact-me.php" class="linker-option">
			<li>Kontakt</li>
		</a>
		
		<?php

			if (isset($_SESSION['logged-in']) && $_SESSION['type'] == 'admin'){
				echo '<a href="pigeons.php" class="linker-option">
						<li>Baza danych</li>
					</a>';
			}
		?>
		
	</ul>
	
	<ul class="user-options">
		<?php
			if (!isset($_SESSION['logged-in']))
			echo '
				<a href="login.php" class="linker-option">
					<li>Zaloguj się</li>
				</a>';
			else 
				echo '
			<a href="logout.php" class="linker-option">
				<li>Wyloguj się</li>
			</a>
			
			<a href="user-panel.php" class="linker-option">
				<li>Panel użytkownika</li>
			</a>';
		?>
		
		<script>
			const icon = document.querySelector('.nav-icon');
			const nav = document.querySelector('.navigation');
			const user = document.querySelector('.user-icon');
			const userlogin = document.querySelector('.user-icon-login');
			const options = document.querySelector('.user-options');

			if (Window.innerWidth >= 1400) {
				nav.className = "navigation";
			}
			
			icon.addEventListener('click', () => { 
				icon.classList.toggle('nav-icon-active'); 
				nav.classList.toggle('navigation-active'); 
			});
			
			
			
			user.addEventListener('click', ()=> {
				user.classList.toggle('user-icon-active'); 
				options.classList.toggle('user-options-active'); 
			});
			
			userlogin.addEventListener('click', () => { 
				userlogin.classList.toggle('user-icon-active'); 
				options.classList.toggle('user-options-active'); 
			});
		</script>
		
		<a href="register.php" class="linker-option">
			<li>Zarejestruj się</li>
		</a>
		
	</ul>

		
	<?php
	
		if (!isset($_SESSION['logged-in']) || !$_SESSION['logged-in']) 
		echo '<div class="buttons">
				<a href="login.php" class="log-in">
					Zaloguj się
				</a>
						
				<a href="register.php" class="register">
					Zarejestruj się
				</a>
			</div>';
	
	?>
</nav>
	

<! INTERLUDE BETWEEN NAVIGATION AND CONTENT >

<div class="interlude">
	<div class = "social" style="text-align: center;">
		<?php
			if (isset($_SESSION['logged-in']) && $_SESSION['type'] == 'admin')
				echo '<br><br>Twoją stronę odwiedziło '.$views.' użytkowników.<br>
				'.$users.' użytkowników zarejestrowało się na stronie!<br><br><br>';
			else echo '
			<div class = "social-text">
				Odwiedź moje media społecznościowe!
			</div>
			
			<a href="https://www.facebook.com/adam.sinka.35" class="social-icon" target="_blank">
				<i class="icon-facebook"></i>
			</a>
				
			<a href="https://www.youtube.com/" class="social-icon" target="_blank">
				<i class="icon-youtube"></i>
			</a>';
		?>
	</div>
</div>