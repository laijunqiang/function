<?php
/**
 * 按综合方式输出通信数据
 * @param integer $code 状态码
 * @param string $message 提示信息
 * @param array $data 数据
 * @param string $type 数据类型
 * return string
 */
function show($code, $message = '', $data = array(), $type = 'json') {
    if(!is_numeric($code)) {
        return '';
    }

    $type = isset($_GET['format']) ? $_GET['format'] : $type;

    $result = array(
        'code' => $code,
        'message' => $message,
        'data' => $data,
    );

    if($type == 'json') {
        return jsonReturn($code, $message, $data);
    } elseif($type == 'array') {
        return $result;
    } elseif($type == 'xml') {
        return xmlReturn($code, $message, $data);
    } else {
        // TODO
    }
}
/**
 * 按json方式输出通信数据
 * @param integer $code 状态码
 * @param string $message 提示信息
 * @param array $data 数据
 * return string
 */
function jsonReturn($code, $message = '', $data = array()){

    if (!is_numeric($code)) {
        return '';
    }
    $result = [
        'code' => $code,
        'msg' => $message,
        'data' => $data
    ];
    return json_encode($result);
}

/**
 * 按xml方式输出通信数据  1.组装字符串  2.使用系统类（1）DomDocument （2）XMLWriter （3）SimpleXML
 * @param integer $code 状态码
 * @param string $message 提示信息
 * @param array $data 数据
 * return string
 */
function xmlReturn($code, $message, $data = array()){
    if (!is_numeric($code)) {
        return '';
    }

    $result = array(
        'code' => $code,
        'message' => $message,
        'data' => $data,
    );

    header("Content-Type:text/xml");
    $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
    $xml .= "<root>\n";

    $xml .= xmlToEncode($result);

    $xml .= "</root>";
    return $xml;
}

function xmlToEncode($data = array()) {

    $xml = $attr = "";
    foreach($data as $key => $value) {
        //xml结点不能为数字
        if(is_numeric($key)) {
            $attr = " id='{$key}'";
            $key = "item";
        }
        $xml .= "<{$key}{$attr}>";
        //递归循环数组
        $xml .= is_array($value) ? xmlToEncode($value) : $value;
        $xml .= "</{$key}>\n";
    }
    return $xml;
}