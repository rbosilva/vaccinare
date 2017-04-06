<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function date($date) {
        $this->_error_messages['date'] = 'Preencha o campo "%s" corretamente.';
        return isDateUS($date);
    }
    
    public function time($time) {
        $this->_error_messages['time'] = 'Preencha o campo "%s" corretamente.';
        return isTime24h($time);
    }
    
}
