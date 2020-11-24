<?php

function loggedUser(){

	if(isset($_SESSION['username'])){

		$logged_user_role = strtolower($_SESSION['role']);

		return $logged_user_role;
	}

}

loggedUser();



function sidebarOptionsPermissions(){

	$role = loggedUser();

	if($role == 'admin'){

		$list = sidebarOptionsAdmin();

		sidebarOptionPrinter($list);

	}
	elseif($role == 'author'){

		$list = sidebarOptionsAuthor();

		sidebarOptionPrinter($list);

	}
	elseif($role == 'subscriber'){

		$list = sidebarOptionsSubscriber();

		sidebarOptionPrinter($list);

	}
	else{

		die("New User Role has found. Please Modify the source code of the cms or check for update.");
	
	}

}


function sidebarOptionsAdmin(){

	$list = ['posts' => true, 'pages' => false, 'categories' => true, 'media' => true, 'sidebar widgets' => true, 'plugins' => true, 'appearence' => true, 'comments' => true, 'users' => true, 'analytics' => false, 'seo' => false, 'settings' => true];

	return $list;

}

function sidebarOptionsAuthor(){

	$list = ['posts' => true, 'pages' => false, 'categories' => true, 'media' => false, 'sidebar widgets' => false, 'plugins' => false, 'appearence' => false, 'comments' => false, 'users' => true, 'analytics' => false, 'seo' => false, 'settings' => false];

	return $list;

}

function sidebarOptionsSubscriber(){

	$list = ['posts' => false, 'pages' => false, 'categories' => false, 'media' => false, 'sidebar widgets' => false, 'plugins' => false, 'appearence' => false, 'comments' => false, 'users' => true, 'analytics' => false, 'seo' => false, 'settings' => false];

	return $list;

}

function sidebarOptionPrinter($list){

	foreach ($list as $key => $value) {

		if($key == 'posts' && $value == true){

			postsOption();

		}
		elseif($key == 'pages' && $value == true){

			pagesOption();

		}
		elseif($key == 'categories' && $value == true){

			categoriesOption();

		}
		elseif($key == 'media' && $value == true){

			mediaOption();

		}
		elseif($key == 'sidebar widgets' && $value == true){

			sidebarWidgetsOption();

		}
		elseif($key == 'plugins' && $value == true){

			pluginsOption();

		}
		elseif($key == 'appearence' && $value == true){

			appearenceOption();

		}
		elseif($key == 'comments' && $value == true){

			commentsOption();

		}
		elseif($key == 'users' && $value == true){

			usersOption();

		}
		elseif($key == 'analytics' && $value == true){

			analyticsOption();

		}
		elseif($key == 'seo' && $value == true){

			seoOption();

		}
		elseif($key == 'settings' && $value == true){

			settingsOption();

		}

	}

}







// Now All Options List Functions

function postsOption(){ ?>
	<p class="a_s_cat_title">Content</p>
	<div class="a_s_items_block">
		<i class="fas fa-pencil-alt a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=view-posts'; ?>" class="a_s_item_link">Posts</a>



		<!-- Drop Links -->
		<div class="dropdown_block">
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=view-posts'; ?>" class="a_s_drop_link" title="View a list of all Posts">View All Posts</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=create-post'; ?>" class="a_s_drop_link" title="Create New Post">Create Post</a>
			</div>
			<!-- <div class="a_s_drop_links_block">
				<a href="<?php //echo SITE_URL . 'admin/dashboard.php?page=edit-post'; ?>" class="a_s_drop_link" title="Edit Post">Edit Post</a>
			</div> -->
		</div> <!-- Drop Links Closing -->



	</div>
	<?php
}

function pagesOption(){ ?>
	<div class="a_s_items_block">
		<i class="fas fa-file a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=view-pages'; ?>" class="a_s_item_link">Pages</a>



		<!-- Drop Links -->
		<div class="dropdown_block">
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=view-pages'; ?>" class="a_s_drop_link" title="View All Pages">View All Pages</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=create-page'; ?>" class="a_s_drop_link" title="Create New Page">Create New Page</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=edit-page'; ?>" class="a_s_drop_link" title="Edit Page">Edit Page</a>
			</div>
		</div> <!-- Drop Links Closing -->



	</div>
	<?php
}

