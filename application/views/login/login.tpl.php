<?php $this->load->view('default/utility/head'); ?>
<div class="loginContainer">
	<img id="logo" src="<?php print ADMIN_THEME_URL ?>/img/logo.png" alt="<?php print SITENAME; ?>" />
		<?php if(isset($message)||isset($error)){ ?>
			<div id="message">
				<?php print isset($message) && $message!=''?'<div class="alert alert-message">'.$message.'</div>':''; ?>
				<?php print validation_errors(); ?>
				<?php print isset($error) && $error!=''?'<div class="alert alert-error">'.$error.'</div>':''; ?>
			</div>
		<?php } ?>
		<div class="clear"></div>		
		<div class="login-form">
			<?php if(isset($form)){ $this->load->view($form); } else { $this->load->view('login/login'); } ?>
		</div>
		<div class="clear"></div>

</div><!-- end container -->
<?php $this->load->view('default/utility/foot'); ?>
