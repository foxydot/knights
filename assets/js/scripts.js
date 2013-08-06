$(document).ready(function($) {
	$('#change_img').click(function(){
		$(this).parents('form').find('.img-upload').toggle();
		$(this).parents('form').find('.img-display').toggle();
	});
});
