<?php include './includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
	<title>Account Verification</title>
	<style type="text/css">
		body{
			margin: 0;
		}
		.a1, .a2{
			display: inline-block;
			width: 500px;
			position: absolute;
			z-index: 2;
			background-color: #95a5a6;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			border-radius: 8px;
			overflow: hidden;
			border: solid 2px #2c3e50;
		}

		.b1, .b2{
			
		}
		.c1, .c2{
			text-align: center;
			font-family: monospace;
			font-size: 22px;
			margin: 0;
			padding: 10px 0;
			background-color: #192a56;
			text-transform: uppercase;
			cursor: pointer;
		}

		.c1{
			color: #2980b9;
		}

		.c2{
			color: #2f3640;
		}

		.d1, .d2{
			padding: 15px;
			line-height: 30px;
		}
		
		.e1, .e2{
			font-family: monospace;
			font-size: 18px;
		}

		.f1, .f2{
			font-family: monospace;
			text-transform: uppercase;
			font-size: 18px;
			text-decoration: none;
		}

		.f1:hover{
			text-decoration: underline;

		}

		.c2{
			background-color: #c23616;
		}
	</style>
</head>
<body>

<?php

$message = new AccountMessages;

global $connection;

if(isset($_GET['user']) and !empty($_GET['user'])){

	$user_id = MRES($_GET['user']);

	if(isset($_GET['key']) and !empty($_GET['key'])){

		$key = MRES($_GET['key']);

		$sql = "SELECT * FROM users_otp WHERE user_id = $user_id and auth_key = '$key'";

		$query = mysqli_query($connection, $sql);

		if($query){

			$status = mysqli_num_rows($query);

			if($status >= 1){

				$message -> updateUserStatus();

			}

			else{

				$message -> accountNotVerifiedMessage();

			}

		}

		else{

			$message -> accountNotVerifiedMessage();

		}

	}









	else{

		if(isset($_GET['otp']) and !empty($_GET['otp'])){

			if(is_int($_GET['otp']) or is_numeric($_GET['otp'])){

				$otp = $_GET['otp'];

				$sql = "SELECT * FROM users_otp WHERE user_id = $user_id and otp = $otp";

				$query = mysqli_query($connection, $sql);

				if($query){

					$status = mysqli_num_rows($query);

					if($status >= 1){

						$message -> updateUserStatus();

						// $message -> accountVerifiedMessage();

					}

					else{

						$message -> accountNotVerifiedMessage();

					}

				}

			}

		}

	}

}

else{

	header("Location: " . SITE_URL . 'admin/login.php');

}










class AccountMessages{

	function accountVerifiedMessage(){ ?>

		<div class="a1">
			<div class="b1"><p class="c1">Congratulations...</p></div>
			<div class="d1">
				<span class="e1">Your account is successfully verified. You can login now to your dashboard.</span>
				<a class="f1" href="<?php echo SITE_URL . 'admin/login.php'; ?>">Login Now</a>
			</div>
		</div>

		<?php
	}

	function accountNotVerifiedMessage(){ ?>

		<div class="a2">
			<div class="b2"><p class="c2">Oops...</p></div>
			<div class="d2">
				<span class="e2">We are unable to verify your account at this time. Please privide correct details { OTP or Authentication Key }</span>
				<a class="f2" href="<?php echo SITE_URL; ?>">Homepage</a>
			</div>
		</div>
	<?php
	}

	function updateUserStatus(){

		global $connection;

		$user_id = MRES($_GET['user']);

		$sql = "UPDATE users SET status = 'active' WHERE user_id = $user_id";

		$query = mysqli_query($connection, $sql);

		if($query){

			accountVerifiedMessage();

		}

		else{

			echo "Unable to update the status of your account. Please contant the admin.";

		}

	}

};

?>



	



	
	
</body>
</html>