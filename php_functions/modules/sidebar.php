<?php
// activeWidgets() this function is created for sidebar to get this list of all active sidebar widgets. 
function activeWidgets(){
	$dir = getcwd(); // storing the current working directory. current working directory means from where this file is calling. if index page is including this page then this function will return the add of index file not its own.
	$dir = str_replace('\\', '/', $dir); // replacing all backslashes to forward slashes.
	$dir .= '/addons/widgets/'; // finalize the address of widget directory
	if (is_dir($dir)){ // checking the directory address for directory. if directory not available then it will escape this if and no sidebar widget will show.
		if ($dh = opendir($dir)){ // this will try to open the directory. if it fails then no sidebar will show.
	  		getActiveWidgets(); // calling a function. this function is created in this page.
	 		closedir($dh);
		}
	}
}

function getActiveWidgets(){ // this function is created to get list of all active widgets from the sql database.
	global $connection;

	$sql = "SELECT * FROM sidebar_widgets ";
	$sql .= "WHERE `status` = 'active'";
	$sql .= " ORDER BY widget_order ASC";

	$sql_q = mysqli_query($connection, $sql); 

	$loc = getcwd();
	$loc = str_replace('\\', '/', $loc);
	$loc .= '/addons/widgets/';

	while($sidebar_result = mysqli_fetch_assoc($sql_q)){ // loop for all the active widgets.

		$file = $sidebar_result['name']; // storing the widget name that has came from the database.
		$dir_loc = $loc . $file . '/';
		$loc2 = $dir_loc . $file . '.php';
		if(file_exists($loc2)){ // checking the file on server. if it exists or not.
			includeSidebarFiles($file); // function to include files of sidebar. function is written in this file.
		}	
	}
}

function includeSidebarFiles($file){
	$loc = getcwd();
	$loc = str_replace('\\', '/', $loc);
	$loc .= '/addons/widgets/' . $file . '/';
	$file_loc = $loc . $file . '.php';
		include($file_loc);
}

?>