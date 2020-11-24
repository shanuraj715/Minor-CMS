<?php


function month_num_to_full_name($month){
	$month_list = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
	$month = ucfirst($month_list[$month - 1]);
	return $month;
}

function month_num_to_short_name($month){
	$month_list = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
	$month = ucfirst($month_list[$month - 1]);
	return $month;
}

function month_full_name_to_num($month){

}

function month_short_name_to_num($month){

}


?>