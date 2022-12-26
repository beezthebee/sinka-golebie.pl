<?php
	
	session_start();
	
	if (!isset($_SESSION['logged-in']) || $_SESSION['type'] != 'admin'){
		header('Location: login.php');
		exit();
	}
	
	if (!isset($_POST['submit'])){
		header('Location: race-results.php');
		exit();
	}
	
	require_once "connect.php";
				
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
					
		else {
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_POST['date'])){
				$_SESSION['error'] = 'Niepoprawny format daty! Akceptowany format to: RRRR-MM-DD';
				header('Location: add-result.php');
				exit();
			}
		
			else {
				$time = strtotime($_POST['date']);
				$day = intval(date("j", $time));
				$month = intval(date("m", $time));
				$year = intval(date("Y", $time));
				
				if (date('Y-m-d', $time) != $_POST['date']){
					$_SESSION['error'] = 'Niepoprawna data!';
					header('Location: add-result.php');
					exit();
				}
			}
			
			$date = $_POST['date'];
			$pigeon_id = $_POST['pigeon_id'];
			$sex = $_POST['sex'];
			$breeder = htmlspecialchars($_POST['breeder'], ENT_QUOTES);
			$line = htmlspecialchars($_POST['line'], ENT_QUOTES);
			$city = htmlspecialchars($_POST['city'], ENT_QUOTES);
			$distance = intval(htmlspecialchars($_POST['distance'], ENT_QUOTES));
			$category = $_POST['category'];
			
			if ($date == NULL || $pigeon_id == NULL || $breeder == NULL || $line == NULL || $city == NULL || $distance == NULL || $category == NULL || $time == NULL) {
				$_SESSION['error'] = 'Wypełnij wszystkie pola!';
				header('Location: add-result.php');
				exit();
			}
			
			if (!preg_match('#^([0-9][0-9]):[0-5][0-9](:[0-5][0-9])?$#', $_POST['time'])){
				$_SESSION['error'] = 'Błędny format czasu!';
				header('Location: add-result.php');
				exit();
			}
			
			$time = $_POST['time'];
			
			
			// check if the pigeon is present in the 'golebie' table; if not, insert the new pigeon
			
			$if_pigeon_present = $connection->query(sprintf("SELECT * FROM golebie WHERE ID='%s'", mysqli_real_escape_string($connection, $pigeon_id)));
			
			if ($if_pigeon_present->num_rows == 0){
				$connection->query(sprintf("INSERT INTO golebie (ID, PLEC, HODOWCA, LINIA) VALUES ('%s', '$sex', '%s', '%s')", mysqli_real_escape_string($connection, $pigeon_id), mysqli_real_escape_string($connection, $breeder), mysqli_real_escape_string($connection, $line)));
			}
			
			else {
				$info = $if_pigeon_present->fetch_assoc();
				if ($info['PLEC'] != $sex || $info['HODOWCA'] != $breeder || $info['LINIA'] != $line){
					$_SESSION['error'] = 'Niepoprawne dane gołębia!';
					header('Location: add-result.php');
					exit();
				}
			}
			
			
			// check if the result is already present in database
			
			$if_result_present = $connection->query(sprintf("SELECT * FROM wyniki WHERE ID_GOLEBIA = '%s' AND MIASTO = '%s' AND DYSTANS = '$distance' AND KATEGORIA = '$category' AND DATA = '$date'", mysqli_real_escape_string($connection, $pigeon_id), mysqli_real_escape_string($connection, $city)))->num_rows;
			
			if ($if_result_present != 0) {
				$_SESSION['error'] = 'Wynik znajduje się już w bazie danych!';
				header('Location: add-result.php');
				exit();
			}
			
			
			// check if the race is already present in 'loty' table; if not, insert the new race
			
			$if_race_present = $connection->query(sprintf("SELECT * FROM loty WHERE MIASTO='%s' AND DYSTANS='$distance' AND DATA='$date' AND KATEGORIA='$category'", mysqli_real_escape_string($connection, $city)))->num_rows;
			
			if ($if_race_present == 0) {
				$connection->query(sprintf("INSERT INTO loty (ID_LOTU, DATA, MIASTO, DYSTANS, KATEGORIA) VALUES ((SELECT ID FROM lista_lotow WHERE MIASTO='%s' AND DYSTANS='$distance'), '$date', '%s', '$distance', '$category')", mysqli_real_escape_string($connection, $city), mysqli_real_escape_string($connection, $city)));
			}
			
			
			// check if the race location and distance are present in the 'lista_lotow' table; if not, insert the new parameters
			
			$if_present_on_list = $connection->query(sprintf("SELECT * FROM lista_lotow WHERE MIASTO='%s' AND DYSTANS='$distance'", mysqli_real_escape_string($connection, $city)))->num_rows;
			
			if ($if_present_on_list == 0) {
				$connection->query(sprintf("INSERT INTO lista_lotow (MIASTO, DYSTANS) VALUES ('%s', '$distance')", mysqli_real_escape_string($connection, $city)));
			}
			
			
			// insert the new result
			
			if ($result = $connection->query(sprintf("INSERT INTO wyniki (ID_GOLEBIA, PLEC, HODOWCA, LINIA, ID_LOTU, MIASTO, DYSTANS, KATEGORIA, DATA, CZAS) VALUES ('%s', '$sex', '%s', '%s', (SELECT ID FROM loty WHERE DATA='$date' AND MIASTO='%s' AND DYSTANS='$distance' AND KATEGORIA='$category'), '%s', '$distance', '$category', '$date', '$time')",
			mysqli_real_escape_string($connection, $pigeon_id),
			mysqli_real_escape_string($connection, $breeder),
			mysqli_real_escape_string($connection, $line),
			mysqli_real_escape_string($connection, $city),
			mysqli_real_escape_string($connection, $city)))){
				header('Location: race-results.php');
			}
		}
	}
					
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}
	
	$connection->close();
?>