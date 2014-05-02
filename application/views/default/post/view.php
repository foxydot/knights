<?php setlocale(LC_MONETARY, 'en_US'); ?>
<div class="container-fluid post">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<h1><?php print $post->title; ?><?php if($this->authenticate->check_auth('administrators')||$this->common->is_author($user['ID'],$post->author_id)){ ?>
						<a href="/post/edit/<?php print $post->post_id; ?>" class="btn btn-default btn-sm pull-right">Edit</a>
					<?php } ?></h1>
		<div class="price pull-right">
			<label>Price<?php print stripos($post->type,'service')!==FALSE?' per hour':''; ?>:</label> <col-md-><?php print money_format('%#1.2n', (float) $post->cost); ?></col-md->
			<?php print form_open_multipart($action['buy'],array('id'=>'buy','class'=>'smallform')); ?>
			<?php print form_fieldset(); ?>
			<div class="row">
				<input name="ID" id="ID" type="hidden" value="<?php print $post->post_id; ?>" />
				<input name="author" id="author" type="hidden" value="<?php print $post->firstname.' '.$post->lastname.'<'.$post->email.'>'; ?>" />
				<input name="sender" id="sender" type="hidden" value="<?php print $user['name'].'<'.$user['email'].'>'; ?>" />
				<input name="subject" id="subject" type="hidden" value="<?php print $post->title; ?>" />
				<input class="btn btn-default btn-sm" name="submit" id="submit" type="submit" value="Buy Now" />
			</div>
			<?php
			print form_fieldset_close();
			print form_close();
			?>
		</div>
		<div class="author"><label>Posted by:</label> <col-md-><?php print $post->firstname.' '.$post->lastname; ?></col-md-></div>
		<div class="content"><?php print $post->content; ?></div>
		<?php if(isset($post->attachments)) {?>	
		<div class="images">
			<ul>
			<?php foreach($post->attachments AS $attachment){ ?>
				<li class="attachment-view">
					<img src="<?php print $attachment->attachment_url; ?>">
				</li>
			<?php } ?>
			</ul>
		</div>
		<?php } ?>
		<div class="categories"><label>Categories</label><ul><li><?php 
		if($post->postcats){
			$categories = array();
			foreach($post->postcats AS $cat){
				if(is_object($cat)){
					$categories[] = $cat->catpath;
				}
			}
			print implode('</li><li>',$categories);
		}
		?></li></ul>
		</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		
		<?php print form_open_multipart($action['contact'],array('id'=>'contact','class'=>'smallform')); ?>
		<?php print form_fieldset(); ?>
		<div class="row">
			<h2>Contact the poster</h2>
			<input name="ID" id="ID" type="hidden" value="<?php print $post->post_id; ?>" />
			<input name="author" id="author" type="hidden" value="<?php print $post->firstname.' '.$post->lastname.'<'.$post->email.'>'; ?>" />
			<input name="sender" id="sender" type="hidden" value="<?php print $user['name'].'<'.$user['email'].'>'; ?>" />
			<input name="subject" id="subject" type="hidden" value="<?php print $post->title; ?>" />
			<textarea name="message" id="message" class="tinymce"></textarea>
			<input class="btn btn-default btn-sm" name="submit" id="submit" type="submit" value="Send" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
	</div>
</div>