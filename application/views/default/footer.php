</div>

<div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	<h3></h3>
    </div>
    <div class="modal-body">
    	<p>One fine body</p>
    </div>
    <div class="modal-footer">
    </div>
</div>
  <!-- JavaScript at the bottom for fast page loading -->
 
<!--[if (gte IE 6)&(lte IE 8)]>
  <script type="text/javascript" src="/assets/js/selectivizr.js"></script>
<![endif]--> 


  <!-- scripts concatenated and minified via ant build script-->  
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  <script type="text/javascript" src="/assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo ADMIN_THEME_URL; ?>/js/scripts.js"></script>

<?php print isset($footer_js)?page_js($footer_js):''; ?>
<?php print isset($page_jquery)?page_jquery($page_jquery):''; ?>
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <script src="/assets/admin/js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->

</body>
</html>