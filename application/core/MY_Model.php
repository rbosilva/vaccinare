<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    private $table;
    private $index;
    private $rules;
    
    public function __construct() {
        parent::__construct();
        // Caso $this->table não esteja setada, usa o nome da classe
        if (empty($this->table)) {
            $this->table = strtolower(preg_replace('/(_model)$/i', 's', get_class($this)));
        }
        // Caso $this->index não esteja setado, tenta encontrar o índice da tabela automaticamente
        if (empty($this->index)) {
            $this->index = $this->db->primary($this->table);
        }
    }
    
    /**
     * Seta o nome da tabela a qual a model está relacionada
     * @param string $table
     */
    protected function set_table($table) {
        if (!empty($table)) {
            $this->table = $table;
        }
    }
    
    /**
     * Retorna o nome da tabela a qual a model está relacionada
     * @return string
     */
    public function get_table() {
        return $this->table;
    }
    
    /**
     * Seta o nome do índice da tabela
     * @param string $index
     */
    protected function set_index($index) {
        if (!empty($index)) {
            $this->index = $index;
        }
    }
    
    /**
     * Retorna o nome do índice da tabela
     * @return string
     */
    public function get_index() {
        return $this->index;
    }
    
    /**
     * Seta as regras de validação dos dados
     * @param array $rules
     */
    protected function set_rules(array $rules) {
        $this->rules = $rules;
    }
    
    /**
     * Retorna as regras de validação dos dados
     * @return array
     */
    public function get_rules() {
        return $this->rules;
    }
    
    /**
     * Se o índice da tabela for passado realiza um update,
     * caso contrário realiza um insert
     * @param array $data Os dados para inserção/alteração
     * @return int O último índice inserido na tabela (quando for insert),
     * o número de linhas afetadas (quando for update), ou false (em caso de falha)
     */
    public function save(array $data) {
        if (!empty($data) && is_array($data)) {
            if (isset($data[$this->index])) {
                $index = $data[$this->index];
                unset($data[$this->index]);
            }
            if (empty($index)) {
                if ($this->db->insert($this->table, $data)) {
                    return $this->db->insert_id();
                }
            } else {
                $this->db->where($this->index, $index);
                if ($this->db->update($this->table, $data)) {
                    return $this->db->affected_rows();
                }
            }
        }
        return false;
    }
    
    /**
     * Deleta um registro da tabela a partir do seu índice
     * @param int $index O valor do índice do registro
     * @return boolean true em caso de sucesso ou false em caso de falha
     */
    public function delete($index) {
        if (isset($index)) {
            return $this->db->delete($this->table, array($this->index => $index));
        }
        return false;
    }
    
    /**
     * Retorna todos os registros da tabela
     * @param string $order_by Os campos para ordenação da consulta
     * @param boolean $return_as_object Se passado como true retorna um objeto com os dados,
     * caso contrário retorna um array
     * @return mixed Um array ou objeto
     */
    public function all($order_by = null, $return_as_object = false) {
        $this->db->order_by($order_by);
        if ($return_as_object) {
            return $this->db->get($this->table)->result();
        }
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Retorna todos os registros da tabela que se encaixarem nas codições especificadas
     * @param array $where As condições para a consulta
     * @param array $order_by Os campos para ordenação da consulta
     * @param int $limit A quantidade máxima de registros que podem ser retornados
     * @param int $offset A partir de que registro serão retornados
     * @param boolean $return_as_object Se passado como true retorna um objeto com os dados,
     * caso contrário retorna um array
     * @return mixed Um array ou objeto
     */
    public function get_where($where = null, $order_by = null, $limit = null, $offset = null, $return_as_object = false) {
        $this->db->order_by($order_by);
        if ($return_as_object) {
            return $this->db->get_where($this->table, $where, $limit, $offset)->result();
        }
        return $this->db->get_where($this->table, $where, $limit, $offset)->result_array();
    }
    
    /**
     * Retorna o primeiro registro de uma consulta nas condições especificadas
     * @param array $where As condições para a consulta
     * @param array $order_by Os campos para ordenação da consulta
     * @param boolean $return_as_object Se passado como true retorna um objeto com os dados,
     * caso contrário retorna um array
     * @return mixed Um array ou objeto
     */
    public function get_first_where($where = null, $order_by = null, $return_as_object = false) {
        $this->db->order_by($order_by);
        if ($return_as_object) {
            return $this->db->get_where($this->table, $where)->row();
        }
        return $this->db->get_where($this->table, $where)->row_array();
    }
    
    /**
     * Retorna um registro da tabela a partir do seu índice
     * @param int $index O valor do índice do registro desejado
     * @param boolean $return_as_object Se passado como true retorna um objeto com os dados,
     * caso contrário retorna um array
     * @return mixed Um array ou false (em caso de falha)
     */
    public function get($index, $return_as_object = false) {
        if (isset($index)) {
            return $this->get_first_where(array($this->index => $index), null, $return_as_object);
        }
        return false;
    }
    
    /**
     * Conta todos os registros da consulta
     * @param array $where As condições da consulta
     * @return int
     */
    public function count($where) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Conta todos os registros da tabela
     * @return int
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
    
    /**
     * Retorna informações a respeito dos campos da tabela
     * @param boolean $return_as_object Se passado como true retorna um objeto com os dados,
     * caso contrário retorna um array
     * @return mixed Um array ou objeto
     */
    public function columns($return_as_object = false) {
        if ($return_as_object) {
            return $this->db->query("SHOW COLUMNS FROM $this->table")->result();
        }
        return $this->db->query("SHOW COLUMNS FROM $this->table")->result_array();
    }
    
    /**
     * Monta e retorna um conjunto de regras de validação a partir dos tipos de dados da tabela
     * @param array $additional_rules Regras adicionais para o retorno
     * @return array
     */
    public function get_rules_from_db(array $additional_rules = array()) {
        $integer_types = array('INTEGER', 'INT', 'SMALLINT', 'TINYINT', 'MEDIUMINT', 'BIGINT');
        $double_types = array('DECIMAL', 'NUMERIC', 'FLOAT', 'DOUBLE');
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
            } else if (in_array(strtoupper($type), $double_types, true)) {
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
