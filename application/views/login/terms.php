		<?php
		print form_open('login/terms',array('id'=>'terms','class'=>'smallform'));
		// pass URL of previous page so we know which page user came from
		print form_fieldset();
		?>
		<h1>Terms & Conditions</h1>
		<p>Document goes here</p>
		<input type="checkbox" value="true" name="terms_accepted"> I have read and agree to abide by the terms and conditions of this site.
		<input type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>