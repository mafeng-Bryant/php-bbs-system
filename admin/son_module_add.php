<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$link =  connectMySql();
//验证是否管理员登录
include_once  'inc/is_manage_login.inc.php';

if (isset($_POST['submit'])){
    //验证用户输入信息
    $check_flag = 'add';
    include 'inc/check_son_module.inc.php';
    $sql = "insert into sfk_son_module(father_module_id,module_name,info,member_id,sort) 
            values ({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['father_module_id']},{$_POST['sort']})";
    execute($link,$sql);
   if (mysqli_affected_rows($link)==1){
       skipPage('son_module.php','ok','恭喜你添加子版块成功');
   }else {
       skipPage('son_module_add.php','error','添加子版块失败，请重试!');
   }
}
$template['title'] = '父版块列表';
$template['css'] = array('style/public.css');

?>

<?php  include 'inc/header.inc.php'?>

<div id="main">
    <div class="title" style="margin-bottom: 20px;">添加子版块</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>所属父版块</td>
                <td>
                <select name="father_module_id">
                    <option value="0">=====请选择一个父版块=====</option>
                    <?php
                    $query = "select * from sfk_father_module";
                    $result = execute($link,$query);
                    while($data=mysqli_fetch_assoc($result)){
                      echo "<option value='{$data['id']}'>{$data['module_name']}</option>";
                    }
                    ?>
                </select>
                </td>
                <td>
                    必须选择一个所属的父版块
                </td>
            </tr>

            <tr>
                <td>版块名称</td>
                <td><input name="module_name"  type="text" /></td>
                <td>
                    版块名称不得为空，最大不超过66个字符
                </td>
            </tr>


            <tr>
            <td>版块简介</td>
                <td>
                <textarea name="info"></textarea>
                </td>
                <td>版块简介不得多余255个字符</td>
            </tr>


            <tr>
                <td>版主</td>
                <td>
                    <select name="member_id">
                        <option value="0">=====请选择一个会员作为版主=====</option>
                    </select>
                </td>
                <td>
                     你可以选择一个会员作为版主
                </td>
            </tr>


            <tr>
                <td>排序</td>
                <td><input name="sort" value="0" type="text" /></td>
                <td>
                    填写一个数字即可
                </td>
            </tr>
        </table>
        <input  style="margin-top: 20px;cursor: pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>
