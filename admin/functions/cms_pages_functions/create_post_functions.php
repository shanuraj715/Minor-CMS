<?php

function submitPost(){

	global $connection;

	// Post Data //

	$post_title = MRES($_POST['post_title']); 

	$post_content = MRES($_POST['post_content']);

	if(isset($_POST['post_author']) and !empty($_POST['post_author'])){

		$post_author = MRES($_POST['post_author']);

	}

	else{

		$post_author = $_SESSION['username'];

	}

	if(isset($_POST['comments_available']) and !empty($_POST['comments_available'])){
		$comments = 1;
	}
	else{
		$comments = 0;
	}





	// Post Meta //






	// Post SEO //

	$enable_seo = MRES($_POST['enable_seo']);

	$post_description = MRES($_POST['post_seo_description']);

	$post_keywords = MRES($_POST['post_seo_keywords']);

	$post_index = MRES($_POST['enable_index']);

	$post_follow = MRES($_POST['enable_follow']);

	$post_subject = MRES($_POST['post_seo_subject']);

	$revisit_after = MRES($_POST['cp_revisit_after']);

	$enable_cache = MRES($_POST['enable_cache']);




	/* Post Settings */

	if(isset($_POST['comments_available']) and !empty($_POST['comments_available'])){


		$enable_comments = MRES($_POST['comments_available']);

		if($enable_comments == 'enable'){

			$enable_comments = true;

		}

		else{

			$enable_comments = false;

		}

	}

	if(isset($_POST['p_category_checkbox']) and !empty($_POST['p_category_checkbox'])){

		if(is_numeric($_POST['p_category_checkbox'])){

			$category_id = $_POST['p_category_checkbox'];

		}

	}

	else{

		$category_id = 0;

	}

	if(isset($_POST['p_tags']) and !empty($_POST['p_tags'])){

		$post_tags = MRES($_POST['p_tags']);

	}

	else{

		$post_tags = "";

	}

	if(isset($_POST['p_status']) and !empty($_POST['p_status'])){

		if($_POST['p_status'] == 'published'){

			$post_status = "published";

		}

		elseif($_POST['p_status'] == 'draft'){

			$post_status = 'draft';

		}

		else{
			$post_status = 'draft';
		}

	}

	if(isset($_FILES['featured_image']['name']) and !empty($_FILES['featured_image']['name'])){
		$featured_image = $_FILES['featured_image']['name'];
		$featured_image = explode('.', $featured_image);
		$featured_image = end($featured_image);
		$featured_image = getImageName($featured_image);
	}
	else{
		$featured_image = "";
	}

	$post_date = date('Y-m-d');
	$post_time = date('H:i:s');
	$last_edit = date('Y-m-d H:i:s');

	$post_id = generatePostId();


	$sql = "INSERT INTO posts(post_id, post_title, post_author, category_id, post_status, post_tags, post_date, post_time, post_content, last_edit, enable_comments, post_image) VALUES($post_id, '$post_title', '$post_author', $category_id, '$post_status', '$post_tags', '$post_date', '$post_time', '$post_content', '$last_edit', $comments, '$featured_image')";

	$query = mysqli_query($connection, $sql);

	if($query){

		// uploading image 

		if(isset($_FILES['featured_image']['name'])){
			$image = $featured_image;
			$temp_image = $_FILES['featured_image']['tmp_name'];
			$image_status = move_uploaded_file($temp_image, SITE_DIR . 'uploads/' . $image);
		}

		// inserting data into content_seo table

		$sql = "INSERT INTO content_seo(`content_id`, `content_type`, `description`, `enable_seo`, `p_index`, `follow`, `keywords`, `author`, `subject`, `revisit_after`, `enable_cache`) VALUES($post_id, 'post', '$post_description', $enable_seo, '$post_index', '$post_follow', '$post_keywords', '$post_author', '$post_subject', '$revisit_after', $enable_cache)";

		$query = mysqli_query($connection, $sql);

		if($query){

			// header("Location: " . SITE_URL . 'admin/dashboard.php?page=edit-post&p_id=' . $post_id);

			header("Location: " . SITE_URL . 'admin/dashboard.php?page=view-posts');

		}

		else{
			showErrorWindow("ERROR", mysqli_error($connection));
		}

	}
	else{
		showErrorWindow("Error", mysqli_error($connection));
	}

}




