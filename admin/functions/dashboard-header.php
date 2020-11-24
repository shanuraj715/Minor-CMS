<?php

function userNotification(){

	global $connection;

	$userid = $_SESSION['userid'];

	$sql = "SELECT * FROM cms_notification WHERE";
	$sql .= " user_id = $userid ";
	$sql .= "and readed = 'unread' ";
	$sql .= "and status = 'inbox' ";
	$sql .= "ORDER BY id DESC";

	$query = mysqli_query($connection, $sql);

	if($query){

		while($result = mysqli_fetch_assoc($query)){ ?>
			<div id="notification_line_block" class="notification_line_block">
				<p id="notification_content" class="notification_content"><?php echo $result['content']; ?></p>
				<div class="notification_extra_options">
					<a id="notification_url" class="notification_url" href="<?php echo $result['url']; ?>" target="_blank"><?php echo substr($result['url'], 0, 40); ?> ...</a>
					<span class="notificatio_readed_btn">Mark as Read</span>
				</div>
			</div>
			<?php
		}
	}

}

?>