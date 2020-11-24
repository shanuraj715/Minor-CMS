<?php

if(isset($_POST['submit_settings'])){
	if(isset($_POST['pbd_view_type_radio']) and !empty($_POST['pbd_view_type_radio'])){

		global $connection;

		$checked_value = MRES($_POST['pbd_view_type_radio']);
		
		$sql = "UPDATE settings SET value = '$checked_value' WHERE name = 'post_by_date'";

		$query = mysqli_query($connection, $sql);

		if($query){

			showSuccessWindow("Done...","Settings Successfully Updated.");

		}

		else{

			showErrorWindow("Error!!!", "Unable to update the settings in tha database");

		}
	}
}

global $connection;
$sql = "SELECT * FROM settings WHERE name = 'post_by_date'";
$query = mysqli_query($connection, $sql);
if($query){
	$result = mysqli_fetch_assoc($query); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('[class = "pdb_radio"]').each(function(){
				if($(this).attr('value') == "<?php echo $result['value']; ?>"){
					$(this).attr('checked', 'checked');
				}
			});
		});
	</script>
<?php
}

?>

<style type="text/css">
	.pbd_settings_container{

	}

	.show_type_text{
		margin: 15px 20px;
		font-family: monospace;
		font-size: 18px;
		font-weight: bold;
		text-decoration: underline;
		text-decoration-color: rgba(56, 173, 169,1.0);
		cursor: pointer;
	}

	.sec_a{
		display: flex;
		/*align-items: center;*/
		background: rgba(199, 236, 238,0.5);
		margin-bottom: 8px;
	}

	.sec_a label{
		min-width: 140px;
	}

	.preview_img_cont{
		width: 200px;
		overflow: hidden;
		margin-left: 15px;
	}

	.preview_img_cont img{
		width: 100%;
	}

	.submit_btn_block{
		display: block;
		text-align: center;
		overflow: hidden;
	}

	.submit_btn1{
		border: solid 1px rgba(7, 153, 146,1.0);
		min-height: 30px;
		height: 40px;
		padding: 0 40px;
		font-family: monospace;
		text-transform: uppercase;
		border-radius: 20px;
		background: rgba(7, 153, 146,1.0);
		outline: none;
		color: white;
		font-size: 18px;
		cursor: pointer;
		transition: 0.2s linear;
	}

	.submit_btn1:hover{
		border: solid 1px rgba(250, 211, 144,1.0);
		color: rgba(250, 211, 144,1.0);
	}
</style>

<div class="pbd_settings_container">
	<p class="show_type_text">Select Widget View</p>
	<form action="" method="post">
		<div class="sec_a">
			<input class="pdb_radio" type="radio" name="pbd_view_type_radio" id="pbd_view_type_date_radio" value="date" required>
			<label for="pbd_view_type_date_radio">By Date</label>
			<div class="preview_img_cont">
				<img src="<?php echo SITE_URL . 'addons/widgets/post-by-date/images/by_date.png'; ?>">
			</div>
		</div>


		<div class="sec_a">
			<input class="pdb_radio" type="radio" name="pbd_view_type_radio" id="pbd_view_type_month_radio" value="month" required>
			<label for="pbd_view_type_month_radio">By Month</label>
			<div class="preview_img_cont">
				<img src="<?php echo SITE_URL . 'addons/widgets/post-by-date/images/by_month.png'; ?>">
			</div>
		</div>


		<div class="sec_a">
			<input class="pdb_radio" type="radio" name="pbd_view_type_radio" id="pbd_view_type_year_radio" value="year" required>
			<label for="pbd_view_type_year_radio">By Year</label>
			<div class="preview_img_cont">
				<img src="<?php echo SITE_URL . 'addons/widgets/post-by-date/images/by_year.png'; ?>">
			</div>
		</div>

		<div class="submit_btn_block">
			<input type="submit" name="submit_settings" class="submit_btn1">
		</div>
	</form>

</div>

<script type="text/javascript">
	
</script>


