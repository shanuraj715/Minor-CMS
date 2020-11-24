<?php

getActivePlugins();


function getActivePlugins(){

	global $connection;

	$sql = "SELECT * FROM plugins WHERE status = 'active'";

	$query = mysqli_query($connection, $sql);

	

	while($result = mysqli_fetch_assoc($query)){

		$dir_name = $result['name'];

		$dir_loc = SITE_DIR;

		//$dir_loc = str_replace('\\', '/', $dir_loc);

		$dir_loc .= 'addons/plugins/' . $dir_name . '/';

		if(is_dir($dir_loc)){

			if(file_exists($dir_loc . 'index.php')){

				$file_loc = $dir_loc . 'index.php';

				include $file_loc;

			}

		}

	}
}




?>