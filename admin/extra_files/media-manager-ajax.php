<?php
// this page is a part of media page that is available in the included_files directory. (file name: media.php)
// ajax request page handler. this page will use by ajax call. 

include '../../config.php';
include SITE_DIR . 'db_connector.php';
if(!isset($_SESSION['username']) and !isset($_SESSION['role'])){
	header("HTTP/1.0 500 Internal Server Error");
	exit();
}

if(isset($_POST['do']) and !empty($_POST['do'])){
	if(isset($_POST['new_file_name']) and !empty($_POST['new_file_name'])){
		$do = $_POST['do'];
		if($do == 'rename_status'){
			$old_file_name = $_POST['old_file_name'];
			$new_file_name = $_POST['new_file_name'];

			$image_dir = SITE_DIR . 'uploads/';
			$file_loc = $image_dir . $new_file_name;

			$old_file_loc = $image_dir . $old_file_name;
			$new_file_loc = $image_dir . $new_file_name;

			if(file_exists($file_loc)){
				echo "not_available";
			}
			else{
				$rename_status = rename($old_file_loc, $new_file_loc);
				if($rename_status){
					$sql = "UPDATE posts SET post_image = '$new_file_name' WHERE post_image = '$old_file_name'";
					$query = mysqli_query($connection, $sql);
					if($query){
						echo "rename_successfull";
					}
				}
			}
			exit();
		}


		elseif($do == 'delete_status'){
			$file = $_POST['new_file_name'];
			$file_loc = SITE_DIR . 'uploads/' . $file;
			$delete_status = unlink($file_loc);
			if($delete_status){
				echo "delete_successfull";
			}
			else{
				echo "delete_unsuccessfull";
			}
		}


		else{

		}
	}
}
else{
	
}

?>