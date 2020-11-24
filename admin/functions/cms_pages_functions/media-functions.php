<?php

function mediaHeaderData(){
	$dir = SITE_DIR;
	$dir .= 'uploads/';
	$total_media = 0;
	$files = glob($dir . '*');
	// $image_types = imageExtensionTypes();
	foreach ($files as $key => $value) {
		$extension = explode('.', $value);
		$extension = end($extension);
		$extension = strtolower($extension);
		// if(isset($image_types[$extension])){
			$total_media++;
		// }
	}
	return $total_media;
}

function mediaUploader(){ ?>
	<div class="media_uploader_container">
		<p class="upload_media_text">Upload Media</p>

		<div class="upload_media_block">
			<div class="uploader_block" id="uploader_block">
				<span class="upload_media_span">Choose File</span>
				<input type="file" class="upload_media_input" id="upload_media_input">
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$('[id="upload_media_input"').change(function(){
					if($(this).val() != ""){
						const media = $(this);
						console.log("Object Catched");
						uploadMedia(media);
					}
				});

				function uploadMedia(media){
					console.log("uploadMedia Called");
					$.ajax({
						type: 'POST',
						url: "<?php echo SITE_URL . 'admin/extra_files/media-uploader-ajax.php';?>",
						data: new FormData(this),
						dataType: 'json',
						contentType: false,
						cache: false,
						processData: false,
						beforeSend: function(){
							console.log("Before Send");
						},
						success: function(message){
							console.log(message);
						}
					});
				}
			});
		</script>
	</div>
	<?php
}

function allMediaFiles(){
	$dir = SITE_DIR;
	$dir .= 'uploads/';
	$total_media = 0;
	$files = glob($dir . '*');
	foreach ($files as $key => $value) {
		$extension = explode('.', $value);
		$extension = end($extension);
		$extension = strtolower($extension);
		$extension_logo = extensionLogo($extension);
		$image = explode('/', $value);


		/* for file date */

		$image = end($image);
		$file = $dir . $image;
		$file_date = date('d-m-Y', filemtime($file));
		/* closing scripts for file date */


		if($extension_logo == 'image'){
			$image_path = SITE_URL . 'uploads/' . $image;
		}
		else{
			$image_path = SITE_URL . 'images/all/' . $extension_logo;
		} ?>
		<div class="media_box" file_name="<?php echo $image; ?>">
			<div class="media_image_block">
				<img class="media_image" src="<?php echo $image_path;?>">
			</div>
			<div class="media_details_block">
				<a id="media_name" href="<?php echo SITE_URL . 'admin/extra_files/media-preview.php?file=' . $image;?>" title="Click here for preview." class="media_name"><?php echo $image; ?></a>
				<p class="media_date"><?php echo $file_date; ?></p>
				<div class="media_box_options_block">
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=media&do=rename&file=' . $image; ?>" class="media_rename">Rename</a>
					<a href="<?php echo SITE_URL . 'admin/dashboard.php?page=media&do=delete&file=' . $image; ?>" class="media_delete">Delete</a>
				</div>
			</div>
		</div>
		<?php
	}
}

function extensionLogo( $extension ){
	$image = array('png', 'jpg', 'jpeg', 'gif', 'bmp');

	$audio = array('mp3', 'aac', 'wav', 'ogg');

	$video = array('mp4', 'mkv', 'avi', 'voc', '3gp', '3gpp');

	$document = array('doc', 'docx');

	if(in_array($extension, $image)){
		return 'image';
	}
	else{
		if(in_array($extension, $audio)){
			return 'audio.png';
		}
		elseif(in_array($extension, $video)){
			return 'video.png';
		}
		elseif(in_array($extension, $document)){
			return 'document.png';
		}
		else{
			return 'unknown.png';
		}
	}
}

// function imageExtensionTypes(){
// 	$type = array(
// 		'png' => 'image',
// 		'jpg' => 'image',
// 		'jpeg' => 'image',
// 		'gif' => 'image',
// 		'bmp' => 'image'
// 	);
// 	return $type;
// }

