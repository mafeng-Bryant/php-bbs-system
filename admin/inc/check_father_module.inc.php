<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

if (empty($_POST['module_name'])){
    skipPage('father_module_add.php','error','版块不能为空!');
}

if (mb_strlen($_POST['module_name']) >66){
    skipPage('father_module_add.php','error','版块名称不能多余66个字符');
}

if (!is_numeric($_POST['sort'])){
    skipPage('father_module_add.php','error','排序只能是数字！');
}
$_POST = escape($link,$_POST);

switch ($check_flag){
    case 'add':
        $sql = "select * from sfk_father_module module_name where module_name = '{$_POST['module_name']}'";
    break;
    case 'update':
        $sql = "select * from sfk_father_module module_name where module_name = '{$_POST['module_name']}' and id !={$_GET['id']}";
      break;
    default:
        skipPage('father_module_add.php','error','$check_flag参数错误!');
}

$result = execute($link,$sql);
if ($data = mysqli_num_rows($result)){
    skipPage('father_module_add.php','error','这个版块已经添加了！');
}


?>