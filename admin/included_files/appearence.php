<script type="text/javascript">
	$('#page_title').html("Site Appearence");
</script>
<?php 
include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/appearence-functions.php';

pageForUser('admin');

if(!isset($_GET['action']) or empty($_GET['action'])){
	header("Location: " . SITE_URL . 'admin/dashboard.php?page=appearence&action=navigation');
	exit();
}
else{
	$action = $_GET['action'];
}

if(isset($action)){
	appearenceHeader(); // header links 
}

global $connection;

if($action == 'navigation'){ ?>
	<div class="app_nav_container">
		<div class="app_nav_block">
			<div class="app_nav_block1">
				<?php
				$sql = "SELECT * FROM cms_navigation ORDER BY id ASC";
				$query = mysqli_query($connection, $sql);
				if($query){
					while($result = mysqli_fetch_assoc($query)){ ?>
						<div class="app_nav_parent_block">
							<ul class="app_nav_ul">
								<li class="app_nav_li"><?php echo $result['title'];?></li>
								<span class="app_nav_parent_edit_link" id="app_nav_del" onclick="deleteNav(<?php echo $result['id'];?>)">Delete</span>
							</ul>
						</div>
						<?php
					}
				} ?>
				<div class="app_add_new_nav_block">
					<button id="navigation_add_more_btn" class="app_add_nav_btn">Add More</button>
				</div>

				<div class="navigation_add_block">
					<input id="nav_add_name" type="text" class="app_add_new_nav_inp" placeholder="Enter button name">
					<input id="nav_add_url" type="text" class="app_add_new_nav_inp" placeholder="Enter URL">
					<button id="add_nav_btn" class="navigation_add_new_done_btn">Done</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.app_head_ul > li').removeClass("app_head_active");
			$('.app_head_li').each(function(){
				if(($(this).attr('btn_id')) == '<?php echo $action; ?>'){
					$(this).addClass('app_head_active');
				}
			});
			$('.navigation_add_block').hide();
		});

		function deleteNav( nav_id ){
			$.ajax({
				type: 'POST',
				data: 'do=delete&nav_id=' + nav_id,
				url: '<?php echo SITE_URL;?>admin/extra_files/navigation.php',
				success: ( data ) => {
					if(data == 'success'){
						window.open('<?php echo THIS_PAGE;?>', "_self");
					}
					else{

						alert(data);
					}
				},
				error: () => {
					alert("Unable to delete the button");
				}
			})
		}

		$('#navigation_add_more_btn').click(() => {
			var expand_status = $(".navigation_add_block");

			if(expand_status.css('display') == 'none'){
				$('.navigation_add_block').show(200);
			}
			else{
				$('.navigation_add_block').hide(200);
			}
		});

		$('#add_nav_btn').click( () => {
			let nav_btn_name = $('#nav_add_name').val();
			let nav_btn_url = $('#nav_add_url').val();

			if(nav_btn_name != '' && nav_btn_url != ''){
				$.ajax({
					type : 'POST',
					data : 'do=insert&name=' + nav_btn_name + '&url=' + nav_btn_url,
					url : '<?php echo SITE_URL;?>admin/extra_files/navigation.php',
					success: ( data ) => {
						if( data == 'success' ){
							alert( data );
							location.reload();
						}
						else{
							alert(data);
						}
					},
					error: () => {
						alert('Unable to send data to the server. Please check your connection');
					}
				});
			}
		});
	</script>
	<?php
}
elseif($action == 'more-opt'){
	?>
	<div class="app_more_opt_cont">
		<div class="app_more_block">
			<?php
				$sql = "SELECT * FROM settings WHERE name = 'top_social_options'";
				$query = mysqli_query($connection, $sql);
				$result = mysqli_fetch_assoc($query);
				if($result['value'] == 'active'){
					$status = 'checked';
				}
				else{
					$status = '';
				}
			?>
			<input id="app_head_social_btns" type="checkbox" class="app_cb" <?php echo $status;?>>
			<span class="app_social_btns">Enable Social Button in Header</span>
		</div>


		<div class="app_more_block">
			<?php
				$sql = "SELECT * FROM settings WHERE name = 'enable_about_us_page'";
				$query = mysqli_query($connection, $sql);
				$result = mysqli_fetch_assoc($query);
				if($result['value'] == 'enable'){
					$status = 'checked';
				}
				else{
					$status = '';
				}
			?>
			<input id="app_enable_about_page" type="checkbox" class="app_cb" <?php echo $status;?>>
			<span class="app_social_btns">Enable About Us Page</span>
		</div>


		<div class="app_more_block">
			<?php
				$sql = "SELECT * FROM settings WHERE name = 'enable_contact_us_page'";
				$query = mysqli_query($connection, $sql);
				$result = mysqli_fetch_assoc($query);
				if($result['value'] == 'active'){
					$status = 'checked';
				}
				else{
					$status = '';
				}
			?>
			<input id="app_enable_contact_page" type="checkbox" class="app_cb" <?php echo $status;?>>
			<span class="app_social_btns">Enable Contact Us Page</span>
		</div>


		<div class="app_more_block">
			<?php
				$sql = "SELECT * FROM settings WHERE name = 'enable_privacy_policy_page'";
				$query = mysqli_query($connection, $sql);
				$result = mysqli_fetch_assoc($query);
				if($result['value'] == 'active'){
					$status = 'checked';
				}
				else{
					$status = '';
				}
			?>
			<input id="app_enable_privacy_page" type="checkbox" class="app_cb" <?php echo $status;?>>
			<span class="app_social_btns">Enable Privacy Policy Page</span>
		</div>


		<div class="app_more_block">
			<?php
				$sql = "SELECT * FROM settings WHERE name = 'footer_ad'";
				$query = mysqli_query($connection, $sql);
				$result = mysqli_fetch_assoc($query);
				if($result['value'] == 'active'){
					$status = 'checked';
				}
				else{
					$status = '';
				}
			?>
			<input id="footer_ad_cb" type="checkbox" class="app_cb" <?php echo $status;?>>
			<span class="app_social_btns">Enable Showing Ads in Footer</span>
		</div>

		<div class="app_footer_ad_block">
			<textarea class="app_footer_ad_inp" placeholder="Paste your ad script here. [Max Size : 600px * 250px]"></textarea>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready( () => {
			let footer_ad_cb_status = $('#footer_ad_cb').prop('checked');
			if(footer_ad_cb_status != true){
				$('.app_footer_ad_block').hide();
			}
		});

		$('#footer_ad_cb').change( () => {
			let status = $('#footer_ad_cb').prop('checked');
			if(status == true){
				$('.app_footer_ad_block').show(200);
			}
			else{
				$('.app_footer_ad_block').hide(200);
			}
		});

		$('#app_head_social_btns').change( () => {
			let status = 'active';
			if($('#app_head_social_btns').prop('checked') == 'true'){
				console.log('true');
			}
			// $.ajax({
			// 	type: 'POST',
			// 	data: 'name=top_social_options&status=' + status,
			// 	url: '<?php //echo SITE_URL;?>',
			// 	success: ( data ) => {
			// 		if( data == 'success'){
			// 			alert("Success");
			// 		}
			// 		else{
			// 			alert(data);
			// 		}
			// 	},
			// 	error: () => {
			// 		alert('Unable to send data to the server. Please check your connection and try again.');
			// 	}
			// })
		});

		$('#app_enable_about_page').change( () => {

		});

		$('#app_enable_contact_page').change( () => {

		});

		$('#app_enable_privacy_page').change( () => {

		});
	</script>

<?php
}

?>





