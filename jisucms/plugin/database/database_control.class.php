<?php
defined('ROOT_PATH') or exit;

class database_control extends admin_control {

    //备份文件所在文件夹
    public $backuppath = ROOT_PATH.'upload/backup/database/';

	// 管理
	public function index() {
		$this->display();
	}

	public function get_list(){
        $sql = "SHOW TABLE STATUS";
        $cms_arr = $this->db->fetch_all($sql);
        foreach($cms_arr as &$v) {
            $v['size'] = get_byte($v['Data_length']);
        }

        //组合数据 输出到页面
        $arr = array(
            'code' => 0,
            'msg' => '',
            'count' => count($cms_arr),
            'data' => $cms_arr,
        );
        exit( json_encode($arr) );
    }

	//备份
    public function export($start = 0){
        if(!empty($_POST)) {
            $tables = R('id_arr', 'P');
            if(empty($tables) || !is_array($tables)) {
                E(1,'请选择数据表！');
            }

            $config = array(
                'path'     => $this->backuppath,
                'part'     => 20971520 ,//数据库备份卷大小20M
                'compress' => 1 ,//数据库备份文件是否启用压缩 0不压缩 1 压缩
                'level'    => 4 ,//数据库备份文件压缩级别 1普通 4 一般  9最高
                'db'       => $_ENV['_config']['db']['master'] ,
                'dbobj'    => $this->db ,
            );
            $time = $_ENV['_time'];
            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if(is_file($lock)){
                E(1,'有任务正在执行，请等候！');
            } else {
                //创建锁文件
                FW($lock, $time);
            }
            //生成备份文件信息
            $file = array(
                'name' => date('Ymd-His', $time),
                'part' => 1,
            );
            // 创建备份文件
            include_once PLUGIN_PATH.'database/lib/Database.php';
            $database = new Database($file, $config);
            if($database->create() !== false) {
                // 备份指定表
                foreach ($tables as $table) {
                    $start = $database->backup($table, $start);
                    while (0 !== $start) {
                        if (false === $start) {
                            E(1, $table.' 备份失败！');
                        }
                        $start = $database->backup($table, $start[0]);
                    }
                }
                // 备份完成，删除锁定文件
                unlink($lock);
            }
            E(0, '备份完成！');
        }
    }

