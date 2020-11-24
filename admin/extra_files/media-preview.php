<?php

include '../../config.php'; ?>
<style type="text/css">
	*{
		background-color: white;
	}
</style>
<?php
if(isset($_GET['file']) and !empty($_GET['file'])){
	$file_name = $_GET['file'];
	$file_loc = SITE_DIR . 'uploads/' . $file_name;
	if(file_exists($file_loc)){
		$file_extension = explode('.', $file_name);
		$file_extension = end($file_extension);
		if($file_extension == 'png' or $file_extension == 'jpg' or $file_extension == 'jpeg' or $file_extension == 'bmp' or $file_extension == 'gif'){ ?>
			<div class="img_32" style="width: 100%; height: 100%; overflow-x: hidden; overflow-y: auto; max-width: 100%; max-height: 100%;">
				<style type="text/css">
					.file_details_32 p{
						margin: 4px 0;
					}		
				</style>
				<img style="max-width: 100%; max-height: 100%;" src="<?php echo SITE_URL . 'uploads/' . $file_name; ?>">
				<div class="file_details_32">
					<p>File Name : <?php echo $file_name;?></p>
					<p>File Path : <?php echo SITE_URL . 'uploads/' . $file_name;?></p>
					<p>Created Date : <?php echo date('d-m-Y', filectime($file_loc));?></p>
					<p>Modified Date : <?php echo date('d-m-Y', filemtime($file_loc));?></p>
				</div>
			</div>
			<?php
		}
		elseif($file_extension == 'mp3' or $file_extension == 'wav' or $file_extension == 'amr' or $file_extension == 'm4a'){ ?>
			<div class="media_audio_prev">
				<style type="text/css">
					.file_details_32 p{
						margin: 4px 0;
					}		
				</style>
				<audio style="min-width: calc(100% - 30px); padding: 5px 15px; outline: none; background-color: #2980b9; border-radius: 10px;" controls>
					<source src="<?php echo SITE_URL . 'uploads/' . $file_name;?>" type="audio/<?php echo $file_extension;?>">
				</audio>
				<div class="file_details_32">
					<p>File Name : <?php echo $file_name;?></p>
					<p>File Path : <?php echo SITE_URL . 'uploads/' . $file_name;?></p>
					<p>Created Date : <?php echo date('d-m-Y', filectime($file_loc));?></p>
					<p>Modified Date : <?php echo date('d-m-Y', filemtime($file_loc));?></p>
				</div>
			</div>
			<?php
		}

		elseif($file_extension == 'mkv' or $file_extension == '3gp' or $file_extension == 'mp4' or $file_extension == 'avi'){ ?>

			<div class="media_audio_prev" style="max-width: 100%;">
				<style type="text/css">
					.file_details_32 p{
						margin: 4px 0;
					}		
				</style>
				<video style="width: calc(100% - 30px); padding: 5px 15px; outline: none; background-color: #2980b9; border-radius: 10px;" controls>
					<source src="<?php echo SITE_URL . 'uploads/' . $file_name;?>" type="video/<?php echo $file_extension;?>">
				</video>
				<div class="file_details_32">
					<p>File Name : <?php echo $file_name;?></p>
					<p>File Path : <?php echo SITE_URL . 'uploads/' . $file_name;?></p>
					<p>Created Date : <?php echo date('d-m-Y', filectime($file_loc));?></p>
					<p>Modified Date : <?php echo date('d-m-Y', filemtime($file_loc));?></p>
				</div>
			</div>
			<?php
		}
		else{ ?>
			<p style="text-align: center; font-family: monospace; text-transform: uppercase; color: red; font-size: 22px;">Unsupported File</p>
			<p style="font-family: monospace; font-size: 16px; ">The File format is not supported. Unable to create a preview of this file.</p>
		<?php
		}
	}
	else{

	}
}

?>