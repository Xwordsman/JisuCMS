<?php
defined('ROOT_PATH') or exit;

class cloud_admin_control extends admin_control {
    public function index() {
        $this->display('cloud_admin_index.htm');
    }

    public function get_list() {
        $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $pagenum = isset($_REQUEST['limit']) ? intval($_REQUEST['limit']) : 15;
        $keyword = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
        $where = array();
        if($keyword) {
            $keyword = safe_str(urldecode($keyword), '.:-_');
            if(preg_match('/^[a-f0-9]{32}$/', $keyword)) {
                $where['cloud_site_id'] = $keyword;
            } else {
                $where['domain'] = array('LIKE' => $keyword);
            }
        }

        $total = $this->cloud_site->find_count($where);
        $maxpage = max(1, ceil($total / $pagenum));
        $page = min($maxpage, max(1, $page));
        $list = $this->cloud_site->list_arr($where, 'last_connect_at', -1, ($page - 1) * $pagenum, $pagenum, $total);
        $data = array();
        foreach($list as $v) {
            $v['cloud_site_installed_at_text'] = empty($v['cloud_site_installed_at']) ? '' : date('Y-m-d H:i:s', $v['cloud_site_installed_at']);
            $v['first_connect_at_text'] = empty($v['first_connect_at']) ? '' : date('Y-m-d H:i:s', $v['first_connect_at']);
            $v['last_connect_at_text'] = empty($v['last_connect_at']) ? '' : date('Y-m-d H:i:s', $v['last_connect_at']);
            $plugins = _json_decode($v['plugins_active']);
            $v['plugins_active_text'] = is_array($plugins) ? implode(', ', $plugins) : '';
            $data[] = $v;
        }

        exit(json_encode(array('code' => 0, 'msg' => '', 'count' => $total, 'data' => $data)));
    }

    public function detail() {
        $cloud_site_id = trim(R('cloud_site_id'));
        if(!preg_match('/^[a-f0-9]{32}$/', $cloud_site_id)) $this->message(0, lang('data_error'), -1);
        $site = $this->cloud_site->get($cloud_site_id);
        if(empty($site)) $this->message(0, lang('data_no_exists'), -1);

        $plugins_active = _json_decode($site['plugins_active']);
        $site['plugins_active_text'] = is_array($plugins_active) ? implode(', ', $plugins_active) : '';
        $site['last_payload_text'] = $this->pretty_json($site['last_payload']);
        $site['latest_response_text'] = $this->pretty_json($site['latest_response']);
        $site['cloud_site_installed_at_text'] = empty($site['cloud_site_installed_at']) ? '' : date('Y-m-d H:i:s', $site['cloud_site_installed_at']);
        $site['first_connect_at_text'] = empty($site['first_connect_at']) ? '' : date('Y-m-d H:i:s', $site['first_connect_at']);
        $site['last_connect_at_text'] = empty($site['last_connect_at']) ? '' : date('Y-m-d H:i:s', $site['last_connect_at']);
        $this->assign('site', $site);
        $this->display('cloud_admin_detail.htm');
    }

    public function log_list() {
        $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $pagenum = isset($_REQUEST['limit']) ? intval($_REQUEST['limit']) : 15;
        $cloud_site_id = trim(R('cloud_site_id'));
        $where = array();
        if($cloud_site_id && preg_match('/^[a-f0-9]{32}$/', $cloud_site_id)) {
            $where['cloud_site_id'] = $cloud_site_id;
        }
        $total = $this->cloud_site_log->find_count($where);
        $maxpage = max(1, ceil($total / $pagenum));
        $page = min($maxpage, max(1, $page));
        $list = $this->cloud_site_log->list_arr($where, 'id', -1, ($page - 1) * $pagenum, $pagenum, $total);
        $data = array();
        foreach($list as $v) {
            $v['dateline_text'] = empty($v['dateline']) ? '' : date('Y-m-d H:i:s', $v['dateline']);
            $data[] = $v;
        }
        exit(json_encode(array('code' => 0, 'msg' => '', 'count' => $total, 'data' => $data)));
    }

    private function pretty_json($json) {
        $arr = _json_decode($json);
        return is_array($arr) ? _json_encode($arr) : $json;
    }
}
