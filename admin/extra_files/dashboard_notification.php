<?php

session_start();

// This is a independent file, So every php function that can return any type of address will return the address of this file. 

$loc = getcwd(); // getting the directory of this file. default is (root/addons/plugins/login_username_checker/)

$loc = str_replace('\\', '/', $loc); // replacing all backslashes to forward slash

$loc = str_replace('admin/extra_files', '', $loc); // to get the root address so we can manually include the db_connector.php file. withot db_connector.php file we can not declare global $connection. after executing this statement we get the root address. next step is to concatinate the db_connector file in this address.

$loc .= 'db_connector.php'; // creating address for db_connector.php file.

include_once $loc; // including the db_connector.php file. so we can easily execute queries on the MySql Database

global $connection; // :)

if(isset($_SESSION['userid']) and !empty($_SESSION['userid'])){

	$userid = $_SESSION['userid'];

	if(!isset($_GET['action'])){
		
		d_n_query(); // for normal query to get all notifications for logged user

	}

	elseif(isset($_GET['action']) and !empty($_GET['action']) and isset($_GET['nid']) and !empty($_GET['nid'])){

		$notification_id = $_GET['nid'];

		$notification_id = mysqli_real_escape_string($connection, $notification_id);

		if($_GET['action'] == 'trash'){

			$sql = "UPDATE `cms_notification` SET `status` = 'trash' WHERE `cms_notification`.`id` = $notification_id and user_id = $userid";

			$query = mysqli_query($connection, $sql);

			if($query){

				d_n_query();

			}

		}

		elseif($_GET['action'] == 'mark'){

			$sql = "UPDATE `cms_notification` SET `readed` = 'yes' WHERE `cms_notification`.`id` = $notification_id and user_id = $userid";

			$query = mysqli_query($connection, $sql);

			if($query){

				d_n_query();

			}

		}

		



	}
	else{
		header("HTTP/1.0 500 Internal Server Error"); // showing 500 Internal Server Error for direct access and without $_GET['username']
	}
}
else{
	header("HTTP/1.0 500 Internal Server Error"); // showing 500 Internal Server Error for direct access and without $_GET['username']
}

function d_n_query(){
	global $connection;

	global $userid;

	$userid = mysqli_real_escape_string($connection, $userid);

	$sql = "SELECT * FROM cms_notification WHERE";
	$sql .= " user_id = $userid ";
	// $sql .= "and readed = 'unread' ";
	$sql .= "and status = 'inbox' ";
	$sql .= "ORDER BY id DESC";

	$query = mysqli_query($connection, $sql);

	$rows = mysqli_num_rows($query);

	if($rows == 0){
	
		echo '<p style="text-align: center; font-size: 22px;">No New Notification.</p>';

	}
	else{

		while($result = mysqli_fetch_assoc($query)){

			printNotifications($result);

		}
		
	} ?>
	<script type="text/javascript">
			$('[id = "notification_url"]').magnificPopup({
				type: 'iframe'
			});
		
	</script>
<?php
}



function printNotifications($result){
	$content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result['content']); //removing invalid characters
	if($result['readed'] == 'no'){
		$bg_color = 'background-color: rgba(47, 53, 66,0.2);'; // background colour for non readed notifications
	}
	else{
		$bg_color = 'background-color: initial;';
	}
 ?>
	<div style="<?php echo $bg_color; ?>" id="notification_line_block" class="notification_line_block">

		<p id="notification_content" class="notification_content" style="cursor: pointer;"><?php echo $content; ?></p>

		<div class="notification_extra_options">

			<a id="notification_url" class="notification_url" href="<?php echo $result['url']; ?>" title="Visit this page now. Link will open in New Tab."><?php echo substr($result['url'], 0, 40); ?>... </a>

			<div class="notification_btns_block">

				<span id="mark_<?php echo $result['id']; ?>" class="notification_readed_btn" onclick="markRead(<?php echo $result["id"];?>)" title="Mark as read."><i class="fas fa-check-square"></i></span>

				<span id="notification_trash_btn" class="notification_trash_btn" onclick="trashNotification(<?php echo $result["id"];?>)" title="Move to trash"><i class="fas fa-trash-alt"></i></span>

			</div>

		</div>

	</div>
	
	<?php
}
?>