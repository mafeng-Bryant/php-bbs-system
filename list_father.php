<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connectMySql();

if (!($member_id = is_login($link))){

}

$template['title'] = '父版块列表页';
$template['css']=array('style/public.css','style/list.css');

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
while ($data_son = mysqli_fetch_assoc($result_son)){
   $id_son.=$data_son['id'].',';
}
$id_son = trim($id_son,',');

$sql2 = "select count(*) from sfk_content where module_id in({$id_son})";
$all_content_count = num($link,$sql2);

$sql3 = "select count(*) from sfk_content where module_id in({$id_son}) and time > CURDATE()";
$today_content_count = num($link,$sql3);


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
                <div class="moderator"> 子版块： <a>NBA</a> <a>CBA</a></div>
            </div>
            <div class="pages_wrap">
                <a class="btn publish" href=""></a>
                <div class="pages">
                    <a>« 上一页</a>
                    <a>1</a>
                    <span>2</span>
                    <a>3</a>
                    <a>4</a>
                    <a>...13</a>
                    <a>下一页 »</a>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <ul class="postsList">
            <li>
                <div class="smallPic">
                    <a href="#">
                        <img width="45" height="45"src="style/2374101_small.jpg">
                    </a>
                </div>
                <div class="subject">
                    <div class="titleWrap"><a href="#">[分类]</a>&nbsp;&nbsp;<h2><a href="#">我这篇帖子不错哦</a></h2></div>
                    <p>
                        楼主：孙胜利&nbsp;2014-12-08&nbsp;&nbsp;&nbsp;&nbsp;最后回复：2014-12-08
                    </p>
                </div>
                <div class="count">
                    <p>
                        回复<br /><span>41</span>
                    </p>
                    <p>
                        浏览<br /><span>896</span>
                    </p>
                </div>
                <div style="clear:both;"></div>
            </li>
            <li>
                <div class="smallPic">
                    <a href="#">
                        <img width="45" height="45"src="style/2374101_small.jpg">
                    </a>
                </div>
                <div class="subject">
                    <div class="titleWrap"><a href="#">[分类]</a>&nbsp;&nbsp;<h2><a href="#">我这篇帖子不错哦</a></h2></div>
                    <p>
                        楼主：孙胜利&nbsp;2014-12-08&nbsp;&nbsp;&nbsp;&nbsp;最后回复：2014-12-08
                    </p>
                </div>
                <div class="count">
                    <p>
                        回复<br /><span>41</span>
                    </p>
                    <p>
                        浏览<br /><span>896</span>
                    </p>
                </div>
                <div style="clear:both;"></div>
            </li>
            <li>
                <div class="smallPic">
                    <a href="#">
                        <img width="45" height="45"src="style/2374101_small.jpg">
                    </a>
                </div>
                <div class="subject">
                    <div class="titleWrap"><a href="#">[分类]</a>&nbsp;&nbsp;<h2><a href="#">我这篇帖子不错哦</a></h2></div>
                    <p>
                        楼主：孙胜利&nbsp;2014-12-08&nbsp;&nbsp;&nbsp;&nbsp;最后回复：2014-12-08
                    </p>
                </div>
                <div class="count">
                    <p>
                        回复<br /><span>41</span>
                    </p>
                    <p>
                        浏览<br /><span>896</span>
                    </p>
                </div>
                <div style="clear:both;"></div>
            </li>
            <li>
                <div class="smallPic">
                    <a href="#">
                        <img width="45" height="45"src="style/2374101_small.jpg">
                    </a>
                </div>
                <div class="subject">
                    <div class="titleWrap"><a href="#">[分类]</a>&nbsp;&nbsp;<h2><a href="#">我这篇帖子不错哦</a></h2></div>
                    <p>
                        楼主：孙胜利&nbsp;2014-12-08&nbsp;&nbsp;&nbsp;&nbsp;最后回复：2014-12-08
                    </p>
                </div>
                <div class="count">
                    <p>
                        回复<br /><span>41</span>
                    </p>
                    <p>
                        浏览<br /><span>896</span>
                    </p>
                </div>
                <div style="clear:both;"></div>
            </li>
        </ul>
        <div class="pages_wrap">
            <a class="btn publish" href=""></a>
            <div class="pages">
                <a>« 上一页</a>
                <a>1</a>
                <span>2</span>
                <a>3</a>
                <a>4</a>
                <a>...13</a>
                <a>下一页 »</a>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    <div id="right">
        <div class="classList">
            <div class="title">版块列表</div>
            <ul class="listWrap">
                <li>
                    <h2><a href="#">NBA</a></h2>
                    <ul>
                        <li><h3><a href="#">私房库</a></h3></li>
                        <li><h3><a href="#">私</a></h3></li>
                        <li><h3><a href="#">房</a></h3></li>
                    </ul>
                </li>
                <li>
                    <h2><a href="#">CBA</a></h2>
                </li>
            </ul>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>


<?php include 'inc/footer.inc.php' ?>