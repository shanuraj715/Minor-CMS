<?php

function pageLoaderAnimDisplay(){ ?>
	<div id="page_loader">
		<img src="<?php echo SITE_URL . 'admin/images/loader.gif'; ?>">
	</div>
	<style type="text/css">
		#page_loader img{
			position: absolute;
			top: 50%;
			left: 50%;
			width: 70%;
			transform: translate(-50%, -50%);
		}
	</style>
	<?php
}

function dateTo_dd_MM_YYYY($date){
	$date = explode('-', $date);
	// $date = strtotime($date);

	$month = $date[1];
	$month = month_num_to_short_name($month);
	$c_date = $date[2];
	$year = $date[0];
	echo $c_date . '-' . $month . '-' . $year;
}

function MRES($data){

	global $connection;

	$data = mysqli_real_escape_string($connection, $data);

	return $data;

}

function validateLogged(){

	if(isset($_SESSION['role']) and !empty($_SESSION['role'])){

		if(isset($_SESSION['userid']) and !empty($_SESSION['userid'])){

			if(isset($_SESSION['username']) and !empty($_SESSION['username'])){

				if(isset($_SESSION['fname']) and !empty($_SESSION['fname'])){

					if(isset($_SESSION['lname']) and !empty($_SESSION['lname'])){

						if(isset($_SESSION['email']) and !empty($_SESSION['email'])){

							if(isset($_SESSION['login_key']) and !empty($_SESSION['login_key'])){

								if($_SESSION['login_key'] == LOGIN_KEY){

									$this_page = $_SERVER['SCRIPT_FILENAME'];

									$this_page = explode('/', $this_page);

									$this_page = $this_page[count($this_page) - 1];

									if($this_page != 'dashboard.php'){

										header('Location: ' . SITE_URL . 'admin/dashboard.php');

									}
								}
								else{
									redirectToLogin();
								}
							}
							else{
								redirectToLogin();
							}
						}
						else{
							redirectToLogin();
						}
					}
					else{
						redirectToLogin();
					}
				}
				else{
					redirectToLogin();
				}
			}
			else{
				redirectToLogin();
			}
		}
		else{
			redirectToLogin();
		}
	}
	else{
		redirectToLogin();
	}
}

function redirectToLogin(){

	$this_page = $_SERVER['SCRIPT_FILENAME'];

	$this_page = explode('/', $this_page);

	$this_page = $file_name[count($this_page) - 1];

	if($this_page != 'login.php'){

		session_destroy();

		header('Location: ' . SITE_URL . 'admin/login.php');

	}

}

function includePage(){

	if(isset($_GET['page']) and !empty($_GET['page'])){

		$location = str_replace('/functions', '', str_replace('\\', '/', __DIR__));

		$file = '/included_files/' . $_GET['page'] . '.php';

		$file_loc = $location . $file;

		if(file_exists($file_loc)){

			include $file_loc;

		}

		else{

			admin404(); // called from this page

		}

	}
	else{

		if($_SESSION['role'] == 'admin'){

			include './included_files/main-page.php';

		}

		elseif($_SESSION['role'] == 'author'){

			header('Location: ' . SITE_URL . 'admin/dashboard.php?page=view-posts');

			exit();

		}

		elseif($_SESSION['role'] == 'subscriber'){

			header('Location: ' . SITE_URL . 'admin/dashboard.php?page=users');

			exit();

		}

		else{
			admin404();
		}

	}

}

function admin404(){
	include DASHBOARD_PAGE_ADDR . 'included_files/404.php';
}













function encryptPassword($password){
	$hashFormat = "$2y$10$";
	$salt = "iamagoodcoderofphp7151";
	$hash_and_salt = $hashFormat . $salt;
	$Encrypted_password = crypt($hash_and_salt, $password);
	return $Encrypted_password;
}



function showErrorWindow($subject, $message){ ?>
	<style type="text/css">
		.show_error_popup_1x1s{
			z-index: 50;
			position: absolute;
			min-height: 230px;
			max-height: 230px;
			min-width: 450px;
			max-width: 450px;
			left: 50%;
			top: 50%;
			background-color: #c8d6e5;
			transform: translate(-50%, -50%);
			border-radius: 6px;
			border: solid 2px #2980b9;
		}

		.show_error_popup_2x2s{
			display: flex;
			padding: 10px 0;
			background-color: #c0392b;
		}

		.show_error_popup_3x3s{
			flex-grow: 2;
			padding: 0 8px;
			color: white;
		}

		#show_error_popup_4x4s{
			padding: 0 10px;
			transform: scale(1.5);
			color: #2c3e50;
		}

		.show_error_popup_5x5s{
			padding: 10px;
		}

		#show_error_popup_6x6s{
			color: #2c3e50;
		}
	</style>

	<div class="show_error_popup_1x1s" id="show_error_popup_1x1s">
		<div class="show_error_popup_2x2s" id="show_error_popup_2x2s">
			<span class="show_error_popup_3x3s" id="show_error_popup_3x3s"><?php echo $subject; ?></span>
			<i class="fas fa-times" id="show_error_popup_4x4s" onclick="hideErrorWindow();"></i>
		</div>
		<div class="show_error_popup_5x5s" id="show_error_popup_5x5s">
			<span id="show_error_popup_6x6s"><?php echo $message; ?></span>
		</div>
	</div>
	<script type="text/javascript">
		function hideErrorWindow(){
			document.getElementById('show_error_popup_1x1s').style.display = 'none';
		}
	</script>

