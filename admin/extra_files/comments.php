<?php
include '../../config.php';
include '../../db_connector.php';


if(isset($_SESSION['role'])){
	$role = $_SESSION['role'];
	global $connection;
	if($role == 'admin'){
		$do = mysqli_real_escape_string($connection, $_POST['do']);

		if(isset($_POST['c_id']) and is_numeric($_POST['c_id'])){
			$c_id = $_POST['c_id'];
			$sql = "UPDATE post_comments SET status = '$do' WHERE comment_id = $c_id";
			$query = mysqli_query($connection, $sql);
			if($query){
				echo 'success';
			}
			else{
				echo 'Unable to update the status of the comment.';
			}
		}
		else{
			
		}
	}
}
?>