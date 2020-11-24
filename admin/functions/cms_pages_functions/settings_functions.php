<?php

function settingsPageGetData($name){

	global $connection;

	$sql = "SELECT * from settings WHERE name = '$name'";

	$query = mysqli_query($connection, $sql);

	if($query){

		$result = mysqli_fetch_assoc($query);

		$data = $result['value'];

		return $data;

	}

	else{

		return "Invalid Data";

	}

}



function settingsSiteSEO($name){

	global $connection;

	$sql = "SELECT * from settings WHERE name = '$name'";

	$query = mysqli_query($connection, $sql);

	if($query){

		$result = mysqli_fetch_assoc($query);

		$data = $result['value'];

		return $data;

	}

	else{

		return "Error";

	}

}



function seoStatus($data){

	if($data == 'seo_enable'){

		$status = strtolower(settingsSiteSEO('site_seo'));

			if($status == 'enable'){

				return 'checked';

			}

	}
	if($data == 'seo_disable'){

		$status = strtolower(settingsSiteSEO('site_seo'));

			if($status == 'disable'){

				return 'checked';

			}

	}

	if($data == 'seo_index'){

		$status = strtolower(settingsSiteSEO('robots_index'));

		if($status == 'index'){

			return 'checked';

		}
		
	}

	if($data == 'seo_noindex'){

		$status = strtolower(settingsSiteSEO('robots_index'));

		if($status == 'noindex'){

			return 'checked';

		}
		
	}

	if($data == 'seo_follow'){

		$status = strtolower(settingsSiteSEO('robots_follow'));

		if($status == 'follow'){

			return 'checked';

		}
		
	}

	if($data == 'seo_nofollow'){

		$status = strtolower(settingsSiteSEO('robots_follow'));

		if($status == 'nofollow'){

			return 'checked';

		}
		
	}

	if($data == 'seo_revisit_1d'){

		$status = settingsSiteSEO('revisit_after');

		if($status == '1 day'){

			return 'selected';

		}
		
	}

	if($data == 'seo_revisit_3d'){

		$status = settingsSiteSEO('revisit_after');

		if($status == '3 days'){

			return 'selected';

		}
		
	}

	if($data == 'seo_revisit_7d'){

		$status = settingsSiteSEO('revisit_after');

		if($status == '7 days'){

			return 'selected';

		}
		
	}

	if($data == 'site_cache_cache'){

		$status = strtolower(settingsSiteSEO('cache'));

		if($status == 'cache'){

			return 'checked';

		}

	}

	if($data == 'site_cache_nocache'){

		$status = strtolower(settingsSiteSEO('cache'));

		if($status == 'no-cache'){

			return 'checked';

		}

	}

	if($data == 'seo_post_indexing_enable'){

		$status = strtolower(settingsSiteSEO('post_indexing'));

		if($status == 'index'){

			return 'checked';

		}
		
	}

	if($data == 'seo_post_indexing_disable'){

		$status = strtolower(settingsSiteSEO('post_indexing'));

		if($status == 'noindex'){

			return 'checked';

		}
		
	}

	if($data == 'post_follow_enable'){

		$status = strtolower(settingsSiteSEO('post_links_follow'));

		if($status == 'follow'){

			return 'checked';

		}

	}

	if($data == 'post_follow_disable'){

		$status = strtolower(settingsSiteSEO('post_links_follow'));

		if($status == 'nofollow'){

			return 'checked';

		}

	}

	if($data == 'tags_index_enable'){

		$status = strtolower(settingsSiteSEO('tags_page_index'));

		if($status == 'index'){

			return 'checked';

		}

	}

	if($data == 'tags_index_disable'){

		$status = strtolower(settingsSiteSEO('tags_page_index'));

		if($status == 'noindex'){

			return 'checked';

		}

	}

	if($data == 'author_index_enable'){

		$status = strtolower(settingsSiteSEO('author_page_index'));

		if($status == 'index'){

			return 'checked';

		}

	}

	if($data == 'author_index_disable'){

		$status = strtolower(settingsSiteSEO('author_page_index'));

		if($status == 'noindex'){

			return 'checked';

		}

	}

}


function saveSettings(){

	global $connection;

	$site_domain             =    MRES($_POST['site_domain']);

	$site_name               =    MRES($_POST['site_name']);

	$site_description        =    MRES($_POST['site_description']);

	$site_author             =    MRES($_POST['site_author']);

	$seo_page_option         =    MRES($_POST['seo_page_option']);

	$seo_page_index          =    MRES($_POST['seo_page_index']);

	$seo_page_follow         =    MRES($_POST['seo_page_follow']);

	$site_subject            =    MRES($_POST['site_subject']);

	$site_keywords           =    MRES($_POST['site_keywords']);

	$site_revisit_after      =    MRES($_POST['site_revisit_select']);

	$site_cache              =    MRES($_POST['seo_cache']);

	$seo_post_index_option   =    MRES($_POST['seo_post_index_option']);

	$seo_post_follow         =    MRES($_POST['seo_post_follow']);

	$seo_tags_index        =    MRES($_POST['seo_tags_index']);

	$seo_author_index        =    MRES($_POST['seo_author_index']);

	$query_string_array = array(
		"UPDATE settings SET value = '$site_domain' WHERE name = 'site_url'",
		"UPDATE settings SET value = '$site_name' WHERE name = 'site_title'",
		"UPDATE settings SET value = '$site_description' WHERE name = 'site_description'",
		"UPDATE settings SET value = '$site_author' WHERE name = 'site_author'",
		"UPDATE settings SET value = '$seo_page_option' WHERE name = 'site_seo'",
		"UPDATE settings SET value = '$seo_page_index' WHERE name = 'robots_index'",
		"UPDATE settings SET value = '$seo_page_follow' WHERE name = 'robots_follow'",
		"UPDATE settings SET value = '$site_subject' WHERE name = 'site_subject'",
		"UPDATE settings SET value = '$site_keywords' WHERE name = 'site_keywords'",
		"UPDATE settings SET value = '$site_revisit_after' WHERE name = 'revisit_after'",
		"UPDATE settings SET value = '$site_cache' WHERE name = 'cache'",
		"UPDATE settings SET value = '$seo_post_index_option' WHERE name = 'post_indexing'",
		"UPDATE settings SET value = '$seo_post_follow' WHERE name = 'post_links_follow'",
		"UPDATE settings SET value = '$seo_tags_index' WHERE name = 'tags_page_index'",
		"UPDATE settings SET value = '$seo_author_index' WHERE name = 'author_page_index'"
	);

	foreach ($query_string_array as $key => $query_string) {

		$flag = true;
		
		$query = mysqli_query($connection, $query_string);

		if(!$query){

			$flag = false;

			showErrorWindow('Error', 'Unable To Execute The Query On The Database');

			break;

		}

	}

	if($flag == true){

		if(isset($_FILES['site_logo']['name']) and !empty($_FILES['site_logo']['name'])){

			$image = $_FILES['site_logo']['name'];

			$image_temp = $_FILES['site_logo']['tmp_name'];

			$status = move_uploaded_file($image_temp, SITE_DIR . 'images/site_images/' . $image);

			$sql = "UPDATE settings SET value = '$image' WHERE name = 'site_logo'";

			$query = mysqli_query($connection, $sql);

			if(!$query){

				$flag = false;

			}

			if(!$status){

				$flag = false;

			}
		}

		if($flag == true){

			showSuccessWindow('Done', "Data Successfully Updated.");

		}

		elseif($flag == true){

			showErrorWindow('Done', "Data Successfully Updated.");

		}
	}

}


?>