<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connectMySql();

if (!($member_id = is_login($link))){
}

if (isset($_POST['submit'])){

    include 'inc/check_login.inc.php';
    $_POST = escape($link,$_POST);
    $query = "select * from sfk_member where name = '{$_POST['name']}' and password =md5('{$_POST['password']}')";
    $result = execute($link,$query);
    if (mysqli_num_rows($result)==1)
     {
         setcookie('sfk[name]',$_POST['name'],time()+$_POST['time']);
         setcookie('sfk[password]',md5($_POST['password']),time()+$_POST['time']);
         skipPage('index.php','ok','登录成功!');
     }else {
        skipPage('login.php','error','登录失败，用户名或者密码输入错误!');
    }
}

$template['title'] = '欢迎登录';
$template['css'] = array('style/public.css','style/register.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="register" class="auto">
    <h2>欢迎注册成为 私房库会员</h2>
    <form method="post">
        <label>用户名：<input type="text" name="name" /><span></span></label>
        <label>密码：<input type="password"  name="password" /><span></span></label>
        <label>验证码：<input name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
        <img class="vcode" src="show_code.php" />
        <label>自动登录：
            <select style="width:236px;height:25px;" name="time">
                <option value="3600">1小时内</option>
                <option value="86400">1天内</option>
                <option value="259200">3天内</option>
                <option value="2592000">30天内</option>
            </select>
            <span>*公共电脑上请勿长期自动登录</span>
        </label>
        <div style="clear:both;"></div>
        <input class="btn" type="submit" value="登录" name="submit" />
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>