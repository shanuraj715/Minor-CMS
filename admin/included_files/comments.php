<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Comments";
</script>

<?php

include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/comments.php';
pageForUser('admin');

commentList(); // from comments.php function page


?>
<script>
	function approveComment( comment_id ){
		$.ajax({
			type: 'POST',
			data: 'do=approve&c_id=' + comment_id,
			url: '<?php echo SITE_URL;?>admin/extra_files/comments.php',
			success: ( data ) => {
				if(data == 'success'){
					alert("Success");
					location.reload();
				}
				else{
					alert( 'Unable to update the record' );
				}
			},
			error: () => {
				alert( 'Unable to send data to the server. Please check your connection.' );
			}
		});
	}

	function unapproveComment( comment_id ){
		$.ajax({
			type: 'POST',
			data: 'do=pending&c_id=' + comment_id,
			url: '<?php echo SITE_URL;?>admin/extra_files/comments.php',
			success: ( data ) => {
				if(data == 'success'){
					alert("Success");
					location.reload();
				}
				else{
					alert( 'Unable to update the record' );
				}
			},
			error: () => {
				alert( 'Unable to send data to the server. Please check your connection.' );
			}
		});

	}
</script>