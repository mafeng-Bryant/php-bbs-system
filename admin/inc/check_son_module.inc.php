<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

if (!is_numeric($_POST['father_module_id'])){
    skipPage('son_module_add.php','error','所属父版块不得为空');
}

$sql = "select * from sfk_father_module where id = {$_POST['father_module_id']}";

$result = execute($link,$sql);

if (mysqli_num_rows($result)==0){
    skipPage('son_module_add.php','error','所属父版块不存在');
}

if (empty($_POST['module_name'])){
    skipPage('son_module_add.php','error','子版块名称不能为空!');
}

if (mb_strlen($_POST['module_name']) >66){
    skipPage('son_module_add.php','error','版块名称不能多余66个字符');
}

if (empty($_POST['info'])){
    skipPage('son_module_add.php','error','版块简介不能为空!');
}

if (mb_strlen($_POST['module_name']) >255){
    skipPage('son_module_add.php','error','版块名称不能多余255个字符');
}

if (!is_numeric($_POST['sort'])){
    skipPage('son_module_add.php','error','排序只能是数字！');
}

$_POST = escape($link,$_POST);

switch ($check_flag){
    case 'add':
        $sql = "select * from sfk_son_module  where module_name = '{$_POST['module_name']}'";
        break;
    case 'update':
        $sql = "select * from sfk_son_module  where module_name = '{$_POST['module_name']}' and id !={$_GET['id']}";
        break;
    default:
        skipPage('son_module.php','error','$check_flag参数错误!');
}

$result = execute($link,$sql);
if (mysqli_num_rows($result)){
    skipPage('son_module_add.php','error','这个版块已经添加了');
}


?>