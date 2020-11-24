<?php

function loginLogoutNavbarLink(){

	if(checkLogged()){ ?>

		<div class="login_logout_btn_container">
			
			<a href="<?php echo SITE_URL; ?>admin/dashboard.php">Dashboard</a>
			
			<a href="<?php echo SITE_URL; ?>admin/logout.php">Logout</a>

		</div>

	<?php

	}

	else{ ?>

		<div class="login_logout_btn_container">
			
			<a href="<?php echo SITE_URL . 'admin/login.php'; ?>">Login / Signup</a>

		</div>

		<?php
		
	}

}


?>
<div class="header_container">
	<div class="header_block">
		<div class="header_left_block">
			<a href="<?php echo SITE_URL; ?>">
				<img src="<?php echo SITE_URL;?>images/site_images/<?php echo siteLogo(); ?>" alt="Site Logo">
			</a>
			<div class="site_title_desc_block">
				<a href="<?php echo SITE_URL; ?>" class="site_title_text"><?php echo siteTitle(); ?></a>
				<span class="site_desc_text"><?php echo siteDescription(); ?></span>
			</div>
		</div>
		<div class="header_right_block">
			<?php 
			if(function_exists('top_header_social')){
				top_header_social();
			} ?>
		</div>
	</div> <!-- Main Header Ends -->

























	<!-- Navigation Area -->
	<div class="navbar_container">
		<!-- Menu Btn will here -->
		<div class="nav_top_block">
			<div class="navigation_btns_block">
				<?php

				global $connection;

				$sql = "SELECT * FROM cms_navigation where parent = 0 ORDER BY id ASC";

				$query = mysqli_query($connection, $sql);

				while($nav_res = mysqli_fetch_assoc($query)){

					echo '<div class="nav_btn_container_block">';

						echo '<a href="' . $nav_res['url'] . '" target="' . $nav_res['new_window'] . '" title="' . $nav_res['description'] . '">' . $nav_res['title'] . '</a>';

						$parent = $nav_res['id'];

						$sql = "SELECT * FROM cms_navigation WHERE parent = $parent";

						$query1 = mysqli_query($connection, $sql);

						if($query1){

							// Dropdown Block Code
							echo '<div class="nav_dropdown_container">';

							while($drop_btns = mysqli_fetch_assoc($query1)){

								$new_window_icon = "";

								if($drop_btns['new_window'] == "_blank"){

									$new_window_icon = "<i style='padding: 0 2px 0 5px; color: #3498db; float: right;' class='fas fa-external-link-alt'></i>";
								}

								echo '<a href="' . $drop_btns['url'] . '" class="dropdown_link" target="' . $drop_btns['new_window'] . '"title="' . $nav_res['description'] . '">' . $drop_btns['title'] . $new_window_icon . '</a>';

							}
							echo '</div>';

						}

					echo '</div>';

				}

				loginLogoutNavbarLink();
				 ?>
				
			</div>

		</div>

	</div>



















</div>