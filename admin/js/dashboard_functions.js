var tooltip = document.querySelectorAll('.hover_popup');

document.addEventListener('mousemove', fn, false);

function fn(e) {
    for (var i=tooltip.length; i--;) {
        tooltip[i].style.left = e.pageX + 5 + 'px';
        tooltip[i].style.top = e.pageY + 20 + 'px';
    }
}

function expand_p_sidebar_option(id,arrow_id){
	var expand_status = document.getElementById(id).style.display;
	if(expand_status!='none'){
		document.getElementById(id).style.display = 'none';
		document.getElementById(arrow_id).style.transform = 'rotateZ(0deg)';
		document.getElementById(arrow_id).style.color = 'white';
	}
	else{
		document.getElementById(id).style.display = 'block';
		document.getElementById(arrow_id).style.transform = 'rotateZ(180deg)';
		document.getElementById(arrow_id).style.color = 'rgba(44, 62, 80,1.0)';
	}
}


/* Editor Sidebar feature image upload functions */


function show_image(){
	var src = document.getElementById("image_selector");
	var target = document.getElementById("feature_image_shower");
	showImage(src, target);
}

function showImage(src, target) {
	var fr = new FileReader();
	fr.onload = function(){
		target.src = fr.result;
	}
	if(src.value!=""){
		document.getElementById('feature_img_image_block').style.display = 'block';
		document.getElementById('remove_fi_btn').style.display = 'block';
		fr.readAsDataURL(src.files[0]);
	}
	else{
		document.getElementById('feature_img_image_block').style.display = 'none';
		target.src = "";
		document.getElementById('remove_fi_btn').style.display = 'none';
	}
}

function remove_featured_image(){
	var src = document.getElementById("image_selector");
	var target = document.getElementById("feature_image_shower");
	src.value = "";
	target.src = "";
	document.getElementById('remove_fi_btn').style.display = 'none';
	document.getElementById('feature_img_image_block').style.display = 'none';
}


/* dashboard page idle task */
idleDashboard();
function idleDashboard(){
	let time = 1; // timer will start from this value
	let logout_time = 1800; // in seconds
	let show_logout_prompt_time = 20; // in seconds (example if value is 5 then prompt will show before 5 seconds of logout)
	let prompt_time = (logout_time - show_logout_prompt_time);
	$(document).ready(function(){ // when page completely loaded
		timer = setInterval(function(){
			time++;
			checkTimeForLogout()
		}, 1000); // timer will increament on every 1000 milliseconds
	});

	$(document).bind('click keypress', function(){
		hidePrompter(); // on click hidePrompter() function will call
		stopInterval();
		timer = setInterval(function(){
			time++;
			checkTimeForLogout()
		}, 1000); // timer will increament on every 1000 milliseconds
	});

	function stopInterval(){ clearInterval(timer); time = 1; } // resetting the timer 
	function checkTimeForLogout(){ time >= logout_time ? logOutUser() : ""; logoutPrompter(); }

	function logOutUser(){
		let logout_page_address = "./logout.php"; // open when timer reach the limit
		window.open(logout_page_address, "_self");
	}

	function logoutPrompter(){
		if(time >= prompt_time){
			let remaining_time = logout_time - time;
			$('.logout_prompter_text').html('You will be logout in <strong>[' + remaining_time + ']</strong> seconds. Click anywhere to cancel.');
			$('.logout_prompter').css('background', '#ea8685');
			$('.logout_prompter').show(700);
		}
	}

	function hidePrompter(){
		$('.logout_prompter').css('background', '#20bf6b');
		$('.logout_prompter_text').html('Logout Cancel');
		setTimeout(function(){ $('.logout_prompter').hide(700); }, 3000);
	}
}

