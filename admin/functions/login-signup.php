<?php

function handleLoginForm(){

	$username = $_POST['username'];

	$username = MRES($username);

	$password = $_POST['user_pass'];

	$password = MRES($password);

	loginQuery($username, $password);
}

function loginQuery($user, $pass){

	global $connection;

	$sql = "SELECT * FROM users WHERE";
	$sql .= " (username = '$user' or email = '$user')";
	$sql .= " and (password = '$pass')";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	$user_row = mysqli_num_rows($query);

	if($user_row == 1){

		setSessionForUser($result);

	}
	elseif($user_row == 0){

		header('Location: ' . SITE_URL . 'admin/login.php?error=1');

		exit();

	}

}

function showLoginPageError(){

	if(isset($_GET['error']) and !empty($_GET['error'])){

		$error = MRES($_GET['error']);

		if($error == 1){ 

			$error_text = "Username or Password Is Incorrect"; ?>

			<div class="error_shower">

				<p class="form_page_error_text"><?php echo $error_text; ?></p>
			
			</div>	
		<?php
		}
	
	} 

}

function setSessionForUser($result){

	$user_id = $result['user_id'];

	$username = $result['username'];

	$fname = $result['fname'];

	$lname = $result['lname'];

	$email = $result['email'];

	$role = $result['role'];

	$unique_key = LOGIN_KEY;

	$_SESSION['userid'] = $user_id;

	$_SESSION['username'] = $username;

	$_SESSION['fname'] = $fname;

	$_SESSION['lname'] = $lname;

	$_SESSION['email'] = $email;

	$_SESSION['role'] = $role;

	$_SESSION['login_key'] = $unique_key;

	if(isset($_GET['redirect']) and !empty($_GET['redirect'])){

		$redirect_to = $_GET['redirect'];

		header('Location: ' . $redirect_to);

	}

	else{

		header('Location: ' . SITE_URL . 'admin/dashboard.php');

	}

}




/* Signup Page */

function handleUserRegisterForm(){

	global $connection;

	$fname = userFirstName();

	$lname = userLastName();

	$username = userUsername();

	$pass1 = userPassword();

	$pass2 = userPassword2();

	$email = userEmail();

	$user_dob = userDob();

	$username_status = validateUsername($username);

	$password_status = validatePassword($pass1, $pass2);

	$email_status = validateEmail($email);

	if($username_status and $password_status and $email_status){

		$otp_enable_status = checkOtpSendStatusFromDb();

		if($otp_enable_status){

			sendOtp($fname, $lname, $email, $username);

			$user_id = $_SESSION['user_id'];

			$status = storeUserRegisterDataInDB($user_id, $fname, $lname, $email, $pass1, $username, $user_dob, 'pending');

			if($status){

				

			}

		}


		else{

			$user_id = generateUserId();

			$status = storeUserRegisterDataInDB($user_id, $fname, $lname, $email, $pass1, $username, $user_dob, 'active');

			if($status){

				header("Location: " . SITE_URL . 'admin/login.php');

			}

		}

	}



}

function storeUserRegisterDataInDB($userid, $fname, $lname, $email, $password, $username, $user_dob, $status){

	global $connection;

	$sql = "INSERT INTO users(user_id, fname, lname, username, email, password, dob, role, status) VALUES($userid, '$fname', '$lname', '$username', '$email', '$password', '$user_dob', 'subscriber', '$status')";

	$query = mysqli_query($connection, $sql);

	if($query){

		return true;

	}

	else{

		return false;

	}

}

function checkOtpSendStatusFromDb(){

	global $connection;

	$sql = "SELECT * FROM settings WHERE name = 'user_otp_verification'";

	$query = mysqli_query($connection, $sql);

		if($query){

		$result = mysqli_fetch_assoc($query);

		if($result['value'] == 'enable'){

			return true;

		}

		else{

			return false;

		}

	}

	else{

		return false;

	}

}

