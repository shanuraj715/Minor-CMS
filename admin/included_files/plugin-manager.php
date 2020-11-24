<script type="text/javascript">
	$('#page_title').html('Plugins Manager');
</script>
<?php include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/plugin-manager-functions.php'; ?>
<?php dashboardHeadData(); ?>
<?php 

pageForUser('admin');


if(!isset($_GET['action']) or empty($_GET['action'])){
	header("Location: " . SITE_URL . 'admin/dashboard.php?page=plugin-manager&action=manage');
	exit();
}
else{
	$action = MRES($_GET['action']);
}

if(isset($_GET['do']) and !empty($_GET['do'])){
	$do = MRES($_GET['do']);
	if(isset($_GET['pl_id']) and is_numeric($_GET['pl_id'])){
		$plugin_id = $_GET['pl_id'];
		$do_list = ['active', 'disable'];
		if(in_array($do, $do_list)){
			changeStatus($do, $plugin_id);
		}
		else{
			showErrorWindow("ERROR!!!", "Unable to complete the task. please do not modify the url manually. This can carsh your website.");
		}
	}
	else{
		showErrorWindow("ERROR!!!", "Unable to complete the task. please do not modify the url manually. This can carsh your website.");
	}
}

?>

<?php
if($action == 'manage'){ ?>
<div class="pm_page_element_container">
	<div class="anp_block">
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=plugin-manager&action=add-plugin'; ?>">Add New Plugin</a>
	</div>
	<div class="show_plugin_block">
		<div class="p_top_row">
			<span class="counter">No.</span>
			<span class="plugin_name_title">Plugin Name</span>
			<span class="plugin_version">Version</span>
			<span class="plugin_status">Status</span>
		</div>
		<?php showPluginList(); ?>
	</div>
	<div class="uf_block">
		
	</div>
</div>
<?php 
}
elseif($action = 'add-plugin'){
	notAvailableAtThisTime();
}
elseif($action == 'update'){
	notAvailableAtThisTime();
}

?>






<?php if(!empty($_GET['show']) and ($_GET['show'] == 'settings')){ ?>
	<div class="pm_settings_popup_window_container">
		<div class="pm_settings_popup_window">
			
			<div class="pm_spw_header">
				<span class="pm_spw_header_span">Widget Settings</span>
				<i id="sw_spw_close_btn" class="fas fa-times"></i>
			</div>
			<div class="pm_spw_page_container">
				<?php 
				if(file_exists($file_address)){
					include $file_address;;
				}
				else{
					//include '404.php';
				} ?>
			</div>

		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#sw_spw_close_btn').click(function(){
				$('.pm_settings_popup_window_container').hide(800);
				setInterval(function(){
					//window.open("<?php echo SITE_URL . 'admin/dashboard.php?page=plugin-manager'; ?>", "_self")
				}, 800);
			});
		});
	</script>
	<?php
} ?>