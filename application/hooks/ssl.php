<?php

/**
 * Força o uso de SSL (HTTPS)
 */
function redirect_ssl() {
    $CI =& get_instance();
    // redirecting to ssl.
    $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
    if ($_SERVER['SERVER_PORT'] != 443) {
        redirect($CI->uri->uri_string());
    }
}
