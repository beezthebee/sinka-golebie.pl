<?php
	
	require_once "connect.php";
	
	mysqli_report(MYSQLI_REPORT_STRICT);
					
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		
		else {
			$display_posts = "SELECT ID, TITLE, CONTENT, MEDIA, DATE FROM posty ORDER BY DATE DESC";
			$result = $connection->query($display_posts);
			if ($result->num_rows > 0) {
				// output data of each row
				while($post = $result->fetch_assoc()) {
					$post_id = $post['ID'];
					
					$content = $post['CONTENT'];
					$pattern = '#https?:\/\/\S+#';
					preg_match_all($pattern, $content, $links);
						foreach ($links[0] as $link){
						$replace = '&nbsp<a href="'.$link.'" target="blank">'.$link.'</a>&nbsp';
						$content = str_replace($link, $replace, $content);
					}
					
					
					$count_comments = "SELECT COUNT(ID) FROM komentarze WHERE komentarze.POST_ID = '$post_id'";
					$amount = $connection->query($count_comments)->fetch_assoc();
					echo '<div class="textholder-news">';
					
					if (isset($_SESSION['edit_id']) && $post_id == $_SESSION['edit_id']){
						echo '<article class="content-news">'.$_SESSION['feedback'].'</article>';
						unset($_SESSION['feedback']);
						unset($_SESSION['edit_id']);
					}
						echo '<header class="title-news">
							<div class = "title-element">
							
								<div style="float: left;">'.$post['TITLE'].'</div>';
								
								if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin'){
								echo '<div class="title-news">
									<form action="edit-post.php" method="post" class="edit-delete">
										<button type="submit" value="'.$post_id.'" name="submit" class="edit-delete"><i class="icon-edit-1" style="font-size: 3rem;"></i></button>
									</form>
									
									<form action="delete-post.php" method="post">
										<button type="submit" value="'.$post_id.'" name="submit" class="edit-delete"><i class="icon-trash-empty" style="font-size: 3rem;"></i></button>
									</form>
								</div>';
								}
								
							echo '</div>
							<div class="title-element" style="text-align: right;">'.$post['DATE'].'</div>
						</header>
								
						<article class="content-news">
							'.$content.'
						</article>
						
						<article class="content-news" style="display: block; text-align: center;">
							<img src="'.$post['MEDIA'].'"/>
						</article>
					
						<header class="title-news">
							Komentarze - '.$amount['COUNT(ID)'].'
						</header>
							
						<article class="content-news">';
						if (isset($_SESSION['comm_id']) && $_SESSION['comm_id'] == $post_id){
							echo $_SESSION['comm_feedback'];
							unset($_SESSION['comm_feedback']);
							unset($_SESSION['comm_id']);
						}
							echo '<form action="comment.php" method="post">
								Twój komentarz:<br>
								<input type="text" name="comment_content" class="input"><br>
								<input type="submit" name="submit-comment" value="Dodaj komentarz" class="button">
								<input type="hidden" name="post_id" value="'.$post_id.'">
							</form>
						</article>';
	
						if (isset($_SESSION['id'])) $user = $_SESSION['id'];
						else $user = 0;

						$display_comments = "SELECT LOGIN, CONTENT, DATE, komentarze.ID, USER_ID FROM komentarze, uzytkownicy WHERE USER_ID='$user' AND uzytkownicy.ID = komentarze.USER_ID AND komentarze.POST_ID = '$post_id'";
						
						$comments_result = $connection->query($display_comments);
						
						if ($comments_result->num_rows > 0) {
							while($comment = $comments_result->fetch_assoc()){
								echo '<article class="content-news">'
										.$comment['DATE'].'<br>
										<form action="delete-comment.php" method="post">
											<button type="submit" name="submit" value="'.$comment['ID'].'" class="edit-delete" style="font-size: 2rem;">
												<i class="icon-trash-empty"></i>
											</button>
										</form>
										<b>'.$comment['LOGIN'].': </b>
										'.$comment['CONTENT'].'
								</article>';
							}
						}
							
						$display_comments = "SELECT LOGIN, CONTENT, DATE, komentarze.ID, USER_ID FROM komentarze, uzytkownicy WHERE USER_ID!='$user' AND uzytkownicy.ID = komentarze.USER_ID AND komentarze.POST_ID = '$post_id'";
							
						$comments_result = $connection->query($display_comments);
							
						if ($comments_result->num_rows > 0){
							while($comment = $comments_result->fetch_assoc()) {
								echo '<article class="content-news">'.$comment['DATE'].'<br>';
								
								if ((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true && $_SESSION['type'] == 'admin')){
									echo '<form action="delete-comment.php" method="post">
										<button type="submit" name="submit" value="'.$comment['ID'].'" class="edit-delete" style="font-size: 2rem;">
											<i class="icon-trash-empty"></i>
										</button>
									</form>';
								}
								echo '<b>'.$comment['LOGIN'].': </b>
								'.$comment['CONTENT'].'
								</article>';
								
							}
						}
					echo '</div>';
				}
			}
		}
	}
	
	catch(Exception $e){
		echo '<span style="color:red">Błąd serwera. Przepraszamy za niedogodności.</span>';
		exit();
	}

	$connection->close();
?>