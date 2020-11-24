<?php

function top_header_social(){
	global $connection;

	$sql = "SELECT * from settings WHERE type = 'top_social'";

	$query = mysqli_query($connection, $sql);

	while($data = mysqli_fetch_assoc($query)){

		if($data['value'] != ""){
			$name = $data['name'];
			$value = $data['value'];
			socialOptions($name, $value);
		}

	}
}

function socialOptions($name, $value){
	switch ($name) {
		case 'instagram':
			echo '<a href="' . $value . '" id="instagram_logo" title="' . ucwords($name) . '"><i class="fab fa-instagram"></i></a>';
			break;

		case 'facebook':
			echo '<a href="' . $value . '" id="facebook_logo" title="' . ucwords($name) . '"><i class="fab fab fa-facebook-f"></i></a>';
			break;

		case 'email':
			echo '<a href="' . $value . '" id="email_logo" title="' . ucwords($name) . '"><i class="far fa-envelope"></i></a>';
			break;

		case 'twitter':
			echo '<a href="' . $value . '" id="twitter_logo" title="' . ucwords($name) . '"><i class="fab fab fa-twitter"></i></a>';
			break;

		case 'youtube':
			echo '<a href="' . $value . '" id="youtube_logo" title="' . ucwords($name) . '"><i class="fab fab fa-youtube"></i></a>';
			break;

		case 'whatsapp':
			echo '<a href="' . $value . '" id="whatsapp_logo" title="' . ucwords($name) . '"><i class="fab fab fa-whatsapp"></i></a>';
			break;
	}
}
?>