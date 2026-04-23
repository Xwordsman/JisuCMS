<?php
defined('ROOT_PATH') or exit();

//标题缩略图伪静态
if (empty($v['haspic'])) {
    // 移除特定的特殊字符，但不包括生僻字和异体字
    $specialChars = ['?', '*', '/', '$', '.', '^'];
    $v['title'] = str_replace($specialChars, '', $v['title']);
    // 使用正则表达式移除其他标点符号，但保留汉字
    $v['title'] = preg_replace('/[^\\p{L}\\p{N}\\w\\s]/u', '', $v['title']);
    // 加密处理后的标题（这里假设 encrypt 函数存在且能够正确处理字符串）
    $encryptedTitle = encrypt($v['title']);
    // 拼接图片路径和文件名（假设 $this->cfg['webdir'] 是配置好的 web 目录）
    $v['pic'] = $this->cfg['webdir'] . 'pic/' . $v['cid'] . '/' . $encryptedTitle . '.jpg';
}

?>
