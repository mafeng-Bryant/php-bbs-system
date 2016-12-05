<?php

include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';

$link =  connectMySql();
//验证是否管理员登录
include_once  'inc/is_manage_login.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id']))
{
    skipPage('son_module.php','error',"删除失败!");
}

$query = "delete from sfk_son_module where id = {$_GET['id']}";
execute($link,$query);
if (mysqli_affected_rows($link)==1){
    skipPage('son_module.php','ok',"恭喜你删除成功!");
}else {
    skipPage('son_module.php','error',"删除失败!");
}



?>