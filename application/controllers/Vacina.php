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
    
    public function form() {
        $this->load->view('vacina/form');
    }
    
    public function save() {
        $dados = $this->input->post(null, true);
        $this->form_validation->set_rules($this->vacina->get_rules_from_db(array(
            'nome' => 'is_unique[' . $this->vacina->get_table() . '.nome]'
        )));
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
            if (stripos($error['message'], 'foreign key')) {
                $this->response('error', 'Esta Vacina já foi cadastrada no Controle de Vacinas, ' .
                                         'é necessário excluir seu vínculo antes.');
            }
            $this->response('error', $error['message']);
        }
    }
    
}
