<?php

	session_start();
	
	if (isset($_SESSION['logged-in']) && $_SESSION['type'] == 'admin' && isset($_POST['submit'])){
	
		$_SESSION['edit_id'] = $_POST['post_id'];
		
		if ($_POST['title'] == NULL){
			$_SESSION['feedback'] = '<span style="color:red">Podaj tytuł!</span>';
			header("location: index.php");
			exit();
		}
		if ($_POST['content'] == NULL){
			$_SESSION['feedback'] = '<span style="color:red">Podaj treść!</span>';
			header("location: index.php");
			exit();
		}
	
		require_once "connect.php";
						
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						
		if ($connection->connect_errno!=0){
			echo "Error: ".$connection->connect_errno;
		}
		
		else {
			$post_title = $_POST['title'];
			$post_content = $_POST['content'];
			$post_id = $_POST['post_id'];
			
			if (!empty($_FILES["media"]["name"])) {
				require_once "functions.php";
				$file = valid_file("media", "picture");
				if (!$file){
					$newpost_connection->close();
					header("location: edit-post.php");
					exit();
				}
				$post_result = $connection->query(sprintf("UPDATE posty SET TITLE='%s', CONTENT='%s', MEDIA='$file' WHERE ID='$post_id'",
				mysqli_real_escape_string($connection, $post_title),
				mysqli_real_escape_string($connection, $post_content)));
			}
			else
				$post_result = $connection->query(sprintf("UPDATE posty SET TITLE='%s', CONTENT='%s' WHERE ID='$post_id'",
				mysqli_real_escape_string($connection, $post_title),
				mysqli_real_escape_string($connection, $post_content)));
			
			if ($post_result)
				$_SESSION['feedback'] = '<span style="color:green">Pomyślnie zedytowano posta.</span>';
			
			else 
				$_SESSION['feedback'] = '<span style="color:red">Nie udało się zedytować posta!</span>';
			
			header('Location: index.php');
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$connection->close();
?>