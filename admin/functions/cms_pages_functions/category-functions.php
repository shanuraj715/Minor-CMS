<?php





function category_lists(){

	global $connection;

	$sql = "SELECT * FROM categories";

	$query = mysqli_query($connection, $sql);

	if($query){

		$count = 1;

		while($result = mysqli_fetch_assoc($query)){

			$category_id = $result['category_id'];

		$sql = "SELECT count(post_id) as total_cats FROM posts WHERE category_id = $category_id and post_status = 'published'";

		$q2 = mysqli_query($connection, $sql);

		$tot_cats = mysqli_fetch_assoc($q2); ?>

			<div class="category_list_block" id="category_list_block_head">
				<span class="category_counter"><?php echo $count; ?></span>
				<span class="admin_category_id"><?php echo $result['category_id']; ?></span>
				<a class="category_list_title_url"><?php echo $result['category_title']; ?></a>
				<span class="admin_category_post_counter"><?php echo $tot_cats['total_cats']; ?></span>
				<div class="admin_cat_hover_opts_block">
					<a class="admin_cat_view_posts" href="<?php echo SITE_URL . '?category=' . $result['category_title']; ?>" target="_blank">View Posts</a>
					<a class="admin_cat_rename" href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category' . '&action=rename&id=' . $result['category_id']; ?>" id="rename_cat_admin">Rename</a>


					<a class="admin_cat_delete" href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category' . '&action=delete&id=' . $result['category_id']; ?>" id="delete_cat_admin">Delete</a>
				</div>
			</div>

		<?php

			$count++;
		}

	}

}

function rename_category($id){ ?>
	<style type="text/css">
		.rename_cat_pop_block{
			margin-bottom: 15px;
			margin-left: 5px;
		}

		.pop_title{
			font-family: monospace;
			font-size: 18px;
			cursor: pointer;
			margin: 0;
			padding: 10px 0;
		}

		.rename_cat_box2{
			padding: 5px 0;
			display: flex;
		}

		.rename_cat_pop_inp{
			outline: none;
			border-radius: 5px;
			border: solid 2px #2980b9;
			padding: 2px 5px;
			letter-spacing: 1px;
		}

		.rename_cat_btn_pop{
			border-radius: 4px;
			outline: none;
			border: solid 2px #2980b9;
			padding: 2px 5px;
			margin: 0 5px;
		}
	</style>
	<div class="rename_cat_pop_block">

		<?php

		global $connection;

		if(is_numeric($id)){

			$sql = "SELECT * FROM categories WHERE category_id = $id";

			$query = mysqli_query($connection, $sql);
			$rows = mysqli_num_rows($query);

			if($query){

				$res = mysqli_fetch_assoc($query);

			}
			else{
				showErrorWindow("Error", "Unknown Error Occured.");
			}

			if($rows == 0){
				$res['category_title'] = "Error";
				showErrorWindow("Error", "No Category found. Please do not edit the url manually. This can corrupt your site files.");
			}

		} ?>
		
		<p class="pop_title">Rename Category</p>

		<div class="rename_cat_box2">
			
			<input type="text" class="rename_cat_pop_inp" placeholder="Enter the new name" value="<?php echo $res['category_title']; ?>">

			<button class="rename_cat_btn_pop">Rename</button>


			<div class="cat_action_close_btn_block">
				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category'; ?>"><i class="fas fa-times"></i></a>
			</div>

			<script type="text/javascript">
				$(document).ready(function(){
					$('.rename_cat_btn_pop').click(function(){
						let rename_to = $('.rename_cat_pop_inp').val();
						let url = "<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" + "&new_name=" + rename_to;
						window.open(url, '_self');
					});
				});
			</script>

		</div>

	</div>
<?php
}

function rename_this_category($cat_id, $cat_name){

	global $connection;

	$sql = "UPDATE categories SET category_title = '$cat_name' WHERE category_id = $cat_id";

	$query = mysqli_query($connection, $sql);

	if($query){

		header("Location:" . SITE_URL . 'admin/dashboard.php?page=manage-category');

		exit();

	}

	else{

		showErrorWindow("Error", "Unable to Rename The Category. Please Try After Some Time Or You Can Also Contact Us.");

	}

}

