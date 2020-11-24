<?php

function pluginList(){
	$plugin_path = SITE_DIR;
	// $plugin_path = str_replace('\\', '/', $plugin_path);
	$plugin_path .= 'addons/plugins/';
	if(is_dir($plugin_path)){
		$file_path = $plugin_path . 'index.php';
		if(file_exists($file_path)){
			include $file_path;
		}
	}
}

?>