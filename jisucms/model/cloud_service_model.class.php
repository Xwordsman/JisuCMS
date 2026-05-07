<?php
defined('ROOT_PATH') or exit;

class cloud_service extends model {
    const INTERVAL = 86400;
    const FAILURE_INTERVAL = 300;
    const DEFAULT_API_URL = 'https://www.jisucms.com/api/v1/cloud/connect';
    const DEFAULT_FALLBACK_API_URL = 'https://www.jisucms.com/index.php?cloud-connect';

    public function ensure_identity() {
        $cfg = $this->kv->xget('cfg');
        $changed = 0;
        $now = time();

        if(empty($cfg['cloud_site_id']) || !preg_match('/^[a-f0-9]{32}$/', $cfg['cloud_site_id'])) {
            $cfg['cloud_site_id'] = $this->make_cloud_site_id();
            $this->kv->xset('cloud_site_id', $cfg['cloud_site_id'], 'cfg');
            $changed = 1;
        }

        if(empty($cfg['cloud_site_installed_at'])) {
            $cfg['cloud_site_installed_at'] = $now;
            $this->kv->xset('cloud_site_installed_at', $cfg['cloud_site_installed_at'], 'cfg');
            $changed = 1;
        }

        $fingerprint = $this->make_fingerprint();
        if(empty($cfg['cloud_site_fingerprint'])) {
            $cfg['cloud_site_fingerprint'] = $fingerprint;
            $this->kv->xset('cloud_site_fingerprint', $fingerprint, 'cfg');
            $changed = 1;
        } elseif($this->should_regenerate_cloud_site_id($cfg['cloud_site_fingerprint'], $fingerprint)) {
            $cfg['cloud_site_id'] = $this->make_cloud_site_id();
            $cfg['cloud_site_fingerprint'] = $fingerprint;
            $cfg['cloud_site_installed_at'] = $now;
            $cfg['cloud_last_connect_at'] = 0;
            $cfg['cloud_last_response'] = '';
            $this->kv->xset('cloud_site_id', $cfg['cloud_site_id'], 'cfg');
            $this->kv->xset('cloud_site_fingerprint', $cfg['cloud_site_fingerprint'], 'cfg');
            $this->kv->xset('cloud_site_installed_at', $cfg['cloud_site_installed_at'], 'cfg');
            $this->kv->xset('cloud_last_connect_at', 0, 'cfg');
            $this->kv->xset('cloud_last_response', '', 'cfg');
            $changed = 1;
        }

        if(!isset($cfg['cloud_last_connect_at'])) {
            $this->kv->xset('cloud_last_connect_at', 0, 'cfg');
            $changed = 1;
        }

        if(!isset($cfg['cloud_last_response'])) {
            $this->kv->xset('cloud_last_response', '', 'cfg');
            $changed = 1;
        }

        if(empty($cfg['cloud_api_url'])) {
            $this->kv->xset('cloud_api_url', self::DEFAULT_API_URL, 'cfg');
            $changed = 1;
        }

        if($changed) {
            $this->kv->save_changed();
            $this->runtime->delete('cfg');
        }

        return $this->kv->xget('cfg');
    }

    public function maybe_connect() {
        $cfg = $this->ensure_identity();
        $last = empty($cfg['cloud_last_connect_at']) ? 0 : intval($cfg['cloud_last_connect_at']);
        $last_response = $this->get_last_response();
        $interval = empty($last_response) || (isset($last_response['err']) && intval($last_response['err'])) ? self::FAILURE_INTERVAL : self::INTERVAL;
        if($last && time() - $last < $interval) {
            return $this->get_last_response();
        }
        return $this->do_connect($cfg);
    }

    public function force_connect() {
        return $this->do_connect($this->ensure_identity());
    }

    public function get_last_response() {
        $cfg = $this->kv->xget('cfg');
        if(empty($cfg['cloud_last_response'])) return array();
        $response = _json_decode($cfg['cloud_last_response']);
        return is_array($response) ? $response : array();
    }

    public function get_latest_version() {
        $response = $this->get_last_response();
        return isset($response['latest_version']) ? $response['latest_version'] : '';
    }

