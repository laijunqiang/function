<?php
include './phpqrcode.php';

$value = 'http://www.dawnfly.cn'; //二维码内容
$errorCorrectionLevel = 'H';//容错级别
$matrixPointSize = 5;//生成图片大小

$dir = iconv("UTF-8", "GBK", './member');//放生成的二维码
if (!file_exists($dir)){
mkdir ($dir,0777,true);
}


$QR = $dir.'/qrcode.png';
$QR1 = $dir.'/qrcode_logo.png';
/**
 *  png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false)
    第一个参数$text，就是上面代码里的URL网址参数，
　　第二个参数$outfile默认为否，不生成文件，只将二维码图片返回，否则需要给出存放生成二维码图片的路径
　　第三个参数$level默认为L，这个参数可传递的值分别是L(QR_ECLEVEL_L，7%)，M(QR_ECLEVEL_M，15%)，Q(QR_ECLEVEL_Q，25%)，H(QR_ECLEVEL_H，30%)。
    这个参数控制二维码容错率，不同的参数表示二维码可被覆盖的区域百分比。利用二维维码的容错率，我们可以将头像放置在生成的二维码图片任何区域。
　　第四个参数$size，控制生成图片的大小，默认为4
　　第五个参数$margin，控制生成二维码的空白区域大小
　　第六个参数$saveandprint，保存二维码图片并显示出来，$outfile必须传递图片路径。
 */
QRcode::png($value, $QR, $errorCorrectionLevel, $matrixPointSize, 2);

$logo = './logo.jpg';//logo图片
if ($logo !== FALSE) {
    //imagecreatefromstring — 从字符串中的图像流新建一图像，返回一个图像标识符。
    $QR = imagecreatefromstring(file_get_contents($QR));
    $logo = imagecreatefromstring(file_get_contents($logo));
    //imagesx — 取得图像宽度，返回 image 所代表的图像的宽度。
    $QR_width = imagesx($QR);//二维码图片宽度
    $QR_height = imagesy($QR);//二维码图片高度
    $logo_width = imagesx($logo);//logo图片宽度
    $logo_height = imagesy($logo);//logo图片高度
    $logo_qr_width = $QR_width / 5;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    $from_width = ($QR_width - $logo_qr_width) / 2;
    //重新组合图片并调整大小
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
        $logo_qr_height, $logo_width, $logo_height);
}

imagepng($QR, $QR1);
echo "<img src='".$QR1."'>";//输出