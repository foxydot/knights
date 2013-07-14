<?php 
/*
 * SITE CONSTANTS
*/
define('SITENAME', 'Knights ');
define('THEME_URL','/assets/themes/default');
define('ADMIN_THEME_URL','/assets/themes/wireframes');
?>
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

  <title><?php print isset($page_title)?$page_title:SITENAME; ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="<?php echo ADMIN_THEME_URL; ?>/img/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo ADMIN_THEME_URL; ?>/img/apple-touch-icon.png">


  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo ADMIN_THEME_URL; ?>/css/style.css">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects --> 
  <script src="<?php echo ADMIN_THEME_URL; ?>/js/modernizr.js"></script>

  <!-- scripts concatenated and minified via ant build script-->
  <script src="http://code.jquery.com/jquery.js"></script>
  <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo ADMIN_THEME_URL; ?>/js/scripts.js"></script>

  <!-- end scripts-->
</head>

<body class="<?php print $body_class; ?>">
<div class="wrap">
	<div class="logo" onClick="location.href='/wireframes/list.php'"></div>
