<?php

function userAge($date){

	$today = date('Y-m-d');

	$age = $today - $date;

	return$age;

}

?>