<?php
/**
 * Author: Xwordsman
 * Date: 2026-4-23
 * Description: 蜘蛛抓取记录表 model
 */

defined('ROOT_PATH') or exit;

class spider extends model {
    public $bots = array(
        'googlebot'     => '谷歌',
        'baiduspider'   => '百度',
        'sosospider'    => '搜搜',
        'msnbot'        => 'MSN',
        'sogou'         => '搜狗',
        'bingbot'       => '必应',
        'yodaobot'      => '有道',
        'bytespider'    => '今日头条',
        '360spider'     => '360',
        'yisouspider'   => '神马',
        'slurp'         => '雅虎',
        'alexa'         => 'Alexa',
        //'user'          => '用户访问',
    );

    function __construct() {
        $this->table = 'spider';	// 表名
        $this->pri = array('id');	// 主键
        $this->maxid = 'id';		// 自增字段
    }

    // 获取内容列表
    public function list_arr($where, $orderby, $orderway, $start, $limit, $total) {
        // 优化大数据量翻页
        if($start > 1000 && $total > 2000 && $start > $total/2) {
            $orderway = -$orderway;
            $newstart = $total-$start-$limit;
            if($newstart < 0) {
                $limit += $newstart;
                $newstart = 0;
            }
            $list_arr = $this->find_fetch($where, array($orderby => $orderway), $newstart, $limit);
            return array_reverse($list_arr, TRUE);
        }else{
            return $this->find_fetch($where, array($orderby => $orderway), $start, $limit);
        }
    }

    public function get_spiderhtml($default = '', $tips = '所有蜘蛛'){
        $s = '<select name="spider" id="spider" lay-filter="spider"><option value="">'.$tips.'</option>';
        foreach ($this->bots as $k => $v){
            $s .= '<option value="'.$k.'"'.($k == $default ? ' selected="selected"' : '').'>'.$v.'</option>';
        }
        $s .= '</select>';
        return $s;
    }

    //记录蜘蛛爬取日志
    public function spider_create(){
        $useragent = addslashes(strtolower($_SERVER['HTTP_USER_AGENT']));
        foreach ($this->bots as $k => $v){
            if( strpos($useragent, $k) !== false ){
                $spider = array(
                    'spider' => $k,
                    'dateline' => $_ENV['_time'],
                    'ip' => ip2long($_ENV['_ip']),
                    'url' => http().$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
                );
                $this->create($spider);
                break;
            }
        }
    }

    // 获取用户浏览器类型
    public function get_user_bs($bs = null){
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
        } else {
            return null;
        }

        // 直接检测传递的值
        if ($bs) {
            if (strpos($user_agent, strtolower($bs))) {
                return true;
            } else {
                return false;
            }
        }

        // 固定检测
        if (strpos($user_agent, 'micromessenger')) {
            $user_bs = 'Weixin';
        } elseif (strpos($user_agent, 'qq')) {
            $user_bs = 'QQ';
        } elseif (strpos($user_agent, 'weibo')) {
            $user_bs = 'Weibo';
        } elseif (strpos($user_agent, 'alipayclient')) {
            $user_bs = 'Alipay';
        } elseif (strpos($user_agent, 'trident/7.0')) {
            $user_bs = 'IE11'; // 新版本IE优先，避免360等浏览器的兼容模式检测错误
        } elseif (strpos($user_agent, 'trident/6.0')) {
            $user_bs = 'IE10';
        } elseif (strpos($user_agent, 'trident/5.0')) {
            $user_bs = 'IE9';
        } elseif (strpos($user_agent, 'trident/4.0')) {
            $user_bs = 'IE8';
        } elseif (strpos($user_agent, 'msie 7.0')) {
            $user_bs = 'IE7';
        } elseif (strpos($user_agent, 'msie 6.0')) {
            $user_bs = 'IE6';
        } elseif (strpos($user_agent, 'edge')) {
            $user_bs = 'Edge';
        } elseif (strpos($user_agent, 'firefox')) {
            $user_bs = 'Firefox';
        } elseif (strpos($user_agent, 'chrome') || strpos($user_agent, 'android')) {
            $user_bs = 'Chrome';
        } elseif (strpos($user_agent, 'safari')) {
            $user_bs = 'Safari';
        } elseif (strpos($user_agent, 'mj12bot')) {
            $user_bs = 'MJ12bot';
        } else {
            $user_bs = 'Other';
        }
        return $user_bs;
    }

    // 获取用户操作系统类型
    function get_user_os($osstr = null)
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
        } else {
            return null;
        }

        // 直接检测传递的值
        if ($osstr) {
            if (strpos($user_agent, strtolower($osstr))) {
                return true;
            } else {
                return false;
            }
        }

        if (strpos($user_agent, 'windows nt 5.0')) {
            $user_os = 'Windows 2000';
        } elseif (strpos($user_agent, 'windows nt 9')) {
            $user_os = 'Windows 9X';
        } elseif (strpos($user_agent, 'windows nt 5.1')) {
            $user_os = 'Windows XP';
        } elseif (strpos($user_agent, 'windows nt 5.2')) {
            $user_os = 'Windows 2003';
        } elseif (strpos($user_agent, 'windows nt 6.0')) {
            $user_os = 'Windows Vista';
        } elseif (strpos($user_agent, 'windows nt 6.1')) {
            $user_os = 'Windows 7';
        } elseif (strpos($user_agent, 'windows nt 6.2')) {
            $user_os = 'Windows 8';
        } elseif (strpos($user_agent, 'windows nt 6.3')) {
            $user_os = 'Windows 8.1';
        } elseif (strpos($user_agent, 'windows nt 10')) {
            $user_os = 'Windows 10';
        } elseif (strpos($user_agent, 'windows phone')) {
            $user_os = 'Windows Phone';
        } elseif (strpos($user_agent, 'android')) {
            $user_os = 'Android';
        } elseif (strpos($user_agent, 'iphone')) {
            $user_os = 'iPhone';
        } elseif (strpos($user_agent, 'ipad')) {
            $user_os = 'iPad';
        } elseif (strpos($user_agent, 'mac')) {
            $user_os = 'Mac';
        } elseif (strpos($user_agent, 'sunos')) {
            $user_os = 'Sun OS';
        } elseif (strpos($user_agent, 'bsd')) {
            $user_os = 'BSD';
        } elseif (strpos($user_agent, 'ubuntu')) {
            $user_os = 'Ubuntu';
        } elseif (strpos($user_agent, 'linux')) {
            $user_os = 'Linux';
        } elseif (strpos($user_agent, 'unix')) {
            $user_os = 'Unix';
        } else {
            $user_os = 'Other';
        }
        return $user_os;
    }

    // 格式化后显示给用户
    public function format(&$spider) {
        if(!$spider) return;

        $spider['spidername'] = '';
        foreach ($this->bots as $k => $v){
            if( $spider['spider'] == $k ){
                $spider['spidername'] = $v;
                break;
            }
        }
        $spider['dateline'] = empty($spider['dateline']) ? '0000-00-00 00:00' : date('Y-m-d H:i:s', $spider['dateline']);
        $spider['ip'] = long2ip($spider['ip']);
    }
}
