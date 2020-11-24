<?php

header_notification_checkDatabase();

function header_notification_checkDatabase(){

	global $connection;

	$sql = "SELECT * from p_header_notification";

	$query = mysqli_query($connection, $sql);

	if($query != TRUE){

		$sql = array("CREATE TABLE `p_header_notification` (`id` int(3) NOT NULL, `title` varchar(120) NOT NULL, `url` varchar(255) DEFAULT NULL, `url_btn_title` varchar(32) DEFAULT NULL)", "ALTER TABLE `p_header_notification` ADD PRIMARY KEY (`id`)", "ALTER TABLE `p_header_notification` MODIFY `id` int(3) NOT NULL AUTO_INCREMENT", "INSERT INTO p_header_notification(`title`, `url`) VALUES('Welcome Back', NULL)");

		foreach ($sql as $value) {
			
			$query = mysqli_query($connection, $value);

		}

	}

}

function header_notification_notificationDate(){

	global $connection;

	$sql = "SELECT * FROM p_header_notification ORDER BY id DESC";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	return $result;

}

function header_notification_Elements($data){

	$notification_title = $data['title'];

	$notification_url = $data['url'];

	$notification_btn_title = $data['url_btn_title'];

	if($notification_btn_title == NULL){

		$notification_btn_title = "Click Here";

	} ?>

	<div style="flex-grow: 1; max-width: 85%; text-align: left; padding: 0 10px;">
		<span style="color: white; line-height: 40px; font-size: 15px;"><?php echo $notification_title; ?></span>
	</div>

	<?php

	if($notification_url != NULL){ ?>
	
		<div style="text-align: center;">
			<a href="<?php echo $notification_url; ?>" style="background:  rgba(0, 151, 230,1.0); line-height: 40px; padding: 4px 10px; border-radius: 5px; text-decoration: none; color: white;" target="_blank"><?php echo $notification_btn_title; ?></a>
		</div>

		<?php

	}

}

$data = header_notification_notificationDate();


if(!isset($_COOKIE['header_notification']) or $_COOKIE['header_notification'] != 'false'){ ?>


	<div id="header_notification1_block" style="position: fixed; display: block; z-index: 1; top: 0; left: 0; background: rgba(53, 59, 72,1.0); height: 40px; max-height: 40px; border-radius: 5px; box-shadow: 0px 2px 5px rgba(22, 160, 133,1.0); width: 100%; display: flex; text-align: center; border-bottom: solid 2px white; min-width: 900px;">

		<?php header_notification_Elements($data); ?>

		

		<div style="text-align: center; width: 100px; min-width: 100px; max-width: 100px;">
			<i class="far fa-window-close" style="line-height: 40px; font-size: 25px; color: white;" onclick="header_notification_hide()"></i>
		</div>
	</div>
	<?php
}
?>




<script type="text/javascript">
var sec = 0;
	
function header_notification_hide(){
	document.getElementById('header_notification1_block').style.display = 'none';
	setCookie('header_notification', 'false', 1);
	sec = 15;
}

window.onload = hideThis();

function hideThis(){
	if(sec<=15){
		// console.log(sec);
		var t = setTimeout(hideThis, 1000);
		sec++;
	}
	else{
		document.getElementById('header_notification1_block').style.display = 'none';
		setCookie('header_notification', 'false', 1);
	}
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

</script>