<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connectMySql();

if (!($member_id = is_login($link))){
    skipPage('login.php','ok','请登录后在发帖!');
}

if (isset($_GET['id'])){ //存在，设置选择



}


if (isset($_POST['submit'])){

    include 'inc/check_publish.inc.php';
    $_POST = escape($link,$_POST);
    $query = "insert into sfk_content(module_id,title,content,time,member_id) values({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',now(),{$member_id})";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skipPage('publish.php','ok','发帖成功');
    }else {
        skipPage('publish.php','error','发帖失败，请重试!');
    }
}

$template['title'] = '帖子发布页';
$template['css']=array('style/public.css','style/publish.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a>首页</a> &gt;发布帖子
</div>
<div id="publish">
    <form method="post">
        <select name="module_id">
            echo "<option value='-1'>请选择一个子版块</option>";
            <?php
            $where = '';
           if (isset($_GET['father_module_id']) && is_numeric($_GET['father_module_id'])){
               $where = "where id = {$_GET['father_module_id']}";
           }
            $query = "select * from sfk_father_module $where order by sort desc";
            $result = execute($link,$query);
          while ($data = mysqli_fetch_assoc($result)){
              echo "<optgroup label='{$data['module_name']}'>";
              $sql = "select * from sfk_son_module where father_module_id={$data['id']} order by sort desc";
              $result_son = execute($link,$sql);
             while ($data_son=mysqli_fetch_assoc($result_son)){
                if (isset($_GET['son_module_id']) && $_GET['son_module_id'] == $data_son['id']){
                    echo "<option  selected='selected' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                }else {
                    echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                }
             }
            echo "</optgroup>";
          }
          ?>
        </select>
        <input class="title" placeholder="请输入标题" name="title" type="text" />
        <textarea name="content" class="content"></textarea>
        <input class="publish" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>


