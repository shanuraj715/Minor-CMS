<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Edit Post";
</script>

<script type="text/javascript" src="./js/editor-pages.js"></script>
<?php include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/post_functions.php'; ?>
<?php include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/create_post_functions.php'; ?>

<?php

pageForUser('admin, author');

global $connection;

if(isset($_POST['p_status']) and !empty($_POST['p_status'])){

	updatePost();

}

if(isset($_GET['p_id']) and !empty($_GET['p_id']) and is_numeric($_GET['p_id'])){

	$p_id = $_GET['p_id'];

	$sql = "SELECT * FROM posts WHERE post_id = $p_id";
	$query = mysqli_query($connection, $sql);
	$rows = mysqli_num_rows($query);

	if($query and $rows == 1){
		$post_data = mysqli_fetch_assoc($query);
	}
	else{
		showErrorWindow("Error", "Unable to fetch post data");
		exit();
	}

	$sql = "SELECT * FROM content_seo WHERE content_id = $p_id";
	$query = mysqli_query($connection, $sql);

	if($query){
		$seo_data = mysqli_fetch_assoc($query);
	}
	else{
		showErrorWindow("Error", "Unable to fetch post SEO data");
		exit();
	}
}
else{
	header("Location: " . SITE_URL . 'admin/dashboard.php?page=create-post');
}
?>




