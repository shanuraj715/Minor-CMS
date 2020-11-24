<?php

function userRedirect(){
	$user_role = $_SESSION['role'];

	if(!isset($_GET['action']) or empty($_GET['action'])){
		if($user_role == 'admin'){
			header("Location: " . SITE_URL . 'admin/dashboard.php?page=users&action=view');
			exit();
		}
		else{
			header("Location: " . SITE_URL . 'admin/dashboard.php?page=users&action=manage-user-account');
			exit();
		}
	}
}

function dbHeaderData(){
	global $connection;
	$sql = "SELECT role FROM users";
	$query = mysqli_query($connection, $sql);
	if($query){
		$total = 0;
		$admins = 0;
		$subscribers = 0;
		$authors = 0;
		while ($result = mysqli_fetch_assoc($query)) {
			if($result['role'] == 'admin'){
				$admins++;
			}
			elseif($result['role'] == 'subscriber'){
				$subscribers++;
			}
			elseif($result['role'] == 'author'){
				$authors++;
			}
		}
		$total = $admins + $authors + $subscribers;
		$text = 'Total : ' . $total . '&nbsp;&nbsp;&nbsp;Admins : ' . $admins . '&nbsp;&nbsp;&nbsp;&nbsp;Subscribers : ' . $subscribers . '&nbsp;&nbsp;&nbsp;&nbsp;Authors : ' . $authors; ?>
		<script type="text/javascript">
			$('#additional_header_text').html("<?php echo $text; ?>");
		</script>
		<?php
	}
}

function users_usersList(){
	global $connection;
	$sql = "SELECT * FROM users";
	$query = mysqli_query($connection, $sql);
	if($query){
		while($result = mysqli_fetch_assoc($query)){
			if($result['image'] == ""){
				$result['image'] = 'default.jpg';
			}
			?>
			<div class="u_view_data">
				<span class="u_name"><?php echo ucwords($result['fname'] . ' ' . $result['lname']); ?></span>
				<span class="u_username"><?php echo $result['username']; ?></span>
				<span class="u_reg_date"><?php echo date('d-m-Y', strtotime($result['username'])); ?></span>
				<span class="u_role"><?php echo ucfirst($result['role']); ?></span>
				<span class="u_image"><img href="<?php echo SITE_URL . 'images/users/' . $result['image']; ?>" src="<?php echo SITE_URL . 'images/users/' . $result['image']; ?>" alt="<?php echo SITE_TITLE; ?>" class="u_profile_image"></span>
				<a class="u_view_user_details" href="<?php echo SITE_URL . 'admin/extra_files/view-user-details.php?user_id=' . $result['user_id']; ?>"><i class="fas fa-info-circle"></i> Full Detail</a>
				<a class="u_view_user_update" href="<?php echo SITE_URL . 'admin/dashboard.php?page=users&action=manage-user-account&uid=' . $result['user_id']; ?>">Update</a>
			</div>
			
			<?php
		}
	}
}

http://127.5.5.5/admin/dashboard.php?page=users&action=manage-user-account



// manage users //

function usersUpdateDetails($uid){
	global $connection;
	$fname     = userFirstName(); // from login-signup.php in the functions directory
	$lname     = userLastName();
	$password  = userPassword();
	$email     = userEmail();
	$dob       = userDob();
	$gender    = MRES($_POST['gender']);
	if(is_numeric($_POST['mobile'])){
		$mobile    = MRES($_POST['mobile']);
	}
	else{
		$mobile = 0;
	}

	$sql = "UPDATE users SET fname = '$fname', lname = '$lname', password = '$password', email = '$email', dob = '$dob', gender = '$gender', mobile = $mobile WHERE user_id = $uid";
	$query = mysqli_query($connection, $sql);
	if($query){
		if(isset($_FILES['profile_image']['name']) and !empty($_FILES['profile_image']['name'])){
			$image = $_FILES['profile_image']['name'];
			$image = explode('.', $image);
			$image = end($image);
			$image = usersGetImageName($image);

			$temp_image = $_FILES['profile_image']['tmp_name'];
			$image_status = move_uploaded_file($temp_image, SITE_DIR . 'images/users/' . $image);

			$sql = "UPDATE users SET image = '$image' WHERE user_id = $uid";
			$query = mysqli_query($connection, $sql);
			if($query){
				$status = 2;
			}
			else{
				showErrorWindow("Error!!!", "Unable to update the database. Please contact the admin for more information.");
			}
		}
		showSuccessWindow("Done...", "Your data is successfully submitted to the database.");
	}
	else{
		showErrorWindow("Error!!!", "Unable to update the database. Please contact the admin for more information");
	}




	


}

