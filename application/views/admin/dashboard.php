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
	
			<div class="stripe row">
	
		<div class="span3">
			<h5 class="heading">Sporting Equipment</h5>
		</div>
				
		<div class="span2"></div>
		
		<div class="span2"></div>
				
		<div class="span1"></div>
		
		<div class="span1"></div>
	
	</div>
						<div class="stripe story row" href="/admin/edit/2">
			
				<div class="span3">
					<h6 class="sub subheading">Test Item</h6>
				</div>
				
				<div class="span2">
					<h6 class="sub">May 9, 2012</h6>
				</div>
				
				<div class="span2">
					<h6 class="sub">Catherine OBrien</h6>
				</div>
				
				<div class="span1">
					<h6 class="live"><a href="javascript:void(0);" class="unpublish_link" name="2">published</a></h6>
				</div>
				
				<div class="span1">
										<h6 class="sub"><a href="javascript:void(0);" class="archive_link" name="2">Archive</a></h6>
									</div>
			
			</div>

						<div class="stripe story row" href="/admin/edit/4">
			
				<div class="span3">
					<h6 class="sub subheading">Test Item</h6>
				</div>
				
				<div class="span2">
					<h6 class="sub">June 1, 2012</h6>
				</div>
				
				<div class="span2">
					<h6 class="sub">Hunter Thurman</h6>
				</div>
				
				<div class="span1">
					<h6 class="live"><a href="javascript:void(0);" class="unpublish_link" name="4">published</a></h6>
				</div>
				
				<div class="span1">
										<h6 class="sub"><a href="javascript:void(0);" class="archive_link" name="4">Archive</a></h6>
									</div>
			
			</div>
				<div class="spacer stripe row">
	
		<div class="span3">
		</div>
		
		<div class="span2">
		</div>
		
		<div class="span2">
		</div>
		
		<div class="span1">
		</div>
		
		<div class="span1">
		</div>
	
	</div>
				<div class="stripe row">
	
		<div class="span3">
			<h5 class="heading">Books</h5>
		</div>
		
		<div class="span2"></div>
				
		<div class="span2"></div>
		
		<div class="span1"></div>
				
		<div class="span1"></div>
	
	</div>
						<div class="stripe story row" href="/admin/edit/8">
			
				<div class="span3">
					<h6 class="sub subheading">Test Item</h6>
				</div>
				
				<div class="span2">
					<h6 class="sub">June 4, 2012</h6>
				</div>
				
				<div class="span2">
					<h6 class="sub">Hunter Thurman</h6>
				</div>
				
				<div class="span1">
					<h6 class="live"><a href="javascript:void(0);" class="publish_link" name="8">unpublished</a></h6>
				</div>
								
				<div class="span1">
										<h6 class="sub"><a href="javascript:void(0);" class="archive_link" name="8">Archive</a></h6>
									</div>
			
			</div>
<?php /*?>
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
		
			<h4>Last Edited</h4>
		
		</div><!-- span2 -->
		
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
		foreach($projects AS $project){
			if(count($project->stories)>0):
			?>
		<div class="stripe row">
	
		<div class="span3">
			<h5 class="heading"><?php print $project->name; ?></h5>
		</div>
		
		<div class="span2"></div>
		
		<div class="span2"></div>
		
		<div class="span2"></div>
		
		<div class="span1"></div>
		
		<div class="span1"></div>
		
		<div class="span1"></div>
	
	</div>
			<?php foreach($project->stories AS $story){ ?>
			<div class="stripe story row" href="/admin/edit/<?php print $story->story_id; ?>">
			
				<div class="span3">
					<h6 class="sub subheading"><?php print $story->title; ?></h6>
				</div>
				
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y",$story->datepresented); ?></h6>
				</div>
				
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y, g:i a",$story->lastedit); ?></h6>
				</div>
				
				<div class="span2">
					<h6 class="sub"><?php print $story->firstname.' '.$story->lastname; ?></h6>
				</div>
				
				<div class="span1">
					<h6 class="live"><a href="javascript:void(0);" class="<?php print $story->datepublished>0?'unpublish_link':'publish_link'; ?>" name="<?php print $story->story_id; ?>"><?php print $story->datepublished>0?'published':'unpublished'; ?></a></h6>
				</div>
				
				<div class="span1">
					<h6 class="sub"><a href="/admin/clone_story/<?php print $story->story_id; ?>" class="clone_story" name="<?php print $story->story_id; ?>">Clone</a></h6>
				</div>
				
				<div class="span1">
					<?php if($archive){ ?>
					<h6 class="sub"><a href="javascript:void(0);" class="unarchive_link" name="<?php print $story->story_id; ?>">Unarchive</a></h6>
					<?php } else { ?>
					<h6 class="sub"><a href="javascript:void(0);" class="archive_link" name="<?php print $story->story_id; ?>">Archive</a></h6>
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
		
			<li><a data-toggle="modal" data-target="#modal" href="/admin/add">+ New Project</a></li>
			
			
			<?php if($archive){ ?>
			<li><a href="/admin">Project List</a></li>
			<?php } else { ?>
			<li><a href="/admin/listarchive">Review Archived</a></li>
			<?php } ?>
			
			<li><a data-toggle="modal" data-target="#modal" href="/user/edit/<?php print $user['ID']; ?>" class="edituser">Author Settings</a></li>
			
			<li><a href="/user">Users</a></li>
		
		</ul><!-- end opt2 -->
	
	</div><!-- end footer --><?php */?>
</div><!-- end container -->