    public function make_cloud_site_id() {
        return random(32, 2, '0123456789abcdef');
    }

    public function make_fingerprint() {
        $master = isset($_ENV['_config']['db']['master']) ? $_ENV['_config']['db']['master'] : array();
        $parts = array(
            defined('ROOT_PATH') ? ROOT_PATH : '',
            isset($master['host']) ? $master['host'] : '',
            isset($master['name']) ? $master['name'] : '',
            isset($master['port']) ? $master['port'] : ''
        );
        return hash('sha256', implode('|', $parts));
    }

    public function should_regenerate_cloud_site_id($old_fingerprint, $new_fingerprint) {
        return $old_fingerprint && $new_fingerprint && $old_fingerprint !== $new_fingerprint;
    }

    public function do_connect($cfg) {
        $now = time();
        $url = empty($cfg['cloud_api_url']) ? self::DEFAULT_API_URL : $cfg['cloud_api_url'];
        $response = $this->http_post_json($url, $this->collect_payload($cfg), 3);
        if(!is_array($response) && $url == self::DEFAULT_API_URL) {
            $url = self::DEFAULT_FALLBACK_API_URL;
            $response = $this->http_post_json($url, $this->collect_payload($cfg), 3);
        }
        if(!is_array($response)) {
            $response = array('err' => 1, 'msg' => 'connect failed', 'time' => $now);
        }

        $this->kv->xset('cloud_last_connect_at', $now, 'cfg');
        $this->kv->xset('cloud_last_response', _json_encode($response), 'cfg');
        $this->kv->save_changed();
        $this->runtime->delete('cfg');

        return $response;
    }

    private function collect_payload($cfg) {
        return array(
            'cloud_site_id' => isset($cfg['cloud_site_id']) ? $cfg['cloud_site_id'] : '',
            'domain' => $this->get_domain($cfg),
            'jisucms_version' => defined('JISUCMS_VERSION') ? JISUCMS_VERSION : '',
            'cloud_site_installed_at' => isset($cfg['cloud_site_installed_at']) ? intval($cfg['cloud_site_installed_at']) : 0,
            'php_version' => PHP_VERSION,
            'mysql_version' => $this->get_db_version(),
            'os' => PHP_OS,
            'language' => C('lang') ? C('lang') : 'zh-cn',
            'theme_active' => empty($cfg['theme']) ? 'default' : $cfg['theme'],
            'plugins_active' => $this->get_active_plugins(),
            'client_time' => time()
        );
    }

    private function get_domain($cfg) {
        if(!empty($cfg['webdomain'])) return $cfg['webdomain'];
        if(!empty($_SERVER['HTTP_HOST'])) return $_SERVER['HTTP_HOST'];
        return empty($_SERVER['SERVER_NAME']) ? '' : $_SERVER['SERVER_NAME'];
    }

    private function get_db_version() {
        try {
            return $this->db ? $this->db->version() : '';
        } catch(Exception $e) {
            return '';
        }
    }

    private function get_active_plugins() {
        $plugins = array();
        $file = CONFIG_PATH.'plugin.inc.php';
        if(!is_file($file)) return $plugins;
        $plugin_arr = (array)include($file);
        foreach($plugin_arr as $dir => $conf) {
            if(!empty($conf['enable'])) $plugins[] = $dir;
        }
        return $plugins;
    }

    private function http_post_json($url, $data, $timeout = 3) {
        $body = _json_encode($data);
        if(function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'User-Agent: JisuCMS/'.(defined('JISUCMS_VERSION') ? JISUCMS_VERSION : 'unknown').' CloudService'));
            if(strpos($url, 'https://') === 0) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            }
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $context = stream_context_create(array('http' => array('method' => 'POST', 'timeout' => $timeout, 'header' => "Content-Type: application/json\r\nUser-Agent: JisuCMS/".(defined('JISUCMS_VERSION') ? JISUCMS_VERSION : 'unknown')." CloudService\r\n", 'content' => $body)));
            $result = @file_get_contents($url, false, $context);
        }

        if(!$result) return false;
        $response = _json_decode($result);
        return is_array($response) ? $response : false;
    }
}
