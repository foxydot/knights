		<?php print form_open_multipart($action,array('id'=>'category','class'=>'smallform popupform')); ?>
		<?php print form_fieldset(); ?>
		<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$cat->ID.'"':''; ?> />
		<input name="title" id="title" type="text" title="Category Name" placeholder="Category Name"<?php print $is_edit?'value="'.$cat->title.'"':''; ?> />
		<textarea name="description" id="description" placeholder="Category description"><?php print $is_edit?$cat->description:''; ?></textarea>
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>