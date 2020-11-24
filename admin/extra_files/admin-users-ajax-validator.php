<?php

// use this page as ajax. this will return the true or false based on the query. this can do some query.
// mainly this page is using on dashboard.php ad add user option.

// when admin enters the details like email or username this page will check the details live on the server

include_once '../../config.php';
include_once SITE_DIR . 'db_connector.php';

if(!isset($_SESSION['username']) or !isset($_SESSION['role'])){
	if($_SESSION['role'] != 'admin'){
		header("Location: " . SITE_URL . 'admin/login.php');
		exit();
	}
}

global $connection;

if(isset($_GET['username']) and !empty($_GET['username'])){
	$username = mysqli_real_escape_string($connection, $_GET['username']);
	echo sql_query('username', $username);
}
if(isset($_GET['email']) and !empty($_GET['email'])){
	$email = mysqli_real_escape_string($connection, $_GET['email']);
	echo sql_query('email', $email);
}






function sql_query($column_name, $data){
	global $connection;
	$sql = "SELECT $column_name FROM users WHERE $column_name = '$data'";
	$query = mysqli_query($connection, $sql);
	if($query){
		$rows = mysqli_num_rows($query);
		if($rows >= 1){
			return 'true';
		}
		else{
			return 'false';
		}
	}
	else{
		return 'false';
	}
}

?>