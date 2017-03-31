<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crianca_Model
 *
 * @author rodrigobarbosa
 */
class Crianca_Model extends MY_Model {
    
    public function get_where($where = null, $order_by = null, $limit = null, $offset = null, $result_type = 'array') {
        $this->db->select("id, nome, idade, sexo, mae, cor_etnia, " .
                          "case when parto_natural = 1 then 'Natural' else 'Cesariana' end as parto_natural");
        $this->db->from($this->get_table());
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
        $this->db->select("id, nome, idade, sexo, mae, cor_etnia, " .
                          "case when parto_natural = 1 then 'Natural' else 'Cesariana' end as parto_natural");
        $this->db->from($this->get_table());
        $sql = $this->db->get_compiled_select();
        $this->db->reset_query();
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results("($sql) as base");
    }
    
}
