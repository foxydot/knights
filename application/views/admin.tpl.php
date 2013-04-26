<?php if(isset($header)){ $this->load->view($header); } else { $this->load->view('admin/header'); } ?>
<?php if(isset($dashboard)){ $this->load->view($dashboard); } else { $this->load->view('admin/dashboard'); } ?>
<?php if(isset($footer)){ $this->load->view($footer); } else { $this->load->view('admin/footer'); } ?>