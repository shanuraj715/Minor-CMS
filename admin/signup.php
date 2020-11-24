<?php include_once('./includes/header.php');
 ?>

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
	<?php

		if(isset($_POST['acc_register_submit']) and isset($_POST['username']) and !empty($_POST['username'])){

		handleUserRegisterForm(); // functions/login-signup.php

	}
	?>
	<div class="login_back_container">
		<div class="login_form_container">
			<form action="" method="POST">
				<div class="form_title_block">
					<h2 class="form_title">Signup Form</h2>
				</div>
				<div class="input_combiner">
					<div class="input_block">
						<i class="far fa-user"></i>
						<input type="text" class="input_text" name="fname" placeholder="Enter Your First Name" required>
					</div>
					<div class="input_block">
						<i class="far fa-user"></i>
						<input type="text" class="input_text" name="lname" placeholder="Enter Your Last Name">
					</div>
				</div>
				<div class="input_combiner">
					<div class="input_block">
						<i class="fas fa-user"></i>
						<input type="text" class="input_text" name="username" placeholder="Enter Your Username" required>
					</div>
				</div>
				<div class="input_combiner">
					<div class="input_block">
						<i class="fas fa-envelope"></i>
						<input type="email" class="input_text" name="user_email" placeholder="Enter Your Email ID" required>
					</div>
				</div>
				<div class="input_combiner">
					<div class="input_block">
						<i class="fas fa-key"></i>
						<input type="password" name="user_pass" class="input_pass" placeholder="Enter Password" required>
					</div>
					<div class="input_block">
						<i class="fas fa-key"></i>
						<input type="password" name="user_pass2" class="input_pass" placeholder="Retype Password" required>
					</div>
				</div>
				<div class="input_combiner">
					<div class="input_block">
						<i class="fas fa-calendar-alt"></i>
						<span class="dob_text">Date Of Birth</span>
						<select name="user_dob_date" class="user_dob_select">
							<?php ageOptionList(); ?>
						</select>
						<select name="user_dob_month" class="user_dob_select">
							<?php monthOptionList(); ?>
						</select>
						<select name="user_dob_year" class="user_dob_select">
							<?php yearOptionList(); ?>
						</select>
					</div>
				</div>
				<div id="more_options_by_plugins">
				</div>
				<div id="cms_form_submit_button_container" class="form_submit_block ">
					<input id="cms_form_submit_btn" type="submit" class="submit_btn" name="acc_register_submit">
				</div>
			</form>
			<div class="form_btns9">
				<div class="back_btn_block">
					<a class="back_btn_link" href="<?php echo SITE_URL; ?>"><i class="fas fa-angle-double-left back_btn_fa"></i>&nbsp;Home</a>
				</div>
				<div class="login_create_btn_block">
					<a class="login_register_btn_link" href="<?php echo SITE_URL . 'admin/login.php'; ?>"><i class="far fa-user-circle back_btn_fa"></i>&nbsp;Login</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>