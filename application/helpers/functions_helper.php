<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
    Caso $variable não exista ou esteja vazia, cria a mesma com o valor $default
*/
if (!function_exists('evaluate')) {
    function evaluate(&$variable, $default = '') {
        if (!isset($variable) || is_null($variable)) {
            return $default;
        } else if (is_object($variable) || is_array($variable)) {
            return $variable;
        } else {
            return htmlspecialchars($variable, ENT_QUOTES, 'UTF-8');
        }
    }
}

/*
    Converte $dateUS no formato "YYYY-MM-DD" para "DD/MM/YYYY"
*/
if (!function_exists('toDateBR')) {
    function toDateBR($dateUS) {
        if (!isDateUS($dateUS)) {
            return false;
        }
        return date('d/m/Y', strtotime($dateUS));
    }
}

/*
    Converte $dateBR no formato "DD/MM/YYYY" para "YYYY-MM-DD"
*/
if (!function_exists('toDateUS')) {
    function toDateUS($dateBR) {
        if (!isDateBR($dateBR)) {
            return false;
        }
        $bits = explode('/', $dateBR);
        return date('Y-m-d', strtotime(implode('-', array_reverse($bits))));
    }
}

/*
    Converte $float para o formato americano (ponto para decimais sem separador para milhares)
*/
if (!function_exists('toFloatUS')) {
    function toFloatUS($float) {
        $replace1 = str_replace('.', '', $float);
        $replace2 = str_replace(',', '.', $replace1);
        if (filter_var($replace2, FILTER_VALIDATE_FLOAT)) {
            return $replace2;
        }
        return false;
    }
}

/*
    Checa se $date está no formato "DD/MM/YYYY"
*/
if (!function_exists('isDateBR')) {
    function isDateBR($date) {
        if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            return false;
        }
        $bits = explode('/', $date);
        return checkdate($bits[1], $bits[0], $bits[2]);
    }
}

/*
    Checa se $date está no formato "YYYY-MM-DD"
*/
if (!function_exists('isDateUS')) {
    function isDateUS($date) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }
        $bits = explode('-', $date);
        return checkdate($bits[1], $bits[2], $bits[0]);
    }
}

/*
    Checa se $time é uma hora no formato 24h
*/
if (!function_exists('isTime24h')) {
    function isTime24h($time) {
        return preg_match('/^([0-1]\d|2[0-3]):[0-5]\d$/', $time) == 1;
    }
}

/*
    Formata os tipos de dados para exibição na tela
*/
if (!function_exists('formatVars')) {
    function formatVars(&$variable, array $ignore = array('id')) {
        if (is_array($variable)) {
            foreach ($variable as $key => &$value) {
                if (!in_array($key, $ignore, true)) {
                    formatVars($value, $ignore);
                }
            }
        } else {
            if (isDateUS($variable)) {
                $variable = toDateBR($variable);
            } else if (filter_var($variable, FILTER_VALIDATE_INT)) {
                $variable = number_format($variable, 0, ',', '.');
            } else if (filter_var($variable, FILTER_VALIDATE_FLOAT)) {
                $variable = number_format($variable, 2, ',', '.');
            }
        }
    }
}

/*
    Valida e Formata os parâmetros passados pelo plugin Datatables
*/
if (!function_exists('format_params')) {
    function formatParams(array $params) {
        $where = null;
        if (!empty($params['search']['value'])) {
            $search_value = filter_var($params['search']['value'], FILTER_SANITIZE_STRING);
            if ($float = toFloatUS($search_value)) {
                $search_value = $float;
            }
            foreach ($params['columns'] as $column) {
                if ($column['searchable'] === 'true') {
                    $where[] = "$column[data] like '%$search_value%'";
                }
            }
            $where = implode(' or ', $where);
        }
        $order_by = null;
        if (!empty($params['order'])) {
            foreach ($params['order'] as $field) {
                $column_position = (int) filter_var($field['column'], FILTER_SANITIZE_NUMBER_INT);
                if ($params['columns'][$column_position]['orderable'] === 'true') {
                    $column = $params['columns'][$column_position]['data'];
                    $dir = filter_var($field['dir'], FILTER_SANITIZE_STRING);
                    $order_by[] = "$column $dir";
                }
            }
            $order_by = implode(', ', $order_by);
        }
        return array(
            'draw' => (int) filter_var($params['draw'], FILTER_SANITIZE_NUMBER_INT),
            'length' => (int) filter_var($params['length'], FILTER_SANITIZE_NUMBER_INT),
            'start' => (int) filter_var($params['start'], FILTER_SANITIZE_NUMBER_INT),
            'where' => $where,
            'order_by' => $order_by
        );
    }
}

/*
    Formata o retorno dos dados para o plugin Datatables
*/
if (!function_exists('format_results')) {
    function formatResults(array $data, $recordsTotal, $recordsFiltered, $draw, $callback = null) {
        foreach ($data as &$row) {
            if (isset($row['id'])) {
                $row['DT_RowData'] = array('id' => $row['id']);
            }
            $row['editar'] = '<a href="#" title="Editar"><i class="fa fa-pencil editar"></i></a>';
            $row['excluir'] = '<a href="#" title="Excluir"><i class="fa fa-remove excluir"></i></a>';
            if (is_callable($callback)) {
                $callback($row);
            }
        }
        return json_encode(array(
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ));
    }
}