<?php
}

function showSuccessWindow($subject, $message){ ?>
	<style type="text/css">
		.show_successs_popup_1x1s{
			z-index: 50;
			position: absolute;
			min-height: 230px;
			max-height: 230px;
			min-width: 450px;
			max-width: 450px;
			left: 50%;
			top: 50%;
			background-color: #c8d6e5;
			transform: translate(-50%, -50%);
			border-radius: 6px;
			border: solid 2px #2980b9;
		}

		.show_successs_popup_2x2s{
			display: flex;
			padding: 10px 0;
			background-color: #27ae60;
		}

		.show_successs_popup_3x3s{
			flex-grow: 2;
			padding: 0 8px;
			color: white;
		}

		#show_successs_popup_4x4s{
			padding: 0 10px;
			transform: scale(1.5);
			color: #2c3e50;
		}

		.show_successs_popup_5x5s{
			padding: 10px;
		}

		#show_successs_popup_6x6s{
			color: #2c3e50;
		}
	</style>

	<div class="show_successs_popup_1x1s" id="show_successs_popup_1x1s">
		<div class="show_successs_popup_2x2s" id="show_successs_popup_2x2s">
			<span class="show_successs_popup_3x3s" id="show_successs_popup_3x3s"><?php echo $subject; ?></span>
			<i class="fas fa-times" id="show_successs_popup_4x4s" onclick="hideSuccessWindow();"></i>
		</div>
		<div class="show_successs_popup_5x5s" id="show_successs_popup_5x5s">
			<span id="show_successs_popup_6x6s"><?php echo $message; ?></span>
		</div>
	</div>
	<script type="text/javascript">
		function hideSuccessWindow(){
			document.getElementById('show_successs_popup_1x1s').style.display = 'none';
		}
	</script>

<?php
}

function notAvailableAtThisTime(){ ?>
	<div id="notfound">
		<style type="text/css">
			#notfound {
			  position: relative;
			  height: 600px;
			  max-height: 100vh;
			  background: white;
			}

			#notfound .notfound {
			  position: absolute;
			  left: 50%;
			  top: 50%;
			  -webkit-transform: translate(-50%, -50%);
			      -ms-transform: translate(-50%, -50%);
			          transform: translate(-50%, -50%);
			}

			.notfound {
			  max-width: 460px;
			  width: 100%;
			  text-align: center;
			  line-height: 1.4;
			}

			.notfound .notfound-404 {
			  position: relative;
			  width: 180px;
			  height: 180px;
			  margin: 0px auto 50px;
			}

			.notfound .notfound-404>div:first-child {
			  position: absolute;
			  left: 0;
			  right: 0;
			  top: 0;
			  bottom: 0;
			  background: rgba(52, 152, 219,1.0);
			  -webkit-transform: rotate(45deg);
			      -ms-transform: rotate(45deg);
			          transform: rotate(45deg);
			  border: 5px dashed #000;
			  border-radius: 5px;
			}

			.notfound .notfound-404>div:first-child:before {
			  content: '';
			  position: absolute;
			  left: -5px;
			  right: -5px;
			  bottom: -5px;
			  top: -5px;
			  -webkit-box-shadow: 0px 0px 0px 5px rgba(0, 0, 0, 0.1) inset;
			          box-shadow: 0px 0px 0px 5px rgba(0, 0, 0, 0.1) inset;
			  border-radius: 5px;
			}

			.notfound .notfound-404 h1 {
			  font-family: 'Cabin', sans-serif;
			  color: #000;
			  font-weight: 700;
			  margin: 0;
			  font-size: 90px;
			  position: absolute;
			  top: 50%;
			  -webkit-transform: translate(-50%, -50%);
			      -ms-transform: translate(-50%, -50%);
			          transform: translate(-50%, -50%);
			  left: 50%;
			  text-align: center;
			  height: 40px;
			  line-height: 40px;
			}

			.notfound h2 {
			  font-family: 'Cabin', sans-serif;
			  font-size: 33px;
			  font-weight: 700;
			  text-transform: uppercase;
			  letter-spacing: 7px;
			}

			.notfound p {
			  font-family: 'Cabin', sans-serif;
			  font-size: 16px;
			  color: #000;
			  font-weight: 400;
			}

			.notfound a {
			  font-family: 'Cabin', sans-serif;
			  display: inline-block;
			  padding: 10px 25px;
			  background-color: #8f8f8f;
			  border: none;
			  border-radius: 40px;
			  color: #fff;
			  font-size: 14px;
			  font-weight: 700;
			  text-transform: uppercase;
			  text-decoration: none;
			  -webkit-transition: 0.2s all;
			  transition: 0.2s all;
			}

			.notfound a:hover {
			  background-color: #2c2c2c;
			}
		</style>
		<div class="notfound">
			<div class="notfound-404">
				<div></div>
				<h1>X</h1>
			</div>
			<h2>Not Available</h2>
			<p>This Feature Is Currently Not Available Or It Is Disabled By The Administrator. We Will Include This Feature Soon. Thanks...</p>
			<a href="<?php echo SITE_URL; ?>admin/dashboard.php">Dashboard Home</a>
		</div>
	</div>
	<?php
}


?>