    <div class="container-fluid form">
	<div class="row">
        
		<?php print form_open_multipart($action,array('id'=>'post','class'=>'smallform col-md-6 col-md-offset-3')); ?>
		<?php if($msg){ 
		    foreach($msg AS $m) { ?>
		    <div class="alert alert-<?php print $m['type'] ?>">
                <button href="#" type="button" class="close" data-dismiss="alert">&times;</button>
                <?php print $m['text']; ?>
            </div>
		<?php  }
        } ?>
		<div class="alert alert-info">
            <button href="#" type="button" class="close" data-dismiss="alert">&times;</button>
            Only non-Summit identifiable items are allowed to be posted on the Knights List.
        </div>
		
		<h1><?php print $is_edit?'Edit':'New'; ?> Post</h1>
		<?php print form_fieldset(); ?>
        <input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$post->post_id.'"':''; ?> />
        <input name="org_id" id="org_id" type="hidden" value="1" />
		<div class="row">
			<div class="col-md-9"><input class="col-md-12" name="title" id="title" type="text" title="Post Title" placeholder="Post Title"<?php print $is_edit?'value="'.htmlentities($post->title, ENT_QUOTES).'"':''; ?> /></div>
<?php //TODO: Add client side validation to ensure this is a number ?>
			<div class="col-md-3"><label class="inline col-md-1">$</label><input class="col-md-11" name="cost" id="cost" type="text" title="Price" placeholder="Price"<?php print $is_edit?'value="'.$post->cost.'"':''; ?> /></div>
		</div>
		<div class="row">
		    <label>Post Type</label>
		    <div class="columns-2">
	        <?php foreach($types AS $k => $v): ?>
	            <input type="radio" name="type" id="type" value="<?php print $k; ?>"<?php print $is_edit && $post->type==$k?' CHECKED':''; ?> /> <?php print $v; ?><br />
	        <?php endforeach; ?>
	        </div>
		</div>
		<?php if(isset($post->attachments)) {?>	
		<div class="row img-display">
			<label>Images</label>
			<ul>
			<?php foreach($post->attachments AS $attachment){ ?>
				<li class="attachment-view">
					<img src="<?php print $attachment->attachment_url; ?>">
					<col-md- class="attachment-delete" id="post_id:<?php print $post->post_id; ?>:attachment_id:<?php print $attachment->ID; ?>"><i class="icon-trash"></i><col-md->
				</li>
			<?php } ?>
			</ul>
		</div>
		<?php } ?>
		<div class="row img-upload">
			<label>Add Image (Recommended photo size is less than 2MB)</label>
			<input type="file" name="attachment_url" size="20" />
			<p><em>Please note: currently, only one image may be added at a time. After saving, you will be able to edit and add another image.</em></p>
		</div>
        <div class="row">
                <input name="author_id" id="author_id" type="hidden" value="<?php print $is_edit?$post->author_id:$user['ID']; ?>" />
                <textarea class="col-md-12 tinymce" name="content" id="content" placeholder="Post Content"><?php print $is_edit?$post->content:''; ?></textarea>
        </div>
		<div class="row">
			<label>Categories</label>
        <div class="alert alert-info">
            <button href="#" type="button" class="close" data-dismiss="alert">&times;</button>
            Need another category? <a href="mailto:knights@communitylist.us">Email us!</a>
        </div>
			<div class="columns-2">
				<?php foreach($cats[0] AS $cat){ ?>
					<?php $attr = $is_edit?array('post'=>$post,'is_edit'=>$is_edit):array('is_edit'=>$is_edit); ?>
					<?php print display_cat($cats,$cat,$attr)?>
				<?php }?>
			</div>
		</div>
		<div class="row">
				<input name="submit_btn" id="submit_btn" type="submit" value="Submit" />
				<input name="delete_btn" id="delete_btn" type="button" class="btn btn-danger" value="Delete" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
	</div>
</div>

<div class="modal hide fade" id="save-msg">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Please Wait</h3>
    </div>
    <div class="modal-body">
        <p>Your post is being saved. If you used large images, this may take up to a minute. This page will refresh when saving is complete.</p>
    </div>
</div>


<?php 
function display_cat($cats,$cat,$attr=array(),$level=0){
	extract($attr);
	$selected = $is_edit && in_array($cat->ID,$post->postcats['ids'])?' CHECKED':'';
    if($cat->isparent){
        $display = '
        <label class="checkbox level-'.$level.'">
            '.$cat->title.'
        </label>';
    } else {
        $display = '
        <label class="checkbox level-'.$level.'">
            <input type="checkbox" name="cat['.$cat->ID.']" id="cat-'.$cat->ID.'" class="pull-left" value="'.$cat->ID.'"'.$selected.' /> '.$cat->title.'
        </label>';
    }
	if(isset($cats[$cat->ID])){
		foreach($cats[$cat->ID] AS $c){
			$display .= display_cat($cats,$c,$attr,$level+1);
		}
	}
	return $display;
}?>