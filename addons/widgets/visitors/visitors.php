<?php

checkVisitorsDatabase();

function checkVisitorsDatabase(){
	global $connection;

	$sql = "SELECT * FROM s_w_visitors";

	$query = mysqli_query($connection, $sql);

	if($query != TRUE){
		
		$sql_query_string = array("CREATE TABLE `s_w_visitors` (`id` bigint(8) NOT NULL,`unique_ip` varchar(32) NOT NULL,`visit_date` date NOT NULL)", "ALTER TABLE `s_w_visitors` ADD PRIMARY KEY (`id`)", "ALTER TABLE `s_w_visitors` MODIFY `id` bigint(8) NOT NULL AUTO_INCREMENT");

		foreach ($sql_query_string as $key => $value) {
			$widget_status = mysqli_query($connection, $value);

			if(!$widget_status){
				// echo 'ww';
			}
		}
	}
}

function visitorsToday(){
	global $sql;
	$today = todayDate();
	$data = executeVisitorQuery($today);
	return $data;
}

function visitorsWeek(){
	$from_date = date('Y-m-d',(strtotime ( '-1 week', strtotime ( DATE_YMD) ) ));
	$data = executeVisitorQuery($from_date);
	return $data;
}

function visitors30Days(){
	$from_date = date('Y-m-d',(strtotime ( '-1 month', strtotime ( DATE_YMD) ) ));
	$from_date = date('Y-m-d',(strtotime ( '+1 day', strtotime ( $from_date) ) ));
	// echo $from_date;
	$data = executeVisitorQuery($from_date);
	return $data;
}

function visitorsMonth(){
	$date = date('d'); //21
	$date = '-' . $date . ' day'; // -21 day
	$from_date = date('Y-m-d',(strtotime ( $date, strtotime ( DATE_YMD) ) ));
	$date = date('d');
	if($date != 1){
		$from_date = date('Y-m-d',(strtotime ( '+1 day', strtotime ( $from_date) ) ));
	}
	else{
		$from_date = todayDate();
	}
	$data = executeVisitorQuery($from_date);
	return $data;
}




function getIP(){
	$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}

function todayDate(){
	$today = date('Y-m-d');
	return $today;
}

function executeVisitorQuery($from_date){
	global $connection;
	$today = todayDate();
	$sql = "SELECT * FROM s_w_visitors WHERE visit_date <= '$today' and visit_date >= '$from_date'";

	$query = mysqli_query($connection, $sql);

	$data = mysqli_num_rows($query);

	if($data <= 1){
		return $data . ' Visitor';
	}
	else{
		return $data . ' Visitors';
	}
}




function insertUserIP(){

	global $connection;

	$today = DATE_YMD;

	$userip = getIP();

	$user_ip_status = checkUserIp($userip);

	if($user_ip_status == 1){ 

		$sql = "INSERT INTO `s_w_visitors` (`unique_ip`, `visit_date`) VALUES('$userip', '$today')";

		$query = mysqli_query($connection, $sql);

		// if(!$query){
		// 	echo "DONE";
		// }
	}
}

function checkUserIp($ip){
	global $connection;

	$today = DATE_YMD;

	$sql = "SELECT unique_ip FROM s_w_visitors WHERE visit_date = '$today' and `unique_ip` = '$ip'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_num_rows($query);

	if($result == 0){
		return 1;
	}
	else{
		return 0;
	}
}














?>



<div class="sidebar_widget">
	<div class="w_latest_posts">
		<p class="w_widget_title">Site Visitors</p>
		<?php insertUserIP(); ?>
		<div class="w_widget_data" style="margin: 10px 0; padding: 2px 5px; background: rgba(209, 204, 192,0.5);">
			<div style="padding: 2px 0; margin: 4px 0; cursor: pointer" onmouseover="this.style.color = '#2980b9'" onmouseout="this.style.color = 'initial'">
				<span class="visitor_list my_ip">Your IP : <?php echo getIP(); ?></span>
			</div>


			<div style="padding: 2px 0; margin: 4px 0; cursor: pointer" onmouseover="this.style.color = '#2980b9'" onmouseout="this.style.color = 'initial'">
				<span class="visitor_list">Today : <?php echo visitorsToday(); ?></span>
			</div>


			<div style="padding: 2px 0; margin: 4px 0; cursor: pointer" onmouseover="this.style.color = '#2980b9'" onmouseout="this.style.color = 'initial'">
				<span class="visitor_list">Last 7 Days : <?php echo visitorsWeek(); ?></span>
			</div>


			<div style="padding: 2px 0; margin: 4px 0; cursor: pointer" onmouseover="this.style.color = '#2980b9'" onmouseout="this.style.color = 'initial'">
				<span class="visitor_list">Last 30 Days : <?php echo visitors30Days(); ?></span>
			</div>


			<div style="padding: 2px 0; margin: 4px 0; cursor: pointer" onmouseover="this.style.color = '#2980b9'" onmouseout="this.style.color = 'initial'">
				<span class="visitor_list">This Month : <?php echo visitorsMonth(); ?></span>
			</div>
		</div>
	</div>
</div>