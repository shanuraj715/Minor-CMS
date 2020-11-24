<?php
session_start();
include('../../db_connector.php');
echo "dgdhjfgdhjfg";
if(isset($_GET['comment_id']) and !empty($_GET['comment_id'])){
	if(isset($_GET['action']) and !empty($_GET['action'])){
		echo "";
	}
	else{
		showComments();
	}
}
else{
	showComments();
}





function showComments(){
	global $connection;
	$sql = "SELECT * from post_comments WHERE status = 'approved'";
	$query = mysqli_query($connection, $sql);
	while($result = mysqli_fetch_assoc($query)){ ?>
	<div class="recent_comment_list_block">
		<div class="rec_comm_user_det_block">
			<p class="rec_comm_u_n_text"><i class="fas fa-user"></i> <?php echo $result['user_name']; ?></p>
			<p class="rec_comm_date_text"><i class="fas fa-calendar-alt"></i> <?php echo $result['comment_date']; ?></p>
		</div>
		<div class="comment_text_block">
			<p class="comment_text"><?php echo $result['comment']; ?></p>
			<div class="rec_comm_action_btn_container">
				<a class="rec_comm_btn approve_btn" onclick="commentAction(<?php echo $result['comment_id']; ?>, 'approve')">Approve</a>
				<a class="rec_comm_btn unapprove_btn" onclick="commentAction(<?php echo $result['comment_id']; ?>, 'unapprove')">Unapprove</a>
				<a class="rec_comm_btn trash_btn" onclick="commentAction(<?php echo $result['comment_id']; ?>, 'trash')">Trash</a>
				<a class="rec_comm_btn spam_btn" onclick="commentAction(<?php echo $result['comment_id']; ?>, 'spam')">Spam</a>
			</div>
		</div>
	</div>
	<?php
	}
}
?>