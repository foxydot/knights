jQuery(document).ready(function($) {
	//this goes on the add project page
	$('.datepicker').datepicker();
	$('.suggest').attr('autocomplete','off');
	$('.suggest').wrap('<div class="suggestionWrap">');
	$('.suggest').after('<div id="suggestions" class="suggestionsBox" style="display: none;"><div id="suggestionsList" class="suggestionList"></div></div>');
	$('.suggest').keyup(function(){
		$('#project_id').val('');
		suggest($(this).val(),$(this).attr('id'));
	});
	$('.suggest').blur(function(){
		var field = $(this).attr('id');
		$('#' + field).removeClass('load');
		setTimeout("$('#" + field + "').siblings('#suggestions').fadeOut();", 10);
	});
});