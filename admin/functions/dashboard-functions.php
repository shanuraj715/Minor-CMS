<?php

/* pageForUser -- this is a function that is created for every single page that can include on dashboard.php (Like settings.php, create-post.php, users.php). this function will prevent the page from loading for an unauthorized user.

The function can only take one parameter. and the parameter should be in a string data type. example

pageForUser('admin');
pageForUser('admin,author');
pageForUser('admin, author, subscriber');

multiple values can be seperated by using comma (,). if any page is restricted to any user role (ex: admin) then we can use this function like pageForUser('admin');

*/

function pageForUser($user){
	$user = str_replace(' ', '', $user); // removing white spaces
	$role = $_SESSION['role']; // getting the loggedin user role by super global variable
	$user_list = []; // initializing an empty array
	array_push($user_list, $user); // inserting the parameter in the array
	$user_list = explode(',', $user); // exploding the string from comma so we can get the roles of the user that was came from the function parameter
	foreach ($user_list as $key => $value) {
		if ($role == $value) {
			$flag = true; // if role exists in the array setting flag variable as true
			break; // closing the loop (foreach)
		}
		else{
			$flag = false;
		}
	}
	if($flag == false){
		notAvailableAtThisTime();
		exit();
	}
}

?>