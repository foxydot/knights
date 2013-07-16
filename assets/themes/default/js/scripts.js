$(document).ready(function($) {
	$('.stripe:first-child,fieldset input:first-child').addClass('first-child');
	$('.stripe:last-child,fieldset input:last-child').addClass('last-child');
	$('.stripe:nth-child(even),fieldset input:nth-child(even)').addClass('even');
	$('.stripe:nth-child(odd),fieldset input:nth-child(odd)').addClass('odd');
});
