<?php
	function valid_file($file_name, $data){
		$path = "uploads/";
		$file = $path.basename($_FILES[$file_name]["name"]);
		$file_type = strtolower(pathinfo($file,PATHINFO_EXTENSION));
			
		if ($data == "picture" && !getimagesize($_FILES[$file_name]["tmp_name"])) {
			$_SESSION['feedback'] = '<span style="color:red">Niepoprawne zdjęcie!</span>';
			return 0;
		}
				
		if (file_exists($file)){
			#$_SESSION['feedback'] = '<span style="color:red">Plik już istnieje!</span>';
			return $file;
		}
				
		if ($_FILES[$file_name]["size"] > 500000000) {
			$_SESSION['feedback'] = '<span style="color:red">Plik jest zbyt duży!</span>';
			return 0;
		}
				
		if (($data == "picture" && $file_type != "jpg" && $file_type != "png" &&
		   $file_type != "jpeg" && $file_type != "gif") ||
		   ($data == "pedigree" && $file_type != "pdf")){
			$_SESSION['feedback'] = '<span style="color:red">Niepoprawny format pliku!</span>';
			return 0;
		}
		
		if (!move_uploaded_file($_FILES[$file_name]["tmp_name"], $file)){
			$_SESSION['feedback'] = '<span style="color:red">Nie udało się przesłać pliku.</span>';
			return 0;
		}
		return $file;
	}
?>