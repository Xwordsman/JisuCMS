<?php

//adminer 数据库管理
function database()
{
    if (empty($_POST)) {
        //用户名 数据库名
        $username = $_ENV['_config']['db']['master']['user'];
        $db = $_ENV['_config']['db']['master']['name'];

        $cfg = $this->kv->xget('cfg');
        $url = http() . $cfg['webdomain'] . $cfg['webdir'] . 'toolcms/plugin/database/adminer-4.8.1-mysql.php?username=' . $username . '&db=' . $db;
        $this->assign('url', $url);

        $models = $this->models->get_models();
        unset($models['models-mid-1']);
        $this->assign('models', $models);

        $this->display();
    } else {
        $table = R('table', 'P');
        $field = R('field', 'P');
        $old = R('old', 'P');
        $new = R('new', 'P');

        $table_prefix = $_ENV['_config']['db']['master']['tablepre'];
        if ($field == 'content') {
            $tablefull = $table_prefix . 'cms_' . $table . '_data';
        } else {
            $tablefull = $table_prefix . 'cms_' . $table;
        }
        $sql = "UPDATE {$tablefull} SET {$field}=REPLACE({$field},'{$old}','{$new}');";
        $this->db->query($sql);

        E(0, '执行成功！');
    }
}

?>