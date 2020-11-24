<?php include('./includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php getSiteMetaSettings('site_title'); ?></title>

	<!-- Meta -->
	<meta name="subject" content="<?php getSiteMetaSettings('subject'); ?>">

	<meta name="description" content="<?php getSiteMetaSettings('description'); ?>"/>

	<meta name="author" content="<?php getSiteMetaSettings('author'); ?>">

	<meta name="keywords" content="<?php getSiteMetaSettings('keywords'); ?>">

	<meta name="revised" content="<?php getSiteMetaSettings('revised'); ?>" />

	<meta name="revisit-after" content="<?php getSiteMetaSettings('revisit-after'); ?>">

	<meta name="og:title" content="<?php getSiteMetaSettings('site_title'); ?>"/>

	<meta name="og:url" content="<?php echo SITE_URL;?>"/>

	<meta name="og:image" content="<?php echo SITE_URL.'images/fevicon.png';?>"/>

	<meta name="og:site_name" content="<?php getSiteMetaSettings('site_title'); ?>"/>

	<meta name="og:description" content="<?php getSiteMetaSettings('description'); ?>"/>


	<meta http-equiv="Pragma" content="<?php getSiteMetaSettings('cache'); ?>">
	<meta http-equiv="Cache-Control" content="<?php getSiteMetaSettings('cache'); ?>">
	<!-- Linking -->
	<?php cms_head_linking(); //From functios.php for all <link> tags ?>

	<script type="text/javascript" src="<?php echo SITE_URL;?>js_functions/shortcut_keys.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js_functions/functions.js"></script>
</head>
<body>

	<!-- Main Header -->

	<?php include(__DIR__ . '/includes/navigation.php'); ?>

	 <!-- Navigation Area Ends -->

	<!-- Page Data Container Start -->

	<div class="page_container">

		<div class="page_content_container">

			<!-- For Page Info (Like Sort by category, Search result of ABC) -->

			<div class="sort_post_block">
				
				<p class="sort_post_text">Search Result Of <?php echo $_GET['s'];?></p>

			</div> <!-- For Page Info -->

			<!-- post small block -->
			<?php
			if(isset($_GET['s'])){
			printPostList();
			}
			else{
				header("Location: " . SITE_URL);
				exit();
			} ?>
			 <!-- post small block closing -->


		</div>
		<!-- CMS Sidebar -->
		<?php include './includes/sidebar.php'; ?>
		 <!-- CMS Sidebar CLosing -->


	</div> <!-- Page Data Container Ends -->



	<!-- Footer Starts -->
	<?php include './includes/footer.php'; ?>
	 <!-- Footer Ends -->
</body>
</html>