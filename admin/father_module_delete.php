<?php
/**
 * Created by PhpStorm.
 * User: patpat
 * Date: 16/11/29
 * Time: 15:14
 */
include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id']))
{
    skipPage('father_module.php','error',"删除失败!");
}
$link =  connectMySql();

$sql = "select * from sfk_son_module where father_module_id = {$_GET['id']}";
$res = execute($link,$sql);
if (mysqli_num_rows($res)){
    skipPage('father_module.php','error',"当前版块下面还有子版块，不能删除!");
}

$query = "delete from sfk_father_module where id = {$_GET['id']}";
execute($link,$query);
if (mysqli_affected_rows($link)==1){
    skipPage('father_module.php','ok',"恭喜你删除成功!");
}else {
    skipPage('father_module.php','error',"删除失败!");
}

?>