function updatePost(){

	global $connection;

	// Post Data //

	$post_title = MRES($_POST['post_title']); 

	$post_content = MRES($_POST['post_content']);

	if(isset($_POST['post_author']) and !empty($_POST['post_author'])){

		$post_author = MRES($_POST['post_author']);

	}

	else{

		$post_author = $_SESSION['username'];

	}

	if(isset($_POST['comments_available']) and !empty($_POST['comments_available'])){
		$comments = 1;
	}
	else{
		$comments = 0;
	}





	// Post Meta //






	// Post SEO //

	$enable_seo = MRES($_POST['enable_seo']);

	$post_description = MRES($_POST['post_seo_description']);

	$post_keywords = MRES($_POST['post_seo_keywords']);

	$post_index = MRES($_POST['enable_index']);

	$post_follow = MRES($_POST['enable_follow']);

	$post_subject = MRES($_POST['post_seo_subject']);

	$revisit_after = MRES($_POST['cp_revisit_after']);

	$enable_cache = MRES($_POST['enable_cache']);




	/* Post Settings */

	if(isset($_POST['comments_available']) and !empty($_POST['comments_available'])){


		$enable_comments = MRES($_POST['comments_available']);

		if($enable_comments == 'enable'){

			$enable_comments = true;

		}

		else{

			$enable_comments = false;

		}

	}

	if(isset($_POST['p_category_checkbox']) and !empty($_POST['p_category_checkbox'])){

		if(is_numeric($_POST['p_category_checkbox'])){

			$category_id = $_POST['p_category_checkbox'];

		}

	}

	else{

		$category_id = 0;

	}

	if(isset($_POST['p_tags']) and !empty($_POST['p_tags'])){

		$post_tags = MRES($_POST['p_tags']);

	}

	else{

		$post_tags = "";

	}

	if(isset($_POST['p_status']) and !empty($_POST['p_status'])){

		if($_POST['p_status'] == 'published'){

			$post_status = "published";

		}

		elseif($_POST['p_status'] == 'draft'){

			$post_status = 'draft';

		}

		else{
			$post_status = 'draft';
		}

	}

	if(isset($_FILES['featured_image']['name']) and !empty($_FILES['featured_image']['name'])){
		$featured_image = $_FILES['featured_image']['name'];
		$featured_image = explode('.', $featured_image);
		$featured_image = end($featured_image);
		$featured_image = getImageName($featured_image);
	}
	else{
		$featured_image = "";
	}

	$post_date = date('Y-m-d');
	$post_time = date('H:i:s');
	$last_edit = date('Y-m-d H:i:s');

	$post_id = $_GET['p_id'];

	$sql = "UPDATE posts SET post_title = '$post_title', post_author = '$post_author', category_id = '$category_id', post_status = '$post_status', post_tags = '$post_tags', post_content = '$post_content', last_edit = '$last_edit', enable_comments = '$comments', post_image = '$featured_image' WHERE post_id = $post_id";

	$query = mysqli_query($connection, $sql);

	if($query){

		// uploading image 

		if(isset($_FILES['featured_image']['name']) and !empty($_FILES['featured_image']['name'])){
			$image = $featured_image;
			$temp_image = $_FILES['featured_image']['tmp_name'];
			$image_status = move_uploaded_file($temp_image, SITE_DIR . 'uploads/' . $image);
		}

		// inserting data into content_seo table

		$sql = "UPDATE content_seo SET `content_type` = 'post', `description` = '$post_description', `enable_seo` = $enable_seo, `p_index` = '$post_index', `follow` = '$post_follow', `keywords` = '$post_keywords', `author` = '$post_author', `subject` = '$post_subject', `revisit_after` = '$revisit_after', `enable_cache` = $enable_cache WHERE `content_id` = $post_id";

		$query = mysqli_query($connection, $sql);

		if($query){

			// header("Location: " . SITE_URL . 'admin/dashboard.php?page=edit-post&p_id=' . $post_id);

			header("Location: " . SITE_URL . 'admin/dashboard.php?page=view-posts');

		}

		else{
			showErrorWindow("ERROR", mysqli_error($connection));
		}

	}
	else{
		showErrorWindow("Error", mysqli_error($connection));
	}

}


















function getImageName($file_extension){
	$flag = false;
	do{
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$file_name = substr(str_shuffle($str_result), 0, 12);
		$file_name .= '.' . $file_extension;
		$file_path = SITE_DIR . 'uploads/' . $file_name;
		if(file_exists($file_path)){
			$flag = true;
		}
		else{
			$falg = false;
		}
	}while($flag != false);
	
	return $file_name;
}

?>