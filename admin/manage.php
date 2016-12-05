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
            skipPage('father_module.php','error','排序参数错误!');
        }
        $query[] = "update sfk_manage set sort={$val} where id={$key}";
    }
    if (execute_multi($link,$query,$error)){
        skipPage('father_module.php','ok','排序修改成功!');
    }else {
        skipPage('father_module.php','error',$error);
    }
}

$template['title'] = '管理员列表页';
$template['css'] = array('style/public.css');

?>

<?php include 'inc/header.inc.php' ?>

    <div id="main">
        <div class="title">管理员列表</div>
            <table class="list">
                <tr>
                    <th>名称</th>
                    <th>等级</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
                <?php
                $query = 'select * from sfk_manage';
                $result = execute($link,$query);
                while($data = mysqli_fetch_assoc($result)){
                    if ($data['level']==0){
                        $data['level']= '超级管理员';
                    }else {
                        $data['level']= '普通管理员';
                    }
                    $url = "manage_delete.php?id={$data['id']}";
                    $url = urlencode($url);
                    $return_url = urlencode($_SERVER['REQUEST_URI']);
                    $message = "你真的要删除管理员{$data['name']} 吗?";
                    $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
//定界符
$html=<<<A
          <tr>
            <td>{$data['name']}[id:{$data['id']}]</td>
            <td>{$data['level']}</td>
            <td>{$data['create_time']}</td>
            <td><a href="{$delete_url}">[删除]</a></td>
        </tr>
A;
                    echo $html;
                }
                ?>
            </table>
    </div>


<?php include 'inc/footer.inc.php' ?>