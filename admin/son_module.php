<?php

include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';

$link =  connectMySql();
//验证是否管理员登录
include_once  'inc/is_manage_login.inc.php';

if (isset($_POST['submit'])){
    foreach ($_POST['sort'] as $key=>$val){
        if (!is_numeric($val) || !is_numeric($key)){
            skipPage('son_module.php','error','排序参数错误!');
        }
        $query[] = "update sfk_son_module set sort={$val} where id={$key}";
    }
    if (execute_multi($link,$query,$error)){
        skipPage('son_module.php','ok','排序修改成功!');
    }else {
        skipPage('son_module.php','error',$error);
    }
}

$template['title'] = '子版块列表';
$template['css'] = array('style/public.css');

?>

<?php include 'inc/header.inc.php'?>

    <div id="main">
        <div class="title">子版块列表</div>
        <form method="post">
        <table class="list">
            <tr>
                <th>排序</th>
                <th>版块名称</th>
                <th>所属父版块</th>
                <th>版主</th>
                <th>操作</th>
            </tr>
            <?php
            $query = "select ssm.sort, ssm.id,ssm.module_name,sfm.module_name father_module_name,ssm.member_id from sfk_son_module ssm,sfk_father_module sfm where ssm.father_module_id = sfm.id ORDER BY sfm.id";
            $result = execute($link,$query);
            while($data = mysqli_fetch_assoc($result)){
                $url = "son_module_delete.php?id={$data['id']}";
                $url = urlencode($url);
                $return_url = urlencode($_SERVER['REQUEST_URI']);
                $message = "你真的要删除子版块{$data['module_name']} 吗?";
                $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
//定界符
$html=<<<A
          <tr>
            <td><input class="sort" type="text" name="sort[{$data['id']}]" value="{$data['sort']}" /></td>
            <td>{$data['module_name']}[id:{$data['id']}]</td>
            <td>{$data['father_module_name']}</td>
            <td>{$data['member_id']}</td>
            <td><a href="#">[访问]</a>&nbsp;&nbsp;<a href="son_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="{$delete_url}">[删除]</a></td>
        </tr>
A;
                echo $html;
            }

            ?>
        </table>
        <input  style="margin-top: 20px;cursor: pointer;" class="btn" type="submit" name="submit" value="修改排序" />
        </form>
    </div>

<?php include 'inc/footer.inc.php'?>