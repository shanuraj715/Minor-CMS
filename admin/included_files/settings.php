<script type="text/javascript">
	document.getElementById('page_title').innerHTML = "Settings";
</script>
<?php include DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/settings_functions.php';

$role = strtolower($_SESSION['role']);

/* following code will prevent this page from loading to any other user except admin */

pageForUser('admin');

/* -------------------------------------- */

pageForUser('admin');

if(isset($_POST['form_submit']) and !empty($_POST['form_submit'])){

	saveSettings();

}

?>


<div class="site_settings_container">
	<div class="settings_options_block">
		<form action="" method="post" enctype="multipart/form-data">
			<section class="site_settings_section1">
				<h2 class="site_settings_title_text">Site Common Settings</h2>
				<div class="common_settings_block">
				

					<div class="common_settings_block_2">
						<label class="option_label" for="site_domain_name">Site Domain Name : <i class="far fa-question-circle" title="Site domain name (www.example.com)"></i></label>
						<input class="input_2" type="text" id="site_domain_name" name="site_domain" value="<?php echo settingsPageGetData('site_url'); ?>">
					</div>


					<div class="common_settings_block_2">
						<label class="option_label" for="site_name">Site Name : <i class="far fa-question-circle" title="Site Name (My Site or World or anything...)"></i></label>
						<input class="input_2" type="text" id="site_name" name="site_name" value="<?php echo settingsPageGetData('site_title'); ?>">
					</div>


					<div class="common_settings_block_2">
						<label class="option_label" for="site_description">Site Description : <i class="far fa-question-circle" title="Site Description (example: Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.)"></i></label>
						<input class="input_2" type="text" id="site_description" name="site_description" value="<?php echo settingsPageGetData('site_description'); ?>">
					</div>


					<div class="common_settings_block_2">
						<label class="option_label" for="site_author">Site Author : <i class="far fa-question-circle" title="Write Admin Name"></i></label>
						<input class="input_2" type="text" id="site_author" name="site_author" value="<?php echo settingsPageGetData('site_author'); ?>">
					</div>


					<div class="common_settings_block_2">
						<label class="option_label" for="site_logo_uploader">Site Logo : <i class="far fa-question-circle" title=""></i></label>
						<input class="site_logo_image_uploader" type="file" id="site_logo_uploader" name="site_logo" onchange="settingsShowUploadedImage();">
						<div class="site_logo_previewer">
							<div class="site_logo_shower_block">
								<p class="site_logo_old">Current Image / Logo</p>
								<img src="<?php echo SITE_URL . 'images/site_images/' . settingsPageGetData('site_logo'); ?>" class="site_logo_settings">
							</div>
							<div class="site_logo_shower_block">
								<p class="site_logo_new">Selected Image / Logo</p>
								<img src="" class="site_logo_settings" id="site_new_logo_viewer">
							</div>
							<script type="text/javascript">
								function settingsShowUploadedImage(){

									var uploader = document.getElementById('site_logo_uploader');

									var target = document.getElementById('site_new_logo_viewer');

									var image = new FileReader()

									image.onload = function(){

										target.src = image.result;	

									}

									if(uploader.value != ""){

										image.readAsDataURL(uploader.files[0]);

									}
									else{

										target.src = '';

									}

								}
								
							</script>
						</div>
					</div>

				</div>
			</section>









			<section class="site_settings_section1">
				<h2 class="site_settings_title_text">Site SEO Settings {For Homepage}</h2>
				<div class="common_settings_block">



					<div class="common_settings_block_2">
						<label class="option_label" for="site_seo">Site SEO : </label>
						<div class="settings_seo_radio_container">
							<input id="seo_page_enable_radio" type="radio" name="seo_page_option" value="enable" <?php echo seoStatus('seo_enable'); ?>>
							<label for="seo_page_enable_radio">Enable</label>
							<input id="seo_page_disable_radio" type="radio" name="seo_page_option" value="disable" <?php echo seoStatus('seo_disable'); ?>>
							<label for="seo_page_disable_radio">Disable</label>
							<span class="x2_popup_container"> <i class="fas fa-exclamation-triangle"></i> Read This
								<div class="x2_popup_block">
									<span class="">If Enable is selected then the SEO will available according to their setting and is Disable is selected the the SEO options will override for whole site and their will no SEO available for crawler.</span>
								</div>
							</span>
						</div>
					</div>



					<div class="common_settings_block_2">
						<label class="option_label" for="site_seo_index_name">Site Pages Indexing : <i class="far fa-question-circle" title="( Robots : index ) - Index: Tells a search engine to index a page."></i></label>
						<div class="settings_seo_radio_container">
							<input id="seo_page_index_radio" type="radio" name="seo_page_index" value="index" <?php echo seoStatus('seo_index'); ?>>
							<label for="seo_page_index_radio">Index</label>
							<input id="seo_page_noindex_radio" type="radio" name="seo_page_index" value="noindex" <?php echo seoStatus('seo_noindex'); ?>>
							<label for="seo_page_noindex_radio">No index</label>
							<span class="x2_popup_container"> <i class="fas fa-exclamation-triangle"></i> Read This
								<div class="x2_popup_block">
									<span class="">if No index option is selected then the SEO will disable for whole site (Including posts) and if index option is selected then the site will index and the SEO will work according to the setting of the post.</span>
								</div>
							</span>
						</div>
					</div>

					
					
					<div class="common_settings_block_2">
						<label class="option_label" for="site_seo_follow_name">Page Links Follow : <i class="far fa-question-circle" title="( Robots : follow ) - Follow: tells the search engine crawler to follow the links in that webpage."></i></label>
						<div class="settings_seo_radio_container">
							<input id="seo_page_follow_radio" type="radio" name="seo_page_follow" value="follow" <?php echo seoStatus('seo_follow'); ?>>
							<label for="seo_page_follow_radio">Follow</label>
							<input id="seo_page_nofollow_radio" type="radio" name="seo_page_follow" value="nofollow" <?php echo seoStatus('seo_nofollow'); ?>>
							<label for="seo_page_nofollow_radio">No follow</label>
							<span class="x2_popup_container"> <i class="fas fa-exclamation-triangle"></i> Read This
								<div class="x2_popup_block">
									<span class="">if Follow Option is selected then the Crawler will follow all the links from the home page but not for all pages. You can set different rule for different post from Create Post or Edit Post Page. If No follow is selected then the rule will set to all pages including posts pages.</span>
								</div>
							</span>
						</div>
					</div>


					<div class="common_settings_block_2">
						<label class="option_label" for="site_subject">Site Subject : <i class="far fa-question-circle" title=""></i></label>
						<input class="input_2" type="text" id="site_subject" name="site_subject" value="<?php echo settingsSiteSEO('site_subject'); ?>">
					</div>


					<div class="common_settings_block_2">
						<label class="option_label" for="site_keywords">Site Keywords : <i class="far fa-question-circle" title="Your SEO keywords are the keywords and phrases in your web content that make it possible for people to find your site via search engines."></i></label>
						<input class="input_2" type="text" id="site_keywords" name="site_keywords" value="<?php echo settingsSiteSEO('site_keywords'); ?>">
					</div>


					<div class="common_settings_block_2">
						<label class="option_label" for="site_revisit">Site Revisit After : <i class="far fa-question-circle" title="This can tell the spider / crawler to come back to your website and index it again."></i></label>
						<select class="site_seo_select" name="site_revisit_select">
							<option value="1 day" <?php echo seoStatus('seo_revisit_1d'); ?>>Every Day</option>
							<option value="3 days" <?php echo seoStatus('seo_revisit_3d'); ?>>After 3 Days</option>
							<option value="7 days" <?php echo seoStatus('seo_revisit_7d'); ?>>After 7 Days</option>
						</select>
					</div>



					<div class="common_settings_block_2">
						<label class="option_label" for="site_seo_cache">Site Cache : </label>
						<div class="settings_seo_radio_container">
							<input id="seo_cache_enable_radio" type="radio" name="seo_cache" value="cache" <?php echo seoStatus('site_cache_cache'); ?>>
							<label for="seo_cache_enable_radio">Enable</label>
							<input id="seo_cache_disable_radio" type="radio" name="seo_cache" value="no-cache" <?php echo seoStatus('site_cache_nocache'); ?>>
							<label for="seo_cache_disable_radio">Disable</label>
						</div>
					</div>




				</div>
			</section>




			<section class="site_settings_section1">
				<h2 class="site_settings_title_text">Site SEO Settings {For Posts, Tags, Categories}</h2>
				<div class="common_settings_block">



					<div class="common_settings_block_2">
						<label class="option_label" for="site_seo">Posts Page Indexing : </label>
						<div class="settings_seo_radio_container">
							<input id="seo_post_enable_radio" type="radio" name="seo_post_index_option" value="index" <?php echo seoStatus('seo_post_indexing_enable'); ?>>
							<label for="seo_post_enable_radio">Enable</label>
							<input id="seo_post_disable_radio" type="radio" name="seo_post_index_option" value="noindex" <?php echo seoStatus('seo_post_indexing_disable'); ?>>
							<label for="seo_post_disable_radio">Disable</label>
							<span class="x2_popup_container"> <i class="fas fa-exclamation-triangle"></i> Read This
								<div class="x2_popup_block">
									<span class="">If Enable is selected then the SEO will override all rules of posts SEO and this will applied on them.</span>
								</div>
							</span>
						</div>
					</div>



					<div class="common_settings_block_2">
						<label class="option_label" for="site_seo_index_name">Posts Page Links Follow : <i class="far fa-question-circle" title="( Robots : index ) - Index: Tells a search engine to index a page."></i></label>
						<div class="settings_seo_radio_container">
							<input id="seo_post_follow_radio" type="radio" name="seo_post_follow" value="follow" <?php echo seoStatus('post_follow_enable'); ?>>
							<label for="seo_post_follow_radio">Follow</label>
							<input id="seo_post_nofollow_radio" type="radio" name="seo_post_follow" value="nofollow" <?php echo seoStatus('post_follow_disable'); ?>>
							<label for="seo_post_nofollow_radio">No Follow</label>
						</div>
					</div>



					<div class="common_settings_block_2">
						<label class="option_label" for="site_tags_index_name">Tags Page Indexing : <i class="far fa-question-circle" title="Example Page: http://www.example.com/?tag=something"></i></label>
						<div class="settings_seo_radio_container">
							<input id="seo_tags_index_radio" type="radio" name="seo_tags_index" value="index" <?php echo seoStatus('tags_index_enable'); ?>>
							<label for="seo_tags_index_radio">Index</label>
							<input id="seo_tags_noindex_radio" type="radio" name="seo_tags_index" value="noindex" <?php echo seoStatus('tags_index_disable'); ?>>
							<label for="seo_tags_noindex_radio">No Index</label>
						</div>
					</div>



					<div class="common_settings_block_2">
						<label class="option_label" for="site_author_index_name">Author Page Indexing : <i class="far fa-question-circle" title="Example Page: http://www.example.com/?author=someone"></i></label>
						<div class="settings_seo_radio_container">
							<input id="seo_author_index_radio" type="radio" name="seo_author_index" value="index" <?php echo seoStatus('author_index_enable'); ?>>
							<label for="seo_author_index_radio">Index</label>
							<input id="seo_author_noindex_radio" type="radio" name="seo_author_index" value="noindex" <?php echo seoStatus('author_index_disable'); ?>>
							<label for="seo_author_noindex_radio">No Index</label>
						</div>
					</div>




				</div>
			</section>




			<section class="setting_submit_btn_section">
				<input class="setting_page_form_btn5" type="submit" name="form_submit" value="Save">
				<a href="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" class="setting_page_form_btn5">Reset</a>
			</section>
		</form>
	</div>
</div>