function sendOtp($fname, $lname, $email, $username){

	global $connection;

	$userid = generateUserId();

	$otp = rand(101234, 999987);

	$auth_key = substr($fname, strlen($fname) - 2);

	$auth_key .= substr($lname, strlen($lname) - 2);

	$auth_key .= substr($email, strlen($email) - 2);

	$auth_key .= rand(2000, 4000);

	$auth_key .= rand(12, 99);

	$sql = "SELECT * FROM settings WHERE name = 'otp_sender_email'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	$sender_email = $result['value']; // sender email id. This email id will use to send the email. and it will attach to the email content.

	$reciver_email = $email; // email will send to this email id

	$subject = SITE_TITLE . ' - OTP Verification';

	$from = 'From ' . $sender_email;

	$email_content = SITE_TITLE . '

Dear ' . $fname . ' ' . $lname . '

We have recived a request to create your new account. Please Provide the Otp to confirm your account.

OTP for your account is ' . $otp . '

or you can also verify your account using the following link. 

' . SITE_URL . 'admin/Validate-OTP.php?user=' . $userid . '&key=' . $auth_key . '

Please ignore this message if this has not done by you.

From ' . SITE_TITLE . ' - ' . SITE_URL;

	$mail_status = mail($reciver_email, $subject, $email_content, $from);

	if($mail_status){

		define('USER_ID', $userid);

		storeOTPinDB($userid, $otp, $auth_key);

	}

	else{

		echo "Mail Not Sent";

	}

}

function storeOTPinDB($user_id, $otp, $auth_key){

	global $connection;

	$now_time = date('Y-m-d H:i:s');

	$sql = "INSERT INTO users_otp (user_id, otp, auth_key, date_time) VALUES($user_id, $otp, '$auth_key', '$now_time')";

	$query = mysqli_query($connection, $sql);

	if($query){

		otpForm($user_id);

	}

	else{

		return false;

	}

}

function validateUsername($username){

	global $connection;

	$sql = "SELECT username FROM users where username = '$username'";

	$query = mysqli_query($connection, $sql);

	$status = mysqli_num_rows($query);

	if($status >= 1){

		return false;

	}

	else{

		return true;

	}

}

function validatePassword($pass1, $pass2){

	if($pass1 == $pass2){

		return true;

	}

	else{

		return false;

	}

}

function validateEmail($email){

	global $connection; 

	$sql = "SELECT user_email FROM users WHERE user_email = '$email'";

	$query = mysqli_query($connection, $sql);

	if($query){

		$status = mysqli_num_rows($query);

		if($status >= 1){

			return false;

		}

		else{

			return true;

		}

	}

	else{

		return true;

	}

}

function generateUserId(){

	global $connection;

	$flag = true;

	do{

		$user_id = rand(100000, 999999);

		$sql = "SELECT user_id FROM users WHERE user_id = $user_id";

		$query = mysqli_query($connection, $sql);

		if($query){

			$result = mysqli_num_rows($query);

			if($result == 0){

				$flag = false;

			}

		}

	} while($flag != false);

	return $user_id;

}





function userFirstName(){

	if(isset($_POST['fname']) and !empty($_POST['fname'])){

		$fname = MRES($_POST['fname']);

	}

	else{

		redirectToHome();

	}

	return $fname;

}

function userLastName(){

	if(isset($_POST['lname']) and !empty($_POST['lname'])){

		$lname = MRES($_POST['lname']);

	}

	else{

		redirectToHome();

	}

	return $lname;

}

function userUsername(){

	if(isset($_POST['username']) and !empty($_POST['username'])){

		$username = MRES($_POST['username']);

	}

	else{

		redirectToHome();

	}

	return $username;

}

function userEmail(){

	if(isset($_POST['user_email']) and !empty($_POST['user_email'])){

		$user_email = MRES($_POST['user_email']);

	}

	else{

		redirectToHome();

	}

	return $user_email;

}

function userPassword(){

	if(isset($_POST['user_pass']) and !empty($_POST['user_pass'])){

		$user_pass = MRES($_POST['user_pass']);

	}

	else{

		redirectToHome();

	}

	return $user_pass;

}

function userPassword2(){

	if(isset($_POST['user_pass2']) and !empty($_POST['user_pass2'])){

		$user_pass2 = MRES($_POST['user_pass2']);

	}

	else{

		$user_pass2 = MRES($_POST['user_pass']);

		return $user_pass2;

	}

	return $user_pass2;

}

