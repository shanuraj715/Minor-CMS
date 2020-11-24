<?php

// comments();

$comments = $comment_post_id; // comments is coming from post page. 

$author_username = $post_author_username;

function authorDetails($data, $author_username){ // data is used to find the type of query. { username, lname, fnam, image, role, etc... }

	global $connection;

	$sql = "SELECT username, fname, lname, role, image FROM users WHERE username = '$author_username'";

	$author_query = mysqli_query($connection, $sql);

	$author_details = mysqli_fetch_assoc($author_query);

	if($data == "username"){

		return $author_details['username'];
		
	}

	if($data == "fname"){

		return $author_details['fname'];
		
	}

	if($data == "lname"){

		return $author_details['lname'];
		
	}

	if($data == "role"){

		return $author_details['role'];
		
	}

	if($data == "image"){

		return $author_details['image'];
		
	}

	if($data == "name"){

		return $author_details['fname'] . ' ' . $author_details['lname'];
		
	}

	

}

function comments(){

	global $connection;

	global $comments;

	$sql = "SELECT * FROM post_comments WHERE post_id = '$comments' and parent_id = 0 and status = 'approved' LIMIT 8";

	$query = mysqli_query($connection, $sql);

	while($result = mysqli_fetch_assoc($query)){

		if($result['parent_id'] == 0){ ?>

			<div class="p_comment_top_block">
				<div class="comment_left_area">
					<img src="<?php echo SITE_URL; ?>images/users/<?php echo authorDetails('image', $result['username']);?>">
				</div>
				<div class="comment_right_area">
					<p class="comment_user_name"><?php echo $result['user_name']; ?></p><span class="comment_user_role"><?php echo ucwords(authorDetails('role', $result['username'])); ?></span>

					<?php
					if(isset($_SESSION['username'])){ ?>
						<a href="#comment" id="comment_reply_btn" onclick="store_cookie_for_comment_id(<?php echo $result['comment_id'];?>)">Reply</a>
						<?php
					}
					?>
					<p class="comment_data"><?php echo $result['comment']; ?></p>
				</div>
			</div>
		
		<?php

			$parent_comment_id = $result['comment_id'];

			$sql = "SELECT * FROM post_comments WHERE post_id = $comments and parent_id = $parent_comment_id and status = 'approved' ORDER BY comment_id ASC";

			$query1 = mysqli_query($connection, $sql);

			$total_nested_comms = mysqli_num_rows($query1);

			if($total_nested_comms > 0){

				while($comm_data = mysqli_fetch_assoc($query1)){ ?>

					<div class="p_comment_nested_block">
						<div class="comment_left_area">
							<img src="<?php echo SITE_URL; ?>images/users/<?php echo authorDetails('image', $comm_data['username']);?>">
						</div>
						<div class="comment_right_area">
							<p class="comment_user_name"><?php echo $comm_data['user_name']; ?></p>
							<span class="comment_user_role"><?php echo ucwords(authorDetails('role', $comm_data['username'])); ?></span>
							<p class="comment_data"><?php echo $comm_data['comment']; ?></p>
						</div>
					</div>

					<?php

				}

			}

		}

	}

}

function totalCommentsCount(){

	global $connection;

	global $comments;

	$sql = "SELECT count(comment_id) as total_comments FROM post_comments WHERE post_id = $comments and status = 'approved'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	$total_comments = $result['total_comments'];

	return $total_comments;

}









if(isset($_POST['submit_comment_btn'])){

	$url = "";

	if(isset($_POST['url']) and !empty($_POST['url'])){

		$url = htmlspecialchars(MRES($_POST['url']));

	}

	if(isset($_POST['name']) and !empty($_POST['name'])){

		if(isset($_POST['email']) and !empty($_POST['email'])){

			if(isset($_POST['comment_content']) and !empty($_POST['comment_content'])){

				global $post_id;

				$username = $_SESSION['username'];

				$name = htmlspecialchars(MRES($_POST['name']));

				$email = htmlspecialchars(MRES($_POST['email']));

				$comment_text = htmlspecialchars(MRES($_POST['comment_content']));

				$comment_date = date('Y-m-d');

				$parent_id = 0;

				if(isset($_COOKIE['comment_id']) and !empty($_COOKIE['comment_id'])){

					if(is_numeric($_COOKIE['comment_id'])){

						$parent_id = $_COOKIE['comment_id'];

						settype($parent_id, 'integer');

					}

				}



				$sql = "INSERT INTO post_comments (post_id, username, user_name, email, url, comment_date, comment, parent_id) VALUES($post_id, '$username', '$name', '$email', '$url', '$comment_date', '$comment_text', $parent_id)";

				$query = mysqli_query($connection, $sql);

				if($query){

					// header("Location: https://fb.com");

				}

				else{
					// header("Location: https://google.com");
				}

				
				
			}
			
		}
		
	}

}

function commentInputBox(){
	if(isset($_SESSION['username'])){ ?>

		<a name="comment"></a>
		<div class="p_comment_head_block">
			<p class="comment_tit">Write A Comment</p>
		</div>
		<div class="comment_writer_block">
			<form action="" method="post">
				<div class="p_comm_name_block">
					<div class="comment_input_block">
						<label for="p_c_name">Full Name<sup class="required_block">*</sup></label>
						<input type="text" id="p_c_name" class="p_c_name" name="name" placeholder="Enter Your Name Here" required>
					</div>
					<div class="comment_input_block">
						<label for="p_c_email">Email ID<sup class="required_block">*</sup></label>
						<input type="email" id="p_c_email" class="p_c_email" name="email" placeholder="Enter Your Email Id Here" required>
					</div>
					<div class="comment_input_block">
						<label for="p_c_url">URL</label>
						<input type="text" id="p_c_url" class="p_c_url" name="url" placeholder="Enter URL (Optional)">
					</div>
					<div class="char_counter_block">
						<span id="comment_char_count" class="comment_char_count">1024 Character Left</span>
					</div>
					<input min="0" max="100" value="0" type="range" id="char_range" disabled>
					<div class="comment_input_block">
						<textarea id="p_c_content" class="p_c_content" name="comment_content" rows="4" placeholder="Write Your Comment Here" onkeyup="get_comment_char_len()" maxlength="1024"></textarea>
					</div>
					<input type="submit" class="comment_submit_btn" name="submit_comment_btn" value="Post Comment" onclick="//document.cookie = 'comment_id='+''">
				</div>
			</form>
		</div>
	<?php
	}
}

?>
<style type="text/css">
	.comment_box_login_btn{
		text-decoration: none;
		color: #c0392b;
		font-size: 14px;
	}
</style>

<div class="post_comment_block">
	<?php commentInputBox(); ?>
	<?php
	if(!isset($_SESSION['username'])){
		echo '<span style="font-size: 14px; padding: 0 10px;">You have to login first to write Comment</span> <a href="' . SITE_URL . 'admin/login.php?redirect=' . THIS_PAGE . '" class="comment_box_login_btn">Login Now</a>';
	} ?>
	
	<div class="p_comment_head_block">
		<p class="comment_tit">Comments On This Post</p>
		<p class="comment_count"><?php echo totalCommentsCount(); ?> Comments</p>
		<i id="comment_block_expander" class="fas fa-plus" id="comments_expander" onclick="toggle_comment_box()"></i>
	</div>
	<div style="display: none;" id="comment_container" class="comments_container_block">

		<?php comments(); ?>

	</div>					
</div>
