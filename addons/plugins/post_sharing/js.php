<script type="text/javascript">
	$(document).ready(function(){
		let document_height = $(document).height();
		if(document_height <= 740){
			$('.ps_post_sharing_container').show();
		}
		else{
			$('.ps_post_sharing_container').hide();
		}
		$(document).scroll(function(){
			let document_height = $(document).height();
			if($(document).scrollTop() >= 740){
				$('.ps_post_sharing_container').show(300);
				// console.log($(document).scrollTop());
			}
			else{
				if(document_height <= 740){
					$('.ps_post_sharing_container').show(300);
					// console.log($(document).scrollTop());
				}
				else{
					$('.ps_post_sharing_container').hide(300);
					// console.log($(document).scrollTop());
				}
			}
		});
	});
</script>