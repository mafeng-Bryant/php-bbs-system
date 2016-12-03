<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once  'inc/page.inc.php';

$link = connectMySql();
if (!$member_id = is_login($link)){
    skipPage('login.php','error','请登录后再做回复');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skipPage('index.php','error','你要回复的帖子参数id不合法');
}

$query = "select sc.id,sc.title,sc.content,sm.name from sfk_content sc,sfk_member sm where sc.id = {$_GET['id']} and sc.member_id = sm.id";
$result_content = execute($link,$query);
if (mysqli_num_rows($result_content)!=1){
    skipPage('index.php','error','你要回复的帖子不存在');
}
$data = mysqli_fetch_assoc($result_content);
$data['title']=htmlspecialchars($data['title']);

if (!isset($_GET['reply_id']) || !is_numeric($_GET['reply_id'])){
    skipPage('index.php','error','引用帖子参数id不合法');
}

$sql1 = "select sfk_reply.content,sfk_member.name from sfk_reply,sfk_member where sfk_reply.id = {$_GET['reply_id']} and sfk_reply.content_id = {$_GET['id']} and sfk_reply.member_id = sfk_member.id";
$result_reply = execute($link,$sql1);
if (mysqli_num_rows($result_reply)!=1){
    skipPage('index.php','error','你要引用的帖子不存在');
}

if (isset($_POST['submit'])) {

    include 'inc/check_reply.inc.php';
    $_POST = escape($link, $_POST);
    $query = "insert into sfk_reply(content_id,quote_id,content,time,member_id) 
              values (
              {$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$member_id}
            )";
    execute($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        skipPage("show.php?id={$_GET['id']}", 'ok', ' 回复成功');
    } else {
        skipPage($_SESSION['REQUEST_URL'], 'error', '回复失败');
    }
}

$data_single_reply = mysqli_fetch_assoc($result_reply);
$data_single_reply['content'] =nl2br(htmlspecialchars($data_single_reply['content']));

$sql = "select count(*) from sfk_reply where content_id = {$_GET['id']} and id<={$_GET['reply_id']}";
$total_count = num($link,$sql);

$template['title'] = '帖子引用回复页';
$template['css']=array('style/public.css','style/publish.css');

?>


<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a>首页</a> &gt; <a>NBA</a> &gt; <a>私房库</a> &gt; 的青蛙地区稳定期望
</div>
<div id="publish">
    <div><?php echo $data['name']?>: <?php echo $data['title']?></div>
    <div class="quote">
        <p class="title">引用<?php echo $total_count?>楼 <?php echo $data_single_reply['name']?> 发表的: </p>
        <?php echo $data_single_reply['content']?>
    </div>
    <form method="post">
        <textarea name="content" class="content"></textarea>
        <input class="reply" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>
<div id="footer" class="auto">
    <div class="bottom">
        <a>私房库</a>
    </div>
    <div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
</div>
</body>
</html>

<?php include 'inc/footer.inc.php' ?>
