


function store_cookie_for_comment_id(comment_id){
	document.cookie = "comment_id=" + comment_id;

}

function toggle_comment_box(){
	var status = document.getElementById('comment_container').style.display;
	var toggle_btn = document.getElementById('comment_block_expander');
	if(status=='none'){
		$('#comment_container').show(400);
		toggle_btn.classList.remove('fa-plus');
		toggle_btn.classList.add('fa-minus');
	}
	else{
		$('#comment_container').hide(400);
		toggle_btn.classList.add('fa-plus');
		toggle_btn.classList.remove('fa-minus');
	}
}

$(document).ready(function(){

});


function get_comment_char_len(){
	var str = document.getElementById('p_c_content'); // Text area
	var range_width = document.getElementById('char_range'); //slider
	var str_len = str.value;
	var print_rem_char = document.getElementById('comment_char_count'); // character counter
	var rem_char = 1024 - str_len.length;
	var range = 100 - ((rem_char / 1024) * 100);
	print_rem_char.innerHTML = rem_char + ' Character Left';
	document.getElementById('char_range').style.width = range + '%';
	var rgb_color = green_to_red_clr(range);
	document.getElementById('comment_char_count').style.color = rgb_color;
	range_width.style.background = rgb_color;
}

// Starting functions to generate rgb Colors (Green To Red Via Yellow)
function green_to_red_clr(percent){ // recieve percent value only in integer form
	var r = 255;
	var g = 255;
	var b = 0;
	if(percent<=50 && percent != 0){
		var new_percent = percent * 2;
		var r = (new_percent / 100) * 255;
		// r = 0;
		r = Math.floor(r);
	}
	if(percent==0){
		g = 255;
		r = 0;
	}
	if(percent>50){
		var new_percent = (100 - percent) * 2;
		var g = (new_percent / 100) * 255;
		g = Math.floor(g);
		console.log(g);
	}
		var color = makeColorRGB(r,g,b);
		return color;
}

function makeColorRGB(r,g,b){
	var color = "rgb(" + r + ',' + g + ',' + b + ")";
	console.log("Color = " + color);
	return color;
}