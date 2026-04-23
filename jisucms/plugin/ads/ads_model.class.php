<?php
defined('ROOT_PATH') or exit;

class ads extends model {

    function __construct() {
        $this->table = 'ads';	// 表名
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

    //删除（删除本地图片）
    public function xdelete($id){
        $data = $this->get($id);
        if(empty($data)){
            return '内容不存在！';
        }elseif($data['pic']){
            $file = ROOT_PATH.$data['pic'];
            try{
                is_file($file) && unlink($file);
            }catch(Exception $e) {}
        }

        $contentstr = $data['content'];
        $pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern,$contentstr,$match);
        if( isset($match[1]) ){
            $cfg = $this->runtime->xget();
            foreach ($match[1] as $imgurl){
                $path = str_replace($cfg['weburl'],'',$imgurl);
                $file = ROOT_PATH.$path;
                try{
                    is_file($file) && unlink($file);
                }catch(Exception $e) {}
            }
        }

        $res = $this->delete($id);
        return $res ? '' : '删除失败！';
    }
}
