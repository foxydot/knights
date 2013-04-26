		<h3><?php print $story->title.': '.$section->story_section.'.'.$section->story_subsection ?></h3>
<?php echo form_open_multipart('',array('id'=>'upload-attachment','class'=>'smallform popupform')); ?>
<?php print form_fieldset(); ?>
<?php print form_hidden('story', $story->story_id); ?>
<?php print form_hidden('section', $section->section_id); ?>
<input type="hidden" id="attachment_type" name="attachment_type">
<div class="media-buttons">
	<?php foreach($attachment_types AS $at){ ?>
		<a href="javascript:void(0);" value="<?php print $at->ID; ?>" class="media-button <?php print strtolower($at->type); ?>"><?php print $at->type; ?></a>
	<?php } ?>
	<div class="reset"><input type="reset" value="Change Type"></div>
</div>

<div class="embed-url"><label>Embed URL</label><input name="embed_url" type="text" /></div>
<div class="file-to-upload">
<label>Title</label><input name="title" type="text" />
<label>File to Upload</label>
	<input type="file" name="userfile" size="20" />
	<div class="modalquery"><input type="checkbox" name="modal" value="1" /> Use modal?</div>
</div>
<input class="submit" type="submit" value="attach" />
<?php print form_fieldset_close(); ?>
<?php print form_close(); ?>

<?php if(count($attachments)>0){ ?>
<div class="attachments-list">
	<?php foreach($attachments AS $type => $group){ ?>
		<h3><?php print ucwords($type); ?></h3>
		<ul>
		<?php 
		switch($type){ 
			case 'image': 
				foreach($group AS $attachment){
					$modal = $attachment->modal?' ismodal':'';
					print '<li class="image'.$modal.' attachment-'.$attachment->ID.'"><span class="remove" id="section_id:'.$section->section_id.':attachment_id:'.$attachment->ID.'">x</span><a class="edit" href="/admin/edit_media/'.$attachment->ID.'">edit</a><img title="'.$attachment->title.'" src="'.$attachment->attachment_url.'" style="width: 100px;" /></li>';
				}
				break; 
			case 'document': 
				foreach($group AS $attachment){
					$attachment_title = $attachment->title != ''?$attachment->title:$attachment->attachment_url;
					print '<li class="document attachment-'.$attachment->ID.'"><span class="remove" id="section_id:'.$section->section_id.':attachment_id:'.$attachment->ID.'">x</span><a class="edit" href="/admin/edit_media/'.$attachment->ID.'">edit</a><a href="'.$attachment->attachment_url.'">'.$attachment_title.'</a></li>';
				}
				break;
			case 'video': 
				foreach($group AS $attachment){
					print '<li class="video attachment-'.$attachment->ID.'"><span class="remove" id="section_id:'.$section->section_id.':attachment_id:'.$attachment->ID.'">x</span><a class="edit" href="/admin/edit_media/'.$attachment->ID.'">edit</a><a href="'.$attachment->attachment_url.'">'.$attachment->attachment_url.'</a></li>';
				}
				break;
		} ?>
		<li class="clear"></li>
		</ul>
	<?php } ?>
</div>
<?php } ?>