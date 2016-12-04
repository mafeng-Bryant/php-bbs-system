<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connectMySql();

if (!($member_id = is_login($link))){
    skipPage('login.php','ok','请登录后在删除帖子!');
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skipPage('index.php', 'error', '帖子id参数不合法!');
}

$query = "select member_id from sfk_content where id = {$_GET['id']}";
$result_content = execute($link,$query);
if (mysqli_num_rows($result_content)==1){
  $data_content = mysqli_fetch_assoc($result_content);
  if (check_user($member_id,$data_content['member_id'])){
   $sql = "delete from sfk_content where id = {$_GET['id']}";
   execute($link,$sql);
   if (mysqli_affected_rows($link)==1){
       skipPage("member.php?id={$member_id}", 'ok', '恭喜你删除成功!');
   }else {
       skipPage("member.php?id={$member_id}", 'error', '对不起，删除失败!');
   }
  }else {
      skipPage("member.php?id={$member_id}", 'error', '当前帖子不是你发的，不能删除!');
  }

}else {
    skipPage("member.php?id={$member_id}", 'error', '帖子不存在!');
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