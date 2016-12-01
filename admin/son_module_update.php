<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = '子版块修改页';
$template['css'] = array('style/public.css');
$link = connectMySql();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skipPage('son_module.php','error','id参数错误');
}
$query = "select * from sfk_son_module where id = {$_GET['id']}";
$result = execute($link,$query);
if (!mysqli_num_rows($result)){
    skipPage('son_module.php','error','这条版块信息不存在!');
}

if (isset($_POST['submit'])){
    //验证
    $check_flag = 'update';
    include 'inc/check_son_module.inc.php';

    $query = "update sfk_son_module set father_module_id ={$_POST['father_module_id']}, 
                                      module_name='{$_POST['module_name']}',
                                      info='{$_POST['info']}',
                                      member_id={$_POST['member_id']},
                                      sort={$_POST['sort']} WHERE id= {$_GET['id']}";

    execute($link,$query);
    if ($data = mysqli_affected_rows($link)){
        skipPage('son_module.php','ok','修改成功');
    }else {
        skipPage('son_module.php','error','修改失败,已经有这个版块了');
    }
}

$data = mysqli_fetch_assoc($result);


?>

<?php  include 'inc/header.inc.php'?>

<div id="main">
    <div class="title" style="margin-bottom: 20px;">修改子版块--<?php echo $data['module_name']?></div>
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
                        while($dataone=mysqli_fetch_assoc($result)){
                          if ($dataone['id'] == $data['father_module_id']){
                              echo "<option selected ='selected' value='{$dataone['id']}'>{$dataone['module_name']}</option>";
                          }else {
                              echo "<option value='{$dataone['id']}'>{$dataone['module_name']}</option>";
                          }
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
                <td><input name="module_name"  value="<?php echo $data['module_name'] ?>"   type="text" /></td>
                <td>
                    版块名称不得为空，最大不超过66个字符
                </td>
            </tr>


            <tr>
                <td>版块简介</td>
                <td>
                    <textarea name="info"><?php echo $data['info'] ?></textarea>
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
                <td><input name="sort" value="<?php echo $data['sort'] ?>" type="text" /></td>
                <td>
                    填写一个数字即可
                </td>
            </tr>
        </table>
        <input  style="margin-top: 20px;cursor: pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>
