<div id="post-list" class="container-fluid list accordion">
      <div class="header row-fluid">
        <div class="span1">
			<h4>Listing Number</h4>
		</div><!-- end span3 -->
        <div class="span3">
			<h4>Title</h4>
		</div><!-- end span3 -->
		<div class="span1">
			<h4>Price</h4>
		</div><!-- end span1 -->
		<div class="span2">
			<h4>Date Added</h4>
		</div><!-- end span2 -->
		<div class="span2">
			<h4>Poster</h4>
		</div><!-- end span2 -->
		<div class="span1">
			<h4></h4>
		</div><!-- end span1 -->
      </div><!--/row-->
	<?php 
		foreach($catsposts AS $cat){
			if(count($cat->posts)>0):
			?>
		<div class="stripe row-fluid accordion-group">
			<div class="span12 accordion-heading">
				<h5 class="heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#post-list" href="#<?php print $cat->slug; ?>-posts"><?php print $cat->title; ?></a></h5>
			</div>
			<div id="<?php print $cat->slug; ?>-posts" class="row-fluid accordion-body collapse">
			<?php foreach($cat->posts AS $post){ ?>
			<div class="stripe post clicky row-fluid accordion-inner" href="/post/view/<?php print $post->post_id; ?>">
				<div class="span1 id">
					<?php print str_pad((string)$post->post_id,8,'0',STR_PAD_LEFT); ?>
				</div>
				<div class="span3 title">
					<?php print $post->title; ?>
				</div>
				<div class="span1 price">
					<?php print $post->cost; ?>
				</div>
				<div class="span2 date-added">
					<?php print date("F j, Y",$post->dateadded); ?>
				</div>
				<div class="span2 author">
					<?php print $post->firstname.' '.$post->lastname; ?>
				</div>
				<div class="span1 edit">
					<?php if($this->authenticate->check_auth('administrators')||$this->common->is_author($user['ID'],$post->author_id)){ ?>
						<a href="/post/edit/<?php print $post->post_id; ?>" class="btn">Edit</a>
					<?php } ?>
				</div>
			</div>
			<?php } //end posts ?>
			</div>
		</div>
		<?php 
		endif;
		} //end cats ?>

	<div id="footer" class="row">
	</div><!-- end footer -->

    </div><!--/.fluid-container-->