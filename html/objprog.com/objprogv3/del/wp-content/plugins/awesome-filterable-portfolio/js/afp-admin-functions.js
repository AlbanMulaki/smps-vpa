/* MEDIA UPLOADER */
jQuery(document).ready(function($){
	var which_one = 0;
	$('#thumbnail').click(function() {
		which_one = 1;
		tb_show('Upload a thumbnail', 'media-upload.php?referer=afp_add_new_portfolio_item&amp;type=image&amp;TB_iframe=true&amp;post_id=0', false);
		return false;
	});
	
	$('#image').click(function() {
		which_one = 2;
		tb_show('Upload an image', 'media-upload.php?referer=afp_add_new_portfolio_item&amp;type=image&amp;TB_iframe=true&amp;post_id=0', false);
		return false;
	});
	
	window.send_to_editor = function(selectedImg) {
		var startIndex = selectedImg.indexOf('"')+1;
		var endIndex = selectedImg.indexOf('"', startIndex);
		var image_url = selectedImg.substring(startIndex, endIndex);
		if(which_one == 1){
			$('#thumbnail_adr').val(image_url);
		}else{
			$('#image_adr').val(image_url);
		}
		tb_remove();
		
	}
});


/* DATEPICKER */
jQuery(document).ready(function($){
	$('#date').datepicker({ showAnim: 'fadeIn' });
});