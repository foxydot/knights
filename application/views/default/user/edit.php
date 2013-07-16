<div class="container-fluid form">
	<div class="row-fluid">
		<?php print form_open_multipart($action,array('id'=>'add-user','class'=>'smallform span6 offset3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> User Information</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input class="span6" name="firstname" id="firstname" type="text" placeholder="First Name"<?php print $is_edit?'value="'.$the_user->firstname.'"':''; ?> />
			<input class="span6" name="lastname" id="lastname" type="text" placeholder="Last Name"<?php print $is_edit?'value="'.$the_user->lastname.'"':''; ?> />
		</div>
		<div class="row-fluid">
			<input class="span12" name="email" id="email" type="text" placeholder="Email"<?php print $is_edit?'value="'.$the_user->email.'"':''; ?> />
		</div>
		<div class="row-fluid">
			<input class="span6" name="password" id="password" type="password" placeholder="<?php print $is_edit?'New ':''; ?>Password" />
			<input class="span6" name="passwordtest" id="passwordtest" type="password" placeholder="<?php print $is_edit?'New ':''; ?>Password Again" />
		</div>
		<div class="row-fluid">
			<div class="span6">
			<label>Access Level</label>
			<?php if($this->authenticate->check_auth('administrators')){ ?>
			<select name="accesslevel" id="accesslevel">
				<option>Access Level</option>
				<?php foreach($access AS $k=>$v){ ?>
					<option value="<?php print $k; ?>"<?php print $is_edit?($the_user->accesslevel==$k?' selected = "selected"':''):''; ?>><?php print ucwords($v); ?></option>
				<?php }	?>
			</select>
			<?php } else { ?>
			<span><?php print ucwords($access[$the_user->accesslevel]); ?></span>
			<?php } ?>
			</div>
			<div class="span6">
			<label>User Group</label>
			<?php if($this->authenticate->check_auth('administrators')){ ?>
			<select name="group_id" id="group_id">
				<option>User Group</option>
				<?php foreach($groups AS $group){ ?>
					<option value="<?php print $group->ID; ?>"<?php print $is_edit?($the_user->group_id==$group->ID?' selected = "selected"':''):''; ?>><?php print ucwords($group->name); ?></option>
				<?php }	?>
			</select>
			<?php } else { ?>
			<?php ts_data($groups);?>
			<span><?php print $the_user->group_id; ?></span>
			<?php } ?>
			</div>
		</div>
		<div class="row-fluid">
			<label>User Photo</label>
				<input type="file" name="userfile" size="20" />
				<input name="submit" id="submit" type="submit" value="Submit" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>