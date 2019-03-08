<?php
/**
 * Created by PhpStorm.
 * Name: index.php
 * User: jackson
 * Date: 2019/3/8
 * Time: 下午3:31
 */

require_once 'EyeCopy.php';

$path='static';
$object = new EyeCopy();

$_path        = $path.'/test.jpg';//上传的图片
$old_image    = $path.'/old.png';//底图
$new_path     = $path.'/image/new.jpg';//新图
$old_path     = $path.'/image/old.jpg';//调整大小后的新图

$object->resize_jpg($_path,$width=270,$height=312,$old_path);//调整上传图片的大小

$image_array=[
    [
        'path'=>$old_path,
        'x'=>25,
        'y'=>276
    ]
];

$object->_image($new_path,$old_image,$image_array);
$name = '测试';

$ttf = $path.'/wryh.ttf';
//如果有文字则添加
$object->addWord($new_path,$name,$x=330,$y=543,$size = 13,$ttf);
