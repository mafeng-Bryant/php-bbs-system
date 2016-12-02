<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once  'inc/page.inc.php';

$link = connectMySql();

$member_id = is_login($link);

if (!is_numeric($_GET['id']) || !isset($_GET['id'])){
    skipPage('index.php','error','父版块id参数错误!');
}

$query = "select * from sfk_father_module where id = {$_GET['id']}";
$result_father = execute($link,$query);
if (mysqli_num_rows($result_father) ==0){
    skipPage('index.php','error','父版块不存在!');
}

$data_father =  mysqli_fetch_assoc($result_father);

$sql = "select * from sfk_son_module where father_module_id = {$_GET['id']}";
$result_son = execute($link,$sql);

$id_son='';
$name_son ='';
while ($data_son = mysqli_fetch_assoc($result_son)){
   $id_son.=$data_son['id'].',';
   $name_son.="<a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a> ";
}
$id_son = trim($id_son,',');

if ($id_son ==''){
    $id_son = '0';
}

$sql2 = "select count(*) from sfk_content where module_id in({$id_son})";
$all_content_count = num($link,$sql2);

$sql3 = "select count(*) from sfk_content where module_id in({$id_son}) and time > CURDATE()";
$today_content_count = num($link,$sql3);

$template['title'] = '父版块列表页';
$template['css']=array('style/public.css','style/list.css');


?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a>
</div>
<div id="main" class="auto">
    <div id="left">
        <div class="box_wrap">
            <h3><?php echo $data_father['module_name'] ?></h3>
            <div class="num">
                今日：<span><?php echo $today_content_count ?></span>&nbsp;&nbsp;&nbsp;
                总帖：<span><?php echo $all_content_count ?></span>
                <div class="moderator"> 子版块： <?php echo $name_son ?></div>
            </div>
            <div class="pages_wrap">
                <a class="btn publish" href="publish.php"></a>
                <div class="pages">
                    <?php
                    $page = page($all_content_count,5);
                    echo $page['html'];
                    ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <ul class="postsList">
            <?php
            $sql4 = "select sfk_member.photo,sfk_member.name,sfk_content.time,sfk_content.id,sfk_content.title,sfk_content.times,sfk_son_module.module_name 
                      from sfk_content,sfk_member,sfk_son_module 
                      where sfk_content.module_id in({$id_son}) 
                      and sfk_content.member_id = sfk_member.id
                      and  sfk_content.module_id = sfk_son_module.id {$page['limit']}";
            $result_3 = execute($link,$sql4);
            while($data_content = mysqli_fetch_assoc($result_3)){
                ?>
            <li>
                <div class="smallPic">
                    <a href="#">
                        <img width="45" height="45" src="<?php
                        if ($data_content['photo'] !='') {
                         echo "{$data_content['photo']}";
                        } else {
                           echo "style/2374101_middle.jpg";
                        }
                        ?>">
                    </a>
                </div>
                <div class="subject">
                    <div class="titleWrap"><a href="#"><?php  echo  $data_content['module_name'] ?></a>&nbsp;&nbsp;<h2><a href="#"><?php echo $data_content['title']?></a></h2></div>
                    <p>
                        楼主：<?php echo $data_content['name'] ?> &nbsp;<?php echo $data_content['time'] ?>&nbsp; 最后回复：2014-12-08
                    </p>
                </div>
                <div class="count">
                    <p>
                        回复<br /><span>41</span>
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
            <a class="btn publish" href="publish.php"></a>
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