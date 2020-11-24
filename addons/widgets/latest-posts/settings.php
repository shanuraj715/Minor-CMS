<?php

/* Updation Process */

if(isset($_POST['submit_settings'])){
	if(isset($_POST['date_flag']) and !empty($_POST['date_flag'])){
		$date_flag = MRES($_POST['date_flag']);
	}
	else{
		$date_flag = 'disable';
	}

	if(isset($_POST['post_limit']) and !empty($_POST['post_limit']) and is_numeric($_POST['post_limit'])){
		if($_POST['post_limit'] >= 2 and $_POST['post_limit'] <= 20){
			$post_limit = $_POST['post_limit'];
		}
		else{
			$post_limit = 10;
		}
	}
	else{
		$post_limit = 10;
	}

	$status = lp_updateRecord('latest_post_limit', $post_limit);
	if($status){
		$status = lp_updateRecord('latest_post_show_date', $date_flag);
		if($status){
			showSuccessWindow("Done...","Settings Successfully Updated.");
		}
		else{
			showErrorWindow("Error!!!", "Unable to update the settings.");
		}
	}
	else{
		showErrorWindow("Error!!!", "Unable to update the settings.");
	}
}

/* get Data */

$show_date_on_post_status = lp_selectRecord('latest_post_show_date');
$show_date_on_post_status = $show_date_on_post_status['value'];
if($show_date_on_post_status == 'enable'){
	$sdops_flag = 'checked';
}
else{
	$sdops_flag = '';
}

$number_of_posts = lp_selectRecord('latest_post_limit');
$number_of_posts = $number_of_posts['value'];





function lp_updateRecord($column_name, $value){
	global $connection;
	$sql = "UPDATE settings SET value = '$value' WHERE name = '$column_name'";
	$query = mysqli_query($connection, $sql);
	if($query){
		return true;
	}
	else{
		return false;
	}
}

function lp_selectRecord($column_name){
	global $connection;
	$sql = "SELECT * FROM settings WHERE name = '$column_name'";
	$query = mysqli_query($connection, $sql);
	if($query){
		$result = mysqli_fetch_assoc($query);
		return $result;
	}
}
?>

<style type="text/css">
	.sw_lpw_settings_container{
		margin: 0 5px;
	}

	.sw_lpw_title{
		margin: 10px 20px;
		font-family: monospace;
		font-size: 20px;
	}

	.sec_a{
		background: rgba(56, 173, 169,0.1);
		padding: 5px;
		margin: 10px 0;
	}

	.sec_a input[type=checkbox]{
		transform: scale(1.2);
		margin: 0 15px;
	}

	.sec_a label{
		margin: 0 10px;
	}

	.submit_btn_block{
		text-align: center;
	}

	.submit_btn_block input{
		height: 30px;
		padding: 8px 25px;
		border: solid 1px rgba(7, 153, 146,1.0);
		border-radius: 15px;
		outline: none;
		cursor: pointer;
		transition: 0.2s linear;
	}

	.submit_btn_block input:hover{
		background: rgba(88, 177, 159,1.0);
		color: white;
	}

	.post_limit_num{
		width: 50px;
		border: solid 1px rgba(74, 105, 189,1.0);
		padding: 3px 5px;
		border-radius: 5px;
		outline: none;
	}


</style>

<div class="sw_lpw_settings_container">
	
	<p class="sw_lpw_title">General Settings</p>

	<form action="" method="POST">
		<div class="sec_a">
			<input type="checkbox" name="date_flag" id="date_flag_cb" value="enable" <?php echo $sdops_flag; ?>>
			<label for="date_flag_cb">Show date on posts</label>
		</div>


		<div class="sec_a">
			<label for="post_limit">Number of Posts to show</label>
			<input class="post_limit_num" type="number" name="post_limit" id="post_limit" value="<?php echo $number_of_posts; ?>" min="0" max="20">
		</div>

		<div class="submit_btn_block">
			<input type="submit" name="submit_settings">
		</div>
	</form>

</div>

<script type="text/javascript">
	


</script>