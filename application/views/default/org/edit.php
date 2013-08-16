<div class="container-fluid form">
	<div class="row-fluid">
		<?php print form_open_multipart($action,array('id'=>'organization','class'=>'smallform span6 offset3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Organization Information</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$org->ID.'"':''; ?> />
			<input class="span12" name="name" id="name" type="text" title="Organization Name" placeholder="Organization Name"<?php print $is_edit?'value="'.$org->name.'"':''; ?> />
		</div>
		<div class="row-fluid">
			<textarea class="span12 tinymce" name="description" id="description" placeholder="Category description"><?php print $is_edit?$org->description:''; ?></textarea>
		</div>
		<div class="row-fluid img-upload"<?php print isset($org->meta['logo_url'])?' style="display:none;"':''; ?>>
			<label>Upload Logo</label>
			<input type="file" name="logo_url" size="20" />
		</div>
		<?php if(isset($org->meta['logo_url'])): ?>
		<div class="row-fluid img-display">
			<label>Logo</label>
			<img src="<?php print $org->meta['logo_url']->meta_value; ?>">
			<input class="btn" name="change_img" id="change_img" type="button" value="Change Logo" />
		</div>
		<?php endif; ?>
		<div class="row-fluid">
				<input name="submit_btn" id="submit_btn" type="submit" value="Submit" />
				<?php if($this->authenticate->check_auth('administrators')){ ?>
					<input name="delete_btn" id="delete_btn" type="button" class="btn btn-danger" value="Delete" />
				<?php } ?>
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>