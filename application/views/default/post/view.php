<div class="container-fluid post">
	<div class="row-fluid span6 offset3">
		<h1><?php print $post->title; ?><?php if($this->authenticate->check_auth('administrators')||$this->common->is_author($user['ID'],$post->author_id)){ ?>
						<a href="/post/edit/<?php print $post->post_id; ?>" class="btn pull-right">Edit</a>
					<?php } ?></h1>
		<div class="price pull-right">
			<label>Asking Price:</label> <span><?php print $post->cost; ?></span>
			<?php print form_open_multipart($action['buy'],array('id'=>'buy','class'=>'smallform')); ?>
			<?php print form_fieldset(); ?>
			<div class="row-fluid">
				<input name="ID" id="ID" type="hidden" value="<?php print $post->post_id; ?>" />
				<input class="btn" name="submit" id="submit" type="submit" value="Buy Now" />
			</div>
			<?php
			print form_fieldset_close();
			print form_close();
			?>
		</div>
		<div class="author"><label>Posted by:</label> <span><?php print $post->firstname.' '.$post->lastname; ?></span></div>
		<div class="content"><?php print $post->content; ?></div>
		<div class="categories"><label>Categories</label><span><?php 
			foreach($post->postcats AS $cat){
				if(is_object($cat)){
					$categories[] = $cat->title;
				}
			}
			print implode(', ',$categories);
		?></span>
		</div>
	</div>
	
	<div class="row-fluid span6 offset3">
		
		<?php print form_open_multipart($action['contact'],array('id'=>'contact','class'=>'smallform')); ?>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<h2>Contact the poster</h2>
			<input name="ID" id="ID" type="hidden" value="<?php print $post->post_id; ?>" />
			<input name="author" id="author" type="hidden" value="<?php print $post->author_id; ?>" />
			<textarea name="message" id="message" class="tinymce"></textarea>
			<input class="btn" name="submit" id="submit" type="submit" value="Send" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>