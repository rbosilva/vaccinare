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
    
    /**
     * Retorna informações de um usuário selecionado pelo seu login
     * @param string $login
     * @return array
     */
    public function get_user($login) {
        $this->db->where('login', $login);
        return $this->db->get($this->get_table())->row_array();
    }
    
    /**
     * Seta o número de tentativas de login
     * @param int $user_id O id do usuário
     * @param int $attempts O número de tentativas
     * @param float $time_locked O tempo de bloqueio restante (em segundos)
     */
    public function set_attempts($user_id, $attempts, $time_locked) {
        $this->db->set('tentativas', $attempts);
        $this->db->set('bloqueado', $time_locked);
        $this->db->where('id', $user_id);
        $this->db->update($this->get_table());
    }
    
}
