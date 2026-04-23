<?php

// 正则表达式模式
$patternimg = '/<img[^>]+>/i';

// 搜索是否存在图片标签
if (!preg_match($patternimg, $data["content"])) {
    
    $pic='';
	
    // 移除特定的特殊字符，但不包括生僻字和异体字
    $specialChars = ['?', '*', '/', '$', '.', '^'];
    $_show['title'] = str_replace($specialChars, '', $_show['title']);
    // 使用正则表达式移除其他标点符号，但保留汉字
    $_show['title'] = preg_replace('/[^\\p{L}\\p{N}\\w\\s]/u', '', $_show['title']);
    // 加密处理后的标题（这里假设 encrypt 函数存在且能够正确处理字符串）
    $encryptedTitle = encrypt($_show['title']);	
	
	
    $pic = '/pic/'.$_show['cid'].'/'.$encryptedTitle.'.jpg';
    $pic = '<img  src="'.$pic.'" style="display:block;margin-left:auto;margin-right:auto;margin-bottom:10px" alt="'.$_show['title'].'" >' ;
	// 正则表达式模式
        $pattern = '/<p>(.*?)<\/p>/';
        
        // 随机选择一个 <p> 标签并插入内容
        $data["content"] = preg_replace_callback($pattern, function($matches) use ($pic) {
            return $pic . $matches[0];
        }, $data["content"], 1); // 限制只替换第一个匹配的 <p> 标签
}


 


?>