
<head>
	<link rel="stylesheet" href="organisatio.css" />
	<link rel="stylesheet" href="races.css" />
</head>

<?php
	echo '<a href="add-'.$_SESSION['table'].'.php" class="add-new" >
		<button type="submit" class="submit">Dodaj nowy element <i class="icon-plus" style="font-size: 2.5rem"></i></button>
	</a>
					
					
	<div class="delete">
		<div style="width: 48%;"> 
			<button type="submit" name="delete" class="submit" form="delete">Usuń</button>
		</div>
					
		<form action="search-'.$_SESSION['table'].'.php" method="post" class="search">
			Szukaj: <input type="text" name="search" />
			<button type="submit" name="submit"><i class="icon-edit-1"></i></button>
		</form>
	</div>
					
	<div style="width: 100%;">
		<form action="sort-'.$_SESSION['table'].'.php" method="post" class="sort">
			Sortuj: <select name="sort">';
?>