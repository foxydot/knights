<div class="container-fluid">
      <div class="header row-fluid">
        <div class="span3">
			<h4>Title</h4>
		</div><!-- end span3 -->
		<div class="span2">
			<h4>Date Added</h4>
		</div><!-- end span2 -->
		<div class="span2">
			<h4>Poster</h4>
		</div><!-- end span2 -->
		<div class="span1">
			<h4>Published</h4>
		</div><!-- end span1 -->
		<div class="span1">
			<h4>Archive</h4>
		</div><!-- end span1 -->
      </div><!--/row-->
	<?php 
		foreach($catsposts AS $cat){
			if(count($cat->posts)>0):
			?>
		<div class="stripe row-fluid">
			<div class="span12">
				<h5 class="heading"><?php print $cat->name; ?></h5>
			</div>
		</div>
			<?php foreach($cat->posts AS $post){ ?>
			<div class="stripe story row-fluid" href="/admin/edit/<?php print $post->story_id; ?>">
				<div class="span3">
					<h6 class="sub subheading"><?php print $post->title; ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y",$post->dateadded); ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print $post->firstname.' '.$post->lastname; ?></h6>
				</div>
				<div class="span1">
					<h6 class="live"><a href="javascript:void(0);" class="<?php print $post->datepublished>0?'unpublish_link':'publish_link'; ?>" name="<?php print $post->ID; ?>"><?php print $post->datepublished>0?'published':'unpublished'; ?></a></h6>
				</div>
				<div class="span1">
					<?php if($archive){ ?>
					<h6 class="sub"><a href="javascript:void(0);" class="unarchive_link" name="<?php print $post->ID; ?>">Unarchive</a></h6>
					<?php } else { ?>
					<h6 class="sub"><a href="javascript:void(0);" class="archive_link" name="<?php print $post->ID; ?>">Archive</a></h6>
					<?php } ?>
				</div>
			</div>
			<?php } //end posts ?>
	<div class="spacer stripe row">
		<div class="span12">
		</div>
	</div>
		<?php 
		endif;
		} //end cats ?>

	<div id="footer" class="row">
	</div><!-- end footer -->

    </div><!--/.fluid-container-->