<div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
        	<?php if(isset($sidebar)){ $this->load->view($sidebar); } else { $this->load->view('default/sidebar'); } ?>
        </div><!--/span-->
        <div class="span9">
          <div class="hero-unit">
            <h1>Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
          <div class="row-fluid">
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>



    </div><!--/.fluid-container-->







<div class="container">

	<div class="header row">
	
		
	
	</div><!-- end header -->
	
	<div class="titleBar row">
	
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
		
			<h4 class="published">Published</h4>
		
		</div><!-- end span1 -->
		
		<div class="span1">
		
			<h4>Archive</h4>
		
		</div><!-- end span1 -->
	
	</div><!-- end titleBar -->	
	<?php 
		foreach($catsposts AS $cat){
			if(count($cat->posts)>0):
			?>
		<div class="stripe row">
	
		<div class="span3">
			<h5 class="heading"><?php print $cat->name; ?></h5>
		</div>
		
		<div class="span2"></div>
		
		<div class="span2"></div>
		
		<div class="span2"></div>
		
		<div class="span1"></div>
		
		<div class="span1"></div>
		
		<div class="span1"></div>
	
	</div>
			<?php foreach($cat->posts AS $post){ ?>
			<div class="stripe story row" href="/admin/edit/<?php print $post->story_id; ?>">
			
				<div class="span3">
					<h6 class="sub subheading"><?php print $post->title; ?></h6>
				</div>
				
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y",$post->datepresented); ?></h6>
				</div>
				
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y, g:i a",$post->lastedit); ?></h6>
				</div>
				
				<div class="span2">
					<h6 class="sub"><?php print $post->firstname.' '.$post->lastname; ?></h6>
				</div>
				
				<div class="span1">
					<h6 class="live"><a href="javascript:void(0);" class="<?php print $post->datepublished>0?'unpublish_link':'publish_link'; ?>" name="<?php print $post->story_id; ?>"><?php print $post->datepublished>0?'published':'unpublished'; ?></a></h6>
				</div>
				
				<div class="span1">
					<h6 class="sub"><a href="/admin/clone_story/<?php print $post->story_id; ?>" class="clone_story" name="<?php print $post->story_id; ?>">Clone</a></h6>
				</div>
				
				<div class="span1">
					<?php if($archive){ ?>
					<h6 class="sub"><a href="javascript:void(0);" class="unarchive_link" name="<?php print $post->story_id; ?>">Unarchive</a></h6>
					<?php } else { ?>
					<h6 class="sub"><a href="javascript:void(0);" class="archive_link" name="<?php print $post->story_id; ?>">Archive</a></h6>
					<?php } ?>
				</div>
			
			</div>
			<?php } //end stories ?>
	<div class="spacer stripe row">
	
		<div class="span3">
		</div>
		
		<div class="span2">
		</div>
		
		<div class="span3">
		</div>
		
		<div class="span2">
		</div>
		
		<div class="span1">
		</div>
		
		<div class="span1">
		</div>
	
	</div>
		<?php 
		endif;
		} //end projects ?>
		<div id="footer" class="row">
		<?php if(isset($nav)){ $this->load->view($nav); } else { $this->load->view('default/nav'); } ?>
	</div><!-- end footer -->
</div><!-- end container -->
