  <!-- JavaScript at the bottom for fast page loading -->
 
<!--[if (gte IE 6)&(lte IE 8)]>
  <script type="text/javascript" src="/assets/js/selectivizr.js"></script>
<![endif]--> 


  <!-- scripts concatenated and minified via ant build script-->  
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  <script type="text/javascript" src="/assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="/assets/js/scripts.js"></script>
  <script src="<?php echo DEFAULT_THEME_URL; ?>/js/scripts.js"></script>
  <!-- Load TinyMCE -->
<script type="text/javascript" src="/assets/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '/assets/js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "spellchecker,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "formatselect,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,pasteword,|,bullist,outdent,indent,|,link,unlink,|,spellchecker,code",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			
			//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
		   forced_root_block : false,
		   force_br_newlines : true,
		   force_p_newlines : false,

			// Example content CSS (should be your site CSS)
			content_css : "<?php echo ADMIN_THEME_URL; ?>/css/content.css",

			// Drop lists for link/image/media/template dialogs
			//template_external_list_url : "/assets/js/lists/template_list.js",
			//external_link_list_url : "/assets/js/lists/link_list.js",
			//external_image_list_url : "/assets/js/lists/image_list.js",
			//media_external_list_url : "/assets/js/lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
			}
		});
	});
</script>
<!-- /TinyMCE -->

<?php print isset($footer_js)?page_js($footer_js):''; ?>
<?php print isset($page_jquery)?page_jquery($page_jquery):''; ?>
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <script src="/assets/admin/js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->

</body>
</html>