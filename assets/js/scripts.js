//Utility functions

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

$(document).ready(function($) {
	$('#change_img').click(function(){
		$(this).parents('form').find('.img-upload').toggle();
		$(this).parents('form').find('.img-display').toggle();
	});
	$('.accordion-toggle').click(function(){
		$(this).find('i').removeClass('icon-expand').removeClass('icon-collapse');
		if($(this).hasClass('collapsed')){
			$(this).find('i').addClass('icon-expand');
		} else {
			$(this).find('i').addClass('icon-collapse');
		}
	});
	$('.attachment-delete').click(function(){
		var info = split_to_array($(this).attr('id'),':');
		var $this = $(this);
		$.post("/ajax/unpublish_attachment", {infoArray:info}, function(data){
			if(data){
				$this.parent('li').hide();
			}
		});
	});
	$('.edit #delete_btn').click(function(){
		var myform = $(this).parents('form');
		myform.attr('action',myform.attr('action').replace('edit','delete'));
		myform.submit();
	});
	$('.buy #payment_option_paypal').click(function(){
			$('.payment_info').hide();
			$('#paypal_info').show();
			$('#buyform').attr('action',$('#paypal_action').val());
	});
	$('.buy #payment_option_check').click(function(){
			$('.payment_info').hide();
			$('#check_info').show();
            $('#buyform').attr('action',$('#check_action').val());
	});
});

