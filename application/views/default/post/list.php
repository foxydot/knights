<div class="container-fluid list">
      <div class="header row-fluid">
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
		<div class="stripe row-fluid">
			<div class="span12">
				<h5 class="heading"><?php print $cat->title; ?></h5>
			</div>
		</div>
			<?php foreach($cat->posts AS $post){ ?>
			<div class="stripe post clicky row-fluid" href="/post/view/<?php print $post->post_id; ?>">
				<div class="span3">
					<?php print $post->title; ?>
				</div>
				<div class="span1">
					<?php print $post->cost; ?>
				</div>
				<div class="span2">
					<?php print date("F j, Y",$post->dateadded); ?>
				</div>
				<div class="span2">
					<?php print $post->firstname.' '.$post->lastname; ?>
				</div>
				<div class="span1">
					<?php if($this->authenticate->check_auth('administrators')||$this->common->is_author($user['ID'],$post->author_id)){ ?>
						<a href="/post/edit/<?php print $post->post_id; ?>" class="btn">Edit</a>
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