<?php
function w_showCategories(){
	global $connection;
	$sql = "SELECT * FROM categories ";
	$sql .= "ORDER BY category_id ASC";
	$query = mysqli_query($connection, $sql);
	while($category_list = mysqli_fetch_assoc($query)){
		$category_id = $category_list['category_id'];
		$total_post_in_category =  total_post_in_category($category_id);?>
		<div class="w_category_block">
			<i class="fas fa-angle-double-right"></i>
			<a href="<?php echo SITE_URL . '?category=' . $category_list['category_title']; ?>" class="w_category_list" title="<?php echo $total_post_in_category; ?> Posts in this category"><?php echo $category_list['category_title'] . ' [' . $total_post_in_category . ']'; ?></a>
		</div>
		<?php
	}
}


function total_post_in_category($category_id){
	global $connection;
	$sql = "SELECT COUNT(category_id) as total_category FROM posts ";
	$sql .= "WHERE `category_id` = $category_id";
	$sql .= " and post_status = 'published'";
	$query = mysqli_query($connection, $sql);
	$total_post_in_this_category = mysqli_fetch_assoc($query);
	return $total_post_in_this_category['total_category'];
}
?>

<div class="sidebar_widget">
	<div class="w_categories_block">
		<p class="w_widget_title">Categories</p>
		<?php w_showCategories(); ?>
	</div>
</div>