<?php

include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';
$link =  connectMySql();
//验证是否管理员登录
include_once  'inc/is_manage_login.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id']))
{
    skipPage('manage.php','error',"删除失败!");
}

$query = "delete from sfk_manage where id = {$_GET['id']}";
execute($link,$query);
if (mysqli_affected_rows($link)==1){
    skipPage('manage.php','ok',"恭喜你删除成功!");
}else {
    skipPage('manage.php','error',"删除失败!");
}


?>