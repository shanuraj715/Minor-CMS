<?php

$file = $_SERVER["SCRIPT_FILENAME"]; // getting the full address with filename

$file_name = explode('/', $file); // breaking the address from every slash and storing as an array

$file_name = $file_name[count($file_name) - 1]; // getting the file name.

if($file_name == 'login.php'){ // Plugin only work for login page. all plugins will load for all pages. we have to manually tell the plugins that where they have to do some work.
?>
	<script type="text/javascript"> //Javascript
	$(document).ready(function(){
		$('#username_input').keyup(function(){ // 
			checkUsername(); // calling a function to check username from the database
		});

		function checkUsername(){
			var s = $('#username_input').val();
			$.ajax({
				url:'<?php echo SITE_URL . "addons/plugins/login_username_checker/Get-Data.php";?>',
				data:'username='+s,
				success:function(data){
					var text = data;
					if(text == 'true'){
						$('#username_icon').addClass('fa-check');
						$('#username_icon').removeClass('fa-user');
					}
					else if(text == 'false'){
						$('#username_icon').addClass('fa-user');
						$('#username_icon').removeClass('fa-check');
					}
				}
			});
		};
	});
	</script>
	<?php
}
?>