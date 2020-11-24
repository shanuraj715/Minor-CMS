<?php

checkRowInSettingsTable();

function checkRowInSettingsTable(){

	global $connection;

	$sql = "SELECT * FROM settings WHERE name = 'post_by_date'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_num_rows($query);

	if($result == 0){

		$sql = "INSERT INTO settings(`name`, `value`) VALUES('post_by_date', 'date')"; // if no row in settings table then this will insert a row for it's settings in settings table

		$query = mysqli_query($connection, $sql);

		if(!$query){

			echo "Widget Inclusion Failed";

		}

	}

}


function post_by_date_GetWidgetType(){ // By Date Or By Month Or By Year etc...

	global $connection;

	$sql = "SELECT * FROM settings WHERE name = 'post_by_date'"; // Query to get the widget type (Date or Month Or Year etc...)

	$query = mysqli_query($connection, $sql); // Executing query on MySql database to get the widget type.

	$type = mysqli_fetch_assoc($query); // string the result into a associative array.

	$type = $type['value']; // Overwriting on $type variable to the value that the sql has returned.

	$type = strtolower($type); // Converting data into lowercase

	settype($type, 'string'); // Typecasting to String. this is used because the widget check if else conditions on string data type. So to prevent any future error, it is strongly set to String.

	if($type == "" and $type != NULL){ // if database returned a black value then the widget will default set to date.

		$type = 'date';

	}

	return $type; // returning data

}
?>
<div class="sidebar_widget">
	<div class="w_latest_posts">
		<?php
		$type = post_by_date_GetWidgetType(); // calling from this page.
		if($type == 'date'){ // For Widget type Date. ?>
			<p class="w_widget_title">Posts By Date</p>
			<p id="pdd_month_name" style="padding: 0; margin: 5px 0; cursor: pointer; position: relative;"><?php echo date('F-Y'); ?>
				<span id="pdd_hover_text" style="display: none; position: absolute; top: 20px; left: 15px; min-width: 240px; max-width: 240px; background-color: #81ecec; padding: 6px; border: solid 2px black; border-radius: 5px;">This section can only show the current month dates. You can not view any other month date here.</span>
			</p>
			<div style="margin: 8px 2px; text-align: center; display: contents;">
				<table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
					<tbody>
						<!-- <tr style="width: 300px; background: rgba(209, 204, 192,0.5); border-radius: 4px; overflow: hidden;">
							<th style="padding: 5px 0;">M</th>
							<th style="padding: 5px 0;">T</th>
							<th style="padding: 5px 0;">W</th>
							<th style="padding: 5px 0;">T</th>
							<th style="padding: 5px 0;">F</th>
							<th style="padding: 5px 0;">S</th>
							<th style="color: red;">S</th>
						</tr> -->
						<span style="display: block; height: 5px; border-bottom: solid 2px #2d3436;"></span>
						<?php
						$start_date = 1; // month calender will start from 1st day.
						$end_date = date('d'); // month day till today date
						$month = date('m');
						$year = date('Y');

						while($start_date <= $end_date){
							if($start_date <= 9){
								$link_date = '0' . $start_date;
							}
							else{
								$link_date = $start_date;
							}
							if($start_date%7 == 1){ // for date is 8, 15, 22, 29 ?>
								<tr>
								<td style="border-radius: 4px; text-align: center;" onmouseover="this.style.background = '#16a085'" onmouseout="this.style.background = 'initial'">
									<a style="text-decoration: none; color: black;" href="<?php echo SITE_URL; ?>?show-by-date=true&date=<?php echo $year . '-' . $month . '-' . $link_date; ?>"><?php echo $start_date; ?></a>
								</td>
								<?php
							}
							elseif($start_date%7 == 0){ // for date 7, 14, 21, 28 ?>
								<td style="border-radius: 4px; text-align: center;" onmouseover="this.style.background = '#16a085'" onmouseout="this.style.background = 'initial'">
									<a style="text-decoration: none; color: red;" href="<?php echo SITE_URL; ?>?show-by-date=true&date=<?php echo $year . '-' . $month . '-' . $link_date; ?>"><?php echo $start_date; ?></a>
								</td>
								</tr>
								<?php
							}
							else{ // for all dates except 7, 8, 14, 15, 21, 22, 28, 29 ?>
								<td style="border-radius: 4px; text-align: center;" onmouseover="this.style.background = '#16a085'" onmouseout="this.style.background = 'initial'">
									<a style="text-decoration: none; color: black;" href="<?php echo SITE_URL; ?>?show-by-date=true&date=<?php echo $year . '-' . $month . '-' . $link_date; ?>"><?php echo $start_date; ?></a>
								</td>
								<?php
							}
							$start_date++; // incrementing the date
						}
						?>
					</tbody>
				</table>
			</div>
		<?php
		}
		if($type == 'month'){ // For Widget type Month. ?>
			<p class="w_widget_title">Posts By Month</p>
			<p style="padding: 0; margin: 5px 0; cursor: pointer;">For This Year</p>
			<div style="display: grid; background: rgba(209, 204, 192,0.5);">
				<?php
				$current_month = date('m');
				$current_year = date('Y');
				$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
				for($i=0; $i < $current_month; $i++){ ?>
					
					<a style="text-decoration: none; color: black; padding: 1px 5px; margin: 3px 2px; border-radius: 4px;" href="<?php echo SITE_URL . '?show-by-date=true&month=' . $months[$i] . '&year=' . $current_year; ?>" onmouseover="this.style.background = '#16a085'" onmouseout="this.style.background = 'initial'"><?php echo $months[$i]; ?></a>
				<?php
				} ?>
			</div>
			<?php
		}
		if($type == 'year'){ // For Widget type Year. ?>
			<p class="w_widget_title">Posts By Year</p>
			<div style="display: grid; background: rgba(209, 204, 192,0.5); margin: 10px 0;">
				<?php
				global $connection;
				$sql = "SELECT MIN(post_date) as start_date, MAX(post_date) as to_date FROM posts WHERE post_status = 'published'";
				$query = mysqli_query($connection, $sql);
				$result = mysqli_fetch_assoc($query);

				$min_year = $result['start_date'];
				$min_year = strtotime($min_year);
				$min_year = date('Y', $min_year); 

				$max_year = $result['to_date'];
				$max_year = strtotime($max_year);
				$max_year = date('Y', $max_year); 
				while($min_year <= $max_year){ ?>
					<a href="<?php echo SITE_URL . '?show-by-date=true&year=' . $min_year; ?>" style="margin: 3px 2px; padding: 1px 2px; text-decoration: none; color: black; border-radius: 4px;" onmouseover="this.style.background = '#16a085'" onmouseout="this.style.background = 'initial'"><?php echo $min_year; ?></a>
					<?php
					$min_year++;
				} ?>
			</div>
			<?php
		} ?>
	</div>
</div>


<script type="text/javascript">
	$("#pdd_month_name").hover(function(){
		
		$("#pdd_hover_text").css("display","initial");

	}, function(){

		$("#pdd_hover_text").css("display","none");

	});


</script>