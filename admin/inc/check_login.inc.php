<?php

if (empty($_POST['name'])){
    skipPage('login.php','error','管理员名称不能为空!');
}

if (mb_strlen($_POST['name']) >66){
    skipPage('login.php','error','管理员名称不能多余32个字符');
}

if (mb_strlen($_POST['password']) <6){
    skipPage('login.php','error','密码不得少于6位');
}

if (strtolower($_POST['vcode']) !=strtolower($_SESSION['vcode']) ){
    skipPage('login.php','error','验证码输入错误!');
}

?>