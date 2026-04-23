<?php


//标题缩略图插件设置
function title_pic(){
    if(empty($_POST)){
        $setting = $this->kv->get('title_pic_setting');
        $input = array();
        $input['cache_day'] = form::get_number('cache_day', $setting['cache_day']);
        $input['watermark_transparency'] = form::get_number('watermark_transparency', $setting['watermark_transparency']);
        $this->assign('input', $input);
        $this->display('title_pic_setting.htm');
    }else{
        $do = (int)R('do','P');
        if($do == 1){
            $arr = array(
                'cache_day'=>(int)R('cache_day', 'P'),
                'watermark_transparency'=>(int)R('watermark_transparency', 'P')
            );
            empty($arr['cache_day']) && E(1, '缓存时间不能为空！');
            if( $arr['watermark_transparency'] < 1 || $arr['watermark_transparency'] > 100 ){
                E(1, '水印透明度只能是1~100！');
            }
            $this->kv->set('title_pic_setting', $arr);
            E(0, '修改成功！');
        }elseif ($do == 2){
            $bgimgdir = PLUGIN_PATH.'title_pic/src_img';
            $dh = opendir($bgimgdir);
            $all_image_files = array();
            while($file = readdir($dh)) {
                if($file == '.' || $file == '..'){
                    continue;
                }else{
                    $filepath = $bgimgdir.'/'.$file;
                    $fileext = preg_replace('/\W/', '', strtolower(substr(strrchr($filepath, '.'), 1, 10)));
                    if($fileext == 'jpg'){
                        $all_image_files[] = $bgimgdir.'/'.$file;
                    }
                }
            }
            closedir($dh);
            if( empty($all_image_files) ){
                E(1, '没有jpg源图！');
            }
            $setting = $this->kv->get('title_pic_setting');
            $water_pic = PLUGIN_PATH.'title_pic/static/water_back.jpg';//水印图
            $water = $setting['watermark_transparency'];    //水印透明度
            foreach ($all_image_files as $file){
                $newfile = str_replace ('src_img', 'bg_img', $file);
                $newdir = dirname($newfile);
                if ( !file_exists($newdir) ) {
                    @mkdir($newdir, 0755,true);
                }
                $img = imagecreatefromjpeg($file);
                $height = imagesy($img);
                imagedestroy($img);
                $x = 50;
                $y = ($height-120)/2;
                //创建图片的实例
                $dst = imagecreatefromstring(file_get_contents($file));
                $src = imagecreatefromstring(file_get_contents($water_pic));
                //获取水印图片的宽高
                list($src_w, $src_h) = getimagesize($water_pic);
                //将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
                imagecopymerge($dst, $src, $x, $y, 0, 0, $src_w, $src_h, $water);
                //输出图片
                list($dst_w, $dst_h, $dst_type) = getimagesize($file);
                imagejpeg($dst, $newfile);
                imagedestroy($dst);
                imagedestroy($src);
            }
            E(0, '生成成功！');
        }
    }
}



?>