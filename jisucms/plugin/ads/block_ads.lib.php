<?php
defined('ROOT_PATH') || exit;
/**
 * 广告
 * @param string pos 唯一标识
 * @return array
 */
function block_ads($conf) {
	global $run;
    $pos = isset($conf['pos']) ?  trim($conf['pos']): '';
	$timenow=strtotime(date('Y-m-d H:i:s',time()));//获得当前时间戳，用作对比
    //print_r($timenow);
    if( empty($pos) ) return array();
    $ads = $run->ads->find_fetch(array('alias'=>$pos), array(), 0, 1);
    if( empty($ads) ){
        return array();
    }else{
        $ads = current($ads);
        if( $ads['pic'] && substr($ads['pic'], 0, 2) != '//' && substr($ads['pic'], 0, 4) != 'http' ){ //不是外链图片
            $ads['pic'] = $run->_cfg['webdir'].$ads['pic'];
        }
		if($ads['exdate'] < $timenow) return array();
		$uids = $run->_uid;
		$users = $run->_user;
		if($ads['client'] == 0) return array();
		//游客可见
		if(is_mobile() && $ads['client'] == 1 && $ads['status'] == 0 && empty($uids)) return $ads;
		if(!is_mobile() && $ads['client'] == 2 && $ads['status'] == 0 && empty($uids)) return $ads;
		if($ads['client'] == 3 && $ads['status'] == 0 && empty($uids)) return $ads;
		//会员可见
		if(is_mobile() && $ads['client'] == 1 && $ads['status'] == 1 && isset($users['groupid']) && $users['groupid'] == 11) return $ads;
		if(!is_mobile() && $ads['client'] == 2 && $ads['status'] == 1 && isset($users['groupid']) && $users['groupid'] == 11) return $ads;
		if($ads['client'] == 3 && $ads['status'] == 1 && isset($users['groupid']) && $users['groupid'] == 11) return $ads;
		//VIP可见
		if(is_mobile() && $ads['client'] == 1 && $ads['status'] == 2 && isset($users['groupid']) && $users['groupid'] == 10) return $ads;
		if(!is_mobile() && $ads['client'] == 2 && $ads['status'] == 2 && isset($users['groupid']) && $users['groupid'] == 10) return $ads;
		if($ads['client'] == 3 && $ads['status'] == 2 && isset($users['groupid']) && $users['groupid'] == 10) return $ads;
		//全部可见
		if(is_mobile() && $ads['client'] == 1 && $ads['status'] == 3) return $ads;
		if(!is_mobile() && $ads['client'] == 2 && $ads['status'] == 3) return $ads;
		if($ads['client'] == 3 && $ads['status'] == 3) return $ads;
        //return $ads;
    }
}
/**
 * 使用方法
   {block:ads pos="index"}
   {if:$data}
   {$data[title]}
   {$data[content]}
   {$data[code]}
   {/if}
   {/block}
 */