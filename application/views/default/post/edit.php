		<?php print form_open_multipart($action,array('id'=>'post','class'=>'smallform popupform')); ?>
		<?php print form_fieldset(); ?>
		<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$post->post_id.'"':''; ?> />
		<input name="title" id="title" type="text" title="Post Title" placeholder="Post Title"<?php print $is_edit?'value="'.$post->title.'"':''; ?> />
		<input name="author_id" id="author_id" type="hidden" value="<?php print $is_edit?$post->author_id:$user['ID']; ?>" />
		<textarea name="content" id="content" placeholder="Post Content"><?php print $is_edit?$post->content:''; ?></textarea>
		<input name="cost" id="cost" type="text" title="Price" placeholder="Price"<?php print $is_edit?'value="'.$post->cost.'"':''; ?> />
		<label>Categories</label>
		<div class="columns-3">
			<?php foreach($cats AS $cat){ ?>
			<label class="checkbox">
				<input type="checkbox" name="cat[<?php print $cat->ID; ?>]" id="cat-<?php print $cat->ID; ?>" class="pull-left" value="<?php print $cat->ID; ?>"<?php print $is_edit && in_array($cat->ID,$post->postcats['ids'])?' CHECKED':''; ?> /> <?php print $cat->title; ?>
			</label>
			<?php }?>
		</div>
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>