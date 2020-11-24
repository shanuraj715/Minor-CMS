<?php

ob_start();

$page = $_SERVER['SCRIPT_FILENAME'];

$page = explode('/', $page);

$page1 = $page[count($page) - 2];

$page1 .= '/' . $page[count($page) - 1];

if($page1 == 'admin/index.php'){

	header("Location: " . SITE_URL);

	exit();
}


?>