<?php

$db['db_host'] = 'localhost';

$db['db_user'] = '';

$db['db_password'] = '';

$db['db_name'] = '';

foreach ($db as $db_key => $db_value) {

	define(strtoupper($db_key), $db_value);

}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(!$connection){
	die("Connection to the database has not been established.");
}

?>