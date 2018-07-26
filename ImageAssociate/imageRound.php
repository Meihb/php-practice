<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2018/7/26
 * Time: 10:57
 */

function cutImage($source, $dest_name, $circle_center_x = 0, $circle_center_y = 0, $radio = 0, $quality = 8.5)
{
    $dir = "/data/www/html/recruit/profile_portrait";
    list($origin_width, $origin_height) = getimagesize($source);
    if ($circle_center_x == 0 || $circle_center_y == 0 || $radio == 0) {
        //默认策略,即 获取长宽最低值做直径,图片中心作圆心
        list($circle_center_x, $circle_center_y, $radio) = defaultImageSizeStrategy($origin_width, $origin_height);
    } else {
        if (($circle_center_y + $radio > $origin_height) ||
            ($circle_center_x + $radio > $origin_width)
        ) {
            list($circle_center_x, $circle_center_y, $radio) = defaultImageSizeStrategy($origin_width, $origin_height);
        }
    }
    $origin_image = imagecreatefromstring(file_get_contents($source));
    $dest_image = imagecreatetruecolor($radio * 2, $radio * 2);
    imagecopy($dest_image, $origin_image, 0, 0, $circle_center_x - $radio, $circle_center_y - $radio, $radio * 2, $radio * 2);

//    imagepng($dest_image, $dir . '/test_origin.png', $quality);
//    imagedestroy($dest_image);

    $image = imagecreatetruecolor(2 * $radio, 2 * $radio);
    $bg = imagecolorallocatealpha($image, 255, 255, 255, 127);
    imagesavealpha($image, true);
    imagefill($image, 0, 0, $bg);
    $r = $radio;
    $src_img = $dest_image;
    for ($x = 0; $x < 2 * $radio; $x++) {
        for ($y = 0; $y < 2 * $radio; $y++) {
            $rgbColor = imagecolorat($src_img, $x, $y);
            if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                imagesetpixel($image, $x, $y, $rgbColor);
            }
        }
    }

    imagepng($image, $dir.'/'.$dest_name, $quality);
    imagedestroy($dest_image);


}
function defaultImageSizeStrategy($width, $height)
{
    $diameter = $width < $height ? $width : $height;
    $radio = floor($diameter / 2);
    $circle_center_x = floor($width / 2);
    $circle_center_y = floor($height / 2);
    return [$circle_center_x, $circle_center_y, $radio];
}