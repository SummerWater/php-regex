<?php
/**
 * Created by PhpStorm.
 * User: Meckey_Shu
 * Date: 2018/6/22
 * Time: 14:06
 */

require_once './Template.php';

$baseDir = str_replace('\\', '/', __DIR__);
$temp = new Template($baseDir . '/source/', $baseDir . '/compiled/');
$temp->assign('page_title', '山寨版Smarty模板引擎');
$temp->assign('test', '慕女神 约吗');
$temp->display('index');