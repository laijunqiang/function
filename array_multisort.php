<?php
/**
 * array_multisort()这个函数可以对多个PHP数组进行排序，排序结果是所有的数组都按第一个数组的顺序进行排列
 */
    $array[] = array("age"=>20,"name"=>"bi");
    $array[] = array("age"=>21,"name"=>"ai");
    $array[] = array("age"=>20,"name"=>"ii");
    $array[] = array("age"=>22,"name"=>"di");

    foreach ($array as $key=>$value){
        $age[$key] = $value['age'];
        $name[$key] = $value['name'];
    }
    //或者使用array_column(数组,数组中的某个键值)  从多维数组中取出某个键值的一列  返回一个一维数组。
    //$age = array_column($array,'age');
    //$name = array_column($array,'name');

    array_multisort($age,SORT_NUMERIC,SORT_DESC,$name,SORT_STRING,SORT_ASC,$array);
    //$array[]数组，按照年龄从大到小的顺序排列，如果年龄相同就按照名字的顺序排序。
    //因为array_multisort()需要的排序参数必须是一个列（个数必须相同）
    echo "<pre>";
    print_r($array);
    echo "</pre>";
?>