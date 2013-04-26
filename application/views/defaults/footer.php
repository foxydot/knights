    	<!-- Le javascript -->  
  <script src="http://code.jquery.com/jquery.js"></script>
  <script src="/themes/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo THEME_URL; ?>/js/scripts.js"></script>
		
<?php print isset($footer_js)?page_js($footer_js):''; ?>
<?php print isset($page_jquery)?page_jquery($page_jquery):''; ?>
 <script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-29355278-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

    	</script>
	</body>

</html>