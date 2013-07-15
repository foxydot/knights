<div class="container-fluid post">
	<div class="row-fluid">
		<h1><?php print $post->title; ?><?php if($this->authenticate->check_auth('administrators')||$this->common->is_author($user['ID'],$post->author_id)){ ?>
						<a href="/post/edit/<?php print $post->post_id; ?>" class="btn pull-right">Edit</a>
					<?php } ?></h1>
		<div class="price pull-right"><label>Asking Price:</label> <span><?php print $post->cost; ?></span></div>
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
</div>