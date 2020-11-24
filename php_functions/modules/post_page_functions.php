<?php

function postData($p_id){

	global $connection;

	$sql = "SELECT * FROM posts Where post_id = $p_id and post_status = 'published'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	return $result;

}

function seoData($p_id){

	global $connection;

	$sql = "SELECT content_seo.description, content_seo.enable_seo, content_seo.p_index, content_seo.follow, content_seo.keywords, content_seo.author, content_seo.subject, content_seo.revisit_after, content_seo.enable_cache, posts.post_title, posts.post_author, posts.post_tags, posts.post_date, posts.post_image from content_seo INNER JOIN posts ON content_seo.content_id = posts.post_id WHERE content_id = $p_id";

	$query = mysqli_query($connection, $sql);

		$rows = mysqli_num_rows($query);
		if($rows > 0){
			$seo_res = mysqli_fetch_assoc($query);
			return $seo_res;
		}
		else{

			settype($p_id, 'integer');
			$sql = "INSERT INTO `content_seo`(`content_id`, `enable_seo`, `keywords`, `author`, `subject`, `revisit_after`, `enable_cache`) VALUES ($p_id, 1, '', '', '', '', 1)";

			$query = mysqli_query($connection, $sql);

			if($query){

				header("refresh: 0");
				exit();

			}

			else{

				// header("Location: http://" . $p_id . ".com");

			}
		}

}

function authorData($post_author){

	global $connection;

	$sql = "SELECT * FROM users WHERE username = '$post_author'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	return $result;

}

function categoryName($cat_id){

	global $connection;

	$sql = "SELECT * FROM categories WHERE category_id = $cat_id";

	$query = mysqli_query($connection, $sql);

	if($query){

	$result = mysqli_fetch_assoc($query);

	}
	else{
		// header("Location: " . SITE_URL);

		error404();

		exit();
	}

	$cat_name = $result['category_title'];

	return $cat_name;

}

function postAuthor($username){

	global $connection;

	$sql = "SELECT fname, lname, username from users WHERE username = '$username'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	$name = $result['fname'] . ' ' . $result['lname'];

	return $name;

}

function postCountPerUser($username){

	global $connection;

	$sql = "SELECT count(post_id) as total_post from posts WHERE post_author = '$username'";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	$total_posts = $result['total_post'];

	return $total_posts;

}

?>