		<?php print form_open_multipart($action,array('id'=>'add-user','class'=>'smallform')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> User Information</h1>
		<?php print form_fieldset(); ?>
		<input name="firstname" id="firstname" type="text" placeholder="First Name"<?php print $is_edit?'value="'.$the_user->firstname.'"':''; ?> />
		<input name="lastname" id="lastname" type="text" placeholder="Last Name"<?php print $is_edit?'value="'.$the_user->lastname.'"':''; ?> />
		<input name="email" id="email" type="text" placeholder="Email"<?php print $is_edit?'value="'.$the_user->email.'"':''; ?> />
		<input name="password" id="password" type="password" placeholder="<?php print $is_edit?'New ':''; ?>Password" />
		<input name="passwordtest" id="passwordtest" type="password" placeholder="<?php print $is_edit?'New ':''; ?>Password Again" />
		<select name="accesslevel" id="accesslevel">
			<option>Access Level</option>
			<?php foreach($access AS $k=>$v){ ?>
				<option value="<?php print $k; ?>"<?php print $is_edit?($the_user->accesslevel==$k?' selected = "selected"':''):''; ?>><?php print ucwords($v); ?></option>
			<?php }	?>
		</select>
		<select name="group_id" id="group_id">
			<option>User Group</option>
			<?php foreach($groups AS $group){ ?>
				<option value="<?php print $group->ID; ?>"<?php print $is_edit?($the_user->group_id==$group->ID?' selected = "selected"':''):''; ?>><?php print ucwords($group->name); ?></option>
			<?php }	?>
		</select>
		<label>User Photo</label>
			<input type="file" name="userfile" size="20" />
			<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>