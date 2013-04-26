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

  <title><?php print $page_title?$page_title:SITENAME; ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <!-- CSS: implied media="all" -->
  <link rel="stylesheet" href="/assets/admin/css/start/jquery-ui-1.8.18.custom.css">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
<?php print isset($page_css)?page_css($page_css):''; ?>
  <!-- Modernizr which enables HTML5 elements & feature detects -->
  <script src="/assets/admin/js/modernizr.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  
<!--[if (gte IE 6)&(lte IE 8)]>
  <script type="text/javascript" src="/assets/js/selectivizr.js"></script>
<![endif]--> 

  <!-- Load TinyMCE -->
<script type="text/javascript" src="/assets/admin/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '/assets/admin/js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "spellchecker,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,|,pasteword,|,bullist,outdent,indent,|,link,unlink,|,spellchecker,code",
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
			<?php if($section->type != 'Prose'){ ?>
		   forced_root_block : false,
		   force_br_newlines : true,
		   force_p_newlines : false,
		   <?php } ?>

			// Example content CSS (should be your site CSS)
			content_css : "/assets/admin/css/content.css",

			// Drop lists for link/image/media/template dialogs
			//template_external_list_url : "/assets/admin/js/lists/template_list.js",
			//external_link_list_url : "/assets/admin/js/lists/link_list.js",
			//external_image_list_url : "/assets/admin/js/lists/image_list.js",
			//media_external_list_url : "/assets/admin/js/lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
			}
		});
	});
</script>
<!-- /TinyMCE -->
<?php print isset($page_jquery)?page_jquery($page_jquery):''; ?>
  <!-- end scripts-->
<?php print isset($page_js)?page_js($page_js):''; ?>
</head>

<body<?php print isset($body_class)?body_class($body_class):''; ?>>
<?php // ts_data($section); ?>
<form method="post" action="/admin/edit_section/<?php print $section->section_id; ?>/<?php print $story->story_id; ?>" style="width: 95%;margin: 0 auto;">
	<div>
		<h3><?php print $story->title.': '.$section->story_section.'.'.$section->story_subsection.' '.$section->type; ?></h3>

		<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
		<div>
			<textarea id="editorContent" name="editorContent" rows="10" cols="80" style="width: 100%" class="tinymce">
				<?php print $section->content; ?>
			</textarea>
		</div>
<?php /* ?>
		<!-- Some integration calls -->
		<a href="javascript:;" onclick="$('#editorContent').tinymce().show();return false;">[Show]</a>
		<a href="javascript:;" onclick="$('#editorContent').tinymce().hide();return false;">[Hide]</a>
		<a href="javascript:;" onclick="$('#editorContent').tinymce().execCommand('Bold');return false;">[Bold]</a>
		<a href="javascript:;" onclick="alert($('#editorContent').html());return false;">[Get contents]</a>
		<a href="javascript:;" onclick="alert($('#editorContent').tinymce().selection.getContent());return false;">[Get selected HTML]</a>
		<a href="javascript:;" onclick="alert($('#editorContent').tinymce().selection.getContent({format : 'text'}));return false;">[Get selected text]</a>
		<a href="javascript:;" onclick="alert($('#editorContent').tinymce().selection.getNode().nodeName);return false;">[Get selected element]</a>
		<a href="javascript:;" onclick="$('#editorContent').tinymce().execCommand('mceInsertContent',false,'<b>Hello world!!</b>');return false;">[Insert HTML]</a>
		<a href="javascript:;" onclick="$('#editorContent').tinymce().execCommand('mceReplaceContent',false,'<b>{$selection}</b>');return false;">[Replace selection]</a>
<?php */ ?>
		<br />
		<input type="submit" name="save" value="Submit" />
		<input type="reset" name="reset" value="Reset" />
	</div>
</form>
<!--[if lt IE 7 ]>
    <script src="/assets/admin/js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->
</body>
</html>
