<?php include './includes/header.php'; ?>



<?php if(isset($_SESSION['username'])){
	header('Location: ' . SITE_URL . 'admin/dashboard.php');
}

if(isset($_POST['username']) and !empty($_POST['username']) and isset($_POST['user_pass']) and !empty($_POST['user_pass'])){

	handleLoginForm();

} ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>CMS Login</title>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL . 'css/style.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL . 'admin/css/login_register.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL . 'css/fonts-awesome/css/all.css'; ?>">
	<?php include './includes/linker.php'; ?>
</head>
<body>
	<?php pluginList(); // function is available in php_functions/handlers/plugins.php ?>
	<div class="login_back_container">
		<?php showLoginPageError(); ?>
		<div class="login_form_container">
			<form id="login_form" action="" method="POST">
				<div class="form_title_block">
					<h2 class="form_title">Login Form</h2>
				</div>
				<div class="input_block">
					<i id="username_icon" class="fas fa-user"></i>
					<input id="username_input" type="text" class="input_text" name="username" placeholder="Username or Email" required>
				</div>
				<div class="input_block">
					<i id="password_icon" class="fas fa-key"></i>
					<input id="password_input" type="password" name="user_pass" class="input_pass" placeholder="Enter Password" required>
				</div>
				<div id="more_options_by_plugins">
				</div>
				<div id="cms_form_submit_button_container" class="form_submit_block">
					<input id="cms_form_submit_btn" type="submit" class="submit_btn" name="acc_login_submit">
				</div>
			</form>



			<div class="form_btns9">
				<div class="back_btn_block">
					<a class="back_btn_link" href="<?php echo SITE_URL; ?>"><i class="fas fa-angle-double-left back_btn_fa"></i>&nbsp;Home</a>
				</div>
				<div class="login_create_btn_block">
					<a class="login_register_btn_link" href="<?php echo SITE_URL . 'admin/signup.php'; ?>"><i class="far fa-user-circle back_btn_fa"></i>&nbsp;Signup</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>