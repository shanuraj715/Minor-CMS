<?php

global $connection;
$sql = "SELECT * from settings WHERE name = 'site_title'";
$query = mysqli_query($connection, $sql);
$site_title = mysqli_fetch_assoc($query);
$site_title = $site_title['value'];


define('SITE_TITLE', $site_title);

?>