function delete_category($cat_id){

	global $connection;

	$sql = "SELECT * FROM categories WHERE category_id = $cat_id";

	$query = mysqli_query($connection, $sql);

	$res = mysqli_fetch_assoc($query); ?>

	<style type="text/css">
		.cat_delete_block{
			display: flex;
			margin: 5px 0;
			padding: 4px 5px;
			border-radius: 5px;
			background-color: rgba(192, 57, 43,0.2);
			border: solid 2px #e74c3c;
		}

		.cat_delete_text{
			flex-grow: 2;
			font-family: monospace;
			font-size: 16px;
			line-height: 25px;
		}

		.delete_cat_yes, .delete_cat_no{
			padding: 2px 15px;
			margin: 0 5px;
			text-decoration: none;
			border: solid 2px rgba(44, 62, 80,1.0);
			border-radius: 5px;
			background-color: rgba(44, 62, 80,1.0);
			color: white;
		}

		.delete_cat_yes:hover{
			background-color: rgba(192, 57, 43,1.0);
			border: solid 2px rgba(44, 62, 80,1.0);
		}

		.delete_cat_no:hover{
			background-color: rgba(41, 128, 185,1.0);
			border: solid 2px rgba(44, 62, 80,1.0);
		}
	</style>

	<div class="cat_delete_block">
		<span class="cat_delete_text">Do you really want to delete "<?php echo $res['category_title']; ?>" Category.</span>
		<a class="delete_cat_yes" href="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '&delete=true'; ?>">Yes</a>
		<a class="delete_cat_no" href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category'; ?>">No</a>
	</div>

	<?php

}

function delete_this_category($cat_id){

	global $connection;

	$sql = "DELETE from categories WHERE category_id = $cat_id";

	$query = mysqli_query($connection, $sql);

	if($query){

		header("Location: " . SITE_URL . 'admin/dashboard.php?page=manage-category');

	}

	else{

		showErrorWindow("Error!!!", "Unable to delete the category. Please try after some time or you can also contact us.");

	}

}

function create_category_form(){ ?>
	<style type="text/css">
		.create_category_block{
			margin: 5px 0;
			display: flex;
			padding: 10px 5px;
			border-radius: 5px;
			border: solid 2px rgba(41, 128, 185,1.0);
			background-color: rgba(41, 128, 185,0.2);
		}

		.create_cat_inp{
			padding: 2px 5px;
			font-family: monospace;
			font-size: 16px;
			letter-spacing: 1px;
			min-width: 300px;
			border-radius: 4px;
			border: solid 1px rgba(41, 128, 185,1.0);
			color: #2980b9;
		}

		.create_cat_btn{
			border-radius: 4px;
			border: solid 1px rgba(41, 128, 185,1.0);
			padding: 2px 5px;
			font-family: monospace;
			font-size: 16px;
			margin: 0 5px;
		}
	</style>
	<div class="create_category_block">
		<input type="text" name="" class="create_cat_inp" placeholder="Enter the category name">
		<button class="create_cat_btn" id="create_cat_btn">Create</button>
		<div class="cat_action_close_btn_block">
			<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category'; ?>"><i class="fas fa-times"></i></a>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#create_cat_btn").click(function(){
				if($(".create_cat_inp").val() != ""){
					let cat_name = $(".create_cat_inp").val();
					let url = "<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" + "&cat_name=" + cat_name;
					window.open(url, "_self");
				}
			});
		});
	</script>

	<?php

}

function create_category($cat_title){

	global $connection;

	$sql = "INSERT INTO categories(category_title) VALUES('$cat_title')";

	$query = mysqli_query($connection, $sql);

	if($query){

		header("Location: " . SITE_URL . 'admin/dashboard.php?page=manage-category');

	}

	else{

		showErrorWindow("Error!!!", "Unable to create a new category. Category Not Created.");

	}

}

?>