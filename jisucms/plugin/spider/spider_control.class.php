<?php
defined('ROOT_PATH') or exit;

class spider_control extends admin_control {

	// 管理
	public function index() {
        // 获取下拉框
        $cidhtml = $this->spider->get_spiderhtml();
        $this->assign('cidhtml', $cidhtml);
		$this->display();
	}

    //获取列表
    public function get_list(){
        //分页
        $page = isset( $_REQUEST['page'] ) ? intval($_REQUEST['page']) : 1;
        $pagenum = isset( $_REQUEST['limit'] ) ? intval($_REQUEST['limit']) : 15;

        //获取查询条件
        $spider = isset( $_REQUEST['spider'] ) ? trim($_REQUEST['spider']) : '';

        //组合查询条件
        $where= array();
        if( $spider ){
            $where['spider'] = $spider;
        }

        //数据量
        if( $where ){
            $total = $this->spider->find_count($where);
        }else{
            $total = $this->spider->count();
        }

        //页数
        $maxpage = max(1, ceil($total/$pagenum));
        $page = min($maxpage, max(1, $page));

        // 获取标签列表
        $data_arr = array();
        $cms_arr = $this->spider->list_arr($where, 'id', -1, ($page-1)*$pagenum, $pagenum, $total);
        foreach($cms_arr as &$v) {
            $this->spider->format($v);
            $data_arr[] = $v;   //排序需要索引从0开始
        }
        unset($cms_arr);
        //组合数据 输出到页面
        $arr = array(
            'code' => 0,
            'msg' => '',
            'count' => $total,
            'data' => $data_arr,
        );
        exit( json_encode($arr) );
    }

    //编辑表格字段
    public function set(){
        if( !empty($_POST) ){
            $field = trim( R('field','P') );
            $id = intval( R('id','P') );
            $value = trim( R('value','P') );
            $data = array(
                'id' => $id,
                $field => $value,
            );

            if(!$this->spider->update($data)) {
                E(1, '更新失败');
            }
            E(0, '更新'.$field.'成功');
        }
    }

    // 删除
    public function del() {
        $id = (int) R('id', 'P');
        empty($id) && E(1, 'ID不能为空！');

        $res = $this->spider->delete($id);
        if($res) {
            E(0, '删除成功！');
        }else{
            E(1, '删除失败！');
        }
    }

    // 批量删除
    public function batch_del() {
        $id_arr = R('id_arr', 'P');
        if(!empty($id_arr) && is_array($id_arr)) {
            $err_num = 0;
            foreach($id_arr as $id) {
                $res = $this->spider->delete($id);
                if(!$res) $err_num++;
            }

            if($err_num) {
                E(1, $err_num.' 条内容删除失败！');
            }else{
                E(0, '删除成功！');
            }
        }else{
            E(1, '参数不能为空！');
        }
    }

    //清空
    public function clear(){
	    if($_POST){
            $this->spider->truncate();
            E(0, '清空完成！');
        }
    }
}
