<?php


function showPluginList(){
	global $connection;
	$sql = "SELECT * from plugins";
	$query = mysqli_query($connection, $sql);
	if($query){
		$counter = 1;
		while ($result = mysqli_fetch_assoc($query)) { ?>
			<div class="p_list_row">
				<span class="counter"><?php echo $counter; ?></span>
				<span class="plugin_name_title"><?php echo ucwords(str_replace('-', ' ', str_replace('_', ' ' ,$result['name']))); ?></span>
				<span class="plugin_version"><?php echo $result['version']; ?></span>
				<span class="plugin_status"><?php echo ucfirst($result['status']); ?></span>
				<div class="plugin_options_block">
					<?php if($result['status'] == 'active'){ ?>
						<a class="plugin_status_changer disable" href="<?php echo SITE_URL . 'admin/dashboard.php?page=plugin-manager&action=manage&do=disable&pl_id=' . $result['id']; ?>">Disable</a>
						<?php
					}
					elseif($result['status'] == 'disable'){ ?>
						<a class="plugin_status_changer enable" href="<?php echo SITE_URL . 'admin/dashboard.php?page=plugin-manager&action=manage&do=active&pl_id=' . $result['id']; ?>">Enable</a>
					<?php
					} ?>
				</div>
			</div>
			<?php 
			$counter++;
		}
	}
}

function changeStatus($action, $plugin_id){
	// action means enable or disable
	global $connection;

	$sql = "UPDATE plugins SET status = '$action' WHERE id = $plugin_id";
	$query = mysqli_query($connection, $sql);
	if($query){
		header("Location: " . SITE_URL . 'admin/dashboard.php?page=plugin-manager&action=manage');
		exit();
	}
	else{
		showErrorWindow("ERROR!!!", "Unable to complete the task. There is an error in the source code. Reference Id : msql:AX85");
	}

}





function dashboardHeadData(){
	global $connection;
	$sql = "SELECT status FROM plugins";
	$query = mysqli_query($connection, $sql);
	if($query){
		$active = 0;
		$disable = 0;
		while($result = mysqli_fetch_assoc($query)){
			if($result['status'] == 'active'){
				$active++;
			}
			elseif($result['status'] == 'disable'){
				$disable++;
			}
		} ?>
		<script type="text/javascript">
			$('#additional_header_text').html("Installed : <?php echo $active + $disable; ?>&nbsp;&nbsp;&nbsp;&nbsp;Active Plugins : <?php echo $active; ?>&nbsp;&nbsp;&nbsp;&nbsp;Disabled : <?php echo $disable; ?>");
		</script>
		<?php
	}
}

?>