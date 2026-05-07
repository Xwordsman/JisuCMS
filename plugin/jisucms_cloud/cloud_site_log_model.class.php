<?php
defined('ROOT_PATH') or exit;

class cloud_site_log extends model {
    function __construct() {
        $this->table = 'cloud_site_log';
        $this->pri = array('id');
        $this->maxid = 'id';
    }

    public function add_connect($payload, $response) {
        return $this->create(array(
            'cloud_site_id' => $payload['cloud_site_id'],
            'domain' => $payload['domain'],
            'jisucms_version' => $payload['jisucms_version'],
            'event_type' => 'connect',
            'payload' => _json_encode($payload),
            'response' => _json_encode($response),
            'dateline' => $_ENV['_time'],
        ));
    }

    public function list_arr($where, $orderby, $orderway, $start, $limit, $total) {
        if($start > 1000 && $total > 2000 && $start > $total / 2) {
            $orderway = -$orderway;
            $newstart = $total - $start - $limit;
            if($newstart < 0) {
                $limit += $newstart;
                $newstart = 0;
            }
            $list_arr = $this->find_fetch($where, array($orderby => $orderway), $newstart, $limit);
            return array_reverse($list_arr, TRUE);
        }
        return $this->find_fetch($where, array($orderby => $orderway), $start, $limit);
    }
}
