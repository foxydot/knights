jQuery(document).ready(function($) {
	$('.stripe:first-child,fieldset input:first-child').addClass('first-child');
	$('.stripe:last-child,fieldset input:last-child').addClass('last-child');
	$('.stripe:nth-child(even),fieldset input:nth-child(even)').addClass('even');
	$('.stripe:nth-child(odd),fieldset input:nth-child(odd)').addClass('odd');
});

function suggest(inputString, field){
	if(inputString.length == 0) {
		$('#suggestions').fadeOut();
	} else {
	$('#' + field).addClass('load');
		$.post("/ajax/autosuggest", {queryString: ""+inputString+""}, function(data){
			if(data.length >0) {
				$('#suggestions').fadeIn();
				$('#suggestionsList').html(data);
				$('#suggestionsList li').click(function(){
					fill($(this).html(),$(this).parents('.suggestionWrap').children('input').attr('id'));
				});
				$('#' + field).removeClass('load');
			}
		});
	}
}

function fill(thisValue, field) {
	$('#' + field).val(thisValue);
	setTimeout("$('#suggestions').fadeOut();", 600);
}

function get_project_id(inputString,field){
	$.post("/ajax/get_project_id", {queryString: ""+inputString+""}, function(data){
		if(data.length >0) {
			$(field).val(data);
		}
	});
}

function archive_story(id){
	$.post("/ajax/archive_story", {queryString: ""+id+""}, function(data){});
}
function unarchive_story(id){
	$.post("/ajax/unarchive_story", {queryString: ""+id+""}, function(data){});
}
function publish_story(id){
	$.post("/ajax/publish_story", {queryString: ""+id+""}, function(data){});
}
function unpublish_story(id){
	$.post("/ajax/unpublish_story", {queryString: ""+id+""}, function(data){});
}

function split_to_array(str,delim){
	var splitstr = str.split(delim);
	var key = new Array();
	var val = new Array();

	for(i=0;i<splitstr.length;i++){
		if(i%2==0){
			key[i/2] = splitstr[i];
		} else {
			val[Math.floor(i/2)] = splitstr[i];
		}
	}
	return array_combine(key,val);
}

function array_combine (keys, values) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: array_combine([0,1,2], ['kevin','van','zonneveld']);
    // *     returns 1: {0: 'kevin', 1: 'van', 2: 'zonneveld'}
    var new_array = {},
        keycount = keys && keys.length,
        i = 0;

    // input sanitation
    if (typeof keys !== 'object' || typeof values !== 'object' || // Only accept arrays or array-like objects
    typeof keycount !== 'number' || typeof values.length !== 'number' || !keycount) { // Require arrays to have a count
        return false;
    }

    // number of elements does not match
    if (keycount != values.length) {
        return false;
    }

    for (i = 0; i < keycount; i++) {
        new_array[keys[i]] = values[i];
    }

    return new_array;
}