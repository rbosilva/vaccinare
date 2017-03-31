<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    private $table;
    private $index;
    
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
    
    protected function get_table() {
        return $this->table;
    }
    
    protected function set_index($index) {
        if (!empty($index)) {
            $this->index = $index;
        }
    }
    
    protected function get_index() {
        return $this->index;
    }
    
    public function save(array $data, $return_rows_updated = false) {
        foreach ($data as &$value) {
            if (isDateBR($value)) {
                $value = toDateUS($value);
            } else if ($float = toFloatUS($value)) {
                $value = $float;
            }
        }
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
    
    // Especifica as regras de validação de cada campo através de informações das colunas da tabela
    // o parâmetro $is_inserting só precisa ser passado caso haja um índex "unique" em $this->table
    public function get_rules_from_db($is_inserting = true) {
        $return = array();
        $columns = $this->columns();
        foreach ($columns as $column) {
            if (!is_array($column) || strtolower($column['Field']) == strtolower($this->index)) {
                continue;
            }
            $field = $column['Field'];
            $label = ucwords(str_replace('_', ' ', $field));
            $rules = '';
            if (strtoupper($column['Null']) == 'NO') {
                $rules = 'required|';
            }
            if (strtoupper($column['Key']) == 'UNI' && $is_inserting) {
                $rules .= "is_unique[$this->table.$column[Field]]|";
            }
            foreach (array('INTEGER', 'INT', 'SMALLINT', 'TINYINT', 'MEDIUMINT', 'BIGINT') as $integer_types) {
                if (strpos(strtoupper($column['Type']), $integer_types) !== false) {
                    $rules .= 'integer|';
                    break;
                }
            }
            if (strpos($rules, 'integer') === false) {
                foreach (array('DECIMAL', 'NUMERIC', 'FLOAT', 'DOUBLE') as $fixed_floating_types) {
                    if (strpos(strtoupper($column['Type']), $fixed_floating_types) !== false) {
                        $rules .= 'numeric|';
                        break;
                    }
                }
            }
            if (strtoupper($column['Type']) == 'DATE') {
                $rules .= 'date|';
            }
            if (strtoupper($column['Type']) == 'TIME') {
                $rules .= 'time|';
            }
            $return[] = array(
                'field' => $field,
                'label' => $label,
                'rules' => substr($rules, 0, -1)
            );
        }
        return $return;
    }
    
}
