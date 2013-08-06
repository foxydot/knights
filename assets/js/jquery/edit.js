jQuery(document).ready(function($) {
	//this goes on the project edit page
	initialize();
	$("body").on("click",".ui-widget-overlay",function() {
	     $('#dialog').modal( "close" );
	     $('#dialog2').modal( "close" );
	     $('#dialog3').modal( "close" );
	     $('#dialog4').modal( "close" );
	});
	$('.quote_ribbon_holder .wrapper .handle').css('height', function(){
		$height = $(this).siblings('.content').height();
		return $height + 'px';
	}).css('background-size','30px 100%');
});
function initialize(){
	$('.plus').unbind('click');
	$('.remove').unbind('click');
	$('.plus').click(function(){
		$('.plus').unbind('click');
		add_subsection($(this));
	});
	$('.subsections').sortable({
			placeholder: "placeholder",
			forcePlaceholderSize: true,
			//connectWith: '.subsections',
			items: '.subsection, .quote_ribbon_holder',
			handle: 'h6.version, .handle',
			cursorAt: {top:12,left:12},
			update: function(event,ui){
				console.log(ui);
			var info = new Object();
				// first, capture the original position of hte dragged element
				info.story_id = $('#main').attr('class').match(/\d+/gi);
				info.story_section = ui.item.context.parentElement.attributes[0].childNodes[0].wholeText.match(/\d+/gi);
				if(ui.item[0].attributes[1].childNodes[0].wholeText.match(/quote/gi)){
					info.quote_id = ui.item[0].attributes[1].childNodes[0].wholeText.match(/\d+/gi);
				} else {
					info.story_subsection = ui.item[0].attributes[1].childNodes[0].wholeText.match(/\d+/gi);
				}
				info.neworder = $(this).sortable('toArray');
				// renumber the dragged item based on the position it was dragged to
				// renumber all the items below it until we get to the original position (not beyond)
				$.post("/ajax/renumber_for_drag",{infoArray:info}, function(data){
					// now do the same thing with jquery to effect the display
					if(!ui.item[0].attributes[1].childNodes[0].wholeText.match(/quote/gi)){
						$('.section'+info.story_section+'.subsections .subsection').each(function(){
						var $this = $(this);
						$this.find('h6.version').text(info.story_section+'.'+($this.prevAll().length + 1));
						});
					}
				});
			}
	});
	$('.remove').click(function(){
		var info = split_to_array($(this).attr('id'),':');
		unpublish_section(info);
		if($(this).closest('.subsection').length == 0){
			$(this).closest('.section').hide();
		} else {
			$(this).closest('.subsection').hide();
		}
	});
	$('.textedit').click(function(){
		var datastr = $(this).attr('id');
		$('#dialog').data('datastr', datastr);
		$('#dialog').modal('open');
	        return false;
	    });
	
	    $('#dialog').modal({
	        show: false,
	        title: "Edit Content",
	        resizeable: true,
	        modal: true,
	        position: 'center',
	        height: 400,
	        width: 600,
	        close: function() { location.reload(); },
	        open: function () {
	            $(this).load('/admin/textedit/' + $(this).data('datastr'));
	        }
	    });
	$('.media').click(function(){
		var datastr = $(this).attr('id');
		$('#dialog2').data('datastr', datastr);
		$('#dialog2').modal('open');
	        return false;
	    }).hover().css('cursor','pointer');
	
	    $('#dialog2').modal({
	        show: false,
	        title: "Add Media",
	        resizeable: true,
	        modal: true,
	        position: 'center',
	        height: 400,
	        width: 500,
	        close: function() { initialize(); },
	        open: function () {
	            $(this).load('/admin/upload/' + $(this).data('datastr'));
	        }
	    });
	$('.quote_ribbon').click(function(){
		var datastr = $(this).attr('id');
		$('#dialog3').data('datastr', datastr);
		$('#dialog3').modal('open');
	        return false;
	    });
	
	    $('#dialog3').modal({
	        show: false,
	        resizeable: true,
	        modal: true,
	        position: 'center',
	        height: 400,
	        width: 500,
	        close: function() { initialize(); },
	        open: function () {
	            $(this).load('/admin/quote_ribbon/' + $(this).data('datastr'));
	        }
	    });
	$('.quote_ribbon_holder .delete').click(function(){
		var quote_id = $(this).parent().parent().attr('id').match(/\d+/gi);
		$.post("/ajax/unpublish_quote", {quote_id:quote_id}, function(data){
		});
		$(this).parent().parent().hide();
	});
	$('.story_settings').click(function(){
		var datastr = $(this).attr('id');
		$('#dialog4').data('datastr', datastr);
		$('#dialog4').modal('open');
	        return false;
	    }).hover().css('cursor','pointer');
	
	    $('#dialog4').modal({
	        show: false,
	        title: "Edit Project Information",
	        resizeable: true,
	        modal: true,
	        position: 'center',
	        height: 400,
	        width: 500,
	        close: function() { initialize(); },
	        open: function () {
	            $(this).load('/admin/edit_story/' + $(this).data('datastr'));
	        }
	    });
	$('.add-section').click(function(){
		add_section($(this));
		});
}

function unpublish_section(info){
	$.post("/ajax/unpublish_subsection", {infoArray:info}, function(data){});
	//renumber down (-1)
	renumber_down(info);
}
