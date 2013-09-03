		<?php
		print form_open('login/register',array('id'=>'register','class'=>'smallform'));
		// pass URL of previous page so we know which page user came from
		print form_fieldset();
		?>
		<h1>Register Your Account</h1>
		<fieldset>
			<input name="firstname" class="one-half first" id="firstname" type="text" placeholder="First Name" value="<?php print isset($values['firstname'])?$values['firstname']:''; ?>" />
			<input name="lastname" class="one-half last" id="lastname" type="text" placeholder="Last Name" value="<?php print isset($values['lastname'])?$values['lastname']:''; ?>" /><br />
			<input name="email" id="email" type="text" placeholder="Email" value="<?php print isset($values['email'])?$values['email']:''; ?>" /><br />
			<input name="password" class="one-half first" id="password" type="password" placeholder="Password" />
			<input name="passwordtest" class="one-half last" id="passwordtest" type="password" placeholder="Password Again" />
		</fieldset>
		<fieldset>
			Please provide the name of your youngest student enrolled at <?php print $organization->name; ?><br />
			<input name="studentfirstname" class="one-half first" id="studentfirstname" type="text" placeholder="Student First Name" value="<?php print isset($values['firstname'])?$values['firstname']:''; ?>" />
			<input name="studentlastname" class="one-half last" id="studentlastname" type="text" placeholder="Student Last Name" value="<?php print isset($values['lastname'])?$values['lastname']:''; ?>" />
		</fieldset>
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>