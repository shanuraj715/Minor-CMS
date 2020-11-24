<?php

function monthList(){
	$month_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	return $month_list;
}

function daysInMonth($month, $type){
	$type = strtolower($type);
	if($type == 'int' or $type == 'integer'){
		settype($month, 'integer');
		$month_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		$month = $month - 1;
		$month = $month_list[$month];
		$month = strtolower($month);
		if($month == 'january' or $month == 'march' or $month == 'may' or $month == 'july' or $month == 'august' or $month == 'october' or $month == 'december'){
			$days_in_month = 31;
		}
		elseif($month == 'february'){
			if(date('Y') / 4 == 0){
				$days_in_month = 29;
			}
			else{
				$days_in_month = 28;
			}
		}
		else{
			$days_in_month = 30;
		}
	}
	elseif($type == 'string' or $type == 'str'){
		$month = strtolower($month);
		if($month == 'january' or $month == 'march' or $month == 'may' or $month == 'july' or $month == 'august' or $month == 'october' or $month == 'december'){
			$days_in_month = 31;
		}
		elseif($month == 'february'){
			if(date('Y') / 4 == 0){
				$days_in_month = 29;
			}
			else{
				$days_in_month = 28;
			}
		}
		else{
			$days_in_month = 30;
		}
	}
	return $days_in_month;
}




?>