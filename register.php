<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connectMySql();

if ($member_id = is_login($link)){
    skipPage("index.php",'error','你已经注册成功，请不要重复注册!');
}

if (isset($_POST['submit'])){

    include 'inc/check_register.inc.php';
    $_POST = escape($link,$_POST);
    $query = "insert into sfk_member(name,password,register_time) values('{$_POST['name']}' , md5('{$_POST['password']}'),now())";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        setcookie('sfk[name]',$_POST['name']);
        setcookie('sfk[password]',md5($_POST['password']));
        skipPage("index.php",'ok','注册成功!');
    }else {
        skipPage("register.php",'error','注册失败，请重试!');
    }
}

$template['title']='会员注册页';
$template['css']=array('style/public.css','style/register.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="register" class="auto">
    <h2>欢迎注册成为 私房库会员</h2>
    <form method="post">
        <label>用户名：<input type="text" name="name"  /><span>*用户名不得为空，并且长度不得超过32个字符*</span></label>
        <label>密码：<input type="password" name="password" /><span>*密码不得少于6位*</span></label>
        <label>确认密码：<input type="password" name="confirm_pw" /><span>*请输入以上一致*</span></label>
        <label>验证码：<input name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
        <img class="vcode" src="show_code.php" />
        <div style="clear:both;"></div>
        <input class="btn" name="submit" type="submit" value="确定注册" />
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>