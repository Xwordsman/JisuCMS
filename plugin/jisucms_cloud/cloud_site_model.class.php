<?php
defined('ROOT_PATH') or exit;

class cloud_site extends model {
    function __construct() {
        $this->table = 'cloud_site';
        $this->pri = array('cloud_site_id');
        $this->maxid = '';
    }

    public function save_connect($payload, $response) {
        $now = $_ENV['_time'];
        $cloud_site_id = $payload['cloud_site_id'];
        $old = $this->get($cloud_site_id);
        $data = array(
            'cloud_site_id' => $cloud_site_id,
            'domain' => $payload['domain'],
            'jisucms_version' => $payload['jisucms_version'],
            'php_version' => $payload['php_version'],
            'mysql_version' => $payload['mysql_version'],
            'os' => $payload['os'],
            'language' => $payload['language'],
            'theme_active' => $payload['theme_active'],
            'plugins_active' => _json_encode($payload['plugins_active']),
            'cloud_site_installed_at' => intval($payload['cloud_site_installed_at']),
            'last_connect_at' => $now,
            'last_payload' => _json_encode($payload),
            'latest_response' => _json_encode($response),
            'status' => 1,
        );

        if(empty($old)) {
            $data['first_connect_at'] = $now;
            $data['connect_count'] = 1;
            return $this->create($data);
        }

        $data['first_connect_at'] = empty($old['first_connect_at']) ? $now : intval($old['first_connect_at']);
        $data['connect_count'] = intval($old['connect_count']) + 1;
        return $this->update($data);
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
