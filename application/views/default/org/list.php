<?php
    $name_array = array_reverse(explode('.',$_SERVER['SERVER_NAME']));
?>
<div class="container-fluid">
	<div class="header row">
        <div class="col-md-1">
            <h4>Site ID</h4>
        </div><!-- end col-md-3 -->
        <div class="col-md-2">
            <h4>Name</h4>
        </div><!-- end col-md-3 -->
		<div class="col-md-5">
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
                <div class="col-md-1">
                    <h6 class="sub"><?php print $org->ID; ?></h6>
                </div>
                <div class="col-md-2">
                    <h6 class="sub"><?php print $org->name; ?></h6>
                </div>
				<div class="col-md-5">
					<h6 class="sub"><?php print $org->description; ?></h6>
				</div>
                <div class="col-md-2">
                    <h6 class="sub"><?php print date("F j, Y",$org->dateadded); ?></h6>
                </div>
                <div class="col-md-1">
                    <h6 class="sub"><a href="http://<?php print $org->meta['subdomain']->meta_value?$org->meta['subdomain']->meta_value:''; ?>.<?php print $name_array[1]; ?>.<?php print $name_array[0]; ?>" class="pull-right btn btn-sm btn-default" target="_blank">Visit</a></h6>
                </div>
                <div class="col-md-1">
                    <h6 class="sub"><a href="http://<?php print $org->meta['subdomain']->meta_value?$org->meta['subdomain']->meta_value:''; ?>.<?php print $name_array[1]; ?>.<?php print $name_array[0]; ?>" class="pull-right btn btn-sm btn-default" target="_blank">Manage</a></h6>
                </div>				
			</div>
			<?php } //end orgs ?>
		<div id="footer" class="row">
	</div><!-- end footer -->
</div><!-- end container -->
