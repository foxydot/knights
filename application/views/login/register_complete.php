		<?php
		print form_open('login/register',array('id'=>'register','class'=>'smallform'));
		// pass URL of previous page so we know which page user came from
		print form_fieldset();
		?>
		<h1>Registration Complete</h1>
		<?php if($approved){ ?>
          <p>Thank you for your registration. Your application was automatically approved. Please <a href="/">login</a>.</p>
        <?php } else { ?>
          <p>Thank you for your registration. Your application will be reviewed within 24 hours and you will receive notice when you are accepted for membership.</p>
        <?php } ?>
		<?php
		print form_fieldset_close();
		print form_close();
		?>