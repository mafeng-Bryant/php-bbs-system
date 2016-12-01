<?php


if (empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
    skipPage('publish.php','error','所属版块id不合法');
}

$query = "select * from sfk_son_module where id = {$_POST['module_id']}";
$result = execute($link,$query);
if (mysqli_num_rows($result)!=1){
    skipPage('publish.php','error','所属版块不存在');
}

if(empty($_POST['title'])){
    skipPage('publish.php', 'error', '标题不得为空！');
}
if(mb_strlen($_POST['title'])>255){
    skipPage('publish.php', 'error', '标题不得超过255个字符！');
}

if(empty($_POST['content'])){
    skipPage('publish.php', 'error', '内容不得为空！');
}


?>