function usersGetImageName($file_extension){
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













function usersJsScripts(){ ?>
	<script type="text/javascript">
		$('#fname').keyup(function(){
			if($(this).val().length >= 3){
				$('#check_fname').removeClass("fa-times");
				$('#check_fname').addClass("fa-check");
				$('#check_fname').css("color", 'rgba(39, 174, 96,1.0)');
			}
			else{
				$('#check_fname').removeClass("fa-check");
				$('#check_fname').addClass("fa-times");
				$('#check_fname').css("color", 'rgba(192, 57, 43,1.0)');
			}
		});



		$('#mobile').bind('keyup click', function(){
			if($(this).val().length == 10){
				$('#check_mobile').removeClass("fa-times");
				$('#check_mobile').addClass("fa-check");
				$('#check_mobile').css("color", 'rgba(39, 174, 96,1.0)');
			}
			else{
				$('#check_mobile').removeClass("fa-check");
				$('#check_mobile').addClass("fa-times");
				$('#check_mobile').css("color", 'rgba(192, 57, 43,1.0)');
			}
		});



		$('#lname').keyup(function(){
			if($(this).val().length >= 3){
				$('#check_lname').removeClass("fa-times");
				$('#check_lname').addClass("fa-check");
				$('#check_lname').css("color", 'rgba(39, 174, 96,1.0)');
			}
			else{
				$('#check_lname').removeClass("fa-check");
				$('#check_lname').addClass("fa-times");
				$('#check_lname').css("color", 'rgba(192, 57, 43,1.0)');
			}
		});



		$('#password').bind('keyup click', function(){
			if($(this).val().length >= 8){
				$('#check_password').removeClass("fa-times");
				$('#check_password').addClass("fa-check");
				$('#check_password').css("color", 'rgba(39, 174, 96,1.0)');
			}
			else{
				$('#check_password').removeClass("fa-check");
				$('#check_password').addClass("fa-times");
				$('#check_password').css("color", 'rgba(192, 57, 43,1.0)');
			}
		});

		$('#username').keyup(function(){
			if($(this).val().length >= 8){
				let username = $(this).val();
				// console.log(username);
				$.ajax({
					url: "<?php echo SITE_URL . 'admin/extra_files/admin-users-ajax-validator.php';?>",
					data: {
						username: username
					},
					success: function( result ) {
						if(result == 'true'){
							$('#check_username').removeClass("fa-check");
							$('#check_username').addClass("fa-times");
							$('#check_username').css("color", 'rgba(192, 57, 43,1.0)');
						}
						else{
							$('#check_username').removeClass("fa-times");
							$('#check_username').addClass("fa-check");
							$('#check_username').css("color", 'rgba(39, 174, 96,1.0)');
						}
					}
				});
			}
			else{
				$('#check_username').removeClass("fa-check");
				$('#check_username').addClass("fa-times");
				$('#check_username').css("color", 'rgba(192, 57, 43,1.0)');
			}
		});

		$('#email').keyup(function(){
			if($(this).val().length >= 8){
				let email = $(this).val();
				// console.log(username);
				$.ajax({
					url: "<?php echo SITE_URL . 'admin/extra_files/admin-users-ajax-validator.php';?>",
					data: {
						email: email
					},
					success: function( result ) {
						if(result == 'true'){
							$('#check_email').removeClass("fa-check");
							$('#check_email').addClass("fa-times");
							$('#check_email').css("color", 'rgba(192, 57, 43,1.0)');
						}
						else{
							$('#check_email').removeClass("fa-times");
							$('#check_email').addClass("fa-check");
							$('#check_email').css("color", 'rgba(39, 174, 96,1.0)');
						}
					}
				});
			}
			else{
				$('#check_email').removeClass("fa-check");
				$('#check_email').addClass("fa-times");
				$('#check_email').css("color", 'rgba(192, 57, 43,1.0)');
			}
		});
	</script>
	<?php
}




?>