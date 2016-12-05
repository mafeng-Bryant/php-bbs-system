<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
include_once 'inc/upload.inc.php';

$link = connectMySql();
if (!$member_id = is_login($link)){
   skipPage('login.php','error','请登录后再修改头像');
}

$query = "select photo from sfk_member where id = $member_id";
$result = execute($link,$query);
$result_data = mysqli_fetch_assoc($result);


if (isset($_POST['submit'])){
 //根据日期存放照片在目录下
 $save_path = 'uploads/'.date('Y/m/d');
 $upload = upload($save_path,'2M','photo');
    if ($upload['return']){
       $query = "update sfk_member set photo ='{$upload['save_path']}' where id = {$member_id}";
        execute($link,$query);
     if (mysqli_affected_rows($link)==1){
         skipPage("member.php?id={$member_id}",'ok','头像更新成功!');
     }else {
         skipPage("member.php?id={$member_id}",'error','头像更新失败，请重试!');
     }
    }else {
        skipPage('member_photo_update.php',$upload['error']);
    }
}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <style type="text/css">
        body {
            font-size:12px;
            font-family:微软雅黑;
        }
        h2 {
            padding:0 0 10px 0;
            border-bottom: 1px solid #e3e3e3;
            color:#444;
        }
        .submit {
            background-color: #3b7dc3;
            color:#fff;
            padding:5px 22px;
            border-radius:2px;
            border:0px;
            cursor:pointer;
            font-size:14px;
        }
        #main {
            width:80%;
            margin:0 auto;
        }
    </style>
</head>
<body>
<div id="main">
    <h2>更改头像</h2>
    <div>
        <h3>原头像：</h3>
        <img src="<?php
        if ($result_data['photo'] !='') {
            echo SUB_URL.$result_data['photo'];
        } else {
            echo "style/photo.jpg";
        }
        ?>">
        <br />
        最佳图片尺寸: 180*180
    </div>
    <div style="margin:15px 0 0 0;">
        <form action="" method="post" enctype="multipart/form-data">
        <input style="cursor:pointer;" width="100" type="file"  name="photo"/><br /><br />
            <input class="submit" type="submit" value="保存" name="submit" />
        </form>
    </div>
</div>
</body>
</html>
