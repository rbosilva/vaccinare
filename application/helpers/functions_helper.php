<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('evaluate')) {
    /**
     * Se $variable não existir ou for nula, retorna o valor $default, caso contrário
     * retorna o valor dela mesma
     * @param mixed $variable A variável a ser checada
     * @param mixed $default O valor a ser aplicado à $variable, caso a mesma não exista
     * @return mixed
     */
    function evaluate(&$variable, $default = '') {
        if (!isset($variable)) {
            return $default;
        } else if (is_object($variable) || is_array($variable)) {
            return $variable;
        } else {
            return htmlspecialchars($variable, ENT_QUOTES, 'UTF-8');
        }
    }
}

if (!function_exists('isDateBR')) {
    /**
     * Checa se $date está no formato "DD/MM/YYYY"
     * @param string $date A data que se deseja checar
     * @return boolean
     */
    function isDateBR($date) {
        if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            return false;
        }
        $bits = explode('/', $date);
        return checkdate($bits[1], $bits[0], $bits[2]);
    }
}

if (!function_exists('isDateUS')) {
    /**
     * Checa se $date está no formato "YYYY-MM-DD"
     * @param string $date A data que se deseja checar
     * @return boolean
     */
    function isDateUS($date) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }
        $bits = explode('-', $date);
        return checkdate($bits[1], $bits[2], $bits[0]);
    }
}

if (!function_exists('isTime24h')) {
    /**
     * Checa se $time é uma hora no formato 24h
     * @param string $time A hora que se deseja checar
     * @return true
     */
    function isTime24h($time) {
        return preg_match('/^([0-1]\d|2[0-3]):[0-5]\d$/', $time) === 1;
    }
}

if (!function_exists('toDateBR')) {
    /**
     * Retorna a data $dateUS no formato "YYYY-MM-DD" convertida para "DD/MM/YYYY"
     * @param string $dateUS A data (no formato americano) que se deseja converter
     * @return boolean
     */
    function toDateBR($dateUS) {
        if (!isDateUS($dateUS)) {
            return false;
        }
        return date('d/m/Y', strtotime($dateUS));
    }
}

if (!function_exists('toDateUS')) {
    /**
     * Retorna a data $dateBR no formato "DD/MM/YYYY" convertida para "YYYY-MM-DD"
     * @param string $dateBR A data (no formato brasileiro) que se deseja converter
     * @return boolean
     */
    function toDateUS($dateBR) {
        if (!isDateBR($dateBR)) {
            return false;
        }
        $bits = explode('/', $dateBR);
        return date('Y-m-d', strtotime(implode('-', array_reverse($bits))));
    }
}

if (!function_exists('toNumberUS')) {
    /**
     * Retorna o valor $float convertido para o formato americano (ponto para decimais sem separador para milhares)
     * ou <b>false</b> caso $float não seja um valor válido
     * @param string $float O valor que se deseja converter
     * @return boolean
     */
    function toNumberUS($float) {
        $replace1 = str_replace('.', '', $float);
        $replace2 = str_replace(',', '.', $replace1);
        if (filter_var($replace2, FILTER_VALIDATE_FLOAT)) {
            return $replace2;
        }
        return false;
    }
}

if (!function_exists('formatVars')) {
    /**
     * Formata os dados contidos em $variable de acordo com seus tipos para exibição na view
     * @param mixed $variable O valor que se deseja checar, pode ser uma variável ou array
     * @param array $ignore Os campos que a função não deve formatar (só é aplicado caso $variable seja um array)
     */
    function formatVars($variable, array $ignore = array('id')) {
        $result = array();
        if (is_array($variable)) {
            foreach ($variable as $key => $value) {
                if (!in_array($key, $ignore, true)) {
                    $result[$key] = formatVars($value, $ignore);
                } else {
                    $result[$key] = $value;
                }
            }
        } else {
            if (isDateUS($variable)) {
                $result = toDateBR($variable);
            } else if (filter_var($variable, FILTER_VALIDATE_INT)) {
                $result = number_format($variable, 0, ',', '.');
            } else if (filter_var($variable, FILTER_VALIDATE_FLOAT)) {
                $result = number_format($variable, 2, ',', '.');
            } else {
                $result = $variable;
            }
        }
        return $result;
    }
}

if (!function_exists('format_params')) {
    /**
     * Retorna os parâmetros passados pelo plugin Datatables validados e formatados
     * @param array $params Os parâmetros passados pelo componente
     * @return array
     */
    function formatParams(array $params) {
        $where = null;
        if (!empty($params['search']['value'])) {
            $search_value = filter_var($params['search']['value'], FILTER_SANITIZE_STRING);
            if (($float = toNumberUS($search_value)) !== false) {
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
                    $column = filter_var($params['columns'][$column_position]['data'], FILTER_SANITIZE_STRING);
                    $dir = filter_var($field['dir'], FILTER_SANITIZE_STRING);
                    $order_by[] = "$column $dir";
                }
            }
            $order_by = implode(', ', $order_by);
        }
        $draw = (int) filter_var($params['draw'], FILTER_SANITIZE_NUMBER_INT);
        $length = (int) filter_var($params['length'], FILTER_SANITIZE_NUMBER_INT);
        $start = (int) filter_var($params['start'], FILTER_SANITIZE_NUMBER_INT);
        return array(
            'draw' => $draw,
            'length' => $length,
            'start' => $start,
            'where' => $where,
            'order_by' => $order_by
        );
    }
}

if (!function_exists('format_results')) {
    /**
     * Retorna os dados formatados para serem enviados ao plugin Datatables
     * @param array $data Um array contendo os dados da tabela
     * @param int $recordsTotal O total de registros retornados
     * @param int $recordsFiltered O total de registros filtrados
     * @param int $draw Parâmetro requerido pelo Datatables, basicamente é a
     * resposta do parametro "draw" recebido em format_params 
     * @param callable $callback [optional] O callback que é aplicado durante a montagem do retorno
     * @return string
     */
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
            "draw" => (int) $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ));
    }
}
