<?php

if (empty($_POST['name'])){
    skipPage('register.php','error','用户名不得为空');
}

if (mb_strlen($_POST['name'])>32){
    skipPage('register.php','error','用户名长度不要超过32个字符!');
}

if (mb_strlen($_POST['password'])<6){
    skipPage('register.php','error','密码不得少于6位');
}

if ($_POST['password'] !=$_POST['confirm_pw']){
    skipPage('register.php','error','两次输入的密码不一致! 请重新输入');
}

if (strtolower($_POST['vcode']) !=strtolower($_SESSION['vcode']) ){
    skipPage('register.php','error','验证码输入错误!');
}

$_POST = escape($link,$_POST);
$query = "select * from sfk_member where name = '{$_POST['name']}'";
$result = execute($link,$query);
if (mysqli_num_rows($result)){
    skipPage('register.php','error','这个用户名已经被别人注册了！');
}


?>