		<?php
		print form_open('login/verify',array('id'=>'login','class'=>'smallform'));
		// pass URL of previous page so we know which page user came from
		print form_hidden('redirect', $this->uri->uri_string());
		print form_fieldset();
		?>
		<h1>Log In</h1>
		<input name="email" id="email" type="text" placeholder="Email" />
		<input name="password" id="password" type="password" placeholder="Password" />
		<div class="remember">
		<span>Remember Me</span>
		<input name="remember" id="remember" type="checkbox" /><br />
		<a href="/login/forgot">Forgot Your Password?</a> | 
		<a href="/login/register">Request Account</a> 
		</div><!-- end remember -->
		<input name="submit" id="submit" type="submit" value="Submit" /><br />
        <a href="/help">Help</a> |
        <a href="/help#what-is-the-knights-list-posts">Information and Guidelines</a><br />
        <a href="mailto:Knights@CommunityList.us">E-mail us with Questions, Suggestions and Feedback</a> 
		<?php
		print form_fieldset_close();
		print form_close();
		?>