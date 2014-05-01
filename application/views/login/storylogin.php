		<?php
		print form_open($action,array('id'=>'login','class'=>'smallform'));
		// pass URL of previous page so we know which page user came from
		print form_fieldset();
		?>
		<h1>Log In</h1>
		<input name="email" id="email" type="text" placeholder="Email" />
		<input name="password" id="password" type="password" placeholder="Password" />
		<div class="remember">
		<col-md->Remember Me</col-md->
		<input name="remember" id="remember" type="checkbox" /><br />
		</div><!-- end remember -->
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>