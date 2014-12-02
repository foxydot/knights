<div class="container-fluid form">
	<div class="row">
		<?php print form_open_multipart($action,array('id'=>'organization','class'=>'smallform col-md-6 col-md-offset-3')); ?>
		<h1><?php print $is_edit?'Edit':'New'; ?> Organization Information<a class="btn btn-default btn-sm cheatsheet-trigger pull-right">
		    <i class="fa fa-magic"></i>
		    </a></h1>
        <div class="row cheatsheet hidden">
            <?php print get_cheatsheet(); ?>
        </div>
		<!-- Nav tabs -->
        <ul class="nav nav-pills">
          <li class="active"><a href="#info" data-toggle="tab">Basic Info</a></li>
          <li><a href="#appearance" data-toggle="tab">Appearance</a></li>
          <li><a href="#payment" data-toggle="tab">Payment Info</a></li>
          <li><a href="#emails" data-toggle="tab">Emails</a></li>
          <li><a href="#advanced" data-toggle="tab">Advanced</a></li>
        </ul>
        
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="info">
              <?php print form_fieldset(); ?>
                <div class="row">
                    <input name="ID" id="ID" type="hidden" <?php print $is_edit?'value="'.$org->ID.'"':''; ?> />
                    <label>Organization Name</label>
                    <input class="col-md-12" name="name" id="name" type="text" title="Organization Name" placeholder="Organization Name"<?php print $is_edit?'value="'.$org->name.'"':''; ?> />
                </div>
                <div class="row">
                    <label>Organization Description</label>
                    <textarea class="col-md-12 tinymce" name="description" id="description" placeholder="Organization description"><?php print $is_edit?$org->description:''; ?></textarea>
                </div>
                <div class="row">
                    <label>Site Guidelines</label>
                    <textarea class="col-md-12 tinymce" name="meta[guidelines]" id="guidelines" placeholder="Guideline Text"><?php print $is_edit && isset($org->meta['guidelines']->meta_value)?$org->meta['guidelines']->meta_value:''; ?></textarea>
                </div>
                <?php
                print form_fieldset_close();
                ?>
          </div>
          <div class="tab-pane" id="appearance">
              <?php print form_fieldset(); ?>
                <div class="row">
                    <label>Site Title</label>
                    <input class="col-md-12" name="meta[site_title]" id="site_title" type="text" title="Site Title" placeholder="Site Title"<?php print $is_edit && isset($org->meta['site_title']->meta_value)?'value="'.$org->meta['site_title']->meta_value.'"':''; ?> />
                </div>
                <div class="row">
                    <label>Subdomain</label>
                    <input class="col-md-12" name="meta[subdomain]" id="subdomain" type="text" title="Subdomain" placeholder="Subdomain"<?php print $is_edit && isset($org->meta['subdomain']->meta_value)?'value="'.$org->meta['subdomain']->meta_value.'"':''; ?> />
                </div>
                <div class="row">
                    <label>Theme</label>
                    <select id="theme" name="meta[theme]">
                        <option value="default"<?php print isset($org->meta['theme']) && $org->meta['theme']->meta_value=='default'?' SELECTED':'' ?>>default</option>
                        <?php
                            $themedir = SITEPATH.'/assets/themes';
                            if ($handle = opendir($themedir)) {
                                while (false !== ($entry = readdir($handle))) {
                                    if(!($entry == '.' || $entry == '..' || $entry == 'default')){
                                        if(is_dir($themedir.'/'.$entry)){
                                            $selected = isset($org->meta['theme']) && $org->meta['theme']->meta_value==$entry?' SELECTED':'';
                                            print '<option value="'.$entry.'"'.$selected.'>'.$entry.'</option>';
                                            
                                        }
                                    }
                                }
                                closedir($handle);
                            } else {
                                print 'NOPE!';
                            }
                        ?>
                    </select>
                </div>
                <div class="row logo-upload"<?php print isset($org->meta['logo_url'])?' style="display:none;"':''; ?>>
                    <label>Upload Logo</label>
                    <input type="file" name="logo_url" size="20" />
                </div>
                <?php if(isset($org->meta['logo_url'])): ?>
                <div class="row logo-display">
                    <label>Logo</label><br>
                    <img src="<?php print $org->meta['logo_url']->meta_value; ?>" style="max-height:300px;max-width:300px;" />
                    <br />
                    <input class="btn btn-default btn-sm" name="change_logo" id="change_logo" type="button" value="Change Logo" />
                </div>
                <?php endif; ?>
                <div class="row img-upload"<?php print isset($org->meta['background_url'])?' style="display:none;"':''; ?>>
                    <label>Upload Background Image</label>
                    <input type="file" name="background_url" size="20" />
                </div>
                <?php if(isset($org->meta['background_url'])): ?>
                <div class="row img-display">
                    <label>Background Image</label><br>
                    <img src="<?php print $org->meta['background_url']->meta_value; ?>" style="max-height:300px;max-width:300px;" />
                    <br />
                    <input class="btn btn-default btn-sm" name="change_img" id="change_img" type="button" value="Change Background Image" />
                </div>
                <?php endif; ?>
                <?php
                if($is_edit){$colorscheme = unserialize($org->meta['colorscheme']->meta_value);}
                ?>
                <div class="row">
                    <label class="col-md-12">Color Scheme</label>
                    <div class="col-md-3 text-center">
                        <span>Background</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="background" name="meta[colorscheme][background]" value="<?php print $is_edit?$colorscheme['background']:'#BAD0DD'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['background']:'#BAD0DD'; ?>;"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Text</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="text" name="meta[colorscheme][text]" value="<?php print $is_edit?$colorscheme['text']:'#333333'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['text']:'#333333'; ?>;"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Link Color</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="link" name="meta[colorscheme][link]" value="<?php print $is_edit?$colorscheme['link']:'#2A6496'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['link']:'#2A6496'; ?>;"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Link Hover</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="highlight" name="meta[colorscheme][highlight]" value="<?php print $is_edit?$colorscheme['highlight']:'#428BCA'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['highlight']:'#428BCA'; ?>;"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Nav Bar</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="navbackground" name="meta[colorscheme][navbackground]" value="<?php print $is_edit?$colorscheme['navbackground']:'#F8F8F8'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['navbackground']:'#F8F8F8'; ?>;"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Nav Text</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="navtext" name="meta[colorscheme][navtext]" value="<?php print $is_edit?$colorscheme['navtext']:'#333333'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['navtext']:'#333333'; ?>;"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Buttons</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="navtext" name="meta[colorscheme][button]" value="<?php print $is_edit?$colorscheme['button']:'#428BCA'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['button']:'#428BCA'; ?>;"></div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Button Text</span>
                        <div class="colorSelector center-block">
                            <input type="hidden" id="navtext" name="meta[colorscheme][buttontext]" value="<?php print $is_edit?$colorscheme['buttontext']:'#FFFFFF'; ?>" />
                            <div style="background-color:<?php print $is_edit?$colorscheme['buttontext']:'#FFFFFF'; ?>;"></div>
                        </div>
                    </div>
                </div>
                <?php
                print form_fieldset_close();
                ?>
          </div>
          <div class="tab-pane" id="payment">
                <?php print form_fieldset(); ?>
                <div class="row">
                    <label class="pull-left">Use Paypal to accept payment?</label>
                    <select name="meta[use_paypal]" id="use_paypal">
                        <option value="yes"<?php print $is_edit?(!isset($org->meta['use_paypal']) || $org->meta['use_paypal']->meta_value=='yes'?' selected = "selected"':''):''; ?>>Yes</option>
                        <option value="no"<?php print $is_edit?(isset($org->meta['use_paypal']) && $org->meta['use_paypal']->meta_value=='no'?' selected = "selected"':''):''; ?>>No</option>
                    </select>
                </div>
                <div class="row paypal">
                    <label>Paypal Address</label>
                    <input class="col-md-12" name="meta[paypal]" id="paypal" type="text" placeholder="Paypal Address"<?php print $is_edit && isset($org->meta['paypal']->meta_value)?'value="'.$org->meta['paypal']->meta_value.'"':''; ?> />
                </div>
                <div class="row">
                    <label>Postal Payment Address</label>
                    <textarea class="col-md-12 tinymce" name="meta[address]" id="meta[address]" placeholder="Postal address"><?php print $is_edit?$org->meta['address']->meta_value:''; ?></textarea>
                </div>
                <?php print form_fieldset_close(); ?>
          </div>
          <div class="tab-pane" id="emails">
              <?php 
                if($is_edit){$email = unserialize($org->meta['email']->meta_value);}
                $email_types = array(
                    'product-invoice' => 'Product Invoice',
                    'service-invoice' => 'Service Invoice',
                );
                print form_fieldset();?>
                <h1>Emails</h1>
                <?php
                foreach($email_types AS $key => $value){
                    //TODO: Add javascript to make the full email panel show/hide on default use
              ?>
                <div class="row">
                    <h3 class="col-md-6"><?php print $value; ?></h3>
                    <div class="col-md-6"><span class="pull-right"><input class="email-default" type="checkbox" name="meta[email][<?php print $key; ?>][default]" id="meta-email-<?php print $key; ?>-default" value="1" <?php print $is_edit && isset($email[$key]['default'])?' checked':''; ?>><label>Use default email?</label></span></div>
                    <div class="email-fields">
                        <input class="col-md-12" name="meta[email][<?php print $key; ?>][subject]" id="meta-email-<?php print $key; ?>-subject" type="text" placeholder="Subject"<?php print $is_edit?'value="'.$email[$key]['subject'].'"':''; ?> />
                        <label>HTML Email</label>
                        <textarea class="col-md-12 tinymce" name="meta[email][<?php print $key; ?>][html]" id="meta-email-<?php print $key; ?>-html" placeholder="Leave blank to use default email"><?php print $is_edit?$email[$key]['html']:''; ?></textarea>
                        <label>Plain Text Email</label>
                        <textarea class="col-md-12" name="meta[email][<?php print $key; ?>][text]" id="meta-email-<?php print $key; ?>-text" placeholder="Leave blank to use default email"><?php print $is_edit?$email[$key]['text']:''; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <hr />
                </div>
                <?php 
                } //end foreach
                print form_fieldset_close(); 
                ?>
          </div>
          <div class="tab-pane" id="advanced">
                <?php print form_fieldset(); ?>
                <div class="row"<?php print isset($org->meta['test_csv'])?' style="display:none;"':''; ?>>
                    <label>Upload Registration Test CSV File</label>
                    <input type="file" name="test_csv" size="20" />
                </div>
                <?php if(isset($org->meta['test_csv'])): ?>
                <div class="row">
                    <label>Registration Test CSV File</label>
                    <?php print $org->meta['test_csv']->meta_value; ?>
                    <input class="btn btn-default btn-sm" name="change_csv" id="change_csv" type="button" value="Change File" />
                </div>
                <?php endif; ?>
                <div class="row">
                    <h3>Copy from another organization</h3>
                    <p>Use the following copy switches to copy all the items from one organization to another. Use with caution! This will immediately add a copy of all the selected items to this organization.</p>
                </div>
                <?php $copy_things = array(
                    'categories',
                    'help',
                    'emails'
                ); ?>
                <?php foreach($copy_things AS $thing){ ?>
                <div class="row">
                    <label>Copy <?php print $thing; ?> from</label>
                    <select name="copy[<?php print $thing; ?>]">
                        <option value="0">Do not copy</option>
                        <?php 
                        foreach($orgs as $o){
                            if($o->ID != $org->ID){
                                print '<option value="'.$o->ID.'">'.$o->name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php } ?>
                <?php print form_fieldset_close(); ?>
          </div>
        </div>
		
        <div class="row">
            <input name="submit_btn" id="submit_btn" type="submit" value="Submit" />
            <?php if($this->authenticate->check_auth('administrators')){ ?>
                <input name="delete_btn" id="delete_btn" type="button" class="btn btn-danger" value="Disable" />
            <?php } ?>
        </div>
        <?php
		print form_close();
		?>
	</div>
</div>