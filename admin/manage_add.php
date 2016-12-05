<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

if ($_POST['submit']){

    $link = connectMySql();
    include 'inc/check_manage.inc.php';
    $query = "insert into sfk_manage(name,password,create_time,level) values('{$_POST['name']}',md5({$_POST['password']}),now(),{$_POST['level']})";
    execute($link,$query);
    if (mysqli_affected_rows($link) ==1){
        skipPage('manage.php','ok','恭喜你添加成功');
    }else {
        skipPage('manage.php','error','对不起，添加失败，请重试!');
    }
}

$template['title'] = '管理员添加页';
$template['css'] = array('style/public.css');

?>

<?php  include 'inc/header.inc.php'?>

<div id="main">
    <div class="title" style="margin-bottom: 20px;">添加管理员</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>管理员名称</td>
                <td><input name="name" type="text" /></td>
                <td>
                    名称不得为空，最大不超过32个字符
                </td>
            </tr>

            <tr>
                <td>密码</td>
                <td><input name="password" type="text" /></td>
                <td>
                  不得少于六位
                </td>
            </tr>

            <tr>
                <td>等级</td>
                <td>
                    <select name="level">
                        <option value="1">普通管理员</option>
                        <option value="0">超级管理员</option>
                    </select>
               </td>
                <td>
                    请选择一个等级，默认为普通管理员(不具备后台管理员管理权限)
                </td>
            </tr>

        </table>
        <input  style="margin-top: 20px;cursor: pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>
