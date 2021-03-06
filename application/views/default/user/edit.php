<?php //ts_data($the_user); ?>
<div class="container-fluid form">
	<div class="row">
		<?php print form_open_multipart($action,array('id'=>'add-user','class'=>'smallform col-md-6 col-md-offset-3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> User Information</h1>
		<?php print form_fieldset(); ?>
		<div class="row">
			<input class="col-md-6" name="firstname" id="firstname" type="text" placeholder="First Name"<?php print $is_edit?'value="'.$the_user->firstname.'"':''; ?> />
			<input class="col-md-6" name="lastname" id="lastname" type="text" placeholder="Last Name"<?php print $is_edit?'value="'.$the_user->lastname.'"':''; ?> />
		</div>
		<div class="row">
			<input class="col-md-12" name="email" id="email" type="text" placeholder="Email"<?php print $is_edit?'value="'.$the_user->email.'"':''; ?> />
		</div>
		<div class="row">
			<input class="col-md-6" name="password" id="password" type="password" placeholder="<?php print $is_edit?'New ':''; ?>Password" />
			<input class="col-md-6" name="passwordtest" id="passwordtest" type="password" placeholder="<?php print $is_edit?'New ':''; ?>Password Again" />
		</div>
		<div class="row">
			<div class="col-md-6">
			<label>Access Level</label>
			<?php if($this->authenticate->check_auth('administrators')){ ?>
			<select name="accesslevel" id="accesslevel">
				<option>Access Level</option>
				<?php foreach($access AS $k=>$v){ ?>
					<option value="<?php print $k; ?>"<?php print $is_edit?($the_user->accesslevel==$k?' selected = "selected"':''):''; ?>><?php print ucwords($v); ?></option>
				<?php }	?>
			</select>
			<?php } else { ?>
			<col-md-><?php print ucwords($access[$the_user->accesslevel]); ?></col-md->
			<?php } ?>
			</div>
			<div class="col-md-6">
			<label>User Group</label>
			<?php if($this->authenticate->check_auth('administrators')){ ?>
			<select name="group_id" id="group_id">
				<option>User Group</option>
				<?php foreach($groups AS $group){ ?>
					<option value="<?php print $group->ID; ?>"<?php print $is_edit?($the_user->group_id==$group->ID?' selected = "selected"':''):''; ?>><?php print ucwords($group->name); ?></option>
				<?php }	?>
			</select>
			<?php } elseif(!empty($the_user->group_id)) { ?>
			<?php $group = $this->common->object_from_array($groups,'ID',$the_user->group_id);?>
			<col-md-><?php print ucwords($group->name); ?></col-md->
			<?php } else { ?>
			No group assigned
			<?php } ?>
			</div>
		</div>
		<div class="row">
			<label>User Photo</label>
				<input type="file" name="userfile" size="20" />
		</div>
		<div class="row">
			<label class="pull-left">Use Paypal to accept payment?</label>
			<select name="meta[use_paypal]" id="use_paypal">
				<option value="yes"<?php print $is_edit?(!isset($the_user->meta['use_paypal']) || $the_user->meta['use_paypal']->meta_value=='yes'?' selected = "selected"':''):''; ?>>Yes</option>
				<option value="no"<?php print $is_edit?(isset($the_user->meta['use_paypal']) && $the_user->meta['use_paypal']->meta_value=='no'?' selected = "selected"':''):''; ?>>No</option>
			</select>
		</div>
		<div class="row">
			<input class="col-md-12" name="meta[paypal]" id="paypal" type="text" placeholder="Your Paypal Address (the email you use to login to PayPal)"<?php print $is_edit && isset($the_user->meta['paypal']->meta_value)?'value="'.$the_user->meta['paypal']->meta_value.'"':''; ?> />
		</div>
        <div class="row">
            <br />
        </div>
        <div class="row">
            <label>Please notify me by email when new items are added to the checked categories:</label>
            <div>
                <label class="checkbox level-1">
                    <input type="checkbox" value="" class="pull-left first-child last-child odd" id="check-all" name="check-all"<?php print $is_edit?'':' CHECKED'; ?>> Check/Un-check All
                </label>
            </div>
            <div class="columns-2">
                <?php foreach($cats[0] AS $cat){ ?>
                    <?php $attr = $is_edit?array('user'=>$the_user,'is_edit'=>$is_edit):array('is_edit'=>$is_edit); ?>
                    <?php print display_cat($cats,$cat,$attr)?>
                <?php }?>
            </div>
        </div>
        <div class="row">
                <input name="submit_btn" id="submit_btn" type="submit" value="Submit" />
                <?php if($this->authenticate->check_auth('administrators')){ ?>
                    <input name="delete_btn" id="delete_btn" type="button" class="btn btn-danger" value="Delete" />
                <?php } ?>
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
    $subscribe = isset($user->meta['subscribe']->meta_value)?unserialize($user->meta['subscribe']->meta_value):array();
    if($is_edit){
        $selected = in_array($cat->ID,$subscribe)?' CHECKED':'';
    } else {
        $selected = ' CHECKED';
    }
    if($cat->isparent){
        $display = '
        <label class="checkbox level-'.$level.'">
            '.$cat->title.'
        </label>';
    } else {
        $display = '
        <label class="checkbox level-'.$level.'">
            <input type="checkbox" name="meta[subscribe]['.$cat->ID.']" id="meta-subscribe-'.$cat->ID.'" class="pull-left category-check" value="'.$cat->ID.'"'.$selected.' /> '.$cat->title.'
        </label>';
    }
    if(isset($cats[$cat->ID])){
        foreach($cats[$cat->ID] AS $c){
            $display .= display_cat($cats,$c,$attr,$level+1);
        }
    }
    return $display;
}?>