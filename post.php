<?php include './includes/header.php'; ?>
<?php

// destroying the cookie for comment id... this cookie is uses to post a nested comment.

setcookie("comment_id", '0', time() - 3600);

// if(isset($_GET['id']) and !empty($_GET['id'])){

// 	if(is_numeric($_GET['id'])){

// 		$post_id = $_GET['id'];

// 		// if(isset($_GET['type']) and !empty($_GET['type'])){

// 		// 	$type = MRES($_GET['type']);

// 		// }

// 	}

// }

// else{

	$uri = $_SERVER['REQUEST_URI'];

	$uri = substr($uri, 1);

	$uri = str_replace('post/', '', $uri);

	$uri = explode('/', $uri);

	if(is_numeric($uri[0])){

		$post_id = $uri[0];

	}
	
	else{

		header("Location: " . SITE_URL);

	}

// }

$post_data = postData($post_id);
$post_author_username = $post_data['post_author'];

if($post_data['post_id'] != "" or $post_data['post_id'] != NULL){
	$seo_data = seoData($post_id);
	$comment_post_id = $post_data['post_id'];
}

$author_details = authorData($post_data['post_author']);

$cat_name = categoryName($post_data['category_id']);
$post_date = date('d-m-Y', strtotime($post_data['post_date']));
$author_since = date('Y', strtotime($author_details['reg_date']));

$total_posts_of_user = postCountPerUser($post_data['post_author']);
$post_content = $post_data['post_content'];
$page_url = str_replace("//", "/", SITE_URL . $_SERVER['REQUEST_URI']); // to remove double slashes from url


if($seo_data['enable_seo'] != 1){

	$seo_data['p_index'] = "noindex";

	$seo_data['follow'] = "nofollow";

}

if(!empty($seo_data['keywords'])){

	$post_keywords = $seo_data['keywords'];

}

else{

	$post_keywords = $seo_data['post_tags'];

}

if($seo_data['enable_cache'] == 1){

	$cache_status = "cache";

}

else{

	$cache_status = "no-cache";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="<?php echo $seo_data['p_index'] . ',' . $seo_data['follow']; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Meta -->
	<meta name="subject" content="<?php echo $seo_data['subject']; ?>">
	<meta name="description" content="<?php echo $seo_data['description']; ?>"/>
	<meta name="author" content="<?php echo $seo_data['author']; ?>">
	<meta name="keywords" content="<?php echo $post_keywords; ?>">
	<meta name="revisit-after" content="7 days">

	<meta name="og:title" content="<?php echo $post_data['post_title'] . ' | ' . SITE_TITLE; ?>"/>
	<meta name="og:url" content="<?php echo $page_url; ?>"/>
	<meta name="og:image" content="<?php echo SITE_URL;?>uploads/<?php echo $post_data['post_image']; ?>"/>
	<meta name="og:site_name" content="<?php echo SITE_TITLE; ?>"/>
	<meta name="og:description" content="<?php echo $seo_data['description']; ?>"/>

	<meta http-equiv="Pragma" content="<?php echo $cache_status;?>">
	<meta http-equiv="Cache-Control" content="<?php echo $cache_status; ?>">


	<!-- Linking -->
	<?php cms_head_linking(); ?>
	<title><?php echo $post_data['post_title'] . ' | ' . SITE_TITLE; ?></title>
</head>
<body>
	<!-- Main Header -->
	<?php include('./includes/navigation.php'); ?>
	<!-- Navigation Area Ends -->

	<!-- Page Data Container Start -->
	<a name="postdata"></a>
	<div class="page_container">
		<div class="page_content_container"> <!-- Post Page Content Starts -->
			
			<div class="post_container">
				<div class="post_title_block">
					<h2 class="post_title"><?php echo $post_data['post_title']; ?></h2>
				</div>
				<div class="post_meta_block">
					<p class="post_meta post_author">Author : <a href="#" class="post_link"><?php echo $post_data['post_author']; ?></a></p>	
				</div>
				<div class="post_meta_block">
					<p class="post_meta post_category">Category : <a href="#" class="post_link"><?php echo $cat_name; ?></a></p>	
				</div>
				<div class="post_meta_block">
					<p class="post_meta post_date">Date : <?php echo $post_date; ?></p>	
				</div>


				<div class="post_main_image_block">
					<img src="<?php echo SITE_URL;?>uploads/<?php echo $post_data['post_image']; ?>" class="post_main_image1">
				</div>

				<div class="p_content_block">
					<?php echo $post_content; ?>
				</div>

				<?php include('./addons/page_elements/post-tags/post-tags.php'); ?>
				

				<div class="post_author_desc">
					<div class="post_auth_desc_block">
						<img src="<?php echo SITE_URL; ?>images/users/<?php echo $author_details['image']; ?>" alt="" class="post_auth_img">
						<div class="post_auth_desc">
							<a href="<?php echo SITE_URL; ?>profile/<?php echo $author_details['username']; ?>" class="post_auth_name"><?php echo $author_details['fname'] . ' ' . $author_details['lname']; ?></a>
							<p class="post_auth_detail">Author Since <?php echo $author_since; ?> | Posted <?php echo $total_posts_of_user; ?> Posts</p>
						</div>
					</div>
				</div>

				<?php
				if($post_data['enable_comments'] == 1){
					include "./addons/page_elements/comment_box/comment_box.php";
				}
				else{ ?>
				<p class="disable_comments_text" style="text-align: center; background-color: rgba(52, 152, 219,0.3); padding: 6px 0;">Comments are disabled for this post.</p>
				<?php
				} ?>

			</div>
		</div> <!-- Post Page Content Ends -->

		<!-- CMS Sidebar -->
		<?php include './includes/sidebar.php'; ?>
		<!-- CMS Sidebar CLosing -->


	</div> <!-- Page Data Container Ends -->



	<!-- Footer Starts -->
	<?php include('./includes/footer.php'); ?>
	<!-- Footer Ends -->
	
</body>
</html>