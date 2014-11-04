<div class="container-fluid">
	<div class="header row">
		<div class="col-md-2">
			<h4>Name</h4>
		</div><!-- end col-md-3 -->
		<div class="col-md-6">
			<h4>Description</h4>
		</div><!-- end col-md-2 -->
        <div class="col-md-2">
            <h4>Date Added</h4>
        </div><!-- end col-md-1 -->
        <div class="col-md-1">
            <h4>Visit</h4>
        </div><!-- end col-md-1 -->
        <div class="col-md-1">
            <h4>Manage</h4>
        </div><!-- end col-md-1 -->
	</div><!-- end titleBar -->
		<?php foreach($orgs AS $org){ ?>
			<div class="stripe org clicky row" href="/org/edit/<?php print $org->ID; ?>">
				<div class="col-md-2">
					<h6 class="sub subheading"><?php print $org->name; ?></h6>
				</div>
				<div class="col-md-6">
					<h6 class="sub"><?php print $org->description; ?></h6>
				</div>
                <div class="col-md-2">
                    <h6 class="sub"><?php print date("F j, Y",$org->dateadded); ?></h6>
                </div>
                <div class="col-md-1">
                    <h6 class="sub"><a href="http://<?php print $org->description; ?>.msdlab3.com" class="pull-right btn btn-sm btn-default">Visit</a></h6>
                </div>
                <div class="col-md-1">
                    <h6 class="sub"><a href="http://<?php print $org->description; ?>.msdlab3.com" class="pull-right btn btn-sm btn-default">Manage</a></h6>
                </div>				
			</div>
			<?php } //end orgs ?>
		<div id="footer" class="row">
	</div><!-- end footer -->
</div><!-- end container -->
