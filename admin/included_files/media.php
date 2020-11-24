<?php
include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/media-functions.php';

pageForUser('admin');

if(isset($_GET['do']) and !empty($_GET['do'])){
	if(isset($_GET['file']) and !empty($_GET['file'])){
		$do = MRES($_GET['do']);
		$file = $_GET['file'];
		mediaPopup( $do, $file );
	}
}

if(isset($_GET['action']) and !empty($_GET['action'])){
	$action = $_GET['action'];
}
else{
	$action = 'view';
}

?>


<div class="media_page_container">
	<?php
	if($action == 'upload'){ ?>
		<script type="text/javascript">
			$('#page_title').html("Upload Media");
		</script>
		<?php
		mediaUploader();
	} 
	elseif($action == 'view'){ ?>
		<script type="text/javascript">
			$('#page_title').html("View Media");
		</script>
		<!-- <div class="media_add_new_block">
			<a class="media_add_new" href="<?php //echo SITE_URL . 'admin/dashboard.php?page=media&action=upload';?>">Upload Media</a>
		</div> -->
		<div class="media_show_block">

			<?php allMediaFiles(); ?>

		</div>
	<?php 
	} ?>
</div>




<script type="text/javascript">
	$(document).ready(function(){
		<?php $total_media = mediaHeaderData(); ?>
		$('#additional_header_text').html("Total Media Files : <?php echo $total_media; ?>");

		/* procedure to close the popup screen */

		$('#media_popup_close_btn').click(function(){
			$('.media_popup_container').hide(400);
			console.log("DONE");
			setTimeout(function(){
				window.open("<?php echo SITE_URL . 'admin/dashboard.php?page=media';?>", "_self");
			}, 400);
		});

		$('.media_popup_img').magnificPopup({
			type: 'image'
		});

		$('.media_name').magnificPopup({
			type: 'iframe'
		});

		/*popup procedure ends here */





	});
</script>