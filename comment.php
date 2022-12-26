<?php
	
	session_start();

	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && isset($_POST['comment_content'])
		&& $_POST['comment_content'] != NULL){
		require_once "connect.php";
		$comment_connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
		if ($comment_connection->connect_errno!=0){
			echo "Error: ".$comment_connection->connect_errno;
		}
		
		else{
			$post_id = $_POST['post_id'];
			$user_id = $_SESSION['id'];
			$comment_content = $_POST['comment_content'];
			$date = date('Y-m-d', time());
			$_SESSION['comm_id'] = $post_id;
			
			if ($comment_result = @$comment_connection->query(sprintf("INSERT INTO komentarze (POST_ID, USER_ID, CONTENT, DATE) VALUES ('%s', '%s', '%s', '$date')",
			mysqli_real_escape_string($comment_connection, $post_id),
			mysqli_real_escape_string($comment_connection, $user_id),
			mysqli_real_escape_string($comment_connection, $comment_content)))){
				
				$_SESSION['comm_feedback'] = '<span style="color:green">Pomyślnie dodano komentarz.<br><br></span>';
			}
			
			else {
				$_SESSION['comm_feedback'] = '<span style="color:red">Nie udało się dodać komentarza!<br><br></span>';
			}
			
			header('Location: index.php');
		}
	}
	
	else {
		header('Location: login.php');
	}
	
	$comment_connection->close();
?>