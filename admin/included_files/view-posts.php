<?php include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/post_functions.php'; ?>
<?php
global $connection;

if(isset($_GET['atd']) and !empty($_GET['atd'])){
	if(isset($_GET['pidl']) and !empty($_GET['pidl'])){
		$action = $_GET['atd'];
		$id_list = MRES($_GET['pidl']);
		if(strpos($id_list, ',') == true){
			$id_list = explode(',', $id_list);
		}
		else{
			$id_list = [$id_list];
		}
		if($action == 'duplicate'){
			$id_list = $id_list[0];
			$sql = "SELECT * FROM posts WHERE post_id = $id_list";
			$query = mysqli_query($connection, $sql);
			if($query){
				$result = mysqli_fetch_assoc($query);

				$post_title = $result['post_title'];	
				$post_author = $result['post_author'];
				$cat_id = $result['category_id'];
				$post_status = $result['post_status'];
				$post_tags = $result['post_tags'];
				$post_date = date('Y-m-d');
				$post_time = $result['post_time'];
				$post_content = $result['post_content'];
				$last_edit = $result['last_edit'];
				$post_image = $result['post_image'];
				$post_id = generatePostId();

				echo $post_id;

				$sql = "INSERT INTO posts (post_id, post_title, post_author, category_id, post_status, post_tags, post_date, post_time, post_content, last_edit, post_image) VALUES($post_id, '$post_title', '$post_author', $cat_id, '$post_status', '$post_tags', '$post_date', '$post_time', '$post_content', '$last_edit', '$post_image')";

				$query = mysqli_query($connection, $sql);

				if($query){

					header("Location: " . $_SERVER['PHP_SELF'] . '?page=view-posts');

				}

				else{

					showErrorWindow('Error!!!', 'Unable to Duplicate the Post.');

				}

			}

			else{
				header("Location: " . SITE_URL . 'admin/dashboard.php');
			}
		}
		else{
			if($action == 'publish'){
				$action = 'published';
			}
			elseif($action == 'draft'){
				$action = 'draft';
			}
			elseif($action = 'trash'){
				$action = 'trashed';
			}
			else{
				header("Location:" . $_SERVER['PHP_SELF'] . '?page=view-posts');
			}			
			foreach($id_list as $key => $post_id){
				settype($post_id, 'integer');
				$query_string = "UPDATE posts SET post_status = '$action' WHERE post_id = $post_id";
				
				$query = mysqli_query($connection, $query_string);

				if(!$query){
					break;
				}

			}

			if($query){

				header("Location: " . SITE_URL . 'admin/dashboard.php?page=view-posts');

				exit();

			}

			else{

				showErrorWindow('Error!!!', 'Query Not Executed Successfully. Try Again...');

			}
		}
	}
}



?>
<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Posts List";
</script>
<?php
if(isset($_GET['search']) and !empty($_GET['search'])){
	$search_text = $_GET['search']; ?>
	<script type="text/javascript">
		var text = '<?php echo "Search Result Of ";?>';
		text += '"' + '<?php echo ucwords($_GET['search']); ?>' + '"';
		document.getElementById('additional_header_text').innerHTML = text;
	</script>
	<?php
} ?>
<div class="post_list_container">
	<!-- Post List Header Begins -->
	<div class="post_page_header_container">
		<a class="add_new_post_btn" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=create-post">Add New</a>
		<div class="post_list_filter_btns_block">

			<a class="post_list_filter_link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=view-posts&filter=all">All (<?php echo countPostStatus('all'); ?>)</a>

			<a class="post_list_filter_link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=view-posts&filter=published">Published (<?php echo countPostStatus('published'); ?>)</a>

			<a class="post_list_filter_link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=view-posts&filter=drafted">Drafted (<?php echo countPostStatus('draft'); ?>)</a>

			<a class="post_list_filter_link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=view-posts&filter=trashed">Trashed (<?php echo countPostStatus('trashed'); ?>)</a>

			<a class="post_list_filter_link" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=view-posts&filter=mine">Mine (<?php echo countPostStatus('mine'); ?>)</a>
		</div>
		<div class="post_search_block">
			<input type="text" id="post_search">
			<button onclick="search_post();">Search</button>
			<i class="far fa-question-circle post_list_search_help_btn">
				<div class="post_list_search_helper">
					<span>You can search Post Title, Post Author, Post Tags and Post Keywords<br><br>Examples: cms, content, world, post, mobile, smartphone</span>
				</div>
			</i>
		</div>
	</div>
	<!-- Post List Header Ends -->

	<!-- Post List Main Begins -->
	<div class="post_list2_block">


		<div class="post_list_top2_block">
			<input type="checkbox" id="all_post_selector">
			<span class="post_title2 post_list_title_header">Title</span>
			<span class="post_category2 post_list_title_header">Category</span>
			<span class="post_date2 post_list_title_header">Date</span>
			<span class="post_tags2 post_list_title_header">Tags</span>
			<span class="post_author2 post_list_title_header">Author</span>
			<span class="post_status2 post_list_title_header">Status</span>
			<span class="post_image2 post_list_title_header">Image</span>
		</div>

		<?php postQuery(); ?>
	</div>

	<div class="post_option_menu_block">

		<div class="post_action_btns_block">
			<input type="checkbox" id="all_post_selector">
			<select class="post_list_select" id="post_list_select">
				<option value="">Select Action</option>
				<option value="publish">Publish</option>
				<option value="draft">Draft</option>
				<option value="trash">Trash</option>
			</select>
			<button id="post_action_btn" class="post_action_btn">Apply</button>
			<script type="text/javascript">
				$(document).ready(function(){








					$("#post_action_btn").click(function(){
						var post_selected_array = [];
						$('[id="post_selector"]').each(function(){
							if($(this).is(':checked')){
								var val = $(this).val();
								post_selected_array.push(val);
								var selected_post_action = $('#post_list_select').children("option:selected").val();
								if(selected_post_action != ""){
									var url = '<?php echo SITE_URL;?>'+'admin/dashboard.php?page=view-posts&atd='+selected_post_action+'&pidl='+post_selected_array;
									window.open(url, '_self');
								}
							}
						});
					});
				});
			</script>
		</div>
	</div>
</div>


<script type="text/javascript">
	function search_post(){
		var text = document.getElementById('post_search').value;
		if(text != ""){
			var url = '<?php echo SITE_URL . "admin/dashboard.php?page=view-posts&search=";?>'+text;
			window.open(url, '_self');
		}
	}
	// to check and uncheck the checkboxes on one click
	$(document).ready(function(){
		$('[id="all_post_selector"]').click(function(){
			if($(this).is(':checked')){
				$('[id="all_post_selector"]').prop('checked', true);
				checkAllPostCheckbox();
			}
			else{
				$('[id="all_post_selector"]').prop('checked', false);
				uncheckAllPostCheckbox();
			}
		});
		$('[id="post_selector"]').click(function(){
			var flag = true;
			$('[id="post_selector"]').each(function(){
				if($(this).is(':checked')){
					// write your code here if any task has to be done on checkbox checked
				}
				else{
					$('[id="all_post_selector"]').prop('checked', false);
					flag = false;
				}
			});
			if(flag == true){
				$('[id="all_post_selector"]').prop('checked', true);
			}
		});
	});

	function checkAllPostCheckbox(){
		$('[id="post_selector"]').prop('checked', true);
	}

	function uncheckAllPostCheckbox(){
		$('[id="post_selector"]').prop('checked', false);
	}
</script>

