<?php

function w_latestPosts(){
	global $connection;

	$sql = "SELECT * FROM settings where name = 'latest_post_limit'";

	$query = mysqli_query($connection, $sql);

	if($query){
		$limit = mysqli_fetch_assoc($query);
		$limit = $limit['value'];
	}
	else{
		$limit = 10;
	}

	$sql = "SELECT * FROM settings where name = 'latest_post_show_date'";

	$query = mysqli_query($connection, $sql);

	if($query){
		$show_date = mysqli_fetch_assoc($query);
		$show_date = $show_date['value'];
	}
	else{
		$show_date = 'enable';
	}

	$sql = "SELECT post_id, post_title, post_date FROM posts ";

	$sql .= "WHERE post_status = 'published'";

	$sql .= "ORDER BY post_date DESC";

	$sql .= " LIMIT $limit";

	$query = mysqli_query($connection, $sql);

	while($latest_posts = mysqli_fetch_assoc($query)){

		$post_id = $latest_posts['post_id'];

		$post_title2 = $latest_posts['post_title'];

		$post_title = $latest_posts['post_title'];

		$post_title = str_replace('%20', '-', $post_title);

		$post_title = str_replace(' ', '-', $post_title);

		$post_date = $latest_posts['post_date']; ?>
		<!-- post_list -->
		<div class="w_latest_post">
			<i class="fas fa-arrow-right"></i><a class="w_latest_post_link" href="<?php echo SITE_URL . 'post/' . $post_id . '/' . $post_title; ?>"><?php echo $post_title2; ?></a>
			<?php
			if($show_date == 'enable'){ ?>
			<div class="w_latest_post_meta_block">
				<span class="w_latest_post_date"><?php echo $post_date; ?></span>
			</div>
			<?php
			} ?>
		</div> <!-- post list Closing -->
	<?php
	}
}

?>

<div class="sidebar_widget">
	<div class="w_sidebar_div">
		<p class="w_widget_title" style="display: block;">Latest Posts<i id="latest_post_expander" status="expanded" class="fas" style="float: right; font-size: 20px;"></i></p>
		<?php w_latestPosts(); ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			if($.cookie("sidebar-w-latest-posts-expand-status") == null){
				$.cookie("sidebar-w-latest-posts-expand-status", "expand", { path:'/' });
					$('#latest_post_expander').addClass('fa-minus');
			}
			else{
				if($.cookie("sidebar-w-latest-posts-expand-status") == "expand"){
					$('#latest_post_expander').addClass('fa-minus');
					$('.w_latest_post').show();
					$('#latest_post_expander').attr('status', 'expanded');
				}
				else if($.cookie("sidebar-w-latest-posts-expand-status") == "collapse"){
					$('#latest_post_expander').addClass('fa-plus');
					$('.w_latest_post').hide();
					$('#latest_post_expander').attr('status', 'hidden');
				}
			}

			$('#latest_post_expander').click(function(){
				if($('#latest_post_expander').attr('status') == 'hidden'){
					$.cookie("sidebar-w-latest-posts-expand-status", "expand", { path:'/' });
					$('.w_latest_post').show(500);
					$('#latest_post_expander').attr('status', 'expanded');
					$('#latest_post_expander').removeClass('fa-plus');
					$('#latest_post_expander').addClass('fa-minus');
				}
				else{
					$.cookie("sidebar-w-latest-posts-expand-status", "collapse", { path:'/' });
					$('.w_latest_post').hide(500);
					$('#latest_post_expander').attr('status', 'hidden');
					$('#latest_post_expander').removeClass('fa-minus');
					$('#latest_post_expander').addClass('fa-plus');
				}
			})
		});
	</script>
</div>