<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    /**
     * Checa se $date é uma data no formato americano
     * @param string $date
     * @return boolean
     */
    public function date($date) {
        $this->_error_messages['date'] = 'Preencha o campo "%s" corretamente.';
        return isDateUS($date);
    }
    
    /**
     * Checa se $time é um horário no formato 24h
     * @param string $time
     * @return boolean
     */
    public function time($time) {
        $this->_error_messages['time'] = 'Preencha o campo "%s" corretamente.';
        return isTime24h($time);
    }
    
}
