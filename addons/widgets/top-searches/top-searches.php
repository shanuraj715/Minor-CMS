<?php

checkTopSearchesDatabase(); // everytime when any page is loading and the this sidebar widget is called the this function will automatically called to check the status of the database availability.
insertIntoDatabase();
function insertIntoDatabase(){ // function to store the search data in the database.
	global $connection;
	if(checkTopSearchesDatabase()){ // if database exists then start the  process to store the search data into the database.

		if(isset($_GET['s']) and !empty($_GET['s'])){ // only store when user search anythihg from the search box and successfully open the search page. it can aslo work even the user has not searched anything from the search box and directly changed the search parameters of search page (ex: also work on manually types url like. search.php?s=xyz or search.php?s=abc)

			$search_data = $_GET['s']; // getting the search parameters from the url.
			$search_data = MRES($search_data); // MRES means mysqli_real_escape_string. MRES() is a global function created in /root/php_functions/functions.php. 

			if (excludeWord($search_data)) { //excudeWord() is a function that checks the search data for not valid words or illegal words. if the searched text contains any of that word then that word will not stored into the database.

				$userip = ts_getIP(); // storing the userip 

				$today = ts_todayDate(); // storing the today date

				$sql = "SELECT id FROM `all_search` WHERE search_date = '$today' and user_ip = '$userip'"; // query to get all data that has inserted in the database for that user on that day.

				$query = mysqli_query($connection, $sql);

				$result = mysqli_num_rows($query);

				if($result<8){ // limiting a user to store max num of searches in database. 8 searches can store in one day per user(IP). It can also use to prevent 

					$sql = "SELECT * FROM all_search WHERE search_date = '$today' and user_ip = '$userip' and search_data = '$search_data'";

					$query = mysqli_query($connection, $sql);

					$result = mysqli_num_rows($query);

					if($result == 0){

						$sql = "INSERT INTO `all_search` (`search_data`, `search_date`, `user_ip`) VALUES('$search_data', '$today', '$userip')";

						$query = mysqli_query($connection, $sql);

						if(!$query){
							echo "Not Inserted";
						}
					}
				}
			}
		}
	}
}




function excludeWord($search_data){
	$array = ['ludhiana', 'punjab', 'chandigarh'];
	$search_data = strtolower($search_data);
	$flag1 = true;
	foreach ($array as $value) {
		$value = strtolower($value);
		if($search_data == $value){
			$flag1 = false;
		}
	}
	if($flag1 == true){
		return true;
	}
	else{
		return false;
	}
}



function ts_getIP(){
	$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}

function ts_todayDate(){
	$today = date('Y-m-d');
	return $today;
}


function checkTopSearchesDatabase(){
	global $connection;

	$sql = "SELECT * FROM all_search";

	$query = mysqli_query($connection, $sql);

	if($query != TRUE){
		
		$sql_query_string = array("CREATE TABLE `all_search` (`id` bigint(8) NOT NULL,`search_data` varchar(255) NOT NULL,`search_date` date DEFAULT NULL)", "ALTER TABLE `all_search` ADD PRIMARY KEY (`id`)", "ALTER TABLE `all_search` MODIFY `id` bigint(8) NOT NULL AUTO_INCREMENT");

		foreach ($sql_query_string as $key => $value) {
			$widget_status = mysqli_query($connection, $value);
			if($widget_status){
				return true;
			}
		}
	}
	else{
		return true;
	}
}



function topSearchShowFrom(){
	global $connection;

	$sql = "SELECT value from settings where name = 'top_search_show_days'";

	$query = mysqli_query($connection, $sql);

	$top_search = mysqli_fetch_assoc($query);

	$top_search_from = '-';

	$top_search_from .= $top_search['value'];

	$top_search_from .= ' day'; // this will store the number of days for top searches

	$from_date = date('Y-m-d',(strtotime ( $top_search_from, strtotime ( DATE_YMD) ) )); // this will store the starting date for top searches

	return $from_date;
}

function topSearchQuery($show_from){
	global $connection;

	strtotime($show_from);

	$sql = "SELECT value from settings where name = 'top_search_show_limit'";

	$query = mysqli_query($connection, $sql);

	$limit_top_searches = mysqli_fetch_assoc($query);

	$limit = $limit_top_searches['value'];

	settype($limit, "integer");

	$sql_top_search_data = "SELECT DISTINCT search_data FROM all_search WHERE search_date > '$show_from'";

	$search_q = mysqli_query($connection, $sql_top_search_data);

	//----------------------------------------------
	while($search_result = mysqli_fetch_assoc($search_q)){
		$search_text = $search_result['search_data'];
			$sql_top_search_data = "SELECT COUNT(search_data) as search_count FROM all_search WHERE search_date > '$show_from' and `search_data` = '$search_text'";

			$search_count_q = mysqli_query($connection, $sql_top_search_data);

			$search_count = mysqli_fetch_assoc($search_count_q);
		 ?>
		<a href="<?php echo SITE_URL . 'search.php?s=' . $search_result['search_data']; ?>" class="w_search_link" title="<?php echo $search_count['search_count']; ?> times searched"><?php echo $search_result['search_data'];?></a>
		<?php
	}
}
?>
<div class="sidebar_widget">
	<div class="w_top_searches_block">
		<?php
		global $connection;
		$sql = "SELECT * FROM all_search limit 1";
		$query = mysqli_query($connection, $sql);
		$top_search_count = mysqli_num_rows($query);
		$today_date = DATE_YMD;
		$show_from = topSearchShowFrom(); // getting the starting date of top searches

		// $top_search_data = topSearchQuery($show_from);
		 ?>
		<p class="w_widget_title">Top Searches</p>
		<div class="w_search_block">
			<?php
			if($top_search_count!=0){
				topSearchQuery($show_from);
			}
			?>
		</div>
	</div>
</div>