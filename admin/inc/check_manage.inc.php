<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

if (empty($_POST['name'])){
    skipPage('manage_add.php','error','管理员名称不能为空!');
}

if (mb_strlen($_POST['name']) >66){
    skipPage('manage_add.php','error','管理员名称不能多余32个字符');
}

if (mb_strlen($_POST['password']) <6){
    skipPage('manage_add.php','error','密码不得少于6位');
}

$_POST = escape($link,$_POST);
$sql = "select * from sfk_manage  where name = '{$_POST['name']}'";
$result = execute($link,$sql);
if (mysqli_num_rows($result)) {
    skipPage('manage_add.php','error','这个名称已经存在了!');
}

if (!isset($_POST['level'])){
    $_POST['level']= 1;
}else if($_POST['level']=='0'){
    $_POST['level']= 0;
}else if($_POST['level']!='1'){
    $_POST['level']= 1;
}else {
    $_POST['level']= 1;
}

?>