<?php setlocale(LC_MONETARY, 'en_US'); ?>
<div class="container-fluid post">
	<div class="row-fluid">
		<div class="span6 offset3">
		<h1><?php print $post->title; ?>
		<div class="price pull-right">
			<span><?php print money_format('%#1.2n', (float) $post->cost); ?></span>
		</div>
		</h1>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6 offset3">
		Insert the buy logic here
		<?php print form_open_multipart('#',array('id'=>'contact','class'=>'smallform')); ?>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" value="<?php print $post->post_id; ?>" />
			<input name="author" id="author" type="hidden" value="<?php print $post->firstname.' '.$post->lastname.'<'.$post->email.'>'; ?>" />
			<input name="sender" id="sender" type="hidden" value="<?php print $user['name'].'<'.$user['email'].'>'; ?>" />
			<input name="subject" id="subject" type="hidden" value="<?php print $post->title; ?>" />
			<textarea name="message" id="message" class="tinymce"></textarea>
			<input class="btn" name="submit" id="submit" type="submit" value="Send" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
	</div>
</div>