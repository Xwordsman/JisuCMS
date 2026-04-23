<?php


//标题缩略图伪静态
//if (preg_match('/pic\\/(\d+)\\/(.*)\\.jpg/i', $uri, $match)) {
if (preg_match('/pic\/(\d+)\/([^.]+)\.jpg$/i', $uri, $match)) { 
    if(!isset($match[2])){exit();}

    $cid = (int)$match[1];
    $mtitle = $match[2];
    if ($mtitle) {
        $title = decrypt($mtitle);
    }
    //如果浏览器对当前页面已经有缓存，那么就直接使用它
    if (isset($_SERVER['http_IF_MODIFIED_SINCE'])) {
        header('Last-Modified: ' . $_SERVER['HTTP_IF_MODIFIED_SINCE'], true, 304);
        exit;
    }
    $all_image_files = array();
    //cid对应文件夹随机取一个背景图
    $bgimgdir = PLUGIN_PATH . 'title_pic/'.$cid.'/';
    if(is_dir($bgimgdir)){
        $all_image_files = _scandir($bgimgdir);
        //背景图存放文件夹的jpg图片
        foreach ($all_image_files as $k => $file) {
            if ($file == '.' || $file == '..') {
                unset($all_image_files[$k]);
            }
        }
    }

    //对应cid里面没有就去默认的里面取
    if (empty($all_image_files)) {
        $bgimgdir = PLUGIN_PATH . 'title_pic/bg_img/';
        $all_image_files = _scandir($bgimgdir);
        //背景图存放文件夹的jpg图片
        foreach ($all_image_files as $k => $file) {
            if ($file == '.' || $file == '..') {
                unset($all_image_files[$k]);
            }
        }
    }

    if (empty($all_image_files)) {
        exit;
    }
    shuffle($all_image_files);
    $backgroundFile = array_slice($all_image_files, 0, 1);
    $backgroundPath = $bgimgdir . $backgroundFile[0];
    $font = PLUGIN_PATH . "title_pic/static/MSYH.otf";//字体，需要使用微软雅黑 宋体等常见字体
    $oneline = 6;
    preg_match_all("/./u", $title, $t_arr);//将所有字符转成单个数组
    $tarr = $t_arr[0];
    $t_total = count($tarr);//标题长度
    if ($t_total > 10) {
        $t_total = 10;
    }
    if ($t_total < 4) {
        $size = 45;
    } elseif ($t_total > 4) {
        $size = 25;
    } else{
		$size = 35;
	}
	/*
    $cha = 10 - $t_total;
    $size = $size + $cha;
    if ($size > 40) {
        $size = 40;
    } elseif ($size < 30) {
        $size = 30;
    }
	*/
    //新增 创建标题文本，每个字符后面都加一个空格，但最后一个字符后面不加
    $spacedText = '';
    foreach ($tarr as $char) {
        $spacedText .= $char . ' ';
    }
    // 移除最后一个多余的空格
    $spacedText = rtrim($spacedText);
	//新增 END
    $text = '';
    if ($t_total > $oneline) {
        $line = 2;
        $bnum = $t_total / 2;
        $snum = 0;
        for ($x = 0; $x < $t_total; $x++) {
            $snum++;
            if ($snum >= $bnum) {
                $snum = 0;
                $text .= $tarr[$x] . PHP_EOL;
            } else {
                if ($x > 27) {
                    $text .= "...";
                    break;
                } else {
                    $text .= $tarr[$x];
                }
            }
        }
    } else {
        //$text = $title;
		$text = $spacedText; // 使用带有空格的标题
        $line = 1;
    }
    //创建图片
    //$img = imagecreatefromjpeg('https://api.btstu.cn/sjbz/api.php');
    //$img = imagecreatefromjpeg('https://source.unsplash.com/800x0/?fintech,forex'); //unsplash 关键词图片随机api blockchain,forex  fintech
    $img = imagecreatefromjpeg($backgroundPath);
    $width = imagesx($img);
    $height = imagesy($img);
    if ($line > 1) {
        $a = imagettfbbox($size, 0, $font, $text);
        //得到字符串虚拟方框四个点的坐标
        $len = $a[2] - $a[0];
        $x = ($width - $len) / 2;//调整左右
        $h = $size / 10;
        $y = $height / 2 - 15 + $h;//调整上下
    } else {
        $a = imagettfbbox($size, 0, $font, $text);
        //得到字符串虚拟方框四个点的坐标
        $len = $a[2] - $a[0];
        $x = ($width - $len) / 2;//调整左右
        $h = $size / 10;
        $y = $height / 2 + 20 + $h;//调整上下
    }
    //$color = imagecolorallocate($img, 255, 255, 255);
	$color = imagecolorallocate($img, 0, 0, 0);
    // 0 0 0 表示黑色
    $setting = $this->kv->get('title_pic_setting');
    $cache_day = $setting['cache_day'] . ' day';
    //缓存天数
    //将规定当前页面缓存的时间（两天），并在下一次访问中使用这个缓存时间节点。接下来判断是否已经有缓存，如果有，就使用缓存。
    header("Cache-Control: private, max-age=10800, pre-check=10800");
    header("Pragma: private");
    header("Expires: " . date(DATE_RFC822, strtotime($cache_day)));
    header("Content-type:image/jpeg");
    imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
    imagejpeg($img);
    imagedestroy($img);
    exit;
}



?>