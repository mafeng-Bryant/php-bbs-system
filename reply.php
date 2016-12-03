<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once  'inc/page.inc.php';

$link = connectMySql();

if (!($member_id = is_login($link))){
    skipPage('login.php','ok','请登录后在回复!');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skipPage('index.php','error','你要回复的帖子参数id不合法');
}

if (isset($_POST['submit'])){

    include 'inc/check_reply.inc.php';
    $_POST = escape($link,$_POST);
    $sql = "insert into sfk_reply(content_id,content,time,member_id) 
                  values({$_GET['id']},'{$_POST['content']}',now(),$member_id )";
    execute($link,$sql);
    if (mysqli_affected_rows($link)==1){
        skipPage("show.php?id={$_GET['id']}",'ok',' 回复成功');
    }else {
        skipPage($_SESSION['REQUEST_URL'],'error','回复失败');
    }

}


$query = "select sc.id,sc.title,sm.name from sfk_content sc,sfk_member sm where sc.id = {$_GET['id']} and sc.member_id = sm.id";
$result_content = execute($link,$query);
if (mysqli_num_rows($result_content)!=1){
    skipPage('index.php','error','你要回复的帖子不存在');
}
$data = mysqli_fetch_assoc($result_content);
$data['title']=htmlspecialchars($data['title']);

$template['title'] = '帖子回复页';
$template['css']=array('style/public.css','style/publish.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; 回复帖子
</div>
<div id="publish">
    <div>回复：由 <?php echo $data['name']?> 发布的: <?php echo $data['title']?> </div>
    <form method="post">
        <textarea name="content" class="content"></textarea>
        <input class="reply" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>
