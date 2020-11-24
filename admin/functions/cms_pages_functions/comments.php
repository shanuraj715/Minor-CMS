<?php

function commentList(){
	global $connection;

	$sql = "SELECT * FROM post_comments ORDER BY comment_id DESC LIMIT 40";
	$query = mysqli_query($connection, $sql);
	while($result = mysqli_fetch_assoc($query)){ ?>
		<div class="dash_comment_block">
			<p class="dash_comm_title"><?php echo $result['comment'];?></p>
			<p class="dash_comm_url"><?php echo $result['url'];?></p>
			<span class="dash_comm_date"><?php echo $result['comment_date'];?></span>
			<span class="dash_comm_user"><?php echo $result['username'];?></span>
			<span class="dash_on_post"<?php echo $result['post_id'];?>></span>
			<span class="dash_comm_email"><?php echo $result['email'];?></span>
			<span class="dash_comm_status"><?php echo $result['status'];?></span>
			<div class="dash_comm_action_block">
				<?php
				if($result['status'] == 'pending'){ ?>
					<button class="dash_comm_action_approve" onclick="approveComment(<?php echo $result['comment_id'];?>)">Approve</button>
					<?php
				}
				else{ ?>
					<button class="dash_comm_action_unapprove" onclick="unapproveComment(<?php echo $result['comment_id'];?>)">Unapprove</button>
				<?php
				} ?>
			</div>
		</div>
	<?php
	}
}




?>