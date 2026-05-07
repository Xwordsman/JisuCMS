<?php
defined('ROOT_PATH') or exit;

class api_control extends control {
    protected $cfg = array();
    protected $resource = '';
    protected $id = 0;

    public function __construct() {
        $this->cfg = $this->runtime->xget('cfg');
        $this->resource = strtolower(trim(R('resource')));
        $this->id = (int)R('id');
        $this->init_cors();
        $this->check_method();
        if(empty($this->cfg['api_open'])) {
            $this->error('api closed', 403);
        }
        $this->check_rate_limit();
    }

    public function index() {
        if(empty($this->resource)) $this->resource = 'site';
        $this->dispatch($this->resource, $this->id);
    }

    public function site() {
        $this->success(array(
            'webname' => isset($this->cfg['webname']) ? $this->cfg['webname'] : '',
            'webdomain' => isset($this->cfg['webdomain']) ? $this->cfg['webdomain'] : '',
            'webdir' => isset($this->cfg['webdir']) ? $this->cfg['webdir'] : '',
            'weburl' => isset($this->cfg['weburl']) ? $this->cfg['weburl'] : '',
            'seo_title' => isset($this->cfg['seo_title']) ? $this->cfg['seo_title'] : '',
            'seo_keywords' => isset($this->cfg['seo_keywords']) ? $this->cfg['seo_keywords'] : '',
            'seo_description' => isset($this->cfg['seo_description']) ? $this->cfg['seo_description'] : '',
            'language' => C('lang') ? C('lang') : 'zh-cn',
            'version' => defined('JISUCMS_VERSION') ? JISUCMS_VERSION : '',
            'release' => defined('JISUCMS_RELEASE') ? JISUCMS_RELEASE : ''
        ));
    }

    public function categories() {
        $mid = (int)R('mid');
        $upid = R('upid') === '' ? null : (int)R('upid');
        $list = $mid ? $this->category->get_category_db_mid($mid) : $this->category->get_category_db();
        $data = array();
        foreach($list as $v) {
            if($upid !== null && (int)$v['upid'] != $upid) continue;
            $this->category->format($v);
            $data[] = $this->format_category($v);
        }
        $this->success($data);
    }

    public function category() {
        $cid = $this->id ? $this->id : (int)R('cid');
        if(empty($cid)) $this->error('cid required', 400);
        $data = $this->category->get($cid);
        if(empty($data)) $this->error('category not found', 404);
        $this->category->format($data);
        $this->success($this->format_category($data, true));
    }

    public function categories_detail() {
        $this->category();
    }

    public function contents() {
        $mid = max(2, (int)R('mid'));
        $table = $this->get_model_table($mid);
        $cid = (int)R('cid');
        $keyword = trim(urldecode(R('keyword')));
        $flag = (int)R('flag');
        $page = max(1, (int)R('page'));
        $limit = $this->get_limit();
        $where = array();
        if($cid) $where['cid'] = $cid;
        if($keyword !== '') $where['title'] = array('LIKE' => safe_str($keyword));
        if($flag) $where['flags'] = array('LIKE' => (string)$flag);

        $this->cms_content->table = 'cms_'.$table;
        $total = $this->cms_content->find_count($where);
        $maxpage = $total ? ceil($total / $limit) : 0;
        $list = $this->cms_content->list_arr($where, $this->get_orderby(), -1, ($page - 1) * $limit, $limit, $total);
        $data = array();
        foreach($list as $v) {
            $this->cms_content->format($v, $mid, 'Y-m-d H:i:s', 0, 0, 0, array('flags' => 1));
            $data[] = $this->format_content_list($v, $mid);
        }
        $this->success(array('list' => $data, 'page' => $page, 'limit' => $limit, 'total' => $total, 'maxpage' => $maxpage));
    }

    public function content() {
        $id = $this->id ? $this->id : (int)R('id');
        if(empty($id)) $this->error('id required', 400);
        $result = $this->get_content_by_id($id, (int)R('mid'));
        $mid = $result['mid'];
        $table = $result['table'];
        $data = $result['data'];
        $this->cms_content->format($data, $mid, 'Y-m-d H:i:s', 0, 0, 1, array('flags' => 1));
        $content_data = $this->cms_content_data->get_cms_content_data($id, $table);
        $data['content'] = isset($content_data['content']) ? $content_data['content'] : '';
        $this->success($this->format_content_detail($data, $mid));
    }

    public function contents_detail() {
        $this->content();
    }

    public function search() {
        $keyword = trim(urldecode(R('keyword')));
        if($keyword === '') $this->error('keyword required', 400);
        if(!empty($this->cfg['close_search'])) $this->error('search closed', 403);
        $_REQUEST['keyword'] = $keyword;
        $_GET['keyword'] = $keyword;
        $this->contents();
    }

    protected function dispatch($resource, $id = 0) {
        // hook api_control_dispatch_before.php
        if($resource == 'site') $this->site();
        if($resource == 'categories') $this->categories();
        if($resource == 'category') $this->category();
        if($resource == 'contents') $this->contents();
        if($resource == 'content') $this->content();
        if($resource == 'search') $this->search();
        // hook api_control_dispatch_after.php
        $this->error('api not found', 404);
    }

    protected function get_model_table($mid) {
        $table = isset($this->cfg['table_arr'][$mid]) ? $this->cfg['table_arr'][$mid] : '';
        if(empty($table) || $table == 'page') $this->error('model not found', 404);
        return $table;
    }

