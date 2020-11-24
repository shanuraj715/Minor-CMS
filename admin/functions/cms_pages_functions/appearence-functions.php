<?php

function appearenceHeader(){
	$valid_actions = ['navigation', 'more-opt'];
	if(in_array($_GET['action'], $valid_actions)){ ?>
		<div class="app_head_cont">
			<ul class="app_head_ul">
				<li class="app_head_li" btn_id="navigation"><a href="<?php echo SITE_URL . 'admin/dashboard.php?page=appearence&action=navigation';?>">Navigation</a></li>
				<li class="app_head_li" btn_id="more-opt"><a href="<?php echo SITE_URL . 'admin/dashboard.php?page=appearence&action=more-opt';?>">More Options</a></li>
			</ul>
		</div>
	<?php
	}
	else{
		admin404();
		exit();
	}
}
?>