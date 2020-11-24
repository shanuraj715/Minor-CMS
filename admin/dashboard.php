<?php include('./includes/header.php'); ?>
<?php validateLogged();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex,nofollow" />
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<link rel="stylesheet" type="text/css" href="../css/fonts-awesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="./css/dashboard.css">
	<?php include './includes/linker.php'; ?>
	<title>Dashboard | <?php echo SITE_TITLE; ?></title>
</head>
<body>
	<div class="a_top_parent_page_container">
		
		<div class="a_dashboard_page_content">
			<div class="a_sidebar">
				<div class="a_site_title_block">
					<a class="a_s_dashboard_link" href="<?php echo SITE_URL; ?>"><?php echo SITE_TITLE; ?></a>
				</div>
				<div class="a_sidebar_block">


					<div class="a_s_cat_container">
						<div class="a_s_cat_block">
							<p class="a_s_cat_title">Main</p>
							<div class="a_s_items_block">
								<i class="fas fa-home a_s_fa"></i>
								<a href="<?php echo SITE_URL . 'admin/dashboard.php';?>" class="a_s_item_link">Dashboard</a>
							</div>

							<?php sidebarOptionsPermissions(); // prints sidebar options ?>
						</div>
					</div>
				</div>
			</div>
			<div class="a_page_content">
				<div class="a_page_container">
					<div class="a_navbar">
						<div class="a_navbar_left">
							<span class="a_nav_home" id="page_title"></span>
							<span id="additional_header_text"></span>
							<!-- <div class="nav_visitors_block">
								<span class="nav_visitor_title">Visitors : <span class="hover_popup">Visitor Count Only Show Unique Visitors.</span></span>
								<span class="nav_visitors">Today : 82</span>
								<span class="nav_visitors">This Week : 145</span>
								<span class="nav_visitors">This Month : 510</span>
							</div> -->
						</div>
						<div class="a_navbar_right">
							<div class="a_n_username_block">
								<span class="a_n_username_text_link"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></span>
								<div class="dashboard_header_user_suboptions_block">
									<div class="d_h_user_so_block">
										<a class="d_h_user_profile_link" href="<?php echo SITE_URL;?>profile/<?php echo $_SESSION['username'];?>">View Profile</a>
									</div>
									<div class="d_h_user_so_block">
										<a class="d_h_user_profile_link" href="<?php echo SITE_URL . 'admin/dashboard.php?page=users&action=manage-user-account'; ?>">Manage Profile</a>
									</div>
								</div>
							</div>
							<div id="notification_button" class="a_n_links_icon"><i class="far fa-bell"></i>
							
							</div>

							<div id="notification_dropdown" class="a_notifications_container">
								<div id="notification_block" class="notification_block">
									<div style="max-height: 90px; overflow: hidden; text-align: center;" class="notification_loader_block">
										<i id="notification_loader" class="fas fa-spinner"></i>
									</div>
								</div>
							</div>
							<a href="<?php echo SITE_URL . "admin/logout.php"; ?>" class="a_n_logout_btn_link" title="Logout"><i class="fas fa-power-off"></i></a>
						</div>
					</div>

					<!-- Dashboard Dynamic Page Container -->
					<div class="a_d_page_container">
						<?php includePage(); // from functions.php page ?>
					</div> <!-- Dashboard Dynamic Page Container Ends Here -->
				</div>
			</div>
		</div>
	</div>
	<div class="logout_prompter">
		<span class="logout_prompter_text"></span>
	</div>
	<script type="text/javascript">
		$('.logout_prompter').hide();
	</script>
</body>

<script type="text/javascript">
	$(document).ready(function(){
		$('#notification_button').click(function(){
			var notification_drop_status = $('#notification_dropdown').css('display');
			if(notification_drop_status == 'none'){
				$('#notification_dropdown').css('display', 'block');
				notificatioData();
			}
			else{
				$('#notification_dropdown').css('display', 'none');
			}
		});

		

		function notificatioData(){

			var id = "<?php echo $_SESSION['userid']; ?>";
			$.ajax({
				url:'<?php echo SITE_URL . "admin/extra_files/dashboard_notification.php";?>',
				data:'',
				success:function(data){
					var text = data;
					$('#notification_block').html(text);
				}
			});
		}
	});

	function markRead(nid){
		var id = "<?php echo $_SESSION['userid'];?>";
		$.ajax({
			url:'<?php echo SITE_URL . "admin/extra_files/dashboard_notification.php";?>',
			data:'uid='+id+'&nid='+nid+'&action=mark',
			success:function(data){
				var text = data;
				$('#notification_block').html(text);
			}
		});

	}

	function trashNotification(nid){
		var id = "<?php echo $_SESSION['userid'];?>";
		$.ajax({
			url:'<?php echo SITE_URL . "admin/extra_files/dashboard_notification.php";?>',
			data:'uid='+id+'&nid='+nid+'&action=trash',
			success:function(data){
				var text = data;
				$('#notification_block').html(text);
			}
		});
	}


</script>


</html>
<script type="text/javascript" src="<?php echo SITE_URL . 'admin/js/dashboard_functions.js';?>"></script>