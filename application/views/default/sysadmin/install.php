<?php 
if(isset($msg)){ print $msg; }
$this->load->helper('form');
print form_open('install',array('id'=>'login'));
print form_label('Admin Email');
print form_input('user_email','');
print '<br>';
print form_label('Admin Password');
print form_password('user_pwd','');
print '<br>';
print form_label('Admin Password Again');
print form_password('user_pwd_chk','');
print '<br>';
print form_label('Admin First Name');
print form_input('user_fname','');
print '<br>';
print form_label('Admin Last Name');
print form_input('user_lname','');
print '<br>';
print form_label('Install Data?');
print form_checkbox('installdata', 'true', FALSE);
print '<br>';
print form_submit('submit','install');
print form_close();
?>