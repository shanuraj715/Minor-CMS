<?php
include "./includes/header.php";
$uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' );
$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
$uri = urldecode( $uri );
$uri_params = explode('/', $uri);
global $connection;
if($uri_params['1'] != 'profile'){
	exit();
}

if(count($uri_params) > 1){
	$username = $uri_params['2'];

	$username = urlencode($username);

	$username = MRES($username);

	$sql = "SELECT * FROM users WHERE username = '$username'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	$user_id = $result['user_id'];

	$user_profile_result = userProfileSettings($user_id);

}

function userProfileSettings($user_id){

	global $connection;

	settype($user_id, 'integer');

	$sql = "SELECT * FROM `user_profile` WHERE user_id = $user_id";

	$query = mysqli_query($connection, $sql);

	$user_profile_result = mysqli_fetch_assoc($query);

	return $user_profile_result;

}

$keywords = "";
$keywords .= $result['username'];
$keywords .= ", " . $result['fname'];
$keywords .= ", " . $result['fname'] . ' ' . $result['lname'];
$keywords .= ", " . $result['fname'] . ' ' . SITE_TITLE;
$keywords .= ", " . $result['fname'] . ' ' . $result['lname'] . ' ' . SITE_TITLE;
$keywords .= ", " . SITE_TITLE . ' ' . $result['fname'];
$keywords .= ", " . SITE_TITLE . ' ' . $result['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo ucfirst($result['username']) . ' | ' . SITE_TITLE; ?></title>
	<meta charset="UTF-8">
	<meta name="robots" content="<?php echo $user_profile_result['page_index']; ?>, follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Meta -->
	<meta name="description" content="<?php echo $user_profile_result['description']; ?>"/>

	<meta name="author" content="<?php echo $result['username']; ?>">

	<meta name="keywords" content="<?php echo $keywords; ?>">

	<meta name="revisit-after" content="1 day">

	<meta name="og:title" content="<?php echo ucfirst($result['username']) . ' | ' . SITE_TITLE; ?>"/>

	<meta name="og:url" content="<?php echo SITE_URL . 'profile/' . $result['username'];?>"/>

	<meta name="og:image" content="<?php echo SITE_URL . 'images/users/' . $result['image'];?>"/>

	<meta name="og:site_name" content="<?php echo ucfirst($result['username']) . ' | ' . SITE_TITLE; ?>"/>

	<meta name="og:description" content="<?php echo $user_profile_result['description']; ?>"/>


	<meta http-equiv="Pragma" content="<?php getSiteMetaSettings('cache'); ?>">
	<meta http-equiv="Cache-Control" content="<?php getSiteMetaSettings('cache'); ?>">
	<!-- Linking -->
	<?php cms_head_linking(); //From functios.php for all <link> tags ?>
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/userprofile.css">
</head>
<body>

	<div class="profile_page_container">
		<div class="profile_p_user_block">
			<div class="profile_p_left_block">
				<img class="profile_user_image" src="<?php echo SITE_URL . 'images/users/' . $result['image'];?>">
			</div>
			<div class="profile_p_right_block">
				<p class="name_text"><?php echo $result['fname'] . ' ' . $result['lname'];?></p>
				<p class="username_text"><span>Username : </span><?php echo $result['username']; ?></p>
				<p class="age_text"><span>Age : </span><?php echo userAge($result['dob']); ?> Years</p>
			</div>
			<div class="social_sharing_block">
				<?php userActiveSocialBtns($user_profile_result); ?>
				<div class="user_description_block">
					<p class="user_description"><?php echo $user_profile_result['description']; ?></p>
				</div>
			</div>
		</div>

		<div class="user_01">
			<div class="user_p_language_block">
				<div class="user_lang_block">
					<p class="skills_title">Skills</p>
					<?php userSkills($user_profile_result['skills']); ?>
				</div>
			</div>
			<div class="user_contri_block">
				<div class="total_posts_box">
					<i class="fas fa-pen-square"></i>
					<div class="total_post_block">
						<p class="t_p_text">Total Posts</p>
						<p class="t_p_count">52</p>
					</div>
				</div>
			</div>
		</div>

		<div class="user_post_stats_container">
			<div class="user_post_stat_box">
				
			</div>
		</div>
	</div>
	
</body>
<?php pluginList(); // function is available in php_functions/handlers/plugins.php ?>
</html>

<?php




function userSkills($skills){

	$skills = strtolower($skills);

	$skills = str_replace(', ', ',', $skills);

	$skills = explode(',', $skills);

	foreach ($skills as $key => $value) {
		switch ($value) {
			case 'android development':
				echo '<div class="user_languages_list_block"><i class="fab fa-android"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'android':
				echo '<div class="user_languages_list_block"><i class="fab fa-android"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'ios':
				echo '<div class="user_languages_list_block"><i class="fab fa-apple"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'java':
				echo '<div class="user_languages_list_block"><i class="fab fa-java"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'javascript':
				echo '<div class="user_languages_list_block"><i class="fab fa-js-square"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'node':
				echo '<div class="user_languages_list_block"><i class="fab fa-node-js"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'node-js':
				echo '<div class="user_languages_list_block"><i class="fab fa-node-js"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'angular':
				echo '<div class="user_languages_list_block"><i class="fab fa-angular"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'angular-js':
				echo '<div class="user_languages_list_block"><i class="fab fa-angular"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'sql':
				echo '<div class="user_languages_list_block"><i class="fas fa-database"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'mysql':
				echo '<div class="user_languages_list_block"><i class="fas fa-database"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'php':
				echo '<div class="user_languages_list_block"><i class="fab fa-php"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'python':
				echo '<div class="user_languages_list_block"><i class="fab fa-python"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'html':
				echo '<div class="user_languages_list_block"><i class="fab fa-html5"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'css':
				echo '<div class="user_languages_list_block"><i class="fab fa-css3-alt"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'html5':
				echo '<div class="user_languages_list_block"><i class="fab fa-html5"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'css3':
				echo '<div class="user_languages_list_block"><i class="fab fa-css3-alt"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'react':
				echo '<div class="user_languages_list_block"><i class="fab fa-react"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;
				
			case 'react-js':
				echo '<div class="user_languages_list_block"><i class="fab fa-react"></i><span class="user_lang_text">' . ucwords($value) . '</div>';
				break;

			default :

				break;

		}
	}

 ?>
<!-- 









 -->
<?php
}



function userActiveSocialBtns($user_profile_result){

	$instagram = $user_profile_result['instagram_url'];

	$facebook = $user_profile_result['facebook_url'];

	$youtube = $user_profile_result['youtube_url'];

	$git = $user_profile_result['git_url'];

	$googleplus = $user_profile_result['googleplus_url'];

	$linkedin = $user_profile_result['linkedin_url']; 

	$twitter = $user_profile_result['twitter_url'];

	if($instagram != NULL){ ?>
		<a class="social_sharing_link profile_instagram_icon" href="<?php echo $user_profile_result['instagram_url']; ?>" target="_blank">
			<i class="fab fa-instagram"></i>
		</a>
		<?php
	}
	if($twitter != NULL){ ?>
		<a class="social_sharing_link profile_twitter_icon" href="<?php echo $user_profile_result['twitter_url']; ?>" target="_blank">
			<i class="fab fa-twitter"></i>
		</a>
		<?php
	}
	if($git != NULL){ ?>
		<a class="social_sharing_link profile_git_icon" href="<?php echo $user_profile_result['git_url']; ?>" target="_blank">
			<i class="fab fa-git"></i>
		</a>
		<?php
	}
	if($facebook != NULL){ ?>
		<a class="social_sharing_link profile_facebook_icon" href="<?php echo $user_profile_result['facebook_url']; ?>" target="_blank">
			<i class="fab fa-facebook-f"></i>
		</a>
		<?php
	}
	if($googleplus != NULL){ ?>
		<a class="social_sharing_link profile_googleplus_icon" href="<?php echo $user_profile_result['googleplus_url']; ?>" target="_blank">
			<i class="fab fa-google-plus-g"></i>
		</a>
		<?php
	}
	if($linkedin != NULL){ ?>
		<a class="social_sharing_link profile_linkedin_icon" href="<?php echo $user_profile_result['linkedin_url']; ?>" target="_blank">
			<i class="fab fa-linkedin-in"></i>
		</a>
		<?php
	}
	if($youtube != NULL){ ?>
		<a class="social_sharing_link profile_youtube_icon" href="<?php echo $user_profile_result['youtube_url']; ?>" target="_blank">
			<i class="fab fa-youtube"></i>
		</a>
		<?php
	}

}

?>