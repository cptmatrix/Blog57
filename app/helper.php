<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/28
 * Time: 14:18
 */

 function human_filesize($bytes,$decimals=2){
    $size=['B','KB','MB','GB','TB','PB'];
    $factor=floor((strlen($bytes)-1)/3);
    return sprintf("%.{$decimals}f",$bytes/pow(1024,$factor)).@$size[$factor];
}

 function is_image($minetype){
    return starts_with($minetype,'image/');
}

function is_checked($value){
     return $value?'checked':'';
}

function page_image($path=null){
    if(empty($path)){
        return config('blog.page_image');
    }
    if(!starts_with($path,'http') && $path[0]!='/'){
        return config('blog.uploads.webpath').'/'.$path;
    }
}
