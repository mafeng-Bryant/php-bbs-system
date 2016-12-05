<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connectMySql();
$is_manage_login = is_manage_login($link);

if (!($member_id = is_login($link)) && !$is_manage_login){
    skipPage('login.php','ok','请登录后在删除帖子!');
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skipPage('index.php', 'error', '帖子id参数不合法!');
}

$query = "select * from sfk_content where id = {$_GET['id']}";
$result_content = execute($link,$query);
if (mysqli_num_rows($result_content)==1){
    $data_content = mysqli_fetch_assoc($result_content);
    $data_content['title'] = htmlspecialchars($data_content['title']);
    if (check_user($member_id,$data_content['member_id'],$is_manage_login)){
        if (isset($_POST['submit'])) {
            include 'inc/check_publish.inc.php';
            $_POST = escape($link, $_POST);
            $query2 = "update sfk_content set module_id = {$_POST['module_id']},title = '{$_POST['title']}',content='{$_POST['content']}' where id = {$_GET['id']}";
            execute($link, $query2);
            if (isset($_GET['return_url'])){
             $return_url = $_GET['return_url'];
            }else {
              $return_url = "member.php?id={$member_id}";
            }
            if (mysqli_affected_rows($link) == 1) {
                skipPage($return_url, 'ok', '修改成功！');
            } else {
                skipPage($return_url, 'error', '修改失败！');
            }
        }
    }else {
        skipPage("index,php", 'error', '当前帖子不是你发的，不能删除!');
    }

}else {
    skipPage("index.php", 'error', '帖子不存在!');
}

$template['title'] = '帖子修改页';
$template['css']=array('style/public.css','style/publish.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a>首页</a> &gt;发布帖子
</div>
<div id="publish">
    <form method="post">
        <select name="module_id">
            echo "<option value='-1'>请选择一个子版块</option>";
            <?php
            $query = "select * from sfk_father_module $where order by sort desc";
            $result = execute($link,$query);
            while ($data = mysqli_fetch_assoc($result)){
                echo "<optgroup label='{$data['module_name']}'>";
                $sql = "select * from sfk_son_module where father_module_id={$data['id']} order by sort desc";
                $result_son = execute($link,$sql);
                while ($data_son=mysqli_fetch_assoc($result_son)){
                    if ($data_son['id'] == $data_content['module_id']){
                        echo "<option  selected='selected' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                    }else {
                        echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                    }
                }
                echo "</optgroup>";
            }
            ?>
        </select>
        <input class="title" placeholder="请输入标题" name="title" value="<?php echo $data_content['title']?>" type="text" />
        <textarea name="content" class="content"><?php echo $data_content['content']?></textarea>
        <input class="publish" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>

<?php include 'inc/footer.inc.php' ?>
