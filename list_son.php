<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once  'inc/page.inc.php';

$link = connectMySql();

$member_id = is_login($link);

if (!is_numeric($_GET['id']) || !isset($_GET['id'])){
    skipPage('index.php','error','子版块id参数错误!');
}

$query = "select * from sfk_son_module where id = {$_GET['id']}";
$result_father = execute($link,$query);
$data_son = mysqli_fetch_assoc($result_father);
if (mysqli_num_rows($result_father) ==0){
    skipPage('index.php','error','子版块不存在!');
}

$sql = "select * from sfk_father_module  where id = {$data_son['father_module_id']}";
$result_data = execute($link,$sql);
$data_father = mysqli_fetch_assoc($result_data);


$sql2 = "select count(*) from sfk_content where module_id={$_GET['id']}";
$all_content_count = num($link,$sql2);
$sql3 = "select count(*) from sfk_content where module_id={$_GET['id']} and time > CURDATE()";
$today_content_count = num($link,$sql3);

//查版主
$sql4 = "select * from sfk_member where id = {$data_son['member_id']}";
$member_result = execute($link,$sql4);


$template['title'] = '子版块列表页';
$template['css']=array('style/public.css','style/list.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">

    <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a> &gt; <a><?php echo $data_son['module_name']?></a>
</div>
<div id="main" class="auto">
    <div id="left">
        <div class="box_wrap">
            <h3><?php echo $data_son['module_name'] ?></h3>
            <div class="num">
                今日：<span><?php echo $today_content_count ?></span>&nbsp;&nbsp;&nbsp;
                总帖：<span><?php echo $all_content_count ?></span>
            </div>
            <div class="moderator">版主：<span>
                  <?php
                 if (mysqli_num_rows($member_result)==0){
                     echo "暂无版主";
                 }else {
                    $data_member = mysqli_fetch_assoc($member_result);
                    echo  $data_member['name'];
                 }
                  ?>
                </span></div>
            <div class="notice"><?php echo $data_son['info']?></div>
            <div class="pages_wrap">
                <a class="btn publish" href="publish.php?son_module_id=<?php echo $_GET['id']?>" target="_blank"></a>
                <div class="pages">
                    <?php
                    $page = page($all_content_count,20);
                    echo $page['html'];
                    ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <ul class="postsList">

            <?php
            $sql4 = "select sfk_member.photo,sfk_member.name,sfk_content.member_id,sfk_content.time,sfk_content.id,sfk_content.title,sfk_content.times
                      from sfk_content,sfk_member 
                      where sfk_content.module_id = {$data_son['id']} 
                      and sfk_content.member_id = sfk_member.id
                      {$page['limit']}";
            $result_3 = execute($link,$sql4);
            while($data_content = mysqli_fetch_assoc($result_3)){
                $data_content['title'] = htmlspecialchars($data_content['title']);
                $sql5 = "select * from sfk_reply where content_id = {$data_content['id']} order by id desc limit 1";
                $result_reply =  execute($link,$sql5);
                if (mysqli_num_rows($result_reply)==0){
                    $last_time = '暂无';
                }else {
                    $result_reply_data = mysqli_fetch_assoc($result_reply);
                    $last_time = $result_reply_data['time'];
                }
                $sql6 = "select count(*) from sfk_reply where content_id = {$data_content['id']}";
                $reply_count = num($link,$sql6);


                ?>
                <li>
                    <div class="smallPic">
                        <a href='member.php?id=<?php echo $data_content['member_id']?>' target='_blank'>
                            <img width="45" height="45" src="<?php
                            if ($data_content['photo'] !='') {
                                echo SUB_URL.$data_content['photo'];
                            } else {
                                echo "style/2374101_middle.jpg";
                            }
                            ?>">
                        </a>
                    </div>
                    <div class="subject">
                        <div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
                        <p>
                            楼主：<?php echo $data_content['name'] ?> &nbsp;<?php echo $data_content['time'] ?>&nbsp; 最后回复：<?php echo $last_time?>
                        </p>
                    </div>
                    <div class="count">
                        <p>
                            回复<br /><span><?php echo $reply_count?></span>
                        </p>
                        <p>
                            浏览<br /><span><?php echo $data_content['times'] ?></span>
                        </p>
                    </div>
                    <div style="clear:both;"></div>
                </li>
                <?php
            }
            ?>
            <div class="pages_wrap">
                <a class="btn publish" href="publish.php?son_module_id=<?php echo $_GET['id']?>" target="_blank"></a>
                <div class="pages">
                    <?php
                    echo $page['html'];
                    ?>
                </div>
                <div style="clear:both;"></div>
            </div>
    </div>
    <div id="right">
        <div class="classList">
            <div class="title">版块列表</div>
            <ul class="listWrap">
                <?php
                $query = "select * from sfk_father_module";
                $result = execute($link,$query);
                while ($data_father = mysqli_fetch_assoc($result)){
                    ?>
                    <li>
                        <h2><a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a></h2>
                        <ul>
                            <?php
                            $query = "select * from sfk_son_module where father_module_id = {$data_father['id']}";
                            $result_son = execute($link,$query);
                            while($data_son = mysqli_fetch_assoc($result_son)){
                                ?>
                                <li><h3><a href="list_son.php?id =<?php echo $data_son['id']?>"><?php echo $data_son['module_name']?></a></h3></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                  }
                ?>
            </ul>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>


<?php include 'inc/footer.inc.php' ?>