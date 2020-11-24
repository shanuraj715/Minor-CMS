
<?php
// including the function page. this page has all the functions rellated to this page.
include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/users-functions.php';
 ?>

<?php

userRedirect(); // this function will redirect user to the manage account page that is not an admin. if the role of the logged user is an admin then the page will redirect to view users page.

if($_SESSION['role'] == 'admin'){
	dbHeaderData(); // display the number of users in dashboard header
}

$action = $_GET['action'];
if($action == 'view'){ 
?>
<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "View Users";
</script>
<div class="users_blocks_container">
	<div class="users_add_user_btn_block">
		<a href="<?php echo SITE_URL . '/admin/dashboard.php?page=users&action=add-new-user'; ?>">Add User</a>
	</div>
	<div class="u_view_block">
		<div class="u_view_head">
			<span class="u_name">Name</span>
			<span class="u_username">Username</span>
			<span class="u_reg_date">Reg. Date</span>
			<span class="u_role">Role</span>
			<span class="u_image_head">User Image</span>
		</div>
		<?php users_usersList(); ?>
	</div>
	<script type="text/javascript">
		$('.u_view_data').magnificPopup({ // magnifiear... this is a jquery plugin. installation dir = /jquery_libs/
			delegate: '.u_view_user_details', // child items selector, by clicking on it popup will open
			type: 'iframe'
	 		// other options
		});


		$('.u_image').magnificPopup({ // magnifiear... this is a jquery plugin. installation dir = /jquery_libs/
			delegate: 'img', // child items selector, by clicking on it popup will open
			type: 'image'
	 		// other options
		});
	</script>

<?php
}

