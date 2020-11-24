<?php

// this page will work as widget main page

$dir_loc = SITE_URL; // storing the the site root url

$dir_loc .= 'addons/widgets/page_qr_generator/'; // overwriting with full widget path

$text = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>


<div class="sidebar_widget">

	<div class="w_latest_posts">

		<p class="w_widget_title">Page QR Code</p>

		<div class="qr_code_shower" style="max-width: 300px; overflow: hidden; padding: 10px; text-align: center;">

			<img style="width: 70%;" src="<?php echo $dir_loc . 'qr_image.php?page=' . $text; ?>">

		</div>

		<p style="color: red; background: rgba(209, 204, 192,0.5); margin: 4px 2px; padding: 2px 5px; border-radius: 4px;">Scan this QR Code to view this page directly on your device.</p>

	</div>

</div>