    protected function get_content_by_id($id, $mid = 0) {
        if($mid > 1) {
            $table = $this->get_model_table($mid);
            $this->cms_content->table = 'cms_'.$table;
            $data = $this->cms_content->get($id);
            if(empty($data)) $this->error('content not found', 404);
            $category = $this->category->get($data['cid']);
            if(empty($category) || (int)$category['mid'] != $mid) $this->error('content not found', 404);
            return array('mid' => $mid, 'table' => $table, 'data' => $data);
        }
        foreach((array)$this->cfg['table_arr'] as $_mid => $table) {
            $_mid = (int)$_mid;
            if($_mid <= 1 || $table == 'page') continue;
            $this->cms_content->table = 'cms_'.$table;
            $data = $this->cms_content->get($id);
            if(empty($data)) continue;
            $category = $this->category->get($data['cid']);
            if(empty($category) || (int)$category['mid'] != $_mid) continue;
            return array('mid' => $_mid, 'table' => $table, 'data' => $data);
        }
        $this->error('content not found', 404);
    }

    protected function get_limit() {
        $max = empty($this->cfg['api_limit']) ? 50 : (int)$this->cfg['api_limit'];
        $max = max(1, min(100, $max));
        $limit = (int)R('limit');
        if(empty($limit)) $limit = 20;
        return max(1, min($max, $limit));
    }

    protected function get_orderby() {
        $orderby = R('orderby');
        $allow = array('id', 'dateline', 'lasttime', 'comments');
        return in_array($orderby, $allow) ? $orderby : 'id';
    }

    protected function format_category($v, $detail = false) {
        $data = array(
            'cid' => (int)$v['cid'],
            'upid' => (int)$v['upid'],
            'mid' => (int)$v['mid'],
            'type' => (int)$v['type'],
            'name' => $v['name'],
            'alias' => $v['alias'],
            'url' => isset($v['url']) ? $v['url'] : '',
            'pic' => isset($v['pic']) ? $v['pic'] : '',
            'intro' => isset($v['intro']) ? $v['intro'] : '',
            'orderby' => isset($v['orderby']) ? (int)$v['orderby'] : 0
        );
        if($detail) {
            $data['seo_title'] = isset($v['seo_title']) ? $v['seo_title'] : '';
            $data['seo_keywords'] = isset($v['seo_keywords']) ? $v['seo_keywords'] : '';
            $data['seo_description'] = isset($v['seo_description']) ? $v['seo_description'] : '';
        }
        return $data;
    }

    protected function format_content_list($v, $mid) {
        return array(
            'id' => (int)$v['id'],
            'cid' => (int)$v['cid'],
            'mid' => (int)$mid,
            'title' => $v['title'],
            'intro' => $v['intro'],
            'pic' => isset($v['pic']) ? $v['pic'] : '',
            'pic_url' => isset($v['pic_url']) ? $v['pic_url'] : '',
            'author' => $v['author'],
            'source' => $v['source'],
            'dateline' => (int)$v['dateline'],
            'date' => isset($v['date']) ? $v['date'] : '',
            'comments' => (int)$v['comments'],
            'url' => isset($v['url']) ? $v['url'] : '',
            'absolute_url' => isset($v['absolute_url']) ? $v['absolute_url'] : '',
            'tags' => isset($v['tag_arr']) ? $v['tag_arr'] : array(),
            'flags' => isset($v['flag_arr']) ? $v['flag_arr'] : array()
        );
    }

    protected function format_content_detail($v, $mid) {
        $data = $this->format_content_list($v, $mid);
        $data['content'] = isset($v['content']) ? $v['content'] : '';
        $data['seo_title'] = isset($v['seo_title']) ? $v['seo_title'] : '';
        $data['seo_keywords'] = isset($v['seo_keywords']) ? $v['seo_keywords'] : '';
        $data['seo_description'] = isset($v['seo_description']) ? $v['seo_description'] : '';
        return $data;
    }

    protected function init_cors() {
        if(!empty($this->cfg['api_allow_origin'])) {
            $origin = str_replace(array("\r", "\n"), '', $this->cfg['api_allow_origin']);
            header('Access-Control-Allow-Origin: '.$origin);
            header('Access-Control-Allow-Methods: GET, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
        }
        if($_ENV['_method'] == 'OPTIONS') exit;
    }

    protected function check_method() {
        if($_ENV['_method'] != 'GET') $this->error('method not allowed', 405);
    }

    protected function check_rate_limit() {
        $limit = empty($this->cfg['api_rate_limit']) ? 120 : (int)$this->cfg['api_rate_limit'];
        if($limit < 1) return;
        $ip = isset($_ENV['_ip']) ? $_ENV['_ip'] : '0.0.0.0';
        $key = 'api_rate_'.md5($ip);
        $data = $this->runtime->get($key);
        $count = empty($data['count']) ? 0 : (int)$data['count'];
        if($count >= $limit) $this->error('too many requests', 429);
        $this->runtime->set($key, array('count' => $count + 1), 60);
    }

    protected function success($data = array(), $msg = 'ok') {
        $this->json(array('err' => 0, 'msg' => $msg, 'data' => $data, 'time' => $_ENV['_time']));
    }

    protected function error($msg = 'error', $err = 1) {
        $this->json(array('err' => $err, 'msg' => $msg, 'time' => $_ENV['_time']));
    }

    protected function json($data) {
        header('Content-Type: application/json; charset=utf-8');
        exit(_json_encode($data));
    }
}
