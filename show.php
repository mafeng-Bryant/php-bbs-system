<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once  'inc/page.inc.php';

$link = connectMySql();
$member_id = is_login($link);

if (!is_numeric($_GET['id']) || !isset($_GET['id'])){
    skipPage('index.php','error','帖子id参数错误!');
}

$query = "select * from sfk_content where id = {$_GET['id']}";
$result_content = execute($link,$query);
if (mysqli_num_rows($result_content) ==0){
    skipPage('index.php','error','帖子不存在!');
}

$data_content =  mysqli_fetch_assoc($result_content);
$sql = "select * from sfk_son_module where id = {$data_content['module_id']}";
$result_data_son = execute($link,$sql);
$data_son = mysqli_fetch_assoc($result_data_son);


$sql3 = "select * from sfk_father_module where id = {$data_son['father_module_id']}";
$result_data_father = execute($link,$sql3);
$data_father = mysqli_fetch_assoc($result_data_father);


$template['title'] = '帖子详情页';
$template['css']=array('style/public.css','style/show.css');


?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a> &gt; <a href="list_son.php?id=<?php  echo $data_son['id']?>"><?php echo $data_son['module_name'] ?></a> &gt; <?php echo $data_content['title']?>
</div>
<div id="main" class="auto">
    <div class="wrap1">
        <div class="pages">
            <a>« 上一页</a>
            <a>1</a>
            <span>2</span>
            <a>3</a>
            <a>4</a>
            <a>...13</a>
            <a>下一页 »</a>
        </div>
        <a class="btn reply" href="#"></a>
        <div style="clear:both;"></div>
    </div>
    <div class="wrapContent">
        <div class="left">
            <div class="face">
                <a target="_blank" href="">
                    <img src="style/2374101_middle.jpg" />
                </a>
            </div>
            <div class="name">
                <a href="">孙胜利</a>
            </div>
        </div>
        <div class="right">
            <div class="title">
                <h2>测试</h2>
                <span>阅读：339&nbsp;|&nbsp;回复：15</span>
                <div style="clear:both;"></div>
            </div>
            <div class="pubdate">
                <span class="date">发布于：2014-12-08 15:03 </span>
                <span class="floor" style="color:red;font-size:14px;font-weight:bold;">楼主</span>
            </div>
            <div class="content">
                带我去的青蛙当前我的青蛙地区稳定期望
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div class="wrapContent">
        <div class="left">
            <div class="face">
                <a target="_blank" href="">
                    <img src="style/2374101_middle.jpg" />
                </a>
            </div>
            <div class="name">
                <a href="">孙胜利</a>
            </div>
        </div>
        <div class="right">

            <div class="pubdate">
                <span class="date">回复时间：2014-12-29 14:24:26</span>
                <span class="floor">1楼&nbsp;|&nbsp;<a href="#">引用</a></span>
            </div>
            <div class="content">
                定位球定位器
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div class="wrapContent">
        <div class="left">
            <div class="face">
                <a target="_blank" data-uid="2374101" href="">
                    <img src="style/2374101_middle.jpg" />
                </a>
            </div>
            <div class="name">
                <a class="J_user_card_show mr5" data-uid="2374101" href="">孙胜利</a>
            </div>
        </div>
        <div class="right">

            <div class="pubdate">
                <span class="date">回复时间：2014-12-29 14:24:26</span>
                <span class="floor">1楼&nbsp;|&nbsp;<a href="#">引用</a></span>
            </div>
            <div class="content">
                <div class="quote">
                    <h2>引用 1楼 孙胜利 发表的: </h2>
                    哈哈
                </div>
                定位球定位器
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div class="wrap1">
        <div class="pages">
            <a>« 上一页</a>
            <a>1</a>
            <span>2</span>
            <a>3</a>
            <a>4</a>
            <a>...13</a>
            <a>下一页 »</a>
        </div>
        <a class="btn reply" href="#"></a>
        <div style="clear:both;"></div>
    </div>
</div>

<?php include 'inc/footer.inc.php' ?>
