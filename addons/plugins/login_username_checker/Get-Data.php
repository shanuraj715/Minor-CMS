<?php

// This is a independent file, So every php function that can return any type of address will return the address of this file. 

$loc = getcwd(); // getting the directory of this file. default is (root/addons/plugins/login_username_checker/)

$loc = str_replace('\\', '/', $loc); // replacing all backslashes to forward slash

$loc = str_replace('addons/plugins/login_username_checker', '', $loc); // to get the root address so we can manually include the db_connector.php file. withot db_connector.php file we can not declare global $connection. after executing this statement we get the root address. next step is to concatinate the db_connector file in this address.

$loc .= 'db_connector.php'; // creating address for db_connector.php file.

include_once $loc; // including the db_connector.php file. so we can easily execute queries on the MySql Database

global $connection; // :)

if(isset($_GET['username'])){
	
	$s = $_GET['username'];

	$s = mysqli_real_escape_string($connection, $s);

	$sql = "SELECT user_id FROM users WHERE username = '$s'";
	// $sql .= " or user_id = '$s'";
	$sql .= " or email = '$s'";

	$query = mysqli_query($connection, $sql);

	$rows = mysqli_num_rows($query);

	if($rows != 1){
	
		echo "false";

	}
	else{
		echo "true";
	}

}
else{
	header("HTTP/1.0 500 Internal Server Error"); // showing 500 Internal Server Error for direct access and without $_GET['username']
}
?>