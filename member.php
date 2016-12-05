<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';

$link = connectMySql();
$member_id = is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skipPage('index.php', 'error', '会员id参数不合法!');
}
$query="select * from sfk_member where id={$_GET['id']}";
$result_memebr=execute($link, $query);
if(mysqli_num_rows($result_memebr)!=1){
    skipPage('index.php', 'error', '你所访问的会员不存在!');
}
$data_member=mysqli_fetch_assoc($result_memebr);

$query="select count(*) from sfk_content where member_id={$_GET['id']}";
$all_content_count=num($link, $query);

$template['title'] = '会员中心';
$template['css']=array('style/public.css','style/list.css','style/member.css');

?>

<?php include 'inc/header.inc.php' ?>

    <div id="position" class="auto">
        <a href="index.php">首页</a> &gt; <?php echo $data_member['name']?>
    </div>
    <div id="main" class="auto">
        <div id="left">
            <ul class="postsList">
                <?php
                $page = page($all_content_count,5);
                $sql = "select sfk_member.photo,sfk_member.name,sfk_content.time,sfk_content.member_id,sfk_content.id,sfk_content.title,sfk_content.times
                      from sfk_content,sfk_member
                      where sfk_content.member_id = {$_GET['id']} and sfk_content.member_id = sfk_member.id {$page['limit']}";
                $result_3 = execute($link,$sql);
             while ($data_content = mysqli_fetch_assoc($result_3)){
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
                        <div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
                        <p>
                            <?php
                            if (check_user($member_id,$data_content['member_id'])){
                                $url = urlencode("content_delete.php?id={$data_content['id']}");
                                $return_url = urlencode($_SERVER['REQUEST_URI']);
                                $message = "你真的要删除帖子{$data_content['title']} 吗?";
                                $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
                                echo "<a href='content_update.php?id={$data_content['id']}'>编辑</a> <a href='{$delete_url}' >删除</a>";
                            }
                            ?>
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
}?>
            </ul>
            <div class="pages">
                <?php echo $page['html']?>
            </div>
        </div>
        <div id="right">
            <div class="member_big">
                <dl>
                    <dt>
                        <img width="180" height="180" src="<?php
                        if ($data_member['photo'] !='') {
                            echo "{$data_member['photo']}";
                        } else {
                            echo "style/2374101_middle.jpg";
                        }
                        ?>" />
                    </dt>
                    <dd class="name"><?php echo $data_member['name']?></dd>
                    <dd>帖子总计：<?php echo $all_content_count ?></dd>
                    <dd>操作：<a target="_blank" href="member_photo_update.php">修改头像</a> | <a target="_blank" href="">修改密码</a></dd>
                </dl>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>

    </body>
    </html>

<?php include 'inc/footer.inc.php' ?>