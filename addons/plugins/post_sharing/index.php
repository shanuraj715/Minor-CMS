<?php
// if you want to enable the sharing option on other pages then, just put the filename in below array.
$ps_pages = ['post.php', 'userprofile.php']; //array of file names where the sharing button will appear

$file = $_SERVER['SCRIPT_FILENAME']; // getting the current opened filename. this is fetching from the $_SERVER array
$file = explode('/', $file); // exploding the opened file location string from slashes and storing in the array
$file = end($file); // getting the last value of the array. this will return the filename of current opended file
in_array($file, $ps_pages)?shareButton():""; // Ternary Operator (If Else)
function shareButton(){ ?>
	<?php include __DIR__ . '/css.php'; ?>
	<?php include __DIR__ . '/js.php'; ?>
	<div class="ps_post_sharing_container">
		<div class="ps_post_sharing_block">
			<span><i class="fas fa-share-alt"></i> Share</span>
			<a class="ps_share_btn" href="https://www.facebook.com/sharer.php?t=<?php echo THIS_PAGE; ?>&u=<?php echo THIS_PAGE; ?>" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>

			<a class="ps_share_btn" href="whatsapp://send?text=I have shared a link. Visit this now... %0A %0A<?php echo THIS_PAGE; ?>" title="Share on Whatsapp"><i class="fab fa-whatsapp"></i></a>

			<a class="ps_share_btn" href="http://twitter.com/share?text=I have shared a link. Visit this now...%0A&url=<?php echo THIS_PAGE; ?>" title="Share on Twitter"><i class="fab fa-twitter"></i></a>

			<a class="ps_share_btn" href="mailto:?subject=<?php echo SITE_TITLE; ?>&body=i have shared a link with you. Open it now...%0A%0A<?php echo THIS_PAGE; ?>%0A%0A" title="Share via E-mail"><i class="far fa-envelope"></i></a>
		</div>
	</div>
	<?php
} ?>