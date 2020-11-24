<?php
include '../../config.php';
include '../../db_connector.php';

if(isset($_SESSION['username']) and $_SESSION['role']){
	$role = $_SESSION['role'];

	if($role == 'admin'){
		if(isset($_POST['do']) and !empty($_POST['do'])){
			$do = $_POST['do'];
			global $connection;

			if($do == 'insert'){
				$name = mysqli_real_escape_string($connection, $_POST['name']);
				$url = mysqli_real_escape_string($connection, $_POST['url']);

				$sql = "INSERT INTO cms_navigation (title, url, parent, description, new_window) VALUES ('$name', '$url', 0, '', '_self')";
				$query = mysqli_query($connection, $sql);

				if($query){
					echo "success";
				}
				else{
					echo 'Unable to insert the record.';
					echo mysqli_error($connection);
				}
			}
			elseif($do == 'delete'){
				if(isset($_POST['nav_id'])  and is_numeric($_POST['nav_id'])){
					$id = $_POST['nav_id'];
					$sql = "DELETE FROM cms_navigation WHERE id = $id";
					$query = mysqli_query($connection, $sql);

					if($query){
						echo 'success';
					}
					else{
						echo 'Unable to update record.';
					}
				}
			}
		}
	}
}


?>