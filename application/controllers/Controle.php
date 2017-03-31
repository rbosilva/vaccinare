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
        $this->load->view('controle/form');
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
    
    public function delete($id = null) {
        $this->check_dose_to_delete($id);
        if ($this->controle->delete($id)) {
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
    
    public function check_dose_to_delete($id) {
        $search = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $controle = $this->controle->get($search);
        if (!empty($controle)) {
            $doses_aplicadas = $this->controle->get_doses($controle['crianca'], $controle['vacina']);
            switch ($controle['dose']) {
                case 'Primeira':
                    if (in_array('Segunda', $doses_aplicadas, true)) {
                        $this->response('error', 'É necessário excluir a Segunda Dose antes.');
                    }
                case 'Segunda':
                    if (in_array('Terceira', $doses_aplicadas, true)) {
                        $this->response('error', 'É necessário excluir a Terceira Dose antes.');
                    }
                    break;
            }
        }
    }
    
    public function childs() {
        $datapost = $this->input->post();
        $where = null;
        if (!empty($datapost['term'])) {
            $search = filter_var($datapost['term'], FILTER_SANITIZE_STRING);
            $where = "nome like '%$search%'";
        }
        $page = 0;
        if (!empty($datapost['page'])) {
            $page = filter_var($datapost['page'], FILTER_SANITIZE_NUMBER_INT);
        }
        $dados = $this->crianca->get_where($where, 'nome asc', 30, 30 * $page);
        $total_count = $this->crianca->count($where);
        $result = array();
        foreach ($dados as $crianca) {
            $result[] = array(
                'id' => $crianca['id'],
                'text' => $crianca['nome']
            );
        }
        echo json_encode(array('dados' => $result, 'total_count' => $total_count));
    }
    
    public function vaccines() {
        $datapost = $this->input->post();
        $where = null;
        if (!empty($datapost['term'])) {
            $search = filter_var($datapost['term'], FILTER_SANITIZE_STRING);
            if ($float = toFloatUS($search)) {
                $search = $float;
            }
            $where = "lote like '%$search%' or nome like '%$search%'";
        }
        $page = 0;
        if (!empty($datapost['page'])) {
            $page = filter_var($datapost['page'], FILTER_SANITIZE_NUMBER_INT);
        }
        $dados = $this->vacina->get_where($where, 'lote asc, nome asc', 30, 30 * $page);
        $total_count = $this->vacina->count($where);
        $result = array();
        foreach ($dados as &$vacina) {
            formatVars($vacina['lote']);
            $result[] = array(
                'id' => $vacina['id'],
                'text' => "$vacina[lote] - $vacina[nome]"
            );
        }
        echo json_encode(array('dados' => $result, 'total_count' => $total_count));
    }
    
}
