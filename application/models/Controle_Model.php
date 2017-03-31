<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controle_Model
 *
 * @author rodrigobarbosa
 */
class Controle_Model extends MY_Model {
    
    public function __construct() {
        $this->set_table('controle_vacinas');
        parent::__construct();
    }
    
    public function get_where($where = null, $order_by = null, $limit = null, $offset = null, $result_type = 'array') {
        $this->db->select('cv.id, cv.data, cv.horario, cv.crianca as id_crianca, ' .
                          'c.nome as crianca, cv.vacina as id_vacina, v.nome as vacina, cv.dose');
        $this->db->from('controle_vacinas cv');
        $this->db->join('criancas c', 'cv.crianca = c.id');
        $this->db->join('vacinas v', 'cv.vacina = v.id');
        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }
        if (!empty($limit)) {
            $this->db->limit($limit);
        }
        if (!empty($offset)) {
            $this->db->offset($offset);
        }
        $sql = $this->db->get_compiled_select();
        $query = "select * from ($sql) as base";
        if (!empty($where)) {
            $query .= " where $where";
        }
        if ($result_type == 'array') {
            return $this->db->query($query)->result_array();
        }
        return $this->db->query($query)->result();
    }
    
    public function count($where) {
        $this->db->select('cv.id, cv.data, cv.horario, cv.crianca as id_crianca, ' .
                          'c.nome as crianca, cv.vacina as id_vacina, v.nome as vacina, cv.dose');
        $this->db->from('controle_vacinas cv');
        $this->db->join('criancas c', 'cv.crianca = c.id');
        $this->db->join('vacinas v', 'cv.vacina = v.id');
        $sql = $this->db->get_compiled_select();
        $this->db->reset_query();
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results("($sql) as base");
    }
    
    public function get_doses($crianca, $vacina) {
        $this->db->select('dose');
        $this->db->from($this->get_table());
        $this->db->where('crianca', $crianca);
        $this->db->where('vacina', $vacina);
        $query = $this->db->get()->result_array();
        $result = array();
        foreach ($query as $dose) {
            $result[] = $dose['dose'];
        }
        return $result;
    }
    
}
