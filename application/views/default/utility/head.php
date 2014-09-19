<?php global $theme_url; ?>
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
  <link rel="shortcut icon" href="<?php echo $theme_url; ?>/img/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo $theme_url; ?>/img/apple-touch-icon.png">


  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar navbar-default text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo DEFAULT_THEME_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo $theme_url; ?>/css/style.css">
  <?php include_once(SITEPATH.DEFAULT_THEME_URL.'/inc/css.php'); ?>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="<?php echo site_url('display'); ?>">
<?php print isset($page_css)?page_css($page_css):''; ?>
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects --> 
  <script src="/assets/js/modernizr.js"></script>
<?php print isset($page_js)?page_js($page_js):''; ?>
</head>

<body<?php print isset($body_class)?body_class($body_class):''; ?>>
<?php print $this->session->flashdata('err')?'<div class="alert alert-error">'.$this->session->flashdata('err').'</div>':''; ?>
<?php print $this->session->flashdata('msg')?'<div class="alert alert-info message">'.$this->session->flashdata('msg').'</div>':''; ?>