    //还原
    public function import(){
	    if( empty($_POST) ){
            $path = $this->backuppath;
            if (!is_dir($path)) {
                $path = str_replace("\\", "/", $path);
                if(substr($path, -1) != '/') $path = $path.'/';
                $temp = explode('/', $path);
                $cur_dir = '';
                $max = count($temp) - 1;
                for($i=0; $i<$max; $i++) {
                    $cur_dir .= $temp[$i].'/';
                    if (@is_dir($cur_dir)) continue;
                    @mkdir($cur_dir, 0755, true);
                    @chmod($cur_dir, 0755);
                }
            }
            $flag = \FilesystemIterator::KEY_AS_FILENAME;
            $glob = new \FilesystemIterator($path,  $flag);
            $list = array();
            foreach ($glob as $name => $file) {
                if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
                    $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
                    $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                    $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                    $part = $name[6];

                    if(isset($list["{$date} {$time}"])){
                        $info = $list["{$date} {$time}"];
                        $info['part'] = max($info['part'], $part);
                        $info['size'] = $info['size'] + $file->getSize();
                    } else {
                        $info['part'] = $part;
                        $info['size'] = $file->getSize();
                    }

                    $extension        = strtoupper($file->getExtension());
                    $info['compress'] = ($extension === 'SQL') ? '无' : $extension;
                    $info['time']     = strtotime("{$date} {$time}");

                    $list["{$date} {$time}"] = $info;
                }
            }
            $this->assign('cms_arr', $list);
            $this->display();
        }else{
            $k = R('k','P');
            $name  = date('Ymd-His', $k) . '-*.sql*';
            $path = $this->backuppath.$name;
            $files = glob($path);
            $list  = array();
            foreach($files as $name){
                $basename = basename($name);
                $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $list[$match[6]] = array($match[6], $name, $gz);
            }
            ksort($list);

            // 检测文件正确性
            $last = end($list);
            if(count($list) === $last[0]){
                include_once PLUGIN_PATH.'database/lib/Database.php';
                foreach ($list as $item) {
                    $config = array(
                        'path'     => $this->backuppath,
                        'compress' => $item[2],
                        'db'       => $_ENV['_config']['db']['master'] ,
                        'dbobj'    => $this->db
                    );
                    $database = new Database($item, $config);
                    $start = $database->import(0);
                    // 导入所有数据
                    while (0 !== $start) {
                        if (false === $start) {
                            E(1, '数据恢复出错');
                        }
                        $start = $database->import($start[0]);
                    }
                }
                E(0, '数据恢复完成！');
            }
            E(1, '备份文件可能已经损坏，请检查！');
        }
    }


    //删除备份
    public function del(){
	    if( !empty($_POST) ){
	        $k = R('k','P');
            $name  = date('Ymd-His', $k) . '-*.sql*';
            $path = $this->backuppath.$name;
            array_map("unlink", glob($path));

            if(count(glob($path)) && glob($path)){
                E(1, '删除失败！');
            }
            E(0, '删除成功');
        }
    }

    //批量优化
    public function batchoptimize(){
        $id_arr = R('id_arr', 'P');
        if(!empty($id_arr) && is_array($id_arr)) {
            $err_num = 0;
            foreach($id_arr as $v) {
                $err = $this->optimize($v);
                if($err == FALSE) $err_num++;
            }

            if($err_num) {
                E(1, $err_num.' 条数据优化失败！');
            }else{
                E(0, '优化完成！');
            }
        }else{
            E(1, '参数不能为空！');
        }
    }


    //优化
    public function optimizetable(){
        $table = R('table', 'P');

        $this->optimize($table);
        E(0,'优化完成！');
    }

    //优化表的SQL
    private function optimize($table=''){
        $sql = 'OPTIMIZE TABLE '.$this->_safe_replace($table);
        return $this->db->query($sql);
    }

    //批量修复
    public function batchrepair(){
        $id_arr = R('id_arr', 'P');
        if(!empty($id_arr) && is_array($id_arr)) {
            $err_num = 0;
            foreach($id_arr as $v) {
                $err = $this->repair($v);
                if($err == FALSE) $err_num++;
            }

            if($err_num) {
                E(1, $err_num.' 条数据修复失败！');
            }else{
                E(0, '修复完成！');
            }
        }else{
                E(1, '参数不能为空！');
        }
    }

    //修复
    public function repairtable(){
        $table = R('table', 'P');

        $this->repair($table);
        E(0,'修复完成！');
    }

    //修复表的SQL
    private function repair($table=''){
        $sql = 'REPAIR TABLE '.$this->_safe_replace($table);
        return $this->db->query($sql);
    }
	
	
    //批量清空表
    public function batchemptytable(){
        $id_arr = R('id_arr', 'P');
        if(!empty($id_arr) && is_array($id_arr)) {
            $err_num = 0;
            foreach($id_arr as $v) {
                $err = $this->truncate($v);
                if($err == FALSE) $err_num++;
            }

            if($err_num) {
                E(1, $err_num.' 条数据清空失败！');
            }else{
                E(0, '清空完成！');
            }
        }else{
            E(1, '参数不能为空！');
        }
    }

    //检查表
    public function checktable(){
        $id_arr = R('id_arr', 'P');
        if(!empty($id_arr) && is_array($id_arr)) {
            foreach($id_arr as $table) {
                $sql = 'CHECK TABLE `'.$table.'`';
                $this->db->fetch_first($sql);
            }
            E(0, '检查完成！');
        }else{
            E(1, '数据错误！');
        }
    }



    //清空单个表
    public function emptytable(){
        $table = R('table', 'P');

        $this->truncate($table);
        E(0,'清空完成！');
    }	

	
    // 清空表的SQL
    private function truncate($table='') {
        $sql = 'TRUNCATE TABLE '.$this->_safe_replace($table);
        return $this->db->query($sql);
    }	
		

    //表结构
    public function structure(){
        $table = R('table','R');
        $sql = 'SHOW CREATE TABLE '.$this->_safe_replace($table);
        $res = $this->db->fetch_first($sql);
        if(isset($res['Create Table'])){
            echo '<pre>'.$res['Create Table'].'</pre>';
        }else{
            echo '无数据';
        }
        exit;
    }

    private function _safe_replace($string) {
        return str_replace(array('`',"\\",'&',' ',"'",'"','/','*','<','>',"\r","\t","\n","#"), '', $string);
	}
}



?>