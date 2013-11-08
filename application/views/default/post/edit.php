    <div class="container-fluid form">
	<div class="row-fluid">
        
		<?php print form_open_multipart($action,array('id'=>'post','class'=>'smallform span6 offset3')); ?>
		<div class="alert alert-info">
            <button href="#" type="button" class="close" data-dismiss="alert">&times;</button>
            Only non-Summit identifiable items are allowed to be posted on the Knights List.
        </div>
		
		<h1><?php print $is_edit?'Edit':'New'; ?> Post</h1>
		<?php print form_fieldset(); ?>
		<div class="row-fluid">
			<input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$post->post_id.'"':''; ?> />
			<input name="org_id" id="org_id" type="hidden" value="1" />
			<input class="span9" name="title" id="title" type="text" title="Post Title" placeholder="Post Title"<?php print $is_edit?'value="'.$post->title.'"':''; ?> />
			<input class="span3" name="cost" id="cost" type="text" title="Price" placeholder="Price"<?php print $is_edit?'value="'.$post->cost.'"':''; ?> />
		</div>
		<div class="row-fluid">
		    <label>Post Type</label>
		    <select name="type" id="type">
		        <?php foreach($types AS $k => $v): ?>
		            <option value="<?php print $k; ?>"<?php print $is_edit && $post->type==$k?' SELECTED':''; ?>><?php print $v; ?></option>
		        <?php endforeach; ?>
		    </select>
		</div>
		<?php if(isset($post->attachments)) {?>	
		<div class="row-fluid img-display">
			<label>Images</label>
			<ul>
			<?php foreach($post->attachments AS $attachment){ ?>
				<li class="attachment-view">
					<img src="<?php print $attachment->attachment_url; ?>">
					<span class="attachment-delete" id="post_id:<?php print $post->post_id; ?>:attachment_id:<?php print $attachment->ID; ?>"><i class="icon-trash"></i><span>
				</li>
			<?php } ?>
			</ul>
		</div>
		<?php } ?>
		<div class="row-fluid img-upload">
			<label>Add Image</label>
			<input type="file" name="attachment_url" size="20" />
		</div>
		<div class="row-fluid">
				<input name="author_id" id="author_id" type="hidden" value="<?php print $is_edit?$post->author_id:$user['ID']; ?>" />
				<textarea class="span12 tinymce" name="content" id="content" placeholder="Post Content"><?php print $is_edit?$post->content:''; ?></textarea>
		</div>
		<div class="row-fluid">
			<label>Categories</label>
			<div class="columns-3">
				<?php foreach($cats[0] AS $cat){ ?>
					<?php $attr = $is_edit?array('post'=>$post,'is_edit'=>$is_edit):array('is_edit'=>$is_edit); ?>
					<?php print display_cat($cats,$cat,$attr)?>
				<?php }?>
			</div>
		</div>
		<div class="row-fluid">
				<input name="submit_btn" id="submit_btn" type="submit" value="Submit" />
				<input name="delete_btn" id="delete_btn" type="button" class="btn btn-danger" value="Delete" />
		</div>
		<?php
		print form_fieldset_close();
		print form_close();
		?>
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