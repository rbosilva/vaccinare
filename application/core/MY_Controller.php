<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
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
