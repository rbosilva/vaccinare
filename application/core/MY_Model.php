<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    private $table;
    private $index;
    private $rules;
    
    public function __construct() {
        parent::__construct();
        if (empty($this->table)) {
            $this->table = strtolower(preg_replace('/(_model)$/i', 's', get_class($this)));
        }
        if (empty($this->index)) {
            $this->index = $this->db->primary($this->table);
        }
    }
    
    protected function set_table($table) {
        if (!empty($table)) {
            $this->table = $table;
        }
    }
    
    public function get_table() {
        return $this->table;
    }
    
    protected function set_index($index) {
        if (!empty($index)) {
            $this->index = $index;
        }
    }
    
    public function get_index() {
        return $this->index;
    }
    
    protected function set_rules(array $rules) {
        $this->rules = $rules;
    }
    
    public function get_rules() {
        return $this->rules;
    }
    
    public function save(array $data, $return_rows_updated = false) {
        if (!empty($data) && is_array($data)) {
            if (isset($data[$this->index])) {
                $index = $data[$this->index];
                unset($data[$this->index]);
            }
            if (empty($index)) {
                $this->db->insert($this->table, $data);
                return $this->db->insert_id();
            } else {
                $this->db->where($this->index, $index);
                $update = $this->db->update($this->table, $data);
                return $return_rows_updated ? $this->db->affected_rows() : $update;
            }
        }
        return false;
    }
    
    public function delete($index, $return_rows = false) {
        if (isset($index)) {
            $delete = $this->db->delete($this->table, array($this->index => $index));
            return $return_rows ? $this->db->affected_rows() : $delete;
        }
        return false;
    }
    
    public function all($order_by = null, $result_type = 'array') {
        $this->db->order_by($order_by);
        if ($result_type == 'array') {
            return $this->db->get($this->table)->result_array();
        }
        return $this->db->get($this->table)->result();
    }
    
    public function get_where($where = null, $order_by = null, $limit = null, $offset = null, $result_type = 'array') {
        $this->db->order_by($order_by);
        if ($result_type == 'array') {
            return $this->db->get_where($this->table, $where, $limit, $offset)->result_array();
        }
        return $this->db->get_where($this->table, $where, $limit, $offset)->result();
    }
    
    public function get_first_where($where = null, $order_by = null, $result_type = 'array') {
        $this->db->order_by($order_by);
        if ($result_type === 'array') {
            return $this->db->get_where($this->table, $where)->row_array();
        }
        return $this->db->get_where($this->table, $where)->row();
    }
    
    public function get($index, $result_type = 'array') {
        if (isset($index)) {
            return $this->get_first_where(array($this->index => $index), null, $result_type);
        }
        return false;
    }
    
    public function count($where) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($this->table);
    }
    
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    public function columns($result_type = 'array') {
        if ($result_type == 'array') {
            return $this->db->query("SHOW COLUMNS FROM $this->table")->result_array();
        }
        return $this->db->query("SHOW COLUMNS FROM $this->table")->result();
    }
    
    public function get_rules_from_db(array $additional_rules = array()) {
        $integer_types = array('INTEGER', 'INT', 'SMALLINT', 'TINYINT', 'MEDIUMINT', 'BIGINT');
        $float_types = array('DECIMAL', 'NUMERIC', 'FLOAT', 'DOUBLE');
        $columns = $this->columns();
        $return = array();
        foreach ($columns as $column) {
            $field = $column['Field'];
            $label = ucwords(str_replace('_', ' ', $field));
            $type = '';
            $length = null;
            sscanf($column['Type'], '%[a-z](%d)', $type, $length);
            $rules = array();
            if (strtoupper($column['Null']) == 'NO' && strtoupper($field) != strtoupper($this->index)) {
                $rules[] = 'required';
            }
            if (in_array(strtoupper($type), $integer_types, true)) {
                $rules[] = 'integer';
            } else if (in_array(strtoupper($type), $float_types, true)) {
                $rules[] = 'numeric';
            } else if (strtoupper($type) == 'DATE') {
                $rules[] = 'date';
            } else if (strtoupper($type) == 'TIME') {
                $rules[] = 'time';
            }
            if (!is_null($length)) {
                $rules[] = "max_length[$length]";
            }
            if (!empty($additional_rules)) {
                foreach ($additional_rules as $key => $value) {
                    if (strtoupper($key) == strtoupper($field)) {
                        $rules[] = $value;
                    }
                }
            }
            $return[] = array(
                'field' => $field,
                'label' => $label,
                'rules' => implode('|', $rules)
            );
        }
        return $return;
    }
    
}
