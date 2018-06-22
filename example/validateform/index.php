<?php
/**
 * Created by PhpStorm.
 * User: Meckey_Shu
 * Date: 2018/6/21
 * Time: 16:50
 */
require_once 'Regextool.php';

// 浏览器友好的输出方式
function show($var = null, $is_dump = false)
{
    $func = $is_dump ? 'print_r' : 'var_dump';

    if (empty($var)) {
        echo 'null';
    } else if (is_array($var) || is_object($var)) {
        echo '<pre>';
        $func($var);
        echo '</pre>';
    } else {
        echo $var;
    }
}


$regex = new Regextool();
if (!$regex->noEmpty($_POST['username'])) {
    exit('用户名是必须填写的!');
}
if (!$regex->isEmail($_POST['email'])) {
    exit('email格式错误!');
}
if (!$regex->isMobile($_POST['phone'])) {
    exit('手机号码格式错误!');
}
