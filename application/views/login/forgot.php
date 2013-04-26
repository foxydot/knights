	<?php if($infosent == true){ ?>
	<?php 
	print form_open('login',array('class'=>'smallform'));
	print form_fieldset();
	?>
	  	<div class="submit">
	    	<input class="btn" name="commit" type="submit" value="<?php print $buttontxt; ?>" />
	  	</div>
	<?php 
	print form_fieldset_close();
	print form_close();
	?>
	<?php } elseif($form_inner == 'reset') {?>
	<?php 
		print form_open('login/resetpass');
		print form_fieldset();
		?>
			<div class="login">
		      	<label id="email_address" for="login-input">Email Address</label>
		      	<input type="text" name="username" size="30" id="username" title="Your email address" class="email" value="" />
		  		<div class="clear"></div>
		
		      	<label id="password_label" for="password">Password</label>
		      	<input type="password" name="user_password" size="16" id="user_password" title="Your password" />	    	
		    	<div class="clear"></div>
		    	
		      	<label id="password_label" for="passwordValid">Confirm Password</label>
		      	<input type="password" name="passwordValid" size="16" id="passwordValid" title="Your password again" />	    	
		    	<div class="clear"></div>
		  	</div>
		  	<div class="submit">
				<input name="reset_key" type="hidden" id="reset_key" value="<?php print $user[0]->resetkey; ?>" />
		    	<input class="btn" name="commit" type="submit" value="<?php print $buttontxt; ?>" />
		  	</div>
		<?php 
		print form_fieldset_close();
		print form_close();
		?>
	<?php } else { ?>
	<?php 
	print form_open('login/forgot');
	print form_fieldset();
	?>
			<div class="login">
		      	<label id="email_address" for="login-input">Email Address</label>
		      	<input type="text" name="username" size="30" id="username" title="Your email address" class="email" value="" />
		  		<div class="clear"></div>
		  	</div>
		  	<div class="submit">
		    	<input class="btn" name="commit" type="submit" value="Reset Password" />
		  	</div>
	<?php 
	print form_fieldset_close();
	print form_close();
	?>
	<?php } ?>