if($action == 'add-new-user'){ 
	if(isset($_POST['fname']) and !empty($_POST['fname'])){
		handleUserRegisterForm(); // from login-signup.php page into functions directory
	}
?>
<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Add User";
</script>
<div class="users_add_user_block">
	<p class="users_add_user_p">Add New User</p>
	<form action="" method="post">
		<div class="users_anu_form_block">
			<label class="users_anu_form_label" for="fname">First Name : </label>
			<input type="text" name="fname" id="fname" class="fname" required>
			<i id="check_fname" class="fas fa-times users_check_tick"></i>
		</div>
		<div class="users_anu_form_block">
			<label class="users_anu_form_label" for="lname">Last Name : </label>
			<input type="text" name="lname" id="lname" class="lname" required>
			<i id="check_lname" class="fas fa-times users_check_tick"></i>
		</div>
		<div class="users_anu_form_block">
			<label class="users_anu_form_label" for="username">Username : </label>
			<input type="text" name="username" id="username" class="username" required>
			<i id="check_username" class="fas fa-times users_check_tick"></i>
		</div>
		<div class="users_anu_form_block">
			<label class="users_anu_form_label" for="email">Email ID  : </label>
			<input type="text" name="user_email" id="email" class="email" required>
			<i id="check_email" class="fas fa-times users_check_tick"></i>
		</div>
		<div class="users_anu_form_block">
			<label class="users_anu_form_label" for="password">Set Password : </label>
			<input type="password" name="user_pass" id="password" class="password" required>
			<i id="check_password" class="fas fa-times users_check_tick"></i>
		</div>
		<div class="users_anu_form_block">
			<label class="users_anu_form_label" for="dob">Date of Birth : </label>
			<select class="users_age_selector" name="user_dob_date">
				<?php ageOptionList(); // from login-signup.php. from functions directory ?>
			</select>
			<select class="users_age_selector" name="user_dob_month">
				<?php monthOptionList(); // from login-signup.php. from functions directory ?>
			</select>
			<select class="users_age_selector" name="user_dob_year">
				<?php yearOptionList(); // from login-signup.php. from functions directory ?>
			</select>
		</div>

		<div class="users_submit_btn_block">
			<input class="users_anu_submit_btn" type="submit" name="new_user_submit" value="Add User">
		</div>
	</form>
	
</div>


<?php
usersJsScripts();
}
elseif($action == 'manage-user-account'){
	global $connection;

	// checking for userid. this userid will use to get the user data from the users table and show them into the form

	if(isset($_GET['uid']) and is_numeric($_GET['uid'])){
		if($_SESSION['role'] == 'admin'){
			$uid = $_GET['uid'];
		}
		else{
			$uid = $_SESSION['userid'];
		}
	}
	else{
		$uid = $_SESSION['userid'];

	}

	// checking for form submission //

	if(isset($_POST['fname']) and !empty($_POST['fname'])){
		if(isset($_POST['user_pass']) and !empty($_POST['user_pass'])){

			usersUpdateDetails($uid);

		}
	}


	$sql = "SELECT * FROM users WHERE user_id = $uid";
	$query = mysqli_query($connection, $sql);
	if($query){
		$result = mysqli_fetch_assoc($query);
		$user_dob_date = date('d', strtotime($result['dob']));
		$user_dob_month = date('m', strtotime($result['dob']));
		$user_dob_year = date('Y', strtotime($result['dob']));
		$gender = strtolower($result['gender']);
	}

	?>
	
<script type="text/javascript">
	$('#page_title').html("Manage Profile");
</script>
	<div class="users_manage_users_block">
		<p class="users_mu_p">Manage Profile</p>
		<div class="users_mu_form_block">
			<form action="" method="post" enctype="multipart/form-data">
				
				<div class="users_mu_form_row">
					<label for="uid">User ID : </label>
					<input type="text" name="uid" id="uid" class="users_mu_form_inp_txt" value="<?php echo $result['user_id'];?>" disabled>
				</div>


				<div class="users_mu_form_row">
					<label for="fname">First Name : </label>
					<input type="text" name="fname" id="fname" class="users_mu_form_inp_txt" value="<?php echo $result['fname'];?>" required>
				</div>


				<div class="users_mu_form_row">
					<label for="lname">Last Name : </label>
					<input type="text" name="lname" id="lname" class="users_mu_form_inp_txt" value="<?php echo $result['lname'];?>" required>
				</div>


				<div class="users_mu_form_row">
					<label for="username">Username : </label>
					<input type="text" name="username" id="username" class="users_mu_form_inp_txt" value="<?php echo $result['username'];?>" disabled>
				</div>


				<div class="users_mu_form_row">
					<label for="password">Password : </label>
					<input type="password" name="user_pass" id="password" class="users_mu_form_inp_txt" value="<?php echo $result['password'];?>">
					<i id="check_password_mu" class="fas fa-eye-slash" style="margin-left: 15px; padding-top: 5px;"></i>
					<i id="check_password" class="fas" style="color: rgba(192, 57, 43,1.0);margin-left: 15px; padding-top: 5px;"></i>
				</div>


				<div class="users_mu_form_row">
					<label for="email">Email ID : </label>
					<input type="text" name="user_email" id="email" class="users_mu_form_inp_txt" value="<?php echo $result['email'];?>">
				</div>


				<div class="users_mu_form_row">
					<label for="dob">Date of Birth : </label>
					<select id="user_dob_date" class="users_age_selector" name="user_dob_date">
						<?php ageOptionList(); // from login-signup.php. from functions directory ?>
					</select>
					<select id="users_dob_month" class="users_age_selector" name="user_dob_month">
						<?php monthOptionList(); // from login-signup.php. from functions directory ?>
					</select>
					<select id="user_dob_year" class="users_age_selector" name="user_dob_year">
						<?php yearOptionList(); // from login-signup.php. from functions directory ?>
					</select>
				</div>
				
				<div class="users_mu_form_row">
					<label for="gender">Gender : </label>
					<select name="gender" class="users_age_selector" id="gender">
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>


				<div class="users_mu_form_row">
					<label for="mobile">Mobile : </label>
					<input type="text" name="mobile" id="mobile" class="users_mu_form_inp_txt" value="<?php echo $result['mobile'];?>">
					<i id="check_mobile" class="fas users_check_tick"></i>
				</div>


				<div class="users_mu_form_row">
					<label for="image">Profile Image : </label>
					<input type="file" name="profile_image" id="profile_image" class="users_mu_form_inp_txt">
				</div>

				<div class="users_mu_image_preview_block">
					<div class="users_mu_image_block">
						<p class="users_image_title">Current Image</p>
						<img class="users_oi_preview" src="<?php echo SITE_URL . 'images/users/' . $result['image'];?>" href="<?php echo SITE_URL . 'images/users/' . $result['image'];?>">
					</div>
					<div class="users_mu_image_block">
						<p class="users_image_title">New Image</p>
						<img id="user_image_show" src="" href="">
					</div>
				</div>

				<div class="users_submit_btn_block">
					<input class="users_anu_submit_btn" type="submit" name="manage_user_submit" value="Save Changes">
				</div>
			</form>
			<?php usersJsScripts(); ?>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#user_dob_date').children().each(function(){
						if($(this).val() == '<?php echo $user_dob_date; ?>'){
							$(this).attr('selected', 'selected');
						}
					});

					$('#user_dob_month').children().each(function(){
						if($(this).val() == '<?php echo $user_dob_month; ?>'){
							$(this).attr('selected', 'selected');
						}
					});

					$('#user_dob_year').children().each(function(){
						if($(this).val() == '<?php echo $user_dob_year; ?>'){
							$(this).attr('selected', 'selected');
						}
					});

					$('#gender').children().each(function(){
						if($(this).val() == '<?php echo $gender; ?>'){
							$(this).attr('selected', 'selected');
						}
					});

					$('#check_password_mu').click(function(){
						if($('#password').attr('type') == 'password'){
							$('#password').attr('type', 'text');
							$('#check_password_mu').removeClass('fa-eye-slash');
							$('#check_password_mu').addClass('fa-eye');
						}
						else{
							$('#password').attr('type', 'password');
							$('#check_password_mu').removeClass('fa-eye');
							$('#check_password_mu').addClass('fa-eye-slash');
						}
					});
					
					/* following code is used for user new image. this will live preview the new image */
					$('#profile_image').on('change' , function(){
						var src = document.getElementById("profile_image");
						var target = document.getElementById("user_image_show");
						showUserImage(src, target);
					});	

					function showUserImage(src, target) {
						var fr = new FileReader();
						fr.onload = function(){
							target.src = fr.result;
						}
						if(src.value!=""){
							// document.getElementById('feature_img_image_block').style.display = 'block';
							// document.getElementById('remove_fi_btn').style.display = 'block';
							fr.readAsDataURL(src.files[0]);
						}
						else{
							// document.getElementById('feature_img_image_block').style.display = 'none';
							target.src = "";
							// document.getElementById('remove_fi_btn').style.display = 'none';
						}
					}


					/* for image preview usinh Magnific Popup (jQuery Plugin).. this qill work on the old user image. */
					$('.users_oi_preview').magnificPopup({ // jQuery plugin. js file is included in dashboard.php page in head section
						type: 'image' // popup type image. 
					});
				});


				
			</script>
		</div>
	</div>

<?php
} ?>
</div>


