<?php
include_once '../../config.php';

// following page is included because we need a function getImageName(). this function will help us to change the file name to a random name.
include_once DASHBOARD_PAGE_ADDR . 'functions/cms_pages_functions/create_post_functions.php';

$uploadDir = SITE_DIR . 'uploads/'; 
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
$uploadStatus = 0;
 
// If form is submitted 
if(isset($_POST['file'])){ 
	if(!empty($_FILES["file"]["name"])){ 

		// File path config 
		$fileName = basename($_FILES["file"]["name"]); 
		$targetFilePath = $uploadDir . $fileName; 
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

		// Allow certain file formats 
		$allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'); 
		if(in_array($fileType, $allowTypes)){ 
			// Upload file to the server 
			if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
				$uploadedFile = $fileName; 
			}else{ 
				$uploadStatus = 0; 
				$response['message'] = 'Sorry, there was an error uploading your file.'; 
			} 
		}else{ 
			$uploadStatus = 0; 
			$response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.'; 
		}
	} 
} 

if($uploadStatus == 1){
	$response['status'] = 1; 
	$response['message'] = 'Form data submitted successfully!'; 
}  
 
// Return response 
echo json_encode($response);

?>