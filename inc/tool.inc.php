<?php

function skipPage($url,$pic,$message){

$html=<<<A
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="refresh" content="2; URL={$url}" />
<title>正在跳转中</title>
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic {$pic}"></span> {$message}  <a href="{$url}">2秒自动跳转中!</a></div>
</body>
</html>
A;
echo $html;
exit();
}

//验证前台登录判断
function  is_login($link){
if (isset($_COOKIE['sfk']['name']) && isset($_COOKIE['sfk']['password'])) {
    $query = "select * from sfk_member where name = '{$_COOKIE['sfk']['name']}' and password ='{$_COOKIE['sfk']['password']}'";
    $result = execute($link, $query);
    if (mysqli_num_rows($result) == 1) {
       $data = mysqli_fetch_assoc($result);
        return $data['id'];
    } else {
        return false;
    }
   }else {
    return false;
  }
}

//判断是不是后台登录或者前台用户自己登录的
function check_user($member_id,$content_member_id,$is_manage_login){
    if ($member_id == $content_member_id || $is_manage_login){
        return true;
    }else {
        return false;
    }
}

//验证后台登录判断
function is_manage_login($link){
    if (isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['password'])) {
        $query = "select * from sfk_manage where name = '{$_SESSION['manage']['name']}' and password ='{$_SESSION['manage']['password']}'";
        $result = execute($link, $query);
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }else {
        return false;
    }
}

?>

