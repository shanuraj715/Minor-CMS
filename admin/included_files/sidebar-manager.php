
<?php
include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/sidebar_functions.php';


pageForUser('admin');


if(!isset($_GET['action']) or empty($_GET['action'])){

	header("Location: " . SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=manage-widgets');

}

if(isset($_GET['do']) and !empty($_GET['do'])){

	if(isset($_GET['id']) and !empty($_GET['id']) and is_numeric($_GET['id'])){

		$id = MRES($_GET['id']);

	}

	else{

		header("Location: " . SITE_URL . 'admin/dashboard.php?page=sidebar-manager');

	}

	// activating

	if(strtolower($_GET['do']) == 'activate'){

		changeStatusWidget($id, 'active');

	}

	// deactivation

	elseif(strtolower($_GET['do']) == 'deactivate'){

		changeStatusWidget($id, 'deactive');
		
	}
}





?>

<?php if($_GET['action'] and $_GET['action'] == 'manage-widgets'){ ?>

<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Sidebar Manager";
</script>



<div class="a_sidebar_container">
	
	<div class="as_add_s_widget_block">
		<a class="a_add_sidebar_widget_btn" href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=add-new'; ?>">Add New Widget</a>
	</div>

</div>

<div class="a_sidebar_container">

	<?php topRow(); ?>

	<div class="a_sidebar_widgets_list_container">
		
		<p class="a_sidebar_head">Installed Widgets</p>
		<div class="s_widget_cols">
			<span class="counter">No.</span>
			<span class="widget_name">Widget Name</span>
			<span class="widget_status">Status</span>
			<span class="widget_order">Order</span>
		</div>
		<?php sidebarWidgetList(); ?>

	</div>

</div>

<div class="a_sidebar_container">
	
	<div class="as_show_updates_block">
		<p class="a_sidebar_update_notice"><i class="fas fa-exclamation-triangle"></i> Update Feature Is Currently No Available. We Will Include This Soon</p>
	</div>

</div>

<?php

}

elseif($_GET['action'] and $_GET['action'] == 'add-new'){ ?>

<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Add New Widget";
</script>

<div class="a_sidebar_container">

	<?php notAvailableAtThisTime(); ?>

</div>

<?php

}

elseif($_GET['action'] and $_GET['action'] == 'update-widgets'){ ?>

<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Update Sidebar Widgets";
</script>

<div class="a_sidebar_container">

	<?php notAvailableAtThisTime(); ?>

</div>

<?php

}

if(isset($_GET['show']) and !empty($_GET['show'])){ 
	if($_GET['show'] == 'settings'){
		if(isset($_GET['id']) and !empty($_GET['id']) and is_numeric($_GET['id'])){
			$id = $_GET['id'];
			global $connection;
			$sql = "SELECT * FROM sidebar_widgets WHERE id = $id";
			$query = mysqli_query($connection, $sql);
			if($query){
				$res = mysqli_fetch_assoc($query);
				$file_name = $res['name'] . '/settings.php';
				$file_address = SITE_DIR . 'addons/widgets/' . $file_name;
				spSpwShowPopup($file_address);
			}
		}
	}
}


function spSpwShowPopup($file_address){ ?>
	<div class="sidebar_settings_popup_window_container">
		<div class="sidebar_settings_popup_window">
			
			<div class="sb_spw_header">
				<span class="sb_spw_header_span">Widget Settings</span>
				<i id="sw_spw_close_btn" class="fas fa-times"></i>
			</div>
			<div class="sb_spw_page_container">
				<?php 
				if(file_exists($file_address)){
					include $file_address;;
				}
				else{
					include '404.php';
				} ?>
			</div>

		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#sw_spw_close_btn').click(function(){
				$('.sidebar_settings_popup_window_container').hide(800);
				setInterval(function(){
					window.open("<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager'; ?>", "_self")
				}, 800);
			});
		});
	</script>
	<?php
} ?>