function categoriesOption(){ ?>
	<div class="a_s_items_block">
		<i class="fas fa-layer-group a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category'; ?>" class="a_s_item_link">Categories</a>



		<!-- Drop Links -->
		<div class="dropdown_block">
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category&task=create-category'; ?>" class="a_s_drop_link" title="Create New Category">Create Category</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category&task=manage'; ?>" class="a_s_drop_link" title="Edit or Delete Categories">Manage Categories</a>
			</div>
		</div> <!-- Drop Links Closing -->



	</div> 
	<?php
}

function mediaOption(){ ?>
	<div class="a_s_items_block">
		<i class="fas fa-photo-video a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=media'; ?>" class="a_s_item_link">Media</a>
	</div>
	<?php
}

function sidebarWidgetsOption(){ ?>
	<p class="a_s_cat_title">Addons and Plugins</p>
	<div class="a_s_items_block">
		<i class="fas fa-grip-lines-vertical a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager'; ?>" class="a_s_item_link">Sidebar Widgets</a>

		<!-- Drop Links -->
		<div class="dropdown_block">
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=add-new'; ?>" class="a_s_drop_link" title="Add New Widget To Sidebar">Add New Widget</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=manage-widgets'; ?>" class="a_s_drop_link" title="Manage Sidebar Widgets">Manage Widgets</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=sidebar-manager&action=update-widgets'; ?>" class="a_s_drop_link" title="Check For Sidebar Widget Updates">Widgets Updates</a>
			</div>
		</div> <!-- Drop Links Closing -->
	</div>
	<?php
}

function pluginsOption(){ ?>
	<div class="a_s_items_block">
		<i class="fas fa-plug a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=plugin-manager'; ?>" class="a_s_item_link">Plugins</a>

		<!-- Drop Links -->
		<div class="dropdown_block">
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=plugin-manager&action=view-installed'; ?>" class="a_s_drop_link" title="View Installed Plugins">Installed Plugins</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=plugin-manager&action=add-new'; ?>" class="a_s_drop_link" title="Add New Plugin To The Site">Add New Plugin</a>
			</div>
		</div> <!-- Drop Links Closing -->
	</div> 
	<?php
}

function appearenceOption(){ ?>
	<p class="a_s_cat_title">Others</p>
	<div class="a_s_items_block">
		<i class="fas fa-eye a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=appearence'; ?>" class="a_s_item_link">Appearence</a>
	</div>
	<?php
}

function commentsOption(){ ?>
	<div class="a_s_items_block">
		<i class="fas fa-comment-dots a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=comments'; ?>" class="a_s_item_link">Comments</a>
	</div>
	<?php
}

function usersOption(){ ?>
	<div class="a_s_items_block">
		<i class="fas fa-users a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=users'; ?>" class="a_s_item_link">Users</a>



		<!-- Drop Links -->
		<div class="dropdown_block">
			<?php
			if($_SESSION['role'] == 'admin'){ ?>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=users&action=view'; ?>" class="a_s_drop_link" title="View Users as List">View Users</a>
			</div>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=users&action=add-new-user'; ?>" class="a_s_drop_link" title="Add New User">Add User</a>
			</div>
		<?php } ?>
			<div class="a_s_drop_links_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=users&action=manage-user-account'; ?>" class="a_s_drop_link" title="Manage Users (Delete or Modify Accounts)">Manage Users</a>
			</div>
		</div> <!-- Drop Links Closing -->


	</div>
	<?php
}

function analyticsOption(){ ?>
	<p class="a_s_cat_title">Maintanance</p>
	<div class="a_s_items_block">
		<i class="fas fa-chart-line a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=analytics'; ?>" class="a_s_item_link">Analytics</a>
	</div>
	<?php
}

function seoOption(){ ?>
	<div class="a_s_items_block">
		<i class="fab fa-searchengin a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-seo'; ?>" class="a_s_item_link">SEO</a>
	</div>
	<?php
}

function settingsOption(){ ?>
	<div class="a_s_items_block">
		<i class="fas fa-cog a_s_fa"></i>
		<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=settings'; ?>" class="a_s_item_link">Settings</a>
	</div>
	<?php
}




?>