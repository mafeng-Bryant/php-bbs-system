<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <?php
    foreach ($template['css'] as $val){
        echo "<link rel='stylesheet' type='text/css' href='{$val}' />";
    }
    ?>

</head>
<body>
<div class="header_wrap">
    <div id="header" class="auto">
        <div class="logo">sifangku</div>
        <div class="nav">
            <a class="hover" href="index.php">首页</a>
        </div>
        <div class="serarch">
            <form>
                <input class="keyword" type="text" name="keyword" placeholder="搜索其实很简单" />
                <input class="submit" type="submit" name="submit" value="" />
            </form>
        </div>
        <div class="login">
        <?php
        if ($member_id){
$str=<<<A
        <a href='member.php?id={$member_id}' target='_blank'>您好！{$_COOKIE['sfk']['name']}</a> <span style="color:#fff">|</span><a href='logout.php'>退出</a>
A;
            echo $str;
        }else {
$str=<<<A
        <a>登录</a>&nbsp;
        <a>注册</a>
A;
            echo $str;
        }
        ?>
        </div>
    </div>
</div>
<div style="margin-top:55px;"></div>
