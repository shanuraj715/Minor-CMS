function write_tags_block(){
	var tags = document.getElementById('p_tag_list').value;
	tags = tags.replace(', ', ',');
	tags = tags.replace(' ,',',');
	tags = tags.split(',');
	var tags_len = tags.length;
	var string = "";
	for(index=0; index<tags_len; index++){
		if(tags[index]!=""){
			string = string + '<span class="p_tag">'+tags[index]+'</span>';
		}
	}
	if(tags[0]!=""){
		string = string.replace('&nbsp;','');
		document.getElementById('tag_cloud').innerHTML = string;
	}
	else{
		document.getElementById('tag_cloud').innerHTML = '';
	}
}


function show_add_cat_block(){
	var status = document.getElementById('p_add_cat_block').style.display;
	if(status!='none'){
		document.getElementById('p_add_cat_block').style.display = 'none';
	}
	else{
		document.getElementById('p_add_cat_block').style.display = 'block';
	}
}













/*changing the publish button to publsih or save draft */

function change_publish_btn(){
	var p_status = document.getElementById('post_status_selector').value;
	p_status = p_status.toLowerCase();
	console.log(p_status);
	var btn = document.getElementById('create_p_submit_btn');
	document.getElementById('create_p_submit_btn').value = "";
	if(p_status=='published'){
		document.getElementById('create_p_submit_btn').value = "Publish";
		// btn.value.replace('\&amp;','&');
		// btn.classList.add('fa-upload');
		// btn.classList.remove('fa-save');
	}
	else if(p_status=='draft'){
		document.getElementById('create_p_submit_btn').value = "Save Draft";
		// btn.classList.add('fa-save');
		// btn.classList.remove('fa-upload');
	}
}