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

$sql5 = "update sfk_content set times = times+1 where id ={$_GET['id']}";
execute($link,$sql5);

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


$sql4 = "select sc.id cid,sc.module_id,sc.title,sc.content,sc.time,sc.times,sc.member_id,sm.name,sm.photo from sfk_content sc,sfk_member sm where sc.id ={$_GET['id']} and sc.member_id = sm.id";
$result_member = execute($link,$sql4);
$data_member = mysqli_fetch_assoc($result_member);
$data_member['title'] = htmlspecialchars($data_member['title']);
$data_member['content'] = nl2br(htmlspecialchars($data_member['content']));

$template['title'] = '帖子详情页';
$template['css']=array('style/public.css','style/show.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a>首页</a> &gt; <a>NBA</a> &gt; <a>私房库</a> &gt; 的青蛙地区稳定期望
</div>
<div id="main" class="auto">
    <div class="wrap1">
        <div class="pages">
            <?php
            $query = "select count(*) from sfk_reply where content_id={$_GET['id']}";
            $count_reply = num($link,$query);
            $page_size = 2;
            $page = page($count_reply,$page_size);
            echo  $page['html'];
            ?>
        </div>
        <a class="btn reply" href="reply.php?id=<?php echo $_GET['id']?>" target="_blank"></a>
        <div style="clear:both;"></div>
    </div>

    <?php

    if (isset($_GET['page']) && $_GET['page'] ==1){
    ?>
         <div class="wrapContent">
            <div class="left">
                <div class="face">
                    <a target="_blank" href="">
                        <img width="120" height="120" src="<?php
                        if ($data_member['photo'] !='') {
                            echo "{$data_member['photo']}";
                        } else {
                            echo "style/2374101_middle.jpg";
                        }
                        ?>">
                    </a>
                </div>
                <div class="name">
                    <a href=""><?php echo $data_member['name']?></a>
                </div>
            </div>
          <div class="right">
                <div class="title">
                    <h2><?php echo $data_member['title']?></h2>
                    <span>阅读:<?php echo $data_member['times']?>&nbsp|&nbsp;回复：15</span>
                    <div style="clear:both;"></div>
                </div>
                <div class="pubdate">
                    <span class="date"><?php echo $data_member['time']?></span>
                    <span class="floor" style="color:red;font-size:14px;font-weight:bold;">楼主</span>
                </div>
                <div class="content">
                    <?php echo $data_member['content']?>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
         <?php
    }
    ?>
    <?php
    $query = "select sm.name,sr.member_id,sm.photo ,sr.quote_id,sr.time,sr.id,sr.content from sfk_reply sr,sfk_member sm where sr.content_id = {$_GET['id']} and sr.member_id = sm.id {$page['limit']};
";
    $result_reply = execute($link,$query);
    $i = 0;
    if (isset($_GET['page'])) {
        $i = ($_GET['page'] - 1)*$page_size+1;
    }

    while ($reply_data = mysqli_fetch_assoc($result_reply)) {
        $reply_data['content'] = nl2br(htmlspecialchars($reply_data['content']));

        ?>
        <div class="wrapContent">
            <div class="left">
                <div class="face">
                    <a target="_blank" href="">
                        <img width="120" height="120" src="<?php
                        if ($reply_data['photo'] !='') {
                            echo "{$reply_data['photo']}";
                        } else {
                            echo "style/2374101_middle.jpg";
                        }
                        ?>">
                    </a>
                </div>
                <div class="name">
                    <a href=""><?php  echo  $reply_data['name']?></a>
                </div>
            </div>
            <div class="right">
                <div class="pubdate">
                    <span class="date">回复时间：<?php echo $reply_data['time']?></span>
                    <span class="floor"><?php echo $i++?>楼&nbsp;|&nbsp;<a target="_blank" href="quote.php?id=<?php echo $_GET['id']?>&reply_id=<?php echo $reply_data['id']?>">引用</a></span>
                </div>
                <div class="content">

          <?php
          if ($reply_data['quote_id']) {
            $query = "select count(*) from sfk_reply where content_id = {$_GET['id']} and id<={$reply_data['quote_id']}";
            $floor = num($link,$query);
              $query1="select sfk_reply.content,sfk_member.name from sfk_reply,sfk_member where sfk_reply.id={$reply_data['quote_id']} and sfk_reply.content_id={$_GET['id']} and sfk_reply.member_id=sfk_member.id";
              $result_quote=execute($link,$query1);
              $data_quote=mysqli_fetch_assoc($result_quote);
              ?>
              <div class="quote">
                  <h2>引用 <?php echo $floor?>楼 <?php echo $data_quote['name']?> 发表的: </h2>
                  <?php echo nl2br(htmlspecialchars($data_quote['content']))?>
              </div>
          <?php }

          ?>
            <?php
           echo  $reply_data['content'];
          ?>

                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <?php
       }
  ?>
    <div class="wrap1">
        <div class="pages">
            <?php
            echo  $page['html'];
            ?>
        </div>
        <a class="btn reply" href="reply.php?id=<?php echo $_GET['id']?>" target="_blank"></a>
        <div style="clear:both;"></div>
    </div>
</div>

<?php include 'inc/footer.inc.php' ?>
