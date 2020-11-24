<?php

function showPostTags($post_id){
	global $connection;

	$sql = "SELECT post_tags from posts WHERE post_id = $post_id";

	$query = mysqli_query($connection, $sql);

	$result = mysqli_fetch_assoc($query);

	$tag_array = str_replace(', ', ',', $result['post_tags']);
	$tag_array = explode(',',$result['post_tags']);

	foreach ($tag_array as $value) { ?>
		<a href="<?php echo SITE_URL . '?tag=' . $value;?>"><?php echo $value; ?></a>
		<?php
	}
	
}




?>

<div class="post_tags_cloud_block">
	<div class="post_tag_list">
		<span class="post_tags_title">Tags : </span>
		<?php
		if(isset($post_data)){

			showPostTags($post_data['post_id']);
	
		} ?>
	</div>
</div>