function userDob(){

	if(isset($_POST['user_dob_date']) and !empty($_POST['user_dob_date'])){

		if(is_int($_POST['user_dob_date']) or is_numeric($_POST['user_dob_date'])){

			$userdate = $_POST['user_dob_date'];

		}

		else{

			redirectToHome();

		}

	}

	else{

		redirectToHome();

	}

	if(isset($_POST['user_dob_month']) and !empty($_POST['user_dob_month'])){

		if(is_int($_POST['user_dob_month']) or is_numeric($_POST['user_dob_month'])){

			$usermonth = $_POST['user_dob_month'];

		}

		else{

			redirectToHome();

		}

	}

	else{

		redirectToHome();

	}

	if(isset($_POST['user_dob_year']) and !empty($_POST['user_dob_year'])){

		if(is_int($_POST['user_dob_year']) or is_numeric($_POST['user_dob_year'])){

			$useryear = $_POST['user_dob_year'];

		}

		else{

			redirectToHome();

		}

	}

	else{

		redirectToHome();

	}

	$date =  strtotime($useryear . '-' . $usermonth . '-' . $userdate);

	return date('Y-m-d', $date);



}















function redirectToHome(){

	header("Location: " . SITE_URL);

	exit();

}

function ageOptionList(){

	$start = 1;

	$end = 31;

	while($start <= $end){

		echo '<option class="user_dob_option" value="' . $start . '">' . $start . '</option>';

		$start++;

	}

}

function monthOptionList(){

	$month_array = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

	foreach ($month_array as $key => $value) {

		$month = $key + 1;
		
		echo '<option class="user_dob_option" value="' . $month . '">' . ucfirst($value) . '</option>';

	}

}

function yearOptionList(){

	$start_year = date('Y') - 50;

	while($start_year <= date('Y')){

		echo '<option class="user_dob_option" value="' . $start_year . '">' . $start_year . '</option>';

		$start_year++;

	}

}

function otpForm($user_id){ ?>

	<style type="text/css">

		.otp_form_bg_full{
			position: absolute;
			min-width: 100vw;
			min-height: 100vh;
			background-color: rgba(26, 188, 156, 0.65);
			z-index: 5;
		}

		.otp_form_container{
			background-color: #dcdde1;
			border: solid 2px #0097e6;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 0 8px 4px #ecf0f1;
			position: absolute;
			z-index: 10;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			max-width: 500px;
		}

		.otp_heading{
			margin: 0;
			padding: 5px 0;
			text-transform: uppercase;
			text-align: center;
			font-family: monospace;
			font-size: 22px;
			background-color: rgba(44, 62, 80,1.0);
			color: white;
		}

		.otp_form{
			padding: 12px 15px;
			text-align: center;
		}

		.otp_text{
			line-height: 28px;
			margin: 0;
			margin-bottom: 15px;
			text-align: left;
		}

		#otp_inp{
			outline: none;
			border: solid 2px #2980b9;
			background-color: #ecf0f1;
			padding: 3px 10px;
			border-radius: 6px;
			font-family: monospace;
			font-size: 20px;
			max-width: 100px;
			transition: background-color 1s;
		}

		#otp_inp:focus{
			background-color: #006266;
			color: white;
		}

		#otp_submit_btn{
			outline: none;
			border: solid 2px #2c3e50;
			background-color: #006266;
			padding: 3px 10px;
			color: white;
			font-family: monospace;
			font-size: 20px;
			text-transform: uppercase;
			border-radius: 4px;
			cursor: pointer;
			transition: 0.3s;
		}

		#otp_submit_btn:hover{
			background-color: #2c3e50;
			border-color: #2980b9;
		}
	</style>
	
	<div class="otp_form_bg_full">
		<div class="otp_form_container">
			<p class="otp_heading"><i class="fas fa-user-secret"></i> Otp Form</p>
			<div class="otp_form">
				<p class="otp_text">Enter the otp in the below box. OTP is successfully sent to your email id.</p>
				<input type="text" id="otp_inp" maxlength="6">
				<button id="otp_submit_btn">Submit</button>

				<script type="text/javascript">
					$('#otp_submit_btn').click(function(){
						let otp = $('#otp_inp').val();
						let url = '<?php echo SITE_URL . "admin/Validate-OTP.php?user="; ?>';
						url +=  "<?php echo $user_id; ?>";
						url += "&otp=" + otp;
						window.open(url, '_SELF');
					});
				</script>

			</div>
		</div>
	</div>

<?php

}
							

?>

