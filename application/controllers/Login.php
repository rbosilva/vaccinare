<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_Model', 'usuario');
    }
    
    public function login() {
        $datapost = $this->input->post(null, true);
        if (!empty($datapost['login']) && !empty($datapost['senha'])) {
            $userdata = $this->usuario->get_user($datapost['login']);
            if (!empty($userdata)) {
                // Máximo de 5 tentativas ou 15 minutos bloqueado
                if (($userdata['tentativas'] < 5) || ((time() - $userdata['bloqueado']) >= 900)) {
                    $this->usuario->set_attempts($userdata['id'], 0, 0);
                    if (Bcrypt::check($datapost['senha'], $userdata['senha'])) {
                        $this->session->user_info = $userdata;
                    } else {
                        $this->session->invalid_user = true;
                        $this->usuario->set_attempts($userdata['id'], $userdata['tentativas'] + 1, time());
                    }
                } else {
                    $this->session->locked_user = round((900 - (time() - $userdata['bloqueado'])) / 60);
                }
            } else {
                $this->session->invalid_user = true;
            }
        }
        redirect();
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect();
    }

}
