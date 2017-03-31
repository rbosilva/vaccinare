<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vacina extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Vacina_Model', 'vacina');
    }
    
    public function index() {
        $datapost = $this->input->post(null, true);
        if (!empty($datapost)) {
            $params = formatParams($datapost);
            $data = $this->vacina->get_where($params['where'], $params['order_by'], $params['length'], $params['start']);
            $count_all = $this->vacina->count_all();
            $count_filtered = $this->vacina->count($params['where']);
            formatVars($data);
            echo formatResults($data, $count_all, $count_filtered, $params['draw']);
        } else {
            $this->load->view('vacina/list');
        }
    }
    
    public function form($id = null) {
        $dados = array();
        if (!empty($id)) {
            $dados = $this->vacina->get($id);
        }
        formatVars($dados);
        $this->load->view('vacina/form', $dados);
    }
    
    public function save() {
        $dados = $this->input->post(null, true);
        $rules = $this->vacina->get_rules_from_db(empty($dados['id']));
        foreach ($rules as &$rule) {
            if ($rule['field'] == 'lote') {
                $rule['rules'] .= '|is_natural_no_zero';
                break;
            }
        }
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            if ($this->vacina->save($dados)) {
                $this->response('success', 'Registro salvo com sucesso.');
            } else {
                $error = $this->db->error();
                $this->response('error', $error['message']);
            }
        } else {
            $this->response('error', validation_errors(' ', '<br>'));
        }
    }
    
    public function delete($id = null) {
        if ($this->vacina->delete($id)) {
            $this->response();
        } else {
            $error = $this->db->error();
            $this->response('error', $error['message']);
        }
    }
    
}
