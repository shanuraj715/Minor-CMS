<?php

function getActivecards(){
	global $connection; ?>

	<div class="basic_stat_container_top">
	<?php
	$sql = "SELECT * FROM dashboard_settings WHERE name = 'main_page_total_post_card' and value = 'active'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_num_rows($query);
	if($result == 1){ ?>
		<div class="basic_stat_container stat_post_color">
			<div class="stat_parent_block">
				<i class="fas fa-pencil-alt"></i>
				<div class="stat_block">
					<p class="stat_data_text"><?php dcTotalPosts(); ?></p>
					<p class="stat_data_text2">Posts</p>
				</div>
				<div class="stat_block_link_block">
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=create-post'; ?>" class="stat_block_link">Create New Post <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
		<?php
	}

	$sql = "SELECT * FROM dashboard_settings WHERE name = 'main_page_total_users_card' and value = 'active'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_num_rows($query);
	if($result == 1){ ?>
		<div class="basic_stat_container stat_users_color">
			<div class="stat_parent_block">
				<i class="fas fa-users"></i>
				<div class="stat_block">
					<p class="stat_data_text"><?php dcTotalUsers(); ?></p>
					<p class="stat_data_text2">Users</p>
				</div>
				<div class="stat_block_link_block">
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=users&action=add-new-user'; ?>" class="stat_block_link">Add User <i class="fas fa-arrow-circle-right"></i> </a>
				</div>
			</div>
		</div>
		<?php
	}


	$sql = "SELECT * FROM dashboard_settings WHERE name = 'main_page_media_card' and value = 'active'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_num_rows($query);
	if($result == 1){ ?>
		<div class="basic_stat_container stat_media_color">
			<div class="stat_parent_block">
				<i class="far fa-image"></i>
				<div class="stat_block">
					<p class="stat_data_text"><?php dcTotalMedia(); ?></p>
					<p class="stat_data_text2">Media</p>
				</div>
				<div class="stat_block_link_block">
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=media'; ?>" class="stat_block_link">View Media <i class="fas fa-arrow-circle-right"></i> </a>
				</div>
			</div>
		</div>
		<?php
	}

	$sql = "SELECT * FROM dashboard_settings WHERE name = 'main_page_media_card' and value = 'active'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_num_rows($query);
	if($result == 1){ ?>
		<div class="basic_stat_container stat_category_color">
			<div class="stat_parent_block">
				<i class="fas fa-layer-group"></i>
				<div class="stat_block">
					<p class="stat_data_text"><?php dcTotalCategory(); ?></p>
					<p class="stat_data_text2">Categories</p>
				</div>
				<div class="stat_block_link_block">
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=manage-category&task=create-category'; ?>" class="stat_block_link">Create New Category <i class="fas fa-arrow-circle-right"></i> </a>
				</div>
			</div>
		</div>
		<?php
	} ?>
	</div>
	<?php
}

function getActiveCards_2(){
	recentCommentsDashboardCard2();
	latestPostCard();
}

function recentCommentsDashboardCard2(){
	global $connection;

	$sql = "SELECT * FROM dashboard_settings WHERE name = 'recent_comments' and value = 'active'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_num_rows($query);
	if($result == 1){ ?>
	<div class="recent_comments_container">
		<div class="recent_comments_block">
			<p class="recent_comment_tit"><i class="far fa-comment-dots"></i> Recent Comments</p>
		</div>
		<div class="recent_comment_data_container" id="recent_comment_data_container">
			<?php
			$sql = "SELECT * from post_comments WHERE status = 'approved' or status = 'pending' ORDER BY comment_id DESC";
			$query = mysqli_query($connection, $sql);
			while($result = mysqli_fetch_assoc($query)){ ?>
			<div class="recent_comment_list_block">
				<div class="rec_comm_user_det_block">
					<p class="rec_comm_u_n_text"><i class="fas fa-user"></i> <?php echo $result['user_name']; ?></p>
					<p class="rec_comm_date_text"><i class="fas fa-calendar-alt"></i> <?php echo $result['comment_date']; ?></p>
				</div>
				<div class="comment_text_block">
					<p class="comment_text"><?php echo $result['comment']; ?></p>
					<div class="rec_comm_action_btn_container">
						<?php
						if($result['status'] == 'approved'){
							echo '<span class="rec_comm_btn approve_btn">Approved</span>';
						}
						elseif($result['status'] == 'pending'){
							echo '<span class="rec_comm_btn unapprove_btn">Unapproved</span>';
						} ?>
					</div>
				</div>
			</div>
			<?php
			} ?>
		</div>
	</div>
	<?php
	}	
}

function latestPostCard(){ ?>
	<div class="latest_posts_container">
		<div class="latest_post_title_block">
			<p class="latest_post_title"><i class="fas fa-pencil-alt"></i> Latest Posts</p>
		</div>
		<div class="latest_post_container">
			<div class="post_list_p_block">
				<span class="post_p_date">Date</span>
				<span class="post_p_author">Author</span>
				<span class="post_p_title">Title</span>
			</div>
			<?php

			global $connection; 

			$sql = "SELECT * FROM posts LIMIT 11";

			$query = mysqli_query($connection, $sql);

			while($result = mysqli_fetch_assoc($query)){ ?>
				<div class="post_list_block">
					<span class="post_date"><?php echo date('d-m-Y', strtotime($result['post_date'])); ?></span>
					<span class="post_author"><?php echo $result['post_author']; ?></span>

					<span href="#" class="post_title"><?php echo $result['post_title']; ?>
						<div class="post_1q">
							<span><?php echo ucfirst($result['post_status']); ?></span>
							<a href="<?php echo SITE_URL . 'admin/view-post.php?post_id=' . $result['post_id']; ?>">View</a>
							<a href="<?php echo $_SERVER['PHP_SELF'] . '?page=edit-post&post_id=' . $result['post_id']; ?>">Edit</a>
						</div>
					</span>
				</div>
				<?php
			} ?>
			
		</div>
	</div>
	<?php

}

function dcTotalPosts(){
	global $connection;
	$sql = "SELECT count(post_id) as total_posts FROM posts WHERE post_status = 'published'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_fetch_assoc($query);
	echo $result['total_posts'];
}

function dcTotalUsers(){
	global $connection;
	$sql = "SELECT count(user_id) as total_users FROM users WHERE status = 'active'";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_fetch_assoc($query);
	echo $result['total_users'];
}

function dcTotalMedia(){
	$directory = SITE_DIR;
	$directory .= 'uploads/';
	$filecount = 0;
	$files = glob($directory . "*");
	if($files){
		$filecount = count($files);
	}
	echo $filecount;
}

function dcTotalCategory(){
	global $connection;
	$sql = "SELECT count(category_id) as total_cats FROM categories";
	$query = mysqli_query($connection, $sql);
	$result = mysqli_fetch_assoc($query);
	echo $result['total_cats'];
}
// <?php echo SITE_URL . "admin/extra_files/dashboard-recent-comments-jqery.php";
?>