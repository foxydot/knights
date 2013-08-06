<div class="container-fluid form">
	<div class="row-fluid">
		<?php print form_open_multipart($action,array('id'=>'category','class'=>'smallform span6 offset3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Category</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$cat->ID.'"':''; ?> />
			<input class="span9" name="title" id="title" type="text" title="Category Name" placeholder="Category Name"<?php print $is_edit?'value="'.$cat->title.'"':''; ?> />
			<select class="span3" name="parent_cat_id" id="parent_cat_id" autocomplete="off">
				<option value="">Parent Category</option>
				<?php 
				foreach($cats[0] AS $c):
					print display_cat($cats,$c,0,$cat->parent_cat_id);
				endforeach;
				?>
			</select>
		</div>
		<div class="row-fluid">
			<label>Description</label>
			<textarea class="span12 tinymce" name="description" id="description" placeholder="Category description"><?php print $is_edit?$cat->description:''; ?></textarea>
		</div>
		<div class="row-fluid">
			<input name="submit" id="submit" type="submit" value="Submit" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>

<?php function display_cat($cats,$cat,$level=0,$parent_id){
	$selected = $cat->ID==$parent_id?' selected="selected"':'';
	$display = '<option class="level-'.$level.'" value="'.$cat->ID.'"'.$selected.'>'.str_repeat("-",(int) $level).$cat->title.'</option>';
	if(isset($cats[$cat->ID])){
		foreach($cats[$cat->ID] AS $c){
			$display .= display_cat($cats,$c,$level+1,$parent_id);
		}
	}
	return $display;
}?>