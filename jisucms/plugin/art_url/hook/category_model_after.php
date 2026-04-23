<?php
	// 获取分类下拉列表HTML (添加分类时使用)
	public function get_cids_by_list($_mid, $cid, $tips = '查看分类') {
		$category_arr = $this->get_category();
		$s = '<select name="cid" id="cid" lay-filter="cid">';
		if(empty($category_arr)) {
			$s .= '<option value="0">'.lang('none').'</option>';
		}else{
			$s .= '<option value="0">'.$tips.'</option>';
			foreach($category_arr as $mid => $arr) {
				if($mid != $_mid) continue;
				foreach($arr as $v) {
					$disabled = $v['type'] == 1 ? ' disabled="disabled"' : '';
					$s .= '<option value="'.$v['cid'].'"'.($v['type'] == 0 && $v['cid'] == $cid ? ' selected="selected"' : '').$disabled.'>';
					$s .= str_repeat("　", $v['pre']-1);
					$s .= '|─'.$v['cid'].'：'.$v['name'].($v['type'] == 1 ? '['.lang('cate_type_1').']' : '').'</option>';
				}
			}
		}
		$s .= '</select>';
		return $s;
	}	
	// 获取分类下拉列表HTML (删除分类时使用)
	public function get_cids_by_delete($_mid, $cid) {
		$category_arr = $this->get_category();
		$s = '';
		if(empty($category_arr)) {
			$s .= '';
		}else{
			foreach($category_arr as $mid => $arr) {
				if($mid != $_mid) continue;
				foreach($arr as $v) {
					//$s .= '<input class="layui-btn layui-btn-sm layui-btn-normal" title="'.$v['cid'].'" id="delcids" placeholder="'.$v['name'].'，CID='.$v['cid'].'" name="delcids[]" type="checkbox" value="'.$v['cid'].'">';
					//$s .= '<pre><strong class="layui-btn layui-btn-jason layui-btn-danger disabled">'.$v['cid'].'</strong>';
					//$s .= '<i class="layui-btn layui-btn-jason layui-btn-normal">'.$v['name'].'</i>';
					$s .= '<pre><i class="layui-btn layui-btn-jason layui-btn-sm layui-btn-danger disabled" value="'.$v['cid'].'"'.($v['type'] == 0 && $v['cid'] == $cid ? ' selected="selected"' : '').'>';
					$s .= str_repeat("　", $v['pre']-1);
					$s .= '└ <font color="blue"><strong>'.$v['cid'].'</strong></font> ：'.$v['name'].($v['type'] == 1 ? '['.lang('cate_type_1').']' : '').'</i></pre>';					
				}
			}
		}
		$s .= '';
		return $s;
	}
	