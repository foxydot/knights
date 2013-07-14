		<?php print form_open_multipart($action,array('id'=>'post','class'=>'smallform popupform')); ?>
		<?php print form_fieldset(); ?>
		<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$post->ID.'"':''; ?> />
		<input name="title" id="title" type="text" title="Post Title" placeholder="Post Title"<?php print $is_edit?'value="'.$post->title.'"':''; ?> />
		<input name="author_id" id="author_id" type="hidden" value="<?php print $user['ID']; ?>" />
		<textarea name="content" id="content" placeholder="Post Content"><?php print $is_edit?$organization->description:''; ?></textarea>
		<input name="cost" id="cost" type="text" title="Cost" placeholder="Cost"<?php print $is_edit?'value="'.$post->cost.'"':''; ?> />
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>