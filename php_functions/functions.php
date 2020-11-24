<?php

function checkLogged(){

	if(isset($_SESSION['username']) and !empty($_SESSION['username'])){

		if(isset($_SESSION['email']) && !empty($_SESSION['email'])){

			return true;

		}

		else{

			return false;

		}

	}

	else{

		return false;

	}

}

function MRES($data){
	global $connection;
	$data = mysqli_real_escape_string($connection, $data);
	return $data;
}

function cms_head_linking(){ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/fonts-awesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/header.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/navigation.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/index.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/sidebar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/footer.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/post.css">

	<script type="text/javascript" src="<?php echo SITE_URL;?>js_functions/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js_functions/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js_functions/shortcut_keys.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js_functions/functions.js"></script>
	<?php siteIcon();
}

function siteIcon(){ ?>
	<link rel="icon" href="<?php echo SITE_URL . '/images/fevicon.png';?>">
	<?php
}

function siteTitle(){
	global $connection;
	$sql = "SELECT value FROM settings WHERE name = 'site_title'";
	$query = mysqli_query($connection, $sql);
	$site_title = mysqli_fetch_assoc($query);
	return $site_title['value'];
}

function siteDescription(){
	global $connection;
	$sql = "SELECT value FROM settings WHERE name = 'site_description'";
	$query = mysqli_query($connection, $sql);
	$site_description = mysqli_fetch_assoc($query);
	return $site_description['value'];
}

function siteLogo(){
	global $connection;
	$sql = "SELECT value FROM settings WHERE name = 'site_logo'";
	$query = mysqli_query($connection, $sql);
	$site_logo = mysqli_fetch_assoc($query);
	return $site_logo['value'];
}

?>