<?php global $org_id,$site_title,$theme_url; ?>
<!doctype html>
<html lang="en">	
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->

  <title><?php print isset($page_title)?$page_title:$site_title; ?></title>
  <meta name="description" content="<?php //presentation description; ?>">
  <meta name="author" content="<?php //presentation author; ?>">
  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="<?php echo $theme_url ?>/img/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo $theme_url ?>/apple-touch-icon.png">


 <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	    <!--[if lt IE 9]>
	      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
	    
  <!-- CSS: implied media="all" -->	    
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link href="<?php echo $theme_url ?>/css/style.css" rel="stylesheet">
  <!--[if IE]>
	<link href="<?php echo $theme_url ?>/css/ie.css" rel="stylesheet">
  <![endif]-->

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->

<?php print isset($page_css)?page_css($page_css):''; ?>

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="<?php echo DEFAULT_THEME_URL ?>/js/modernizr.js"></script>
<?php print isset($page_js)?page_js($page_js):''; ?>

</head>


<body<?php print isset($body_class)?body_class($body_class):''; ?>>

<?php print $this->session->flashdata('err')?'<div class="error">'.$this->session->flashdata('err').'</div>':''; ?>
<?php print $this->session->flashdata('msg')?'<div class="message">'.$this->session->flashdata('msg').'</div>':''; ?>