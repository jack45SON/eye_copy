<?php
/**
 * Created by PhpStorm.
 * Name: EyeCopy.php
 * User: jackson
 * Date: 2019/3/8
 * Time: 下午2:52
 */

class EyeCopy
{
    /**
     * @Title: save_image
     * @Description: todo(上传图片)
     * @Author: liu tao
     * @Time: 2019/3/8 下午3:07
     * @param $openid
     * @param $base64
     * @return string
     */
    public function save_image($image,$base64){
        preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result);
        $type = $result[2];
        $image .= $type;
        //  创建将数据流文件写入我们创建的文件内容中
        file_put_contents($image, base64_decode(str_replace($result[1], '', $base64)));

        return $image;
    }

    /**
     * @Title: _image
     * @Description: todo(合成图片与文字)
     * @Author: liu tao
     * @Time: 2019/3/8 下午3:24
     * @param $image
     * @param $openid
     * @param $width
     * @param $height
     * @param $dst_x
     * @param $dst_y
     * @param string $name
     * @param int $x
     * @param int $y
     * @param int $size
     * @param string $ttf
     * @return string
     */
    public function _image($new_path,$old_path,$image_array){

        $old_image = imagecreatefromstring(file_get_contents($old_path));
        $copy_old_image = imageCreatetruecolor(imagesx($old_image),imagesy($old_image));
        $color = imagecolorallocate($copy_old_image, 255, 255, 255);
        imagefill($copy_old_image, 0, 0, $color);
        imageColorTransparent($copy_old_image, $color);
        imagecopyresampled($copy_old_image,$old_image,0,0,0,0,imagesx($old_image),imagesy($old_image),imagesx($old_image),imagesy($old_image));

        foreach($image_array as $k=>$v){
            $extra_image = imagecreatefromstring(file_get_contents($v['path']));
            imagecopymerge($copy_old_image,$extra_image, $v['x'], $v['y'],0,0,imagesx($extra_image),imagesy($extra_image), 100);
            imagedestroy($extra_image);
        }

        header('Content-Type: image/jpeg');
        imagejpeg($copy_old_image,$new_path);
        imagedestroy($copy_old_image);
        return $new_path;
    }

    /**
     * @Title: resize_jpg
     * @Description: todo(调整图片大小)
     * @Author: liu tao
     * @Time: 2019/3/8 下午3:15
     * @param $img_src
     * @param $img_width
     * @param $img_height
     * @param $path_3
     */
    public function resize_jpg($img_src,$img_width,$img_height,$path)
    {
        $arr = getimagesize($img_src);
        header("Content-type: image/jpg");
        $typeArr=explode(".",$img_src);
        $type=$typeArr[1];
        switch($type)
        {
            case "png":
                $im=imagecreatefrompng($img_src);
                break;

            case "jpeg":
                $im=imagecreatefromjpeg($img_src);
                break;

            case "jpg":
                $im=imagecreatefromjpeg($img_src);
                break;

            case "gif":
                $im=imagecreatefromgif($img_src);
                break;
        }
        $image = imagecreatetruecolor($img_width, $img_height); //创建一个彩色的底图
        imagecopyresampled($image, $im, 0, 0, 0, 0,$img_width,$img_height,$arr[0], $arr[1]);

        imagepng($image,$path);
        imagedestroy($image);
        return $img_src;
    }

    /**
     * @Title: addWord
     * @Description: todo(添加文字)
     * @Author: liu tao
     * @Time: 2019/3/8 下午3:16
     * @param $dst_path
     * @param $name
     */
    public function addWord($dst_path,$name,$x,$y,$size,$ttf){
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, $size, 0, $x, $y, $black, $ttf, $name);
        imagejpeg($dst,$dst_path);
        imagedestroy($dst);
    }
}