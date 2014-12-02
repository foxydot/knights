<div class="container-fluid form">
	<div class="row">
		<?php print form_open_multipart($action,array('id'=>'article','class'=>'smallform col-md-6 col-md-offset-3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Help Article<a class="btn btn-default btn-sm cheatsheet-trigger pull-right">
            <i class="fa fa-magic"></i>
            </a></h1>
		<div class="row cheatsheet hidden">
		    <?php print get_cheatsheet(); ?>
		</div>
		<?php print form_fieldset(); ?>
		<div class="row">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$article->ID.'"':''; ?> />
			<input name="parent_art_id" id="parent_art_id" type="hidden" <?php print $is_edit?'value="'.$article->parent_art_id.'"':'value="0"'; ?> />
		  <label class="col-md-9">Title</label>
		  <label class="col-md-3">Page Order</label>
			<input class="col-md-9" name="title" id="title" type="text" title="Title" placeholder="Title"<?php print $is_edit?'value="'.$article->title.'"':''; ?> />
            <input class="col-md-3" name="pageorder" id="pageorder" type="text" title="Page Order" placeholder="Page Order"<?php print $is_edit?'value="'.$article->pageorder.'"':''; ?> />
		</div>
		<div class="row">
			<label>Content</label>
			<textarea class="col-md-12 tinymce" name="content" id="content" placeholder="Article Content"><?php print $is_edit?$article->content:''; ?></textarea>
		</div>
		<div class="row">
			<input name="submit_btn" id="submit_btn" type="submit" value="Submit" />             
			<input name="delete_btn" id="delete_btn" type="button" class="btn btn-danger" value="Delete" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>