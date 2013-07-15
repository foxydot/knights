<?php $this->load->view('default/utility/head'); ?>
<?php if(isset($header)){ $this->load->view($header); } else { $this->load->view('default/header'); } ?>
<?php if(isset($nav)){ $this->load->view($nav); } else { $this->load->view('default/nav'); } ?>
<?php if(isset($dashboard)){ $this->load->view($dashboard); } else { $this->load->view('default/dashboard'); } ?>
<?php if(isset($footer)){ $this->load->view($footer); } else { $this->load->view('default/footer'); } ?>
<?php $this->load->view('default/utility/foot'); ?>