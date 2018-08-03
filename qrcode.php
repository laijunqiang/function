<?php
/**
 * png()方法
 * 其中参数$text表示生成二位的的信息文本；参数$outfile表示是否输出二维码图片 文件，默认否；
 * 参数$level表示容错率，也就是有被覆盖的区域还能识别，分别是 L（QR_ECLEVEL_L，7%），M（QR_ECLEVEL_M，15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）；
 * 参数$size表示生成图片大小，默认是3；参数$margin表示二维码周围边框空白区域间距值；参数$saveandprint表示是否保存二维码并 显示。
 */
    include "phpqrcode.php";
    $value = "http://www.baidu.com";
    $level = 'L';
    $size = 6;
    QRcode::png($value, $level, $size, 2);

    //生成二维码图片
    QRcode::png($value, 'qrcode.png', $level, $size, 2);
    $logo = 'logo.jpg';//准备好的logo图片
    $QR = 'qrcode.png';//已经生成的原始二维码图

    if ($logo !== FALSE) {
        //imagecreatefromstring — 从字符串中的图像流新建一图像，返回一个图像标识符。
        $QR = imagecreatefromstring(file_get_contents($QR));
        $logo = imagecreatefromstring(file_get_contents($logo));
        //imagesx — 取得图像宽度，返回 image 所代表的图像的宽度。
        $QR_width = imagesx($QR);//二维码图片宽度  174
        $QR_height = imagesy($QR);//二维码图片高  174
        $logo_width = imagesx($logo);//logo图片宽度  650
        $logo_height = imagesy($logo);//logo图片高度  477
        $logo_qr_width = $QR_width / 5;  //34.8
        $scale = $logo_width/$logo_qr_width;  //18.68
        $logo_qr_height = $logo_height/$scale;  //25.5
        $from_width = ($QR_width - $logo_qr_width) / 2;
        //重新组合图片并调整大小
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
            $logo_qr_height, $logo_width, $logo_height);
    }
    //输出图片
    imagepng($QR, 'helloweba.png');
    echo '<img src="helloweba.png">';