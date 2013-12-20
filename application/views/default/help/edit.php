<div class="container-fluid form">
	<div class="row-fluid">
		<?php print form_open_multipart($action,array('id'=>'article','class'=>'smallform span6 offset3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Help Article</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$article->ID.'"':''; ?> />
			<input name="parent_art_id" id="parent_art_id" type="hidden" <?php print $is_edit?'value="'.$article->parent_art_id.'"':'value="0"'; ?> />
			<input class="span9" name="title" id="title" type="text" title="Title" placeholder="Title"<?php print $is_edit?'value="'.$article->title.'"':''; ?> />
            <input class="span3" name="pageorder" id="pageorder" type="text" title="Page Order" placeholder="Page Order"<?php print $is_edit?'value="'.$article->pageorder.'"':''; ?> />
		</div>
		<div class="row-fluid">
			<label>Content</label>
			<textarea class="span12 tinymce" name="content" id="content" placeholder="Article Content"><?php print $is_edit?$article->content:''; ?></textarea>
		</div>
		<div class="row-fluid">
			<input name="submit_btn" id="submit_btn" type="submit" value="Submit" />             
			<input name="delete_btn" id="delete_btn" type="button" class="btn btn-danger" value="Delete" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>