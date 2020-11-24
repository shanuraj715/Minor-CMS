<?php

function countPostStatus($status){

	global $connection;

	if($status == 'mine'){

		$me = $_SESSION['username'];

		$sql = "SELECT count(post_id) as total_posts FROM posts WHERE post_author = '$me'";

	}

	elseif($status != "all"){

		$sql = "SELECT count(post_id) as total_posts FROM posts WHERE post_status = '$status'";

	}

	else{

		$sql = "SELECT count(post_id) as total_posts FROM posts";

	}

	$query = mysqli_query($connection, $sql);

	$post_count = mysqli_fetch_assoc($query);

	return $post_count['total_posts'];

}

function postQuery(){

	global $connection;

	if(isset($_GET['filter']) && !empty($_GET['filter'])){

		$filter = strtolower(MRES($_GET['filter']));

		if($filter == 'all'){

			$sql = "SELECT * FROM posts ORDER BY post_date DESC";

		}

		elseif($filter == 'published'){

			$sql = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_date DESC";

		}

		elseif($filter == 'drafted' or $filter == 'draft'){

			$sql = "SELECT * FROM posts WHERE post_status = 'draft' ORDER BY post_date DESC";

		}

		elseif($filter == 'trashed'){

			$sql = "SELECT * FROM posts WHERE post_status = 'trashed' ORDER BY post_date DESC";

		}

		elseif($filter == 'mine'){

			$me = $_SESSION['username'];

			$sql = "SELECT * FROM posts WHERE post_author = '$me' ORDER BY post_date DESC";

		}

	}

	elseif(isset($_GET['search']) and !empty($_GET['search'])){

		$search = MRES($_GET['search']);

		$sql = "SELECT * FROM posts";

		$sql .= " WHERE post_tags LIKE '%$search%'";

		$sql .= " or post_title LIKE '%$search%'";

		$sql .= " or post_author LIKE '%$search%'";

	}

	else{

		$sql = "SELECT * FROM posts ORDER BY post_date DESC";

	}

	$query = mysqli_query($connection, $sql);

	if($query){

		while($result = mysqli_fetch_assoc($query)){

			postList($result);

		}
	}

}

function postList($data){ ?>

	<div class="post_list_items_block">

		<input type="checkbox" id="post_selector" value="<?php echo $data['post_id']; ?>">

		<div class="title_options_container">

			<span class="post_title2 post_list"><?php echo substr($data['post_title'], 0, 80); ?></span>

			<div class="post_options_block">

				<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=edit-post&p_id=' . $data['post_id'];?>" class="post_options_edit_link">Edit</a>

				<?php
				if($data['post_status'] == 'published'){ ?>
					<a href="<?php echo $_SERVER['PHP_SELF'] . '?page=view-posts&atd=trash&pidl=' . $data['post_id']; ?>" class="post_options_trash_link">Trash</a>
					<?php
				}
				else{ ?>
					<a href="<?php echo $_SERVER['PHP_SELF'] . '?page=view-posts&atd=publish&pidl=' . $data['post_id']; ?>" class="post_options_publish_link">Publish</a>
					<?php
				} ?>


				
				<?php
				if($data['post_status'] == 'published'){ ?>
					<a href="<?php echo SITE_URL . 'post/' . $data['post_id']; ?>" target="blank" class="post_options_view_link">View</a>
				<?php
				} ?>

				<a href="<?php echo $_SERVER['PHP_SELF'] . '?page=view-posts&atd=duplicate&pidl=' . $data['post_id']; ?>" class="post_options_duplicate_link">Duplicate</a>

			</div>

		</div>

		<?php

		global $connection;

		$cat_id = $data['category_id'];

		$sql = "SELECT * FROM categories WHERE category_id = $cat_id";

		$query = mysqli_query($connection, $sql);

		$cat_name = mysqli_fetch_assoc($query);

		$cat_name = $cat_name['category_title'];

		?>

		<span class="post_category2 post_list"><?php echo $cat_name; ?></span>

		<span class="post_date2 post_list"><?php echo date('d-m-y', strtotime($data['post_date'])); ?></span>

		<span class="post_tags2 post_list" style="font-size: 14px;"><?php echo $data['post_tags']; ?></span>

		<span class="post_author2 post_list"><?php echo $data['post_author']; ?></span>

		<span class="post_status2 post_list"><?php echo ucfirst($data['post_status']); ?></span>

		<span class="post_image2 post_list">

			<img class="post_list_image" src="<?php echo SITE_URL;?>uploads/<?php echo $data['post_image']; ?>">

		</span>
		
	</div>
	
<?php

}

function generatePostId(){
	global $connection;

	$flag = true;

	do{

		$random_num = rand(1000, 9999);

		$sql = "SELECT post_id FROM posts WHERE post_id = $random_num";

		$query1 = mysqli_query($connection, $sql);

		$rows = mysqli_num_rows($query1);

		if($rows != 0){

			$flag = false;

		}
		
	} while($flag == false);

	return $random_num;
}

?>