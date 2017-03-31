<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controle extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Controle_Model', 'controle');
        $this->load->model('Crianca_Model', 'crianca');
        $this->load->model('Vacina_Model', 'vacina');
    }
    
    public function index() {
        $datapost = $this->input->post(null, true);
        if (!empty($datapost)) {
            $params = formatParams($datapost);
            $data = $this->controle->get_where($params['where'], $params['order_by'], $params['length'], $params['start']);
            $count_all = $this->controle->count_all();
            $count_filtered = $this->controle->count($params['where']);
            formatVars($data, array('id', 'id_crianca', 'id_vacina'));
            echo formatResults($data, $count_all, $count_filtered, $params['draw'], function (&$row) {
                $row['crianca'] = "<a href='#' title='Visualizar Criança' class='visualizar-crianca' data-id-crianca='$row[id_crianca]'>$row[crianca]</a>";
                $row['vacina'] = "<a href='#' title='Visualizar Vacina' class='visualizar-vacina' data-id-vacina='$row[id_vacina]'>$row[vacina]</a>";
            });
        } else {
            $this->load->view('controle/list');
        }
    }
    
    public function form() {
        $crianca_list = $this->crianca->all('nome asc');
        $vacina_list = $this->vacina->all('data_validade asc, lote desc');
        $dados = compact('crianca_list', 'vacina_list');
        formatVars($dados);
        $this->load->view('controle/form', $dados);
    }
    
    public function save() {
        $dados = $this->input->post(null, true);
        $this->form_validation->set_rules($this->controle->get_rules_from_db(true));
        if ($this->form_validation->run()) {
            $doses_aplicadas = $this->controle->get_doses($dados['crianca'], $dados['vacina']);
            $this->check_dose($dados['dose'], $doses_aplicadas);
            if ($this->controle->save($dados)) {
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
        if ($this->controle->delete($lote)) {
            $this->response();
        } else {
            $error = $this->db->error();
            $this->response('error', $error['message']);
        }
    }
    
    public function check_dose($dose, $doses_aplicadas) {
        if (in_array($dose, $doses_aplicadas)) {
            $this->response('error', 'A Dose selecionada desta Vacina já foi cadastrada para esta Criança.');
        }
        if (in_array('Única', $doses_aplicadas)) {
            $this->response('error', 'A Dose Única desta Vacina já foi cadastrada para esta Criança.');
        }
        switch ($dose) {
            case 'Primeira':
                if (in_array('Segunda', $doses_aplicadas)) {
                    $this->response('error', 'A Segunda Dose desta Vacina já foi cadastrada para esta Criança.');
                }
                if (in_array('Terceira', $doses_aplicadas)) {
                    $this->response('error', 'A Terceira Dose desta Vacina já foi cadastrada para esta Criança.');
                }
                break;
            case 'Segunda':
                if (!in_array('Primeira', $doses_aplicadas)) {
                    $this->response('error', 'A Primeira Dose desta Vacina ainda não foi cadastrada para esta Criança.');
                }
                if (in_array('Terceira', $doses_aplicadas)) {
                    $this->response('error', 'A Terceira Dose desta Vacina já foi cadastrada para esta Criança.');
                }
                break;
            case 'Terceira':
                if (!in_array('Primeira', $doses_aplicadas)) {
                    $this->response('error', 'A Primeira Dose desta Vacina ainda não foi cadastrada para esta Criança.');
                }
                if (!in_array('Segunda', $doses_aplicadas)) {
                    $this->response('error', 'A Segunda Dose desta Vacina ainda não foi cadastrada para esta Criança.');
                }
                break;
            case 'Única':
                if (in_array('Primeira', $doses_aplicadas) || in_array('Segunda', $doses_aplicadas) ||
                    in_array('Terceira', $doses_aplicadas)) {
                    $this->response('error', 'Outras Doses desta Vacina já foram cadastradas para esta Criança.');
                }
        }
    }
    
}
