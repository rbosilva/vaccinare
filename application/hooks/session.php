<?php

function check_session() {
    $CI =& get_instance();
    $class = $CI->router->fetch_class();
    if (empty($CI->session->user_info) && !in_array(strtolower($class), array('init', 'login'))) {
        $CI->session->session_expired = true;
        if (!$CI->input->is_ajax_request()) {
            redirect();
        } else {
            die('session_expired');
        }
    }
}
