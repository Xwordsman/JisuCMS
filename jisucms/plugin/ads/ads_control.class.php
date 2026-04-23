<?php
defined('ROOT_PATH') or exit;

class ads_control extends admin_control {

	// 管理
	public function index() {
		$this->display();
	}

    //AJAX获取列表
    public function get_list(){
        //分页
        $page = isset( $_REQUEST['page'] ) ? intval($_REQUEST['page']) : 1;
        $pagenum = isset( $_REQUEST['limit'] ) ? intval($_REQUEST['limit']) : 15;

        //数据量
        $total = $this->ads->count();

        //页数
        $maxpage = max(1, ceil($total/$pagenum));
        $page = min($maxpage, max(1, $page));

        // 获取列表
        $data_arr = array();
        $cms_arr = $this->ads->list_arr(array(), 'id', -1, ($page-1)*$pagenum, $pagenum, $total);
        foreach($cms_arr as &$v) {
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

            if(!$this->ads->update($data)) {
                E(1, '更新失败');
            }
            E(0, '更新'.$field.'成功');
        }
    }

    // 发布
    public function add() {
        if(empty($_POST)) {

            $this->display('ads_set.htm');
        }else{
            $alias = trim(strip_tags(R('alias', 'P')));
            $title = trim(R('title', 'P'));
			
			$exdate = R('exdate', 'P');
			$exdatetime = strtotime($exdate);	
            $timenow=strtotime(date('Y-m-d H:i:s',time()));//获得当前时间戳，用作对比
		    if (isset($exdatetime) && !empty($exdatetime)) {
		       $adexdatetime =$exdatetime;
		    }else{
		       $adexdatetime = $timenow;	
		    }			
			
            $client = isset($_POST['client']) ? $_POST['client'] : 3;
            $status = isset($_POST['status']) ? $_POST['status'] : 3;			
			
            empty($alias) && E(1, '唯一标识不能为空！');
            //empty($title) && E(1, '标题不能为空！');

            if(!preg_match("/^[0-9a-zA-Z-_]+$/u",$alias)){
                E(1, '唯一标识只能是 英文 数字 横线 _');
            }elseif($this->ads->find_fetch_key(array('alias'=> $alias))) {
                E(1, '唯一标识已经存在啦！');
            }

            // 写入内容表
            $data = array(
                'alias' => $alias,
                'title' => $title,
                'pic' => R('pic', 'P'),
				'exdate' => $adexdatetime,
                'url' => R('url', 'P'),
                'content' => R('content', 'P'),
				'code' => R('code', 'P'),
				'client' => $client,
				'status' => $status,
            );
            $id = $this->ads->create($data);
            if(!$id) {
                E(1, '写入广告表出错');
            }
            E(0, '发布成功！');
        }
    }

    // 编辑
    public function edit() {
        if(empty($_POST)) {
            $id = intval(R('id'));
            $data = $this->ads->get($id);
            if(empty($data)) $this->message(0, '内容不存在！', -1);
            $this->assign('data', $data);

            $this->display('ads_set.htm');
        }else{
            $id = intval(R('id', 'P'));
            $alias = trim(strip_tags(R('alias', 'P')));
            $title = trim(R('title', 'P'));
			
			$olddate = $this->ads->get($id);
			$exdate_old = $olddate['exdate'];
			
			$exdate = R('exdate', 'P');
			$exdatetime = strtotime($exdate);
            $timenow=strtotime(date('Y-m-d H:i:s',time()));//获得当前时间戳，用作对比
		    if (isset($exdatetime) && !empty($exdatetime)) {
		       $adexdatetime = $exdatetime;
		    }else{
		       $adexdatetime = $timenow;	
		    }			
						
			
            $client = $_POST['client'];
			$status = $_POST['status'];
		
			
            empty($id) && E(1, 'ID不能为空！');
            empty($alias) && E(1, '唯一标识不能为空！');
            //empty($title) && E(1, '标题不能为空！');			
			
			if($exdate_old == $exdate){E(1, '到期时间没有变化，请点击到期时间输入框重新输入到期时间！');}

            if(!preg_match("/^[0-9a-zA-Z-_]+$/u",$alias)){
                E(1, '唯一标识只能是 英文 数字 横线 _');
            }

            $data = $this->ads->get($id);
            if(empty($data)) E(1, '内容不存在！');

            if($data['alias'] != $alias && $this->ads->find_fetch_key(array('alias'=> $alias))){
                E(1, '唯一标识已经存在啦！');
            }

            // 写入内容表
            $data = array(
                'id' => $id,
                'alias' => $alias,
                'title' => $title,
                'pic' => R('pic', 'P'),
				'exdate' => $adexdatetime,
                'url' => R('url', 'P'),
                'content' => R('content', 'P'),
				'code' => R('code', 'P'),
				'client' => $client,
				'status' => $status,
            );
            if(!$this->ads->update($data)) {
                E(1, '更新广告表出错');
            }
            E(0, '编辑完成');
        }
    }

    // 删除
    public function del() {
        $id = (int) R('id', 'P');
        empty($id) && E(1, 'ID不能为空！');

        $err = $this->ads->xdelete($id);
        if($err) {
            E(1, $err);
        }else{
            E(0, '删除成功！');
        }
    }

    // 批量删除
    public function batch_del() {
        $id_arr = R('id_arr', 'P');
        if(!empty($id_arr) && is_array($id_arr)) {
            $err_num = 0;
            foreach($id_arr as $id) {
                $err = $this->ads->xdelete($id);
                if($err) $err_num++;
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
}
