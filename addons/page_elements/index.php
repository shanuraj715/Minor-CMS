<?php


getActivePageElements();

function getActivePageElements(){

	global $connection;

	$sql = "SELECT * FROM settings WHERE name = 'top_social_options'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	if($result['value'] == 'active'){

		$dir = getcwd();

		$dir = str_replace('\\', '/', $dir);

		$dir .= '/addons/page_elements/';

		$dir .= $result['name'] . '/' . $result['name'] . '.php';

		include($dir);
		
	}
}


?>