<?php

function topRow(){
	global $connection;

	$sql = "SELECT name, status from sidebar_widgets";

	$query = mysqli_query($connection, $sql);

	$active = 0;
	$deactive = 0;

	while($res = mysqli_fetch_assoc($query)){

		if($res['status'] == 'active'){

			$active++;

		}
		elseif($res['status'] == 'deactive'){

			$deactive++;

		}

	}
 ?>


<script type="text/javascript">
	document.getElementById('additional_header_text').innerHTML = "Active Widgets : <?php echo $active; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Not Active Widgets: <?php echo $deactive; ?>";
</script>

<?php

}

function sidebarWidgetList(){

	global $connection;

	$sql = "SELECT * FROM sidebar_widgets ORDER BY widget_order ASC";

	$query = mysqli_query($connection, $sql);

	if($query){

		$counter = 1;

		while($result = mysqli_fetch_assoc($query)){ ?>

			<div class="s_widget_cols2">
			<span class="counter"><?php echo $counter; ?></span>
			<span class="widget_name"><?php echo ucwords(str_replace('-',' ', str_replace('_', ' ', $result['name']))); ?></span>





			<span class="widget_status"><?php echo ucfirst($result['status']); ?></span>
			<span class="widget_order"><?php echo $result['widget_order']; ?></span>
			<div class="s_widget_opts_block">
				<?php
				if(strtolower($result['status']) == 'active'){ ?>
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=manage-widgets&do=deactivate&id=' . $result['id']; ?>" class="a_deactivate_btn">Deactivate</a>
				<?php
				}
				elseif(strtolower($result['status']) == 'deactive'){ ?>
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=manage-widgets&do=activate&id=' . $result['id']; ?>" class="a_activate_btn">Activate</a>
				<?php
				}
				if($result['has_settings'] == 1){ ?>
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=manage-widgets&id=' . $result['id']; ?>&show=settings" class="a_change_order_btn">Settings</a>
				<?php
				} ?>
				<!-- <a href="<?php //echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=manage-widgets&do=change_order&id=' . $result['id']; ?>" class="a_change_order_btn">Change Order</a> -->
			</div>
		</div>
		<?php

		$counter++;

		}

	}

}

function changeStatusWidget($id, $status){

	global $connection;
	$sql = "UPDATE sidebar_widgets SET status = '$status' WHERE id = $id";
	$query = mysqli_query($connection, $sql);

	if($query){
		header("Location: " . SITE_URL . 'admin/dashboard.php?page=sidebar-manager');
		exit();
	}
	else{
		showErrorWindow("ERROR!!!", "Unable to Execute Query. Please Contact The Administrator.");
	}

}

?>