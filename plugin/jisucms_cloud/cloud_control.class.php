<?php
defined('ROOT_PATH') or exit;

class cloud_control extends control {
    public function connect() {
        if($_ENV['_method'] != 'POST') {
            $this->json(array('err' => 1, 'msg' => 'method not allowed'));
        }

        $payload = $this->get_payload();
        $payload = $this->filter_payload($payload);
        $error = $this->validate_payload($payload);
        if($error) {
            $this->json(array('err' => 1, 'msg' => $error));
        }
        if(!$this->check_rate_limit($payload['cloud_site_id'])) {
            $this->json(array('err' => 1, 'msg' => 'too many requests'));
        }

        $response = $this->make_response();

        try {
            $this->cloud_site->save_connect($payload, $response);
            $this->cloud_site_log->add_connect($payload, $response);
        } catch(Exception $e) {
            $this->json(array('err' => 1, 'msg' => 'server busy'));
        }

        $this->json($response);
    }

    public function index() {
        $this->connect();
    }

    private function get_payload() {
        $raw = file_get_contents('php://input');
        $payload = $raw ? _json_decode($raw) : array();
        if(!is_array($payload) || empty($payload)) {
            $payload = $_POST;
        }
        return is_array($payload) ? $payload : array();
    }

    private function filter_payload($payload) {
        $plugins = isset($payload['plugins_active']) && is_array($payload['plugins_active']) ? $payload['plugins_active'] : array();
        $plugins_active = array();
        foreach($plugins as $plugin) {
            $plugin = $this->safe_value($plugin, 80);
            if($plugin !== '') $plugins_active[] = $plugin;
        }

        return array(
            'cloud_site_id' => isset($payload['cloud_site_id']) ? strtolower(trim($payload['cloud_site_id'])) : '',
            'domain' => isset($payload['domain']) ? $this->safe_value($payload['domain'], 255) : '',
            'jisucms_version' => isset($payload['jisucms_version']) ? $this->safe_value($payload['jisucms_version'], 32) : '',
            'cloud_site_installed_at' => isset($payload['cloud_site_installed_at']) ? intval($payload['cloud_site_installed_at']) : 0,
            'php_version' => isset($payload['php_version']) ? $this->safe_value($payload['php_version'], 64) : '',
            'mysql_version' => isset($payload['mysql_version']) ? $this->safe_value($payload['mysql_version'], 64) : '',
            'os' => isset($payload['os']) ? $this->safe_value($payload['os'], 64) : '',
            'language' => isset($payload['language']) ? $this->safe_value($payload['language'], 32) : '',
            'theme_active' => isset($payload['theme_active']) ? $this->safe_value($payload['theme_active'], 80) : '',
            'plugins_active' => $plugins_active,
            'client_time' => isset($payload['client_time']) ? intval($payload['client_time']) : 0,
        );
    }

    private function validate_payload($payload) {
        if(empty($payload['cloud_site_id']) || !preg_match('/^[a-f0-9]{32}$/', $payload['cloud_site_id'])) return 'invalid cloud_site_id';
        if(empty($payload['domain'])) return 'domain required';
        if(strlen($payload['domain']) > 255) return 'domain too long';
        return '';
    }

    private function check_rate_limit($cloud_site_id) {
        $key = 'cloud_rate_'.$cloud_site_id;
        $data = $this->runtime->get($key);
        $count = empty($data['count']) ? 0 : intval($data['count']);
        if($count >= 60) return false;
        $this->runtime->set($key, array('count' => $count + 1), 60);
        return true;
    }

    private function safe_value($value, $length) {
        $value = trim(strip_tags((string)$value));
        $value = str_replace(array("\r", "\n", "\t"), ' ', $value);
        if(function_exists('mb_substr')) {
            return mb_substr($value, 0, $length, 'UTF-8');
        }
        return substr($value, 0, $length);
    }

    private function make_response() {
        return array(
            'err' => 0,
            'msg' => 'ok',
            'server_time' => $_ENV['_time'],
            'latest_version' => defined('JISUCMS_VERSION') ? JISUCMS_VERSION : '',
            'latest_release' => defined('JISUCMS_RELEASE') ? JISUCMS_RELEASE : '',
            'notices' => array(),
        );
    }

    private function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        exit(_json_encode($data));
    }
}
