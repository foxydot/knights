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
			<?php foreach($cats AS $cat): ?>
			<div class="stripe user clicky row-fluid" href="/category/edit/<?php print $cat->ID; ?>">
				<div class="span2">
					<h6><?php print $cat->title; ?></h6>
				</div>
				<div class="span8">
					<h6><?php print $cat->description; ?></h6>
				</div>
				<div class="span2">
					<h6><?php print date("F j, Y",$cat->dateadded); ?></h6>
				</div>
			</div>
				<?php 
				if(isset($cat->children)):
				foreach($cat->children AS $child): ?>
				<div class="stripe user clicky row-fluid indent1" href="/category/edit/<?php print $child->ID; ?>">
					<div class="span2 sub">
						<h6><?php print $child->title; ?></h6>
					</div>
					<div class="span8 sub">
						<h6><?php print $child->description; ?></h6>
					</div>
					<div class="span2 sub">
						<h6><?php print date("F j, Y",$child->dateadded); ?></h6>
					</div>
				</div>
					<?php 
					if(isset($child->children)):
					foreach($child->children AS $grandchild): ?>
					<div class="stripe user clicky row-fluid indent1" href="/category/edit/<?php print $grandchild->ID; ?>">
						<div class="span2 subsub">
							<h6><?php print $grandchild->title; ?></h6>
						</div>
						<div class="span8 subsub">
							<h6><?php print $grandchild->description; ?></h6>
						</div>
						<div class="span2 subsub">
							<h6><?php print date("F j, Y",$grandchild->dateadded); ?></h6>
						</div>
					</div>
					<?php endforeach;endif; ?>
				<?php endforeach;endif; ?>
			<?php endforeach; //end stories ?>
		<div id="footer" class="row-fluid">	
	</div><!-- end footer -->
</div><!-- end container -->
