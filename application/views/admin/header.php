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
  <link rel="stylesheet" href="/themes/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo ADMIN_THEME_URL; ?>/css/style.css">
  <link rel="stylesheet" href="<?php echo ADMIN_THEME_URL; ?>/css/custom-theme/jquery-ui-1.8.20.custom.css">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
<?php print isset($page_css)?page_css($page_css):''; ?>
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects --> 
  <script src="<?php echo ADMIN_THEME_URL; ?>/js/modernizr.js"></script>
<?php print isset($page_js)?page_js($page_js):''; ?>
</head>

<body<?php print isset($body_class)?body_class($body_class):''; ?>>
<div class="wrap">
<?php print $this->session->flashdata('err')?'<div class="alert alert-error">'.$this->session->flashdata('err').'</div>':''; ?>
<?php print $this->session->flashdata('msg')?'<div class="alert alert-info message">'.$this->session->flashdata('msg').'</div>':''; ?>