function mediaPopup($do, $file){
	$file_address = SITE_DIR . 'uploads/' . $file;
	if(file_exists($file_address)){
		if($do == 'rename'){
			mediaRename($file);
		}
		elseif($do == 'delete'){
			mediaDelete($file);
		}
	}
	else{
		showErrorWindow("Error!!!", "File does not exists on the server. Try another file.");
	}
}

function mediaRename($file){ ?>
	<div class="media_popup_container">
		<div class="media_popup_subcontainer">
			<div class="media_popup_header">
				<p class="media_popup_head_title">Rename File</p>
				<i id="media_popup_close_btn" class="media_popup_close_btn fas fa-times"></i>
			</div>
			<div class="media_popup_block">
				<div class="file_preview">
					<?php filePreview($file); ?>
				</div>
				<div class="media_file_opaeration_block">
					<input type="text" name="file_name" class="media_popup_rename_input" value="<?php echo $file; ?>">
					<button class="rename_button">Go <i class="fas fa-arrow-alt-circle-right"></i></button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('.rename_button').click(function(){
			let old_file_name = "<?php echo $_GET['file'];?>";
			let input_value = $('.media_popup_rename_input').val();
			console.log(input_value);
			$.post("<?php echo SITE_URL . 'admin/extra_files/media-manager-ajax.php';?>",
			{
				old_file_name: old_file_name,
				new_file_name: input_value,
				do: "rename_status"
			},
			function(data, status){
				if(data == 'not_available'){
					alert("File already exists on the server. Overwriting not allowed. Please use a different name.");
				}
				else if(data == 'rename_successfull'){
					alert("File successfully renamed.");
					window.open("<?php echo SITE_URL . 'admin/dashboard.php?page=media';?>", "_self");
				}
			});
		});
	</script>
<?php
}

function mediaDelete($file){?>
	<div class="media_popup_container">
		<div class="media_popup_subcontainer">
			<div class="media_popup_header popup_delete_background">
				<p class="media_popup_head_title">Delete File</p>
				<i id="media_popup_close_btn" class="media_popup_close_btn fas fa-times"></i>
			</div>
			<div class="media_popup_block">
				<div class="file_preview">
					<?php filePreview($file); ?>
				</div>
				<div class="media_file_opaeration_block">
					<button class="delete_button" value="yes">Yes <i class="fas fa-check"></i></button>
					<button class="delete_button" value="no">No <i class="fas fa-times"></i></button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('.delete_button').click(function(){
			if($(this).val() == 'yes'){
				let new_file_name = "<?php echo $_GET['file']; ?>";
				$.post("<?php echo SITE_URL . 'admin/extra_files/media-manager-ajax.php';?>",
				{
					new_file_name: new_file_name,
					do: "delete_status"
				},
				function(data, status){
					if(data == 'delete_unsuccessfull'){
						alert("Unable to delete the file. The file does not exist on the server or there may be any error in the execution of the code.");
					}
					else if(data == 'delete_successfull'){
						alert("File successfully deleted.");
						window.open("<?php echo SITE_URL . 'admin/dashboard.php?page=media';?>", "_self");
					}
					else{
						alert("ERROR");
					}
				});
			}

			else if($(this).val() == 'no'){
				window.open("<?php echo SITE_URL . 'admin/dashboard.php?page=media';?>", "_self");
			}
			else{
				window.open("<?php echo SITE_URL . 'admin/dashboard.php?page=media';?>", "_self");
			}
		});
	</script>
<?php
}

function filePreview($file){
	$file_ext = explode('.', $file);
	$file_ext = end($file_ext);
	$file_image = extensionLogo( $file_ext );
	if($file_image == 'image'){ ?>
		<img class="media_popup_img" href="<?php echo SITE_URL . 'uploads/' . $file;?>" src="<?php echo SITE_URL . 'uploads/' . $file;?>">
		<?php 
	}
	else{

	}
}

?>