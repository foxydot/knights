jQuery(document).ready(function($) {
	var timer = 100; //timeout length in ms
	//these go on the project list page
	$('.story').hover(function(){
		if($(this).attr('href') != ''){
			$(this).css('cursor','pointer');
		}
	});
	$('.story').click(function(){
		window.location = $(this).attr('href');
	});
	$('.archive_link').click(function(){
		$('.story').unbind('click');
		archive_story($(this).attr('name'));
		setTimeout(function() {window.location.reload();},timer);
	});
	$('.unarchive_link').click(function(){
		$('.story').unbind('click');
		unarchive_story($(this).attr('name'));
		setTimeout(function() {window.location.reload();},timer);
	});
	$('.publish_link').click(function(){
		$('.story').unbind('click');
		publish_story($(this).attr('name'));
		setTimeout(function() {window.location.reload();},timer);
	});
	$('.unpublish_link').click(function(){
		$('.story').unbind('click');
		unpublish_story($(this).attr('name'));
		setTimeout(function() {window.location.reload();},timer);
	});

	$('#footer .addproject').click(function(){
			$('#dialog').modal('open');
		        return false;
		    });
		
		    $('#dialog').modal({
		        show: false,
		        title: "Add Project Information",
		        resizeable: true,
		        modal: true,
		        position: 'center',
		        height: 400,
		        width: 500,
		        open: function () {
		            $(this).load('/admin/add');
		        }
		});	

	$('#footer .edituser').click(function(){
			var datastr = $(this).attr('id');
			$('#dialog2').data('datastr', datastr);
			$('#dialog2').modal('open');
		        return false;
		    });
		
		    $('#dialog2').modal({
		        show: false,
		        title: "Edit User Information",
		        resizeable: true,
		        modal: true,
		        position: 'center',
		        height: 400,
		        width: 500,
		        open: function () {
		            $(this).load($(this).data('datastr'));
		        }
		});
});