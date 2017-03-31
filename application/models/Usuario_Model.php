<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario_Model
 *
 * @author rodrigobarbosa
 */
class Usuario_Model extends MY_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_user($login) {
        $this->db->where('login', $login);
        return $this->db->get($this->get_table())->row_array();
    }
    
    public function set_attempts($user_id, $attempts, $time_locked) {
        $this->db->set('tentativas', $attempts);
        $this->db->set('bloqueado', $time_locked);
        $this->db->where('id', $user_id);
        return $this->db->update($this->get_table());
    }
    
}
