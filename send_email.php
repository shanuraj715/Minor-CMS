<!-- This is a test page. it is not a part of cms -->
<?php
ob_start();

if(isset($_GET['email']) and !empty($_GET['email'])){
	$email = $_GET['email'];
	sendEmail($email);
}

function sendEmail($to){ //$to is a variable which stores the email id of receiver
	$from = "subscribers@techfacts007.in";
	$message = "Hello!" . 

	 "Thank you for showing interest in our travel packages." . 
	 "We will get back to you shortly with a proper quotation.";


	$subject = "Acknowledgement of your enqury.";
	$headers = "From: $from\n";
	$mail = mail($to, $subject, $message, $headers);
	if($mail){
// 		header('Location: http://localhost/Travel/index.html', true, 307);
        echo "<script>window.open('http://localhost/travel/index.html', '_self');</script>";
		exit();
	}
}
?>