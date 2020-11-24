<?php
	
	$file = $_SERVER['SCRIPT_FILENAME'];

	$file = explode('/', $file);

	$file1 = $file[count($file) - 1];
	
	if($file1 == 'login.php' or $file1 == 'signup.php'){

		$val1 = rand(100,599);

		$operator = rand(1,20);

		$operator = $operator % 2;

		if($operator == 0){
			$operator = '+';
		}
		else{
			$operator = '-';
		}

		$val2 = rand(0,20);

		$_SESSION["captcha_answer"] = $val1 . $operator . $val2;

		$val1 = (($val1 +5) * 6) / 3;

		$val2 = (($val2 +5) * 6) / 3;

		math_captcha_for_login($val1, $val2, $operator);

	}

function math_captcha_for_login($val1, $val2, $operator){

	$file = SITE_URL; ?>

	<script type="text/javascript">
		$(document).ready(function(){ // this is written because our all plugin functions called when the page is loading. so javascript and jquery execute the function but if the element is not loaded till now. the function will not work

			var text = '<div style="display: flex; margin-top: 5px;">';
			text += '<i style="padding: 0 2px; line-height: 28px;" class="fas fa-lock"></i>';
			text += '<img src="<?php echo $file;?>addons/plugins/math_captcha_for_login_signup/generate_captcha.php?val1=<?php echo $val1;?>&val2=<?php echo $val2;?>&op=<?php echo $operator; ?>" style="border-radius: 6px; filter: grayscale(100%); padding: 0 2px; margin: 0 10px; max-height: 30px; height: 30px; min-height:30px;">';
			text += '<input id="math_captcha_input" type="text" style="font-size: 18px; line-height: 22px; width: 200px;" name="captcha" required="required">';
			text += '<span id="math_captcha_submit_btn" style="min-width: 80px; text-align: center; margin: 0 5px; background: #c0392b; border: solid 2px #2980b9; outline: none; border-radius: 5px; color: white; padding: 0 10px; cursor: pointer;">Verify</span>';
			text += '</div>';



			var block = $("#cms_form_submit_button_container");
			var button = block.html(); // getting the input button
			

			block.html(""); // removing the submit button
			
			$('#more_options_by_plugins').html(text);

			$("#math_captcha_submit_btn").click(function(){

				var input_box_val = $("#math_captcha_input").val();

				if(input_box_val != ""){
					if(input_box_val == <?php echo $_SESSION['captcha_answer']; ?>){
						block.html(button);
						$("#math_captcha_submit_btn").html("Verified");
						$("#math_captcha_submit_btn").css("background" , "#27ae60");
					}
					else{
						alert("Captcha Code Incorrect");
						location.reload();
					}
				}
				else{
					alert("Please Fill Captcha Code.");
				}

			});
		});

	</script>

	<?php

}

?>