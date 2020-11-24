<?php

function printPostList(){

	global $connection;

	$sql = "SELECT * FROM posts ";
	$sql .= "WHERE post_status = 'published' ";

	if(isset($_GET['s'])){ // works when any search query is fired
		if(empty($_GET['s'])){
			header('Location: ' . SITE_URL);
			exit();
		}
		$search = $_GET['s'];
		$search = MRES($search); // MRES mysqli_real_escape_string

		$sql .= "and (post_tags LIKE '%$search%' or post_title LIKE '%$search%') ";
	}
	else{
		if(isset($_GET['category']) and !empty($_GET['category'])){

			$category = $_GET['category'];
			$category = MRES($category);

			$cat_sql = "SELECT * FROM categories WHERE category_title = '$category'";

			$cat_query = mysqli_query($connection, $cat_sql);

			$cat_result = mysqli_fetch_assoc($cat_query);

			$cat_count = mysqli_num_rows($cat_query);

			if($cat_count!=0){

				$cat_id = $cat_result['category_id'];

				$banner_text = 'Sorted By Category ' . $cat_result['category_title'];

				showPageBanner($banner_text);

				$sql .= "and (category_id = $cat_id) ";

			}

			else{

				$cat_id = $cat_result['category_id'];

				$sql .= "and (category_id = 0) ";
			}
		}

		elseif(isset($_GET['author']) and !empty($_GET['author'])){
			
			$author = MRES($_GET['author']);

			$banner_text = 'Sorted By Author ' . $author;

			showPageBanner($banner_text);

			$sql .= "and (post_author = '$author') ";
		}

		elseif(isset($_GET['tag']) and !empty($_GET['tag'])){
			
			$tag = MRES($_GET['tag']);

			$banner_text = 'Sorted By Tag ' . $tag;

			showPageBanner($banner_text);

			$sql .= "and (post_tags LIKE '%$tag%') ";
		}

		elseif(isset($_GET['show-by-date']) and !empty($_GET['show-by-date'])){
			
			if($_GET['show-by-date'] == 'true' and isset($_GET['month']) and isset($_GET['year']) and !empty($_GET['month']) and !empty($_GET['year'])){

				$month = MRES($_GET['month']);

				$year = MRES($_GET['year']);

				$month = strtolower($month);

				$month_int = false;

				$month_array = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];

				foreach ($month_array as $key => $value) {
					if($month == $value){
						$month_int = $key + 1;
					}
				}
				
				if($month_int == false){
					header('Location: ' . SITE_URL);
				}

				if($month_int < 10){
					$month_int = '0' . $month_int;
				}

				$date = '01';

				$from_date = $year . '-' . $month_int . '-' . $date;

				$to_date = $year . '-' . $month_int . '-' . '31';

				$banner_text = 'Showing Posts Of Month ' . ucfirst($month) . '-' . $year;

				showPageBanner($banner_text);

				$sql .= "and post_date >= '$from_date' and post_date <= '$to_date'";
			}

			elseif($_GET['show-by-date'] == 'true' and isset($_GET['date']) and !empty($_GET['date'])){ 
				// for a particular date (2018-09-09 or 2019-01-02 etc...)
				$date = MRES($_GET['date']);

				$sql .= "and post_date = '$date'";

				$banner_text = 'Showing Posts Of Date ' . $date;

				showPageBanner($banner_text);

			}

			elseif($_GET['show-by-date'] == 'true' and isset($_GET['year']) and !empty($_GET['year'])){

				$year = MRES($_GET['year']);

				if($year < 2000 or $year > 3000){
					header('Location: ' . SITE_URL);
				}

				$from_date = $year . '-01-01';

				$to_date = $year . '-12-31';

				$banner_text = "Showing Posts Of Year " . $year;

				showPageBanner($banner_text);

				$sql .= "and post_date >= '$from_date' and post_date <= '$to_date'";
			}

			else{
				// header('Location: ' . SITE_URL);
			}

		}
		
	}

	// $sql .= "ORDER BY post_date DESC";

	$sql .= "ORDER BY last_edit DESC";

	$post_list_query = mysqli_query($connection, $sql);

	$post_num = mysqli_num_rows($post_list_query);

	if($post_num!=0){
		while($post_data = mysqli_fetch_assoc($post_list_query)){ 

			$cat_id = $post_data['category_id'];

			$cat_sql = "SELECT * FROM categories ";

			$cat_sql .= "WHERE category_id = $cat_id";

			$cat_query = mysqli_query($connection, $cat_sql);

			$cat_title = mysqli_fetch_assoc($cat_query);

			$title = $post_data['post_title'];

			$title = str_replace(' ', '-', str_replace('%20', '-', str_replace(' - ', '-', $post_data['post_title']))); ?>
			

			<div class="post_small_block">
				<!-- post image -->
				<div class="post_image_block">
					<a href="post/<?php echo $post_data['post_id']; ?>/<?php echo $title; ?>">
						<img src="<?php echo SITE_URL . 'uploads/' . $post_data['post_image']; ?>">
					</a>
				</div>

				<!-- post details (Title, Meta, Desc) ID 1-->
				<div class="s_post_details_block">
					<div class="s_post_title_nd_meta">
						<a href="post/<?php echo $post_data['post_id']; ?>/<?php echo $title; ?>" class="s_post_title"><?php echo $post_data['post_title']; ?></a>

						<div class="s_post_meta_block">

							<span class="s_post_meta s_meta_author">Author : <a href="<?php echo SITE_URL . '?author=' . $post_data['post_author']; ?>"><?php echo $post_data['post_author']; ?></a></span>
							<br>

							<span class="s_post_meta s_meta_date">Date : <?php echo date('d-m-Y', strtotime($post_data['post_date'])); ?></span>

							<br>
							<span class="s_post_meta s_meta_category">Category : <a href="<?php echo SITE_URL . '?category=' . $cat_title['category_title']; ?>"><?php echo $cat_title['category_title']; ?></a></span>
						</div>

					</div>

					<div class="s_post_desc_block">
						<p class="s_post_desc_text"><?php echo limitCharacters(strip_tags($post_data['post_content']), 350); ?> <a href="post/<?php echo $post_data['post_id']; ?>/<?php echo $title; ?>" class="read_more_t1">Read&nbsp;More...</a></p>
					</div>

				</div> <!-- Closing ID 1 -->

			</div> 
			<?php
		}
	}
	else{
		noDataFound();
	}
}












function limitCharacters($data, $limit){

	if(strlen($data)>$limit){

		$data = substr($data, 0, $limit);

	}

	return $data . '......';

}

function showPageBanner($text){
	if($text != ""){ ?>
	<div class="sort_post_block">
			
		<p class="sort_post_text"><?php echo $text; ?></p>

	</div>
	<?php
	}
}


function noDataFound(){ ?>
	<div class="no_data_found_block" style="text-align: center;">
		<img src="<?php echo SITE_URL;?>images/no_data.png" style="max-width: 500px; min-width: 200px; width: 25%;">
		<h1 class="no_data_title" style="text-align: center;">No Data Found</h1>
		<h3 class="no_data_title" style="text-align: center; color: #666;">Try Something Other</h3>
	</div>
	<?php
}

function error404(){ ?>
	
	<style type="text/css">
		.error404_image{
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 100%;
			overflow: hidden;
			max-height: 100vh;
		}
	</style>

	<div class="error404_block" style="max-height: 100vh; overflow: hidden;">
		
		<img class="error404_image" src="<?php echo SITE_URL;?>images/404.jpg">

	</div>

<?php
}
?>


