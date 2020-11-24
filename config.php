<?php
session_start();
ob_start();



date_default_timezone_set('Asia/Kolkata'); // setting site timezone to Asia/Kolkata (+5:30)

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	$site_protocol = "https://";
}
else{
	$site_protocol = "http://";
}



$date = date('Y-m-d'); 

define('DATE_YMD', $date); // defining a constant DATE_YMD (2000-01-01)

$this_page = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

define('THIS_PAGE', $site_protocol . $this_page); // defining a constant to get the current working page address

$login_key = "iamagoodcoderofphp7151";

define('LOGIN_KEY', $login_key);

$site_add = $_SERVER['HTTP_HOST'];
$site_add = str_replace('\\', '/', $site_add);

$site_dir = $site_protocol . $site_add . '/';
define('SITE_URL', $site_dir);




$site_dir = __DIR__;
$site_dir = str_replace('\\', '/', $site_dir);
$site_dir .= '/';
define('SITE_DIR', $site_dir);




$dashboard_page_location = SITE_DIR;
$dashboard_page_location .= 'admin/';
define('DASHBOARD_PAGE_ADDR', $dashboard_page_location); //this is used to share the directory location of dashboard page.(Absolute Path). Available in functions.php

?>