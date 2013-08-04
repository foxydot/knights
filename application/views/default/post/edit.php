<div class="container-fluid form">
	<div class="row-fluid">
		<?php print form_open_multipart($action,array('id'=>'post','class'=>'smallform span6 offset3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Post</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$post->post_id.'"':''; ?> />
			<input class="span9" name="title" id="title" type="text" title="Post Title" placeholder="Post Title"<?php print $is_edit?'value="'.$post->title.'"':''; ?> />
			<input class="span3" name="cost" id="cost" type="text" title="Price" placeholder="Price"<?php print $is_edit?'value="'.$post->cost.'"':''; ?> />
		</div>
		<div class="row-fluid">
				<input name="author_id" id="author_id" type="hidden" value="<?php print $is_edit?$post->author_id:$user['ID']; ?>" />
				<textarea class="span12 tinymce" name="content" id="content" placeholder="Post Content"><?php print $is_edit?$post->content:''; ?></textarea>
		</div>
		<div class="row-fluid">
			<label>Categories</label>
			<div class="columns-3">
				<?php foreach($cats[0] AS $cat){ ?>
				<?php print display_cat($cats,$cat)?>
				<?php }?>
			</div>
		</div>
		<div class="row-fluid">
			<input class="btn" name="submit" id="submit" type="submit" value="Submit" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>


<?php function display_cat($cats,$cat,$level=0){
	global $is_edit,$post;
	$selected = $is_edit && in_array($cat->ID,$post->postcats['ids'])?' CHECKED':'';
	$display = '
	<label class="checkbox level-'.$level.'">
		<input type="checkbox" name="cat['.$cat->ID.']" id="cat-'.$cat->ID.'" class="pull-left" value="'.$cat->ID.'"'.$selected.' /> '.$cat->title.'
	</label>';
	if(isset($cats[$cat->ID])){
		foreach($cats[$cat->ID] AS $c){
			$display .= display_cat($cats,$c,$level+1);
		}
	}
	return $display;
}?>