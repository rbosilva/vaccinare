<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modals extends MY_Controller {
    
    public function alert() {
        $data = $this->input->post(null, true);
        $this->load->view('modals/alert', $data);
    }
    
    public function confirm() {
        $data = $this->input->post(null, true);
        $this->load->view('modals/confirm', $data);
    }
    
}
