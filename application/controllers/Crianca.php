<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crianca extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Crianca_Model', 'crianca');
    }
    
    public function index() {
        $datapost = $this->input->post(null, true);
        if (!empty($datapost)) {
            $params = formatParams($datapost);
            $data = $this->crianca->get_where($params['where'], $params['order_by'], $params['length'], $params['start']);
            $count_all = $this->crianca->count_all();
            $count_filtered = $this->crianca->count($params['where']);
            $results = formatVars($data);
            echo formatResults($results, $count_all, $count_filtered, $params['draw']);
        } else {
            $this->load->view('crianca/list');
        }
    }
    
    public function form($id = null) {
        $dados = array();
        if (!empty($id)) {
            $dados = $this->crianca->get($id);
        }
        $results = formatVars($dados);
        $this->load->view('crianca/form', $results);
    }
    
    public function save() {
        $dados = $this->input->post(null, true);
        $this->form_validation->set_rules($this->crianca->get_rules_from_db(array(
            'sexo' => 'in_list[M,F]',
            'cor_etnia' => 'in_list[Branca,Negra,Parda,Indígena,Amarela]'
        )));
        if ($this->form_validation->run()) {
            if ($this->crianca->save($dados) !== false) {
                $this->response('success', 'Registro salvo com sucesso.');
            } else {
                $error = $this->db->error();
                $this->response('error', $error['message']);
            }
        } else {
            $this->response('error', validation_errors(' ', '<br>'));
        }
    }
    
    public function delete($lote = null) {
        if ($this->crianca->delete($lote)) {
            $this->response();
        } else {
            $error = $this->db->error();
            if (stripos($error['message'], 'foreign key')) {
                $this->response('error', 'Esta Criança já foi cadastrada no Controle de Vacinas, ' .
                                         'é necessário excluir seu vínculo antes.');
            }
            $this->response('error', $error['message']);
        }
    }
    
}
