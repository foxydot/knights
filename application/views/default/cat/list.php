<?php //ts_data($cats); ?>
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
			<?php foreach($cats[0] AS $cat): ?>
				<?php print display_cat($cats,$cat); ?>
			<?php endforeach; //end stories ?>
		<div id="footer" class="row-fluid">	
	</div><!-- end footer -->
</div><!-- end container -->


<?php function display_cat($cats,$cat,$level=0){
	$display = '
	<div class="stripe user clicky row-fluid level-'.$level.'" href="/category/edit/'. $cat->ID.'">
		<div class="span2">
			<h6>'.$cat->title.'</h6>
		</div>
		<div class="span8">
			<h6>'.$cat->description.'</h6>
		</div>
		<div class="span2">
			<h6>'.date("F j, Y",$cat->dateadded).'</h6>
		</div>
	</div>';
	if(isset($cats[$cat->ID])){
		foreach($cats[$cat->ID] AS $c){
			$display .= display_cat($cats,$c,$level+1);
		}
	}
	return $display;
}?>