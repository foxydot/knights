jQuery(document).ready(function($) {
	$('.userlist .user').hover(function(){
		if($(this).attr('href') != ''){
			$(this).css('cursor','pointer');
		}
	});
	$('.userlist .user').click(function(){
			var datastr = $(this).attr('href');
			window.location.assign(datastr);
		});

});