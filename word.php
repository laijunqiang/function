<?php
error_reporting(0);
header("Content-Type: application/msword"); //以word文件形式下载
header("Content-Disposition: attachment; filename={$company_name}发货单.doc"); //指定文件名称
header("Pragma: no-cache");
header("Expires: 0");
$html ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>这是一个报表</title>
    <style type="text/css">
        body,td,th {
            font-size: 16px;
            font-family: Verdana, Geneva, sans-serif;
        }
        table{
            border-collapse: collapse;
            border-right-width: 1px;
            border-bottom-width: 1px;
            border-left-width: 1px;
            /*以上分别设置的是表格边框中上右下左的边框宽度*/
            border-top-style: solid;
            border-right-style: solid;
            border-bottom-style: solid;
            border-left-style: solid;
            /*设置边框的表现样式，solid为实线*/
            border-top-color: #333;
            border-right-color: #333;
            border-bottom-color: #333;
            border-left-color: #333;
            /*设置边框的颜色*/
        }
        table td{
            border:1px solid #333;
        }
    </style>
</head>

<body>
<center>
    <table width="1980px" border="1" style="border:0px" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="8" style="border-style:none" align="center"><strong style="font-size:26px;">'.$company_name.'发货单</strong></td>
        </tr>
        <tr>
            <td colspan="8" style="border-style:none" align="center" valign="middle">地址：'.$company_address.' 电话：'.$company_phone.' 传真:'.$company_fax.'</td>
        </tr>
        <tr>
            <td colspan="8" style="border-style:none" align="left">订单编号：'.$orderid.'</td>
        </tr>
        <tr>
            <td colspan="2" style="border-style:none">客户名称：'.$leader.'</td>
            <td colspan="4" style="border-style:none">送货地址：'.$address.'</td>
            <td colspan="2" style="border-style:none">日期：'.date('Y年m月d日',$shipment_time).'</td>
        </tr>
        <tr>
            <td width="197" align="center">产品名称</td>
            <td width="65" align="center">件数</td>
            <td width="69" align="center">包装量</td>
            <td width="76" align="center">数量</td>
            <td width="74" align="center">单位</td>
            <td width="118" align="center">单价</td>
            <td width="124" align="center">金额</td>
            <td width="200" align="center">备注</td>
        </tr>';

        foreach ($order as $key => $value) {
        $tot = $value['num']*$value['price']!=0?floatval($value['num']*$value['price']):'';
        $html.='<tr>
            <td align="center">&nbsp;'.$value['commodityname'].'</td>
            <td align="center">&nbsp;'.$value['piece'].'</td>
            <td align="center">&nbsp;'.$value['packnum'].'</td>
            <td align="center">&nbsp;'.$value['num'].'</td>
            <td align="center">&nbsp;'.$value['box'].'</td>
            <td align="center">&nbsp;'.$value['price'].'</td>
            <td align="center">&nbsp;'.$tot.'</td>
            <td align="center">&nbsp;</td>
        </tr>';
        }

        $html.='<tr>
            <td align="center">合计</td>
            <td align="center">&nbsp;'.$piece.'</td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;'.$num.'</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;'.$total.'</td>
            <td align="center">&nbsp;'.$remark.'</td>
        </tr>
        <tr>
            <td>&nbsp;'.date('m月d日',$shipment_time).'前欠金额:'.(floatval($detailed)).'元</td>
            <td colspan="5">收款金额：￥'.$total.'元 -   减免金额：￥'.$credits_price.'元</td>
            <td colspan="2">应收金额：￥'.($total-$credits_price).'元</td>
        </tr>
        <tr>
            <td colspan="3" style="border-style:none">操作员：'.session('admin_realname').'</td>
            <td colspan="2" style="border-style:none">审核人：</td>
            <td colspan="3" style="border-style:none">收款单位签章</td>
        </tr>
    </table>
</center>
</body>
</html>
';
echo $html;