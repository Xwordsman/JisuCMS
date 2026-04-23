<?php
defined('ROOT_PATH') || exit;

class log_control extends admin_control
{
    // 错误日志
    public function index()
    {
        $file = LOG_PATH . 'php_error.php';
        if (is_file($file)) {
            $cfg = $this->kv->xget('cfg');
            $byte = filesize($file);
            if (round($byte / 1048576) > $cfg['tool_log_file_max_size']) {
                exit('文件大小超出限制，建议直接下载 ' . $file . ' 查看分析');
            }
        }
        $res = $this->readLog($file);
        $this->assign('filesize', $res['filesize']);
        $total = count($res['data_arr']);

        $this->assign('total', $total);
        $data_arr = array_reverse($res['data_arr']);
        $this->assign('data_arr', $data_arr);
        $this->display();
    }

    // 404日志
    public function log404()
    {
        $file = LOG_PATH . 'php_error404.php';
        if (is_file($file)) {
            $cfg = $this->kv->xget('cfg');
            $byte = filesize($file);
            if (round($byte / 1048576) > $cfg['tool_log_file_max_size']) {
                exit('文件大小超出限制，建议直接下载 ' . $file . ' 查看分析');
            }
        }
        $res = $this->readLog($file);
        $this->assign('filesize', $res['filesize']);
        $total = count($res['data_arr']);

        $this->assign('total', $total);
        $data_arr = array_reverse($res['data_arr']);
        $this->assign('data_arr', $data_arr);
        $this->display();
    }

    // 后台登录错误日志
    public function login()
    {
        $file = LOG_PATH . 'login_log.php';
        if (is_file($file)) {
            $cfg = $this->kv->xget('cfg');
            $byte = filesize($file);
            if (round($byte / 1048576) > $cfg['tool_log_file_max_size']) {
                exit('文件大小超出限制，建议直接下载 ' . $file . ' 查看分析');
            }
        }
        $res = $this->readLog($file);
        $this->assign('filesize', $res['filesize']);
        $total = count($res['data_arr']);

        $this->assign('total', $total);
        $data_arr = array_reverse($res['data_arr']);
        $this->assign('data_arr', $data_arr);
        $this->display();
    }

    //读取
    private function readLog($file)
    {
        if (!file_exists($file)) {
            $data_arr = [];
            $filesize = 0;
        } else {
            $data_arr = [];
            $lines = 0;
            $fp = fopen($file, 'ab+');
            if ($fp) {
                $lines = file($file);
                foreach ($lines as $line_num => $line) {
                    $log_str = str_replace(
                        '<?php exit;

?>',
                        '',
                        $line
                    );
                    $log_arr = explode('  ', $log_str);

                    $data = [
                        'date' => isset($log_arr[0]) ? $log_arr[0] : '',
                        'ip' => isset($log_arr[1]) ? $log_arr[1] : '',
                        'url' => isset($log_arr[2]) ? $log_arr[2] : '',
                        'content' => isset($log_arr[3]) ? $log_arr[3] : '',
                    ];
                    $data_arr[] = $data;
                }
            }
            fclose($fp);

            $filesize = get_byte(filesize($file));
        }

        return [
            'filesize' => $filesize,
            'data_arr' => $data_arr,
        ];
    }

    //清空日志
    public function clearlog()
    {
        if ($_POST['type']) {
            $file = '';
            switch ($_POST['type']) {
                case 'error':
                    $file = LOG_PATH . 'php_error.php';
                    break;
                case 'log404':
                    $file = LOG_PATH . 'php_error404.php';
                    break;
                case 'login':
                    $file = LOG_PATH . 'login_log.php';
                    break;
                default:
                    E(1, '参数错误');
            }
            if (empty($file)) {
                E(1, '参数错误！');
            } else {
                if (is_file($file)) {
                    unlink($file);
                }
                E(0, '清空成功！');
            }
        }
    }

    //设置
    public function setting()
    {
        if (empty($_POST)) {
            $cfg = $this->kv->xget('cfg');

            $input['tool_log_file_max_size'] = form::get_number('tool_log_file_max_size', $cfg['tool_log_file_max_size']);
            $this->assign('input', $input);

            $this->display();
        } else {
            $tool_log_file_max_size = (int) R('tool_log_file_max_size', 'P');
            empty($tool_log_file_max_size) && E(1, '不能为空哦！');

            $this->kv->xset('tool_log_file_max_size', $tool_log_file_max_size, 'cfg');
            $this->kv->save_changed();
            $this->runtime->delete('cfg');

            E(0, '保存成功！');
        }
    }

    // hook admin_log_control_after.php
}
?>