<div class="create_post_container">
	<form action="" method="post" class="p_form" enctype="multipart/form-data">
		<div class="page_data_block">
			<div class="post_creation_form">
				<div class="post_title_block">
					<input type="text" name="post_title" placeholder="Post Title" class="cp_post_title" value="<?php echo $post_data['post_title']; ?>">
				</div>
				<div class="post_writer_block">
					<textarea name="post_content" id="body" style="display: none;" value="<?php echo $post_data['post_content'];?>"></textarea>
				</div>


				<div class="cp_post_options_container">
					<div class="cp_post_author">
						<p class="cp_author">Post Author</p>
						<?php
						global $connection;
						$sql = "SELECT * from users WHERE role = 'admin' or role = 'author' or role = 'editor'";

						$query = mysqli_query($connection, $sql);

						while($result = mysqli_fetch_assoc($query)){ ?>

							<div class="cp_author_list_block">

								<input id="<?php echo $result['username']; ?>" type="radio" name="post_author" value="<?php echo $result['username']; ?>">
								<label for="<?php echo $result['username']; ?>"><?php echo $result['username']; ?></label>
							
							</div>
							<?php
						}

						?>
						
					</div>
				</div>

				<div class="seo_previewer_container">
					<div class="cp_seo_options">
						<p class="cp_seo_header_text">Manage SEO</p>
						<div class="cp_seo_opts">
							<div class="cp_seo_1">
								<span class="cp_seo_title2">Enable SEO on this post</span>
								<input class="cp_seo_rad_btn" type="radio" name="enable_seo" value="1" id="enable_seo_enable" checked>
								<label class="cp_seo_label" for="enable_seo_enable">Enable</label>
								<input class="cp_seo_rad_btn" type="radio" name="enable_seo" value="0" id="enable_seo_disable">
								<label for="enable_seo_disable">Disable</label>
							</div>



							<div class="cp_seo_1">
								<span class="cp_seo_title2">Post Indexing</span>
								<input class="cp_seo_rad_btn" type="radio" name="enable_index" value="index" id="enable_indexing_enable" checked>
								<label class="cp_seo_label" for="enable_indexing_enable">Enable</label>
								<input class="cp_seo_rad_btn" type="radio" name="enable_index" value="noindex" id="enable_indexing_disable">
								<label for="enable_indexing_disable">Disable</label>
							</div>



							<div class="cp_seo_1">
								<span class="cp_seo_title2">Post Links Follow</span>
								<input class="cp_seo_rad_btn" type="radio" name="enable_follow" value="follow" id="enable_follow_enable" checked>
								<label class="cp_seo_label" for="enable_follow_enable">Enable</label>
								<input class="cp_seo_rad_btn" type="radio" name="enable_follow" value="nofollow" id="enable_follow_disable">
								<label for="enable_follow_disable">Disable</label>
							</div>


							<div class="cp_seo_2">
								<span class="cp_seo_title1">Post Description</span>
								<input class="cp_seo_inp_txt" type="text" name="post_seo_description">
							</div>


							<div class="cp_seo_2">
								<span class="cp_seo_title1">Post Keywords</span>
								<input class="cp_seo_inp_txt" type="text" name="post_seo_keywords">
							</div>


							<div class="cp_seo_2">
								<span class="cp_seo_title1">Post Subject</span>
								<input class="cp_seo_inp_txt" type="text" name="post_seo_subject">
							</div>


							<div class="cp_seo_2">
								<span class="cp_seo_title1">Crawler Revisit Time</span>
								<select name="cp_revisit_after" class="cp_seo_revisit_select">
									<option value="1 day">Everyday</option>
									<option value="3 days">After 3 Days</option>
									<option value="7 days">After 7 Days</option>
								</select>
							</div>


							<div class="cp_seo_1">
								<span class="cp_seo_title2">Enable Page Cache</span>
								<input class="cp_seo_rad_btn" type="radio" name="enable_cache" value="1" id="enable_cache_enable">
								<label class="cp_seo_label" for="enable_cache_enable">Enable</label>
								<input class="cp_seo_rad_btn" type="radio" name="enable_cache" value="0" id="enable_cache_disable" checked>
								<label for="enable_cache_disable">Disable</label>
							</div>


						</div>
					</div>

				</div>






			</div>
			<div class="p_action_area">



				<div class="sidebar_option_list">
					<p class="p_option_text" onclick="expand_p_sidebar_option('option_expander_p_status','p_s_sidebar_arrow')"><i class="clr_lyellow fas fa-check"></i> Post Status <i id="p_s_sidebar_arrow" class="fas fa-arrow-circle-down rotate_arrow"></i></p>


					<div class="p_option_content" id="option_expander_p_status">
						<?php 
						if($post_data['post_status'] == 'published'){
							$post_status = "Published";
						}
						elseif($post_data['post_status'] == 'draft'){
							$post_status = 'Draft';
						}
						else{
							$post_status = "Draft";
						} ?>
						<p class="post_now_status">Current Status <span class="post_now_status"><?php echo $post_status; ?></span></p>
						<div class="p_status_block">
							<label for="p_status_label" class="clr_wh fs_18">Status</label>
							<select id="post_status_selector" class="p_status_select fs_16" name="p_status" onchange="change_publish_btn()">
								<option class="p_status_option" value="draft">Draft</option>
								<option class="p_status_option" value="published">Publish</option>
							</select>
						</div>
					</div>
					<div class="p_submit_btn_block">
						<input id="create_p_submit_btn" class="far p_submit_btn" type="submit" name="create_post" value="&#xf0c7; Publish">
					</div>
				</div>









				<div class="sidebar_option_list">
					<p class="p_option_text" onclick="expand_p_sidebar_option('option_expander_p_setting','p_sett_sidebar_arrow')"><i class="clr_lyellow fas fa-cogs"></i> Post Setting <i id="p_sett_sidebar_arrow" class="fas fa-arrow-circle-down rotate_arrow"></i></p>
					<div class="p_option_content" id="option_expander_p_setting">
						<div class="p_opt_cont_block">
							<?php if($post_data['enable_comments'] == 1){
								$enable_comments = "checked";
							}
							else{
								$enable_comments = "";
							} ?>
							<input type="checkbox" id="comments_available" name="comments_available" value="1" <?php echo $enable_comments; ?>>
							<label for="comments_available">Enable Comments</label>
						</div>
					</div>
				</div>









				<div class="sidebar_option_list">
					<p class="p_option_text" onclick="expand_p_sidebar_option('option_expander_p_cat','p_cat_sidebar_arrow')"><i class="clr_lyellow fas fa-plus"></i> Categories <i id="p_cat_sidebar_arrow" class="fas fa-arrow-circle-down rotate_arrow"></i></p>
					<div class="p_option_content" id="option_expander_p_cat">
						<div class="p_opt_cont_block">
							<p class="p_opt_sub_title clr_lyellow">Select Category</p>
							<?php
							global $connection;
							$sql = "SELECT * FROM categories ORDER BY category_id";
							$query = mysqli_query($connection, $sql);

							while($result = mysqli_fetch_assoc($query)){ ?>
								<div class="p_category_list_block">
									<input id="<?php echo str_replace(' ', '', $result['category_title']); ?>" type="radio" name="p_category_checkbox" value="<?php echo $result['category_id']; ?>">
									<label for="<?php echo str_replace(' ', '', $result['category_title']); ?>"><?php echo $result['category_title']; ?></label>
								</div>
								<?php
							} ?>
							<div class="add_cat_btn_block">
									<span class="add_cat_btn_1" onclick="show_add_cat_block()">Add New Category</span>
								</div>
							<div class="p_add_cat_block" id="p_add_cat_block">
								<!-- <form class="add_cat_form" action="" method="post"> -->
									<div class="add_cat_form_data_block">
										<!-- <input type="text" class="add_cat_input" name="new_cat_name" placeholder="Enter Category Name" required> -->
									</div>
									<div class="add_cat_submit_block">
										<!-- <input type="submit" class="add_cat_btn"> -->
									</div>
								<!-- </form> -->
							</div>
						</div>
					</div>
				</div>





							




				<div class="sidebar_option_list">
					<p class="p_option_text" onclick="expand_p_sidebar_option('option_expander_p_tags','p_tags_sidebar_arrow')"><i class="clr_lyellow fas fa-tags"></i> Post Tags <i id="p_tags_sidebar_arrow" class="fas fa-arrow-circle-down rotate_arrow"></i></p>
					<div class="p_option_content" id="option_expander_p_tags">
						<div class="p_opt_cont_block">
							<p class="p_tags_text">Enter Tags, Seperated By Comma (,)</p>
							<input type="text" name="p_tags" class="p_tags_input" onkeyup="write_tags_block()" id="p_tag_list" maxlength="1024" value="<?php echo $post_data['post_tags']; ?>">
							<div class="tags_list_block" id="tag_cloud">
							</div>
						</div>
					</div>
				</div>









				<div class="sidebar_option_list">
					<p class="p_option_text" onclick="expand_p_sidebar_option('option_expander_p_fi','p_fi_sidebar_arrow')"><i class="clr_lyellow far fa-file-image"></i> Featured Image <i id="p_fi_sidebar_arrow" class="fas fa-arrow-circle-down rotate_arrow"></i></p>
					<div class="p_option_content" id="option_expander_p_fi">
						<div class="p_opt_cont_block">
							<p class="margin_tb_10 clr_wh fs_18">Upload Featured Image</p>
							
							<div class="from_gallery_uploader_block">
								
							</div>
							<input type="file" name="featured_image" id="image_selector" onchange="show_image()">
							<div class="image_shower_block" id="feature_img_image_block">
								<img id="feature_image_shower">
								<span class="remove_image_btn" id="remove_fi_btn" onclick="remove_featured_image()">Remove Image</span>
							</div>
						</div>
					</div>
				</div>









				<div class="sidebar_option_list">
					<p class="p_option_text" onclick="expand_p_sidebar_option('option_expander_p_sharing','p_sharing_sidebar_arrow')"><i class="clr_lyellow fas fa-share-alt"></i> Post Sharing <i id="p_sharing_sidebar_arrow" class="fas fa-arrow-circle-down rotate_arrow"></i></p>
					<div class="p_option_content" id="option_expander_p_sharing">
						<div class="p_opt_cont_block">
							<input id="p_sharing_checkbox" type="checkbox" name="sharing" value="true" checked>
							<label for="p_sharing_checkbox">Enable Sharing Options</label>
						</div>
					</div>
				</div>









				<!-- <div class="sidebar_option_list">
					<p class="p_option_text" onclick="expand_p_sidebar_option('option_expander_p_seo','p_seo_sidebar_arrow')"><i class="clr_lyellow fas fa-search"></i> Post SEO <i id="p_seo_sidebar_arrow" class="fas fa-arrow-circle-down rotate_arrow"></i></p>
					<div class="p_option_content" id="option_expander_p_seo">
						<div class="p_opt_cont_block">
							<input type="checkbox" name="seo_index" id="seo_p_index" value="true" checked>
							<label for="seo_p_index">Enable Page Indexing</label>
						</div>
						<div class="p_opt_cont_block">
							<input type="checkbox" name="seo_follow" id="seo_p_follow" value="true" checked>
							<label for="seo_p_follow">Enable Follow Links</label>
						</div>
					</div>
				</div> -->



			</div>
		</div>
		<script type="text/javascript" src="<?php echo SITE_URL . 'admin/addons/ckeditor/ckeditor.js'; ?>"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#body').css('display', 'block');
				CKEDITOR.replace('body');
			})
		</script>
	</form>
</div>