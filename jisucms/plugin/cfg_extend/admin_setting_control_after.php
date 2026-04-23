<?php
//扩展信息插件
function cfg_extend(){
    if(empty($_POST)) {
        $cfg = $this->kv->xget('cfg');
        $setting = $cfg['cfg_extend'];
        $this->assign('setting', $setting);

        $this->display();
    }else{
        _trim($_POST);

        $cfg = $this->kv->xget('cfg');
        $setting = $cfg['cfg_extend'];

        $del = (int)R('del','P');
        $edit = (int)R('edit','P');

        if($del){
            $key = R('key','P');
            if(empty($key)){
                E(1, '删除失败！');
            }else{
                unset($setting[$key]);
                $this->kv->xset('cfg_extend', $setting, 'cfg');

                $this->kv->save_changed();
                $this->runtime->delete('cfg');
                E(0, '删除成功！');
            }
        }
        if($edit){
            $key = R('key','P');
            if(empty($key) || !isset($setting[$key])){
                E(1, '修改失败！');
            }else{
                $key_arr = R('key_arr', 'P');
                $setting[$key]  = array(
                    'name'=>$key_arr[0],
                    'val'=>$key_arr[1],
                    'remark'=>$key_arr[2]
                );
                $this->kv->xset('cfg_extend', $setting, 'cfg');

                $this->kv->save_changed();
                $this->runtime->delete('cfg');
                E(0, '修改成功！');
            }
        }

        $key = trim(R('alias','P'));
        empty($key) && E(1, '唯一标识不能为空！');

        if(!preg_match('/^\w+$/', $key)) {
            E(1, '唯一标识只能是 英文 数字 _');
        }

        if( isset($setting[$key]) ){
            E(1, '唯一标识已经存在啦！');
        }

        $post = array(
            'name'=>trim(R('name','P')),
            'val'=>trim(R('val','P')),
            'remark'=>trim(R('remark','P')),
        );
        if(empty($post['name']) || empty($post['val'])){
            E(1, '必填项不能为空！');
        }
        $setting[$key] = $post;
        $this->kv->xset('cfg_extend', $setting, 'cfg');

        $this->kv->save_changed();
        $this->runtime->delete('cfg');

        E(0, '添加成功！');
    }
}