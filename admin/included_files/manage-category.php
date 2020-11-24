<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Categories";
</script>
<?php include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/category-functions.php'; ?>

<?php

pageForUser('admin, author');


if(isset($_GET['action']) and !empty($_GET['action'])){
	$action = $_GET['action'];
	if(isset($_GET['id']) and !empty($_GET['id']) and is_numeric($_GET['id'])){
		$cat_id = MRES($_GET['id']);
	}
	else{
		header("Location: " . SITE_URL . 'admin/dashboard.php?page=manage-category');
		exit();
	}
	if($action == 'rename'){
		rename_category($cat_id);
	}
	elseif($action == 'delete'){
		delete_category($cat_id);
	}



	// for rename

	if(isset($_GET['new_name']) and !empty($_GET['new_name'])){

		$cat_name = MRES($_GET['new_name']);

		rename_this_category($cat_id, $cat_name);

	}

	// for deletion

	if(isset($_GET['delete']) and !empty($_GET['delete'])){

		if($_GET['delete'] == 'true'){

			delete_this_category($cat_id);

		}

		else{

			header("Location: " . SITE_URL . 'admin/dashboard.php?page=manage-category');

		}

	}
}

// for creation of new category

if(isset($_GET['task']) and !empty($_GET['task'])){

	if($_GET['task'] == 'create-category'){

		create_category_form();

	}

	if($_GET['task'] == 'create-category' and isset($_GET['cat_name']) and !empty($_GET['cat_name'])){

		$cat_name = MRES($_GET['cat_name']);

		create_category($cat_name);

	}

} ?>

<div class="admin_category_container">
	<div class="admin_show_category_block">
		<p class="admin_category_title">Categories</p>
		<div class="category_list_block_head">
			<span class="category_counter">No.</span>
			<span class="admin_category_id">Cat Id</span>
			<a class="category_list_title_url">Category Title</a>
			<span class="admin_category_post_counter">Total Posts</span>
		</div>

		<?php category_lists(); ?>

	</div>
</div>