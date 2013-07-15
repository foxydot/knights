<div class="container-fluid list">
	<div class="header row-fluid">
		<div class="span2">
			<h4>Category</h4>
		</div><!-- end span3 -->
		<div class="span8">
			<h4>Description</h4>
		</div><!-- end span1 -->
		<div class="span2">
			<h4>Date Added</h4>
		</div><!-- end span1 -->
	</div><!-- end titleBar -->
			<?php foreach($cats AS $cat){ ?>
			<div class="stripe user clicky row-fluid" href="/category/edit/<?php print $cat->ID; ?>">
				<div class="span2">
					<h6 class="sub "><?php print $cat->title; ?></h6>
				</div>
				<div class="span8">
					<h6 class="sub"><?php print $cat->description; ?></h6>
				</div>
				<div class="span2">
					<h6 class="sub"><?php print date("F j, Y",$cat->dateadded); ?></h6>
				</div>
			</div>
			<?php } //end stories ?>
		<div id="footer" class="row-fluid">	
	</div><!-- end footer -->
</div><!-- end container -->
