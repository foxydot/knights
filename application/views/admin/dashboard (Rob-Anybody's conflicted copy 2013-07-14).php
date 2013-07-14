<div class="container">

	<div class="header row">
	
		<a href="/admin"><img id="logo" src="<?php print ADMIN_THEME_URL ?>/img/logo.png" alt="<?php print SITENAME; ?>" /></a>
		<h5>Welcome back, <?php print $user['firstname']; ?></h5>
		
		<a id="logout" href="/login/logout">Log Out</a>
	
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
	
		
		<ul class="opt2">
		
			<li><a class="modal-loader" title="Add new post" data-toggle="modal" data-target="#modal" href="/admin/add">+ New post</a></li>
			
			
			<?php if($archive){ ?>
			<li><a href="/admin">Project List</a></li>
			<?php } else { ?>
			<li><a href="/admin/listarchive">Review Archived</a></li>
			<?php } ?>
			
			<li><a class="modal-loader" title="Edit author" data-toggle="modal" data-target="#modal" href="/user/edit/<?php print $user['ID']; ?>" class="edituser">Author Settings</a></li>
			
			<?php if($this->authenticate->check_auth()){ ?>
			<li><a href="/user">Users</a></li>
			<li><a href="/organizations">Organizations</a></li>
			<?php } ?>
		</ul><!-- end opt2 -->
	
	</div><!-- end footer -->
</div><!-- end container -->
