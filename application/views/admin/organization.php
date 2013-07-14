		<?php print form_open_multipart($action,array('id'=>'organization','class'=>'smallform popupform')); ?>
		<?php print form_fieldset(); ?>
		<input name="ID" id="ID" type="hidden"<?php print $is_edit?'value="'.$organization->ID.'"':''; ?> />
		<input name="name" id="name" type="text" title="Organization Name" placeholder="Organization Name"<?php print $is_edit?'value="'.$organization->name.'"':''; ?> />
		<textarea name="description" id="description" placeholder="Description"><?php print $is_edit?$organization->description:''; ?></textarea>
		<label>Upload Logo</label>
			<input type="file" name="logo_url" size="20" />
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>