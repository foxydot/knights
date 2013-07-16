jQuery(document).ready(function($) {
	//this goes on the add media page
	$('.media-button').click(function(){
		$('#attachment_type').val($(this).attr('value'));
		$('.media-button').hide();
		$(this).show();
		$('.reset').show();
		if($(this).attr('value')==3){
			$('.embed-url').show();
		} else {
			$('.file-to-upload').show();
			if($(this).attr('value')==2){
				$('.modalquery').hide();
			} else {
				$('.modalquery').show();
			}
		}
	});
	$('.embed-url, .file-to-upload').change(function(){
		$('.submit').show();
	});
	$('.reset').click(function(){
		$('#attachment_type').val('');
		$('.media-button').show();
		$('.reset').hide();
		$('.embed-url').hide();
		$('.file-to-upload').hide();
		$('.submit').hide();
	});
	$('.remove').click(function(){
		var info = split_to_array($(this).attr('id'),':');
		$this = $(this);
		$.post("/ajax/unpublish_attachment", {infoArray:info}, function(data){
			if(data){
				$this.parent('li').hide();
			}
		});
	});
});