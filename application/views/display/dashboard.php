		<div id="hero">
			<div id="poster">
				<img src="<?php print $story->banner_url; ?>" alt="<?php print $story->name; ?>: <?php print $story->title; ?>"/>
			</div>
			<div id="theme" class="container">
				<div class="logo"><img src="<?php print $story->logo_url; ?>" alt="<?php print $story->name; ?>"/></div>
				<div class="title">
					<h4><?php print date('F j, Y',$story->datepresented);?></h4>
					<h1><?php print $story->name; ?>:</h1>
					<h2><?php print $story->title; ?></h2>
				</div>
			</div>
		</div>
		
<?php foreach($story->sections AS $sectionkey => $section){ ?>
<?php $section_id = $section[0]['Headline']->story_section; ?>
<div id="section<?php print $section_id; ?>" class="section">
	<div id="headline-<?php print $section_id; ?>" class="headline">
		<div class="container">
			<div class="row">
				<div class="span1">
					<div class="numeric-headline"><?php print $section_id; ?>.<?php print $section[0]['Headline']->story_subsection; ?></div>
				</div>
				<div class="fold span11">
					<h2><?php print display($section[0]['Headline']->content); ?></h2>
				</div>
			</div>
		</div>
	</div> 
	<div class="container">
		<?php for($i=1;$i<count($section);$i++){ ?>
		<?php //ts_data($section[$i]);?>
		<?php $quote_ribbon = isset($quotes[$section_id][$section[$i]['Sub Head']->story_subsection])?do_quote_wrap($quotes[$section_id][$section[$i]['Sub Head']->story_subsection]):'';?>
		<?php print isset($quote_ribbon)?render_section($section[$i],$quote_ribbon):render_section($section[$i]); ?>
		<?php } ?>
	</div>
</div>
<?php } // end foreach; ?>
			</div>
		</div>
		<footer>
	    	<div id="signoff" class="container">
	    		<div class="row">
	    			<div id="emb" class="span8">
	    				<img src="/assets/frontend/img/emblem.png" alt="Thrive Plan"/>
	    			</div>
	    			<?php //insert author vcard ?>
	    			<div id="vcard" class="span2" style="background-image: url(<?php print $story->avatar; ?>);">
	    				<p><?php print $story->firstname; ?> <?php print $story->lastname; ?></p>
	    				<p><a href="mailto:<?php print $story->email; ?>"><?php print $story->email; ?></a><br/>513.891.3000</p>
	    			</div>
	    		</div>
	    	</div>
	   	</footer>
		
		<div id="sidebarNav">
			<ul>
				<li id="thirty"><a href="#introarea"><img src="/assets/frontend/img/nav-30.png" alt="30" /></a></li>
				<li id="sixty"><a href="#aboutfactorytitle"><img src="/assets/frontend/img/nav-60.png" alt="60" /></a></li>
				<li id="ninety"><a href="#processfactorytitle"><img src="/assets/frontend/img/nav-90.png" alt="90" /></a></li>
				<li id="logout"><a href="<?php print site_url(); ?>"><img src="/assets/frontend/img/nav-lo.png" alt="Logout" /></a></li>
			</ul>
		</div><!-- end sidebarNav -->