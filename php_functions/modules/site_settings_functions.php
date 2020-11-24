<?php

function getSiteMetaSettings($seo_data){
	global $connection;
	$sql = "SELECT * from ";
	$sql .= "settings WHERE ";
	switch($seo_data){
		case 'robots_index': 
			if(isset($_GET['category']) and !empty($_GET['category'])){

				$category = $_GET['category'];

				$sql = "SELECT * from categories WHERE category_title = '$category'";

				$query = mysqli_query($connection, $sql);
				$meta_result = mysqli_fetch_assoc($query);
				echo $meta_result['index_pages'];
			}
			elseif(isset($_GET['tag'])){
				$sql .= "name = 'tags_page_index'";
				$query = mysqli_query($connection, $sql);
				$meta_result = mysqli_fetch_assoc($query);
				echo $meta_result['value'];
			}
			elseif(isset($_GET['author'])){
				$sql .= "name = 'author_page_index'";
				$query = mysqli_query($connection, $sql);
				$meta_result = mysqli_fetch_assoc($query);
				echo $meta_result['value'];
			}
			else{
				$sql2 = "SELECT * FROM settings WHERE name = 'site_seo'";
				$query2 = mysqli_query($connection, $sql2);
				$result2 = mysqli_fetch_assoc($query2);
				if($result2['value'] != 'enable'){
					echo 'noindex';
				}
				else{
					$sql .= "name = 'robots_index'";
					$query = mysqli_query($connection, $sql);
					$meta_result = mysqli_fetch_assoc($query);
					echo $meta_result['value'];
				}
			}
			break;
			
		case 'robots_follow': 
			$sql2 = "SELECT * FROM settings WHERE name = 'site_seo'";
				$query2 = mysqli_query($connection, $sql2);
				$result2 = mysqli_fetch_assoc($query2);
				if($result2['value'] != 'enable'){
					echo 'nofollow';
				}
				else{
					$sql .= "name = 'robots_follow'";
					$query = mysqli_query($connection, $sql);
					$meta_result = mysqli_fetch_assoc($query);
					echo $meta_result['value'];
				}
			break;
			
		case 'site_title': 
			if(isset($_GET['category']) and !empty($_GET['category'])){

				$category = $_GET['category'];

				$sql = "SELECT * from categories WHERE category_title = '$category'";

				$query = mysqli_query($connection, $sql);
				$meta_result = mysqli_fetch_assoc($query);
				echo ucfirst($meta_result['category_title']) . " - " . SITE_TITLE;
			}
			elseif(isset($_GET['tag'])){
				$tag = $_GET['tag'];

				echo ucfirst($tag) . ' | Tag - ' . SITE_TITLE;
			}
			elseif(isset($_GET['author'])){
				$author = $_GET['author'];

				echo ucfirst($author) . ' | Author - ' . SITE_TITLE;
			}
			elseif(isset($_GET['s'])){
				$search = $_GET['s'];

				echo $search .' - ' . SITE_TITLE;
			}
			else{
				$sql .= "name = 'site_title'";
				$query = mysqli_query($connection, $sql);
				$meta_result = mysqli_fetch_assoc($query);
				echo $meta_result['value'];
			}
			break;
			
		case 'subject': 
			$sql .= "name = 'site_subject'";
			$query = mysqli_query($connection, $sql);
			$meta_result = mysqli_fetch_assoc($query);
			echo $meta_result['value'];
			break;
			
		case 'description': 
			$sql .= "name = 'site_description'";
			$query = mysqli_query($connection, $sql);
			$meta_result = mysqli_fetch_assoc($query);
			echo $meta_result['value'];
			break;
			
		case 'author': 
			$sql .= "name = 'site_author'";
			$query = mysqli_query($connection, $sql);
			$meta_result = mysqli_fetch_assoc($query);
			echo $meta_result['value'];
			break;
			
		case 'keywords': 
			$sql .= "name = 'site_keywords'";
			$query = mysqli_query($connection, $sql);
			$meta_result = mysqli_fetch_assoc($query);
			echo $meta_result['value'];
			break;
			
		case 'revised': 
			$sql .= "name = 'site_revised'";
			$query = mysqli_query($connection, $sql);
			$meta_result = mysqli_fetch_assoc($query);
			echo $meta_result['value'];
			break;
			
		case 'revisit-after': 
			$sql .= "name = 'revisit_after'";
			$query = mysqli_query($connection, $sql);
			$meta_result = mysqli_fetch_assoc($query);
			echo $meta_result['value'];
			break;
			
		case 'cache': 
			$sql .= "name = 'cache'";
			$query = mysqli_query($connection, $sql);
			$meta_result = mysqli_fetch_assoc($query);
			echo $meta_result['value'];
			break;
	}
}



?>