<style type="text/css">
	*{
		background: white;
	}
</style>
<?php
// this page is used to display the user profile details. we can only open this by iframe on dashboard.php page. it will not work alone.

include '../../config.php';
include SITE_DIR . 'db_connector.php';
include SITE_DIR . 'admin/functions/functions.php';
if(!isset($_SESSION['username']) or !isset($_SESSION['role'])){
	header("Location: " . SITE_URL . 'admin/login.php');
}

if(isset($_GET['user_id']) and is_numeric($_GET['user_id'])){
	if($_SESSION['role'] == 'admin'){
		$user_id = $_GET['user_id'];
	}
	else{
		$user_id = $_SESSION['userid'];
	}
}
else{
	$user_id = $_SESSION['userid'];
}

global $connection;
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$query = mysqli_query($connection, $sql);
if($query){
	$result = mysqli_fetch_assoc($query);
	$row = mysqli_num_rows($query);
	if($row == 0){
		echo "Please reload the page. Server returned an error...";
		exit();
	}
	$reg_date = date('d-m-Y', strtotime($result['reg_date']));
	$reg_time = date('h:i:s A', strtotime($result['reg_date']));
	if($result['image'] == ""){
		$result['image'] = 'default.jpg';
	}
}
else{
	notAvailableAtThisTime();
	exit();
}


?>

<style type="text/css">

	*{
		margin: 0;
		padding: 0;
	}
	.users_details_container{
		background: white;
		padding: 10px;
		border-radius: 5px;
		margin: 15px;
		border: solid 2px rgba(45, 52, 54,1.0);
		/*min-height: 94vh;*/
	}

	.user_details_row_block{
		display: flex;
		font-family: monospace;
		font-size: 17px;
		margin: 5px 0;
		padding: 7px;
	}

	.user_det_title{
		display: inline-block;
		min-width: 140px;
		font-weight: bold;
	}

	.users_image_az{
		width: 150px;
		max-height: 300px;
		max-width: 300px;
		position: absolute;
		right: 20px;
	}

	.users_image_az img{
		width: 150px;
		max-height: 300px;
		max-width: 300px;
	}
</style>

<div class="users_details_container">


	<div class="user_details_row_block users_image_az">
		<img src="<?php echo SITE_URL . 'images/users/' . $result['image']; ?>">
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">User ID : </span>
		<span class="user_det_value"><?php echo $result['user_id']; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">First Name : </span>
		<span class="user_det_value"><?php echo $result['fname']; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Last Name : </span>
		<span class="user_det_value"><?php echo $result['lname']; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Username : </span>
		<span class="user_det_value"><?php echo $result['username']; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Email ID : </span>
		<span class="user_det_value"><?php echo $result['email']; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Mobile : </span>
		<span class="user_det_value"><?php echo $result['mobile']; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Gender : </span>
		<span class="user_det_value"><?php echo ucfirst($result['gender']); ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Status : </span>
		<span class="user_det_value"><?php echo ucwords($result['status']); ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Reg. Date : </span>
		<span class="user_det_value"><?php echo $reg_date; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Reg. Time : </span>
		<span class="user_det_value"><?php echo $reg_time; ?></span>
	</div>


	<div class="user_details_row_block">
		<span class="user_det_title">Role : </span>
		<span class="user_det_value"><?php echo ucfirst($result['role']); ?></span>
	</div>
</div>