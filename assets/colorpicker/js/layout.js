(function($){
	var initLayout = function() {
		var hash = window.location.hash.replace('#', '');
		var currentColorSelector;
		$('.colorSelector').click(function(){
		    currentColorSelector = $(this);
		}).ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
                currentColorSelector.find('div').css('backgroundColor', '#' + hex);
                currentColorSelector.find('input').val('#' + hex);
			}
		});
	};
	
	EYE.register(initLayout, 'init');
})(jQuery)