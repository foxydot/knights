<div class="container-fluid form">
	<div class="row-fluid">
		<?php print form_open_multipart($action,array('id'=>'organization','class'=>'smallform span6 offset3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Organization Information</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$organization->ID.'"':''; ?> />
			<input class="span12" name="name" id="name" type="text" title="Organization Name" placeholder="Organization Name"<?php print $is_edit?'value="'.$organization->name.'"':''; ?> />
		</div>
		<div class="row-fluid">
			<textarea class="span12 tinymce" name="description" id="description" placeholder="Category description"><?php print $is_edit?$organization->description:''; ?></textarea>
		</div>
		<div class="row-fluid">
			<label>Upload Logo</label>
			<input type="file" name="logo_url" size="20" />
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