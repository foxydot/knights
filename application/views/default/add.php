		<?php print form_open_multipart($action,array('id'=>'add-project','class'=>'smallform popupform')); ?>
		<?php print form_fieldset(); ?>
		<input name="name" id="name" type="text" class="suggest" title="Client|Project Name" placeholder="Client|Project Name"<?php print $is_edit?'value="'.$story_data->name.'"':''; ?> />
		<input name="project_id" id="project_id" type="hidden"<?php print $is_edit?'value="'.$story_data->project_id.'"':''; ?> />
		<input name="title" id="title" type="text" title="Story Title" placeholder="Story Title"<?php print $is_edit?'value="'.$story_data->title.'"':''; ?> />
		<input title="Presentation Date" name="datepresented" id="datepresented" class="datepicker" type="text" placeholder="Presentation Date"<?php print $is_edit?'value="'.date('m/d/Y',$story_data->datepresented).'"':''; ?> />
		<div class="info">Author:<br />
		<select name="author_id" id="author_id">
		<?php foreach($author_options AS $ao){ ?>
			<option value="<?php print $ao->ID; ?>"<?php print $is_edit?$ao->ID==$story_data->author_id?' SELECTED':'':$ao->ID==$user['ID']?' SELECTED':''; ?>><?php print $ao->firstname; ?> <?php print $ao->lastname; ?></option>
		<?php } ?>
		</select></div>
		<input title="Story Password" name="password" id="password" type="text" placeholder="Story Password"<?php print $is_edit?'value="'.$story_data->password.'"':''; ?> />
		<label>Upload Logo</label>
			<input type="file" name="logo_url" size="20" />
		<label>Upload Banner</label>
			<input type="file" name="banner_url" size="20" />
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>