  <!-- JavaScript at the bottom for fast page loading -->
 
<!--[if (gte IE 6)&(lte IE 8)]>
  <script type="text/javascript" src="/assets/js/selectivizr.js"></script>
<![endif]--> 


  <!-- scripts concatenated and minified via ant build script-->  
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script src="/assets/js/scripts.js"></script>
  <script src="<?php echo DEFAULT_THEME_URL; ?>/js/scripts.js"></script>
  <!-- Load TinyMCE -->
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript">
		tinymce.init({
		    selector: "textarea.tinymce",
		    plugins: [
                     "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                     "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                     "save table contextmenu directionality emoticons template paste textcolor"
               ],
            
            menubar : false,
            toolbar: "code | undo redo | styleselect | bold italic forecolor | bullist numlist outdent indent | link",

			// General options
			theme : "modern",

			// Example content CSS (should be your site CSS)
			content_css : "<?php echo ADMIN_THEME_URL; ?>/css/content.css",

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