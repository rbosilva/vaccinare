<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    /**
     * Imprime uma string na tela em formato json com as informações passadas
     * @param string $type O tipo de mensagem para o retorno, error para falha ou qualquer outra coisa para sucesso
     * @param mixed $data Os dados para o retorno, pode ser uma variável ou array
     */
    protected function response($type = 'success', $data = '') {
        $return = array(
            'info' => 1
        );
        if ($type == 'error') {
            $return['info'] = 0;
        }
        if (!empty($data)) {
            if (is_array($data)) {
                unset($data['info']);
                $return = array_merge($return, $data);
            } else {
                $return['msg'] = $data;
            }
        }
        die(json_encode($return));
    }

}
