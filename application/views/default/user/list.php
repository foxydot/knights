<div class="container-fluid list">
	<div class="header row">
		<div class="col-md-2">
			<h4>User</h4>
		</div><!-- end col-md-3 -->
		<div class="col-md-2">
			<h4>Email</h4>
		</div><!-- end col-md-2 -->
		<div class="col-md-2">
			<h4>Access Level</h4>
		</div><!-- col-md-3 -->
		<div class="col-md-2">
			<h4>Group</h4>
		</div><!-- end col-md-2 -->
		<div class="col-md-2">
			<h4 class="published">Group Access Level</h4>
		</div><!-- end col-md-1 -->
		<div class="col-md-2">
			<h4>Date Added</h4>
		</div><!-- end col-md-1 -->
	</div><!-- end titleBar -->
	<?php if(count($users)>0){ ?>
			<?php foreach($users AS $user){ ?>
			<div class="stripe user clicky row" href="/user/edit/<?php print $user->ID; ?>">
				<div class="col-md-2">
					<h6 class="sub subheading"><?php print $user->firstname; ?> <?php print $user->lastname; ?></h6>
				</div>
				<div class="col-md-2">
					<h6 class="sub"><?php print $user->email; ?></h6>
				</div>
				<div class="col-md-2">
					<h6 class="sub"><?php print $user->access; ?></h6>
				</div>
				<div class="col-md-2">
					<h6 class="sub"><?php print $user->group_name; ?></h6>
				</div>
				<div class="col-md-2">
					<h6 class="sub"><?php print $user->group_access; ?></h6>
				</div>
				<div class="col-md-2">
					<h6 class="sub"><?php print date("F j, Y",$user->dateadded); ?></h6>
				</div>
			</div>
			<?php } //end users ?>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-12">
                 This organization has no users.
            </div>
        </div>
    <?php } ?>
		<div id="footer" class="row">	
	</div><!-- end footer -->
</div><!-- end container -->
