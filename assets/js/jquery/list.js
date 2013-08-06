jQuery(document).ready(function($) {
	$('.list .clicky').hover(function(){
		if($(this).attr('href') != ''){
			$(this).css('cursor','pointer');
		}
	});
	$('.list .clicky').click(function(){
		if($(this).attr('href') != ''){
			var datastr = $(this).attr('href');
			window.location.assign(datastr);
		}
	});
});