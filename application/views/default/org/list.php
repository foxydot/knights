<div class="container-fluid">
	<div class="header row-fluid">
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
			<div class="stripe org clicky row-fluid" href="/org/edit/<?php print $org->ID; ?>">
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
			<?php } //end orgs ?>
		<div id="footer" class="row-fluid">
	</div><!-- end footer -->
</div><!-- end container -->
