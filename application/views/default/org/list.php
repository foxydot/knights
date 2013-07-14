<div class="container">

	<div class="header row">
	
		<a href="/admin"><img id="logo" src="<?php print ADMIN_THEME_URL ?>/img/logo.png" alt="<?php print SITENAME; ?>" /></a>
		<h5>Welcome back, <?php print $user['firstname']; ?></h5>
				
		<a id="logout" href="/login/logout">Log Out</a>
	
	</div><!-- end header -->
	
	<div class="titleBar row">
	
		<div class="span2">
		
			<h4>Name</h4>
		
		</div><!-- end span3 -->
		
		<div class="span8">
		
			<h4>Description</h4>
		
		</div><!-- end span2 -->
		
		<div class="span2">
		
			<h4>Date Added</h4>
		
		</div><!-- end span1 -->
	
	</div><!-- end titleBar -->
				<?php foreach($orgs AS $org){ ?>
			<div class="stripe org row" href="/org/edit/<?php print $org->ID; ?>" id="editorg-<?php print $org->ID; ?>" class="modal-loader editorg" title="Edit Organization <?php print $org->name; ?>" data-toggle="modal" data-target="#modal">
			
				<div class="span2">
					<h6 class="sub subheading"><?php print $org->name; ?></h6>
				</div>
				
				<div class="span8">
					<h6 class="sub"><?php print $org->description; ?></h6>
				</div>
								
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y",$org->dateadded); ?></h6>
				</div>	
				
			
			</div>
			<?php } //end stories ?>

		<div id="footer" class="row">
	
		
		<ul class="opt2">

			<li><a href="/admin">Dashboard</a></li>
			<li><a href="/orgs/add" id="addorg" class="modal-loader addorg" title="Add Organization" data-toggle="modal" data-target="#modal">+ New Organization</a></li>
		
		</ul><!-- end opt2 -->
	
	</div><!-- end footer -->
</div><!-- end container -->
