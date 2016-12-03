<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once  'inc/page.inc.php';

$link = connectMySql();

if (!($member_id = is_login($link))){
    skipPage('login.php','ok','请登录后在回复!');
}

$template['title'] = '帖子回复页';
$template['css']=array('style/public.css','style/publish.css');



?>


<?php include 'inc/header.inc.php' ?>







<?php include 'inc/footer.inc.php' ?>
