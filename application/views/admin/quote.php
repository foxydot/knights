		<?php print form_open($action,array('id'=>'quote-ribbon','class'=>'smallform')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Quote Ribbon</h1>
		<?php print form_fieldset(); ?>
		<input name="story_id" id="story_id" type="hidden" value="<?php print $story->story_id; ?>" />
		<?php if($is_edit){ ?>
			<input name="quote_id" id="quote_id" type="hidden" value="<?php print $quote->ID; ?>" />
		<?php } ?>
		<textarea name="content" id="content" placeholder="Quote Content"><?php print $is_edit?$quote->content:''; ?></textarea>
		<label>Place after: </label>
		<select name="quote_placement" id="quote_placement">
			<?php foreach($sections AS $section){ 
				if($section->type == "Sub Head"){ 
				if($is_edit){
					$selected = ($section->story_section == $quote->after_section) && ($section->story_subsection == $quote->after_subsection)?' SELECTED':'';
				}?>
				<option value="<?php print $section->story_section; ?>_<?php print $section->story_subsection; ?>"<?php print $is_edit?$selected:''; ?>><?php print $section->story_section; ?>.<?php print $section->story_subsection; ?> <?php print substr($section->content,0,80); ?></option>
			<?php }
				} ?>
		</select>
		<input name="submit" id="submit" type="submit" value="Submit" />
		<?php
		print form_fieldset_close();
		print form_close();
		?>