<div class="container-fluid form">
	<div class="row-fluid">
		<?php print form_open_multipart($action,array('id'=>'category','class'=>'smallform span6 offset3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Category</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$cat->ID.'"':''; ?> />
			<input class="span12" name="title" id="title" type="text" title="Category Name" placeholder="Category Name"<?php print $is_edit?'value="'.$cat->title.'"':''; ?> />
		</div>
		<div class="row-fluid">
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