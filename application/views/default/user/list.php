<div class="container">
	<div class="header row-fluid">
		<div class="span2">
			<h4>User</h4>
		</div><!-- end span3 -->
		<div class="span2">
			<h4>Email</h4>
		</div><!-- end span2 -->
		<div class="span2">
			<h4>Access Level</h4>
		</div><!-- span3 -->
		<div class="span2">
			<h4>Group</h4>
		</div><!-- end span2 -->
		<div class="span2">
			<h4 class="published">Group Access Level</h4>
		</div><!-- end span1 -->
		<div class="span2">
			<h4>Date Added</h4>
		</div><!-- end span1 -->
	</div><!-- end titleBar -->
			<?php foreach($users AS $user){ ?>
			<div class="stripe user row-fluid" href="/user/edit/<?php print $user->ID; ?>">
				<div class="span2">
					<h6 class="sub subheading"><?php print $user->firstname; ?> <?php print $user->lastname; ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print $user->email; ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print $user->access; ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print $user->group_name; ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print $user->group_access; ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y",$user->dateadded); ?></h6>
				</div>
			</div>
			<?php } //end stories ?>
		<div id="footer" class="row-fluid">	
	</div><!-- end footer -->
</div><!-- end container -->
