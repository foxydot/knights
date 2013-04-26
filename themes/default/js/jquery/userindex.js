jQuery(document).ready(function($) {
	//these go on the user manager page
	$('#adduser').click(function(){
		$('.userlist #dialog').modal('open');
	        return false;
	    });
		
	    $('.userlist #dialog').modal({
	        show: false,
	        title: "Add User",
	        resizeable: true,
	        modal: true,
	        position: 'center',
	        height: 400,
	        width: 500,
	        open: function () {
	            $(this).load('/user/add');
	        }
	    });

	$('.userlist .user').hover(function(){
		if($(this).attr('href') != ''){
			$(this).css('cursor','pointer');
		}
	});
	$('.userlist .user').click(function(){
			var datastr = $(this).attr('id');
			$('.userlist #dialog2').data('datastr', datastr);
			$('.userlist #dialog2').modal('open');
		        return false;
		    });
		
		    $('.userlist #dialog2').modal({
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