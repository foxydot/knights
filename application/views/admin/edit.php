<?php //ts_data($quotes); ?>
<div class="container3">

<div class="topbar">

	<?php //ts_data($story); ?>
	<div class="container">
		<h3><?php print $story->name; ?> | <?php print $story->title; ?> | <?php print date("F j, Y",$story->datepresented)?></h3>
		<a class="display-link" href="/presentation/<?php print $story->slug; ?>"><?php print site_url('/presentation/'.$story->slug); ?></a>
		<a class="logout" href="/login/logout">Log Out</a>
	
	</div><!-- end container -->

</div><!-- end topbar -->

<div class="container">
	<div id="titlerow" class="row">
		<div id="headline" class="span2">
		
			<h4>Headline</h4>
		
		</div><!-- end headline -->
		
		<div id="subHead" class="span3">
		
			<h4>Sub Head</h4>
		
		</div><!-- end span3  -->
		
		<div id="prose" class="span4">
		
			<h4>Prose</h4>
		
		</div><!-- end span4 -->
		
		<div id="topline" class="span3">
		
			<h4>Topline</h4>
		
		</div><!-- end span2 -->
	</div>
	<div id="main" class="row story<?php print $story->story_id; ?>">
	<?php foreach($sections AS $section){ ?>
		<?php if($section->story_subsection == 0):?>
			<?php if($section->story_section != 1): ?>
			<div class="clear closure"></div>	
					</div>			
			<?php print isset($quote_ribbon)?$quote_ribbon:''; //for any quote ribbons at the very bottom of a section ?>
				</div>
			</div>
			<div class="clear"></div>
			<?php endif; ?>
			<div id="section<?php print $section->story_section; ?>" class="row section section<?php print $section->story_section; ?>">
		<?php endif; //end section wrapper?>
			<?php if($section->type == 'Sub Head'):?>
				<?php if($section->story_subsection != 1):?><div class="clear closure"></div></div><?php print isset($quote_ribbon)?$quote_ribbon:''; //for quote ribbons mid section?><?php endif; ?>
				<?php if($section->story_subsection == 1):?><div class="section<?php print $section->story_section; ?> subsections"><?php endif; ?>
				<div id="subsection<?php print $section->story_subsection; ?>" class="section<?php print $section->story_section; ?> subsection">
			<?php endif; //end subsection wrapper?>
		<?php 
		$bootstrap = 'span3';
		switch($section->type){
			case 'Headline':
				$bootstrap = 'span2';
				break;
			case 'Sub Head':
				$plus = '<h6 class="plus">+</h6>';
				break;
			case 'Prose':
				$bootstrap = 'span4';
				break;
			case 'Topline':
				$quote_ribbon = isset($quotes[$section->story_section][$section->story_subsection])?do_quote_wrap_admin($quotes[$section->story_section][$section->story_subsection]):'';
				break;
		}
		?>
		<div id="<?php print post_slug($section->type).$section->story_section.'-'.$section->story_subsection; ?>" class="<?php print post_slug($section->type); ?> <?php print $bootstrap; ?>">
					
			<div class="color<?php print $section->story_section%7; ?> textBox">
			
				<h6 class="version" id="id<?php print $section->section_id; ?>"><?php print $section->story_section.'.'.$section->story_subsection; ?></h6>
				<h6 class="remove" id="<?php print 'story_id:'.$story->story_id.':section_id:'.$section->section_id.':story_section:'.$section->story_section.':story_subsection:'.$section->story_subsection; ?>">x</h6>
				<?php print $section->type=='Sub Head'?'<h6 class="plus" id="story_id:'.$story->story_id.':section_id:'.$section->section_id.':story_section:'.$section->story_section.':story_subsection:'.$section->story_subsection.'">+</h6>':''; ?>
				
				<div id="<?php print 'story_id:'.$story->story_id.':section_id:'.$section->section_id.':section_type:'.post_slug($section->section_type).':story_section:'.$section->story_section.':story_subsection:'.$section->story_subsection; ?>" class="textedit"><?php print $section->content; ?></div>
				<?php if($section->type=='Sub Head'):
					print '<div class="media" id="story_id:'.$story->story_id.':section_id:'.$section->section_id.':story_section:'.$section->story_section.':story_subsection:'.$section->story_subsection.'">media</div>';
					foreach($section->attachments AS $k => $v){
						print count($v)>0?'<div class="'.$k.'" title="'.count($v).' '.$k.'(s)">'.count($v).'</div>':'';
					}
					endif; ?>
				<div class="clear"></div>
			</div><!-- end textbox -->
		
		</div><!-- end <?php print $section->type; ?> -->
		<?php $lastsection = $section->story_section; ?>
	<?php } // end foreach; ?>
	<div class="clear closure"></div>
	<?php print isset($quote_ribbon)?$quote_ribbon:''; //for any quote ribbons at the very bottom of the page ?>
	</div>
	</div>
	</div><!-- end main -->

	<div id="<?php print 'story_id:'.$story->story_id.':story_section:'.($lastsection+1); ?>" class="add-section">+</div>
</div><!-- end container -->

</div><!-- end container3 -->
<div id="footer">
	
		<ul class="opt">
					
			<li><a href="/presentation/<?php print $story->slug; ?>" target="_preview">Preview</a></li>
			<?php /* don't actually do anything right now
			<li><a href="#">Undo</a></li>
			*/ ?>
			
			<li><a href="javascript:void(0);" class="quote_ribbon" name="<?php print $story->story_id; ?>" id="<?php print $story->story_id; ?>">Quote Ribbon</a></li>
		
		</ul><!-- end opt -->	
		
		<ul class="opt2">
		
			<li><a href="/admin">Dashboard</a></li>
			
			<li><a href="javascript:void(0);" class="<?php print $story->datepublished>0?'unpublish_link':'publish_link'; ?>" name="<?php print $story->story_id; ?>"><?php print $story->datepublished>0?'Unpublish':'Publish'; ?></a></li>
			
			<li><a href="">Save</a></li>
			<?php if($this->Admin->has_history($story->story_id)): ?>
			<li><a href="/admin/undo_edit/<?php print $story->story_id; ?>">Undo</a></li>
			<?php endif; ?>
			<li><a href="javascript:void(0);">Export</a>
				<ul>
					<li><a href="/export/index/<?php print $story->story_id; ?>/html">HTML</a></li>
					<li><a href="/export/index/<?php print $story->story_id; ?>/ppt">PPT</a></li>
				</ul>
			</li>

			<?php /* don't actually do anything right now
			<li><a href="#">Review Revisions</a></li>
			*/ ?>

			<li><a href="javascript:void(0);" class="story_settings" name="<?php print $story->story_id; ?>" id="<?php print $story->story_id; ?>">Settings</a></li>
		
			
		</ul><!-- end opt2 -->
	
	</div><!-- end footer -->
	