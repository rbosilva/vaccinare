<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Init extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        if (empty($this->session->user_info)) {
            $this->load->view('login');
        } else {
            $this->load->view('index');
        }
    }

}
