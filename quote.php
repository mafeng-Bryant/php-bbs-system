<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once  'inc/page.inc.php';

$link = connectMySql();
$member_id = is_login($link);


$template['title'] = '帖子引用回复页';
$template['css']=array('style/public.css','style/publish.css');


?>


<?php include 'inc/header.inc.php' ?>

<div id="position" class="auto">
    <a>首页</a> &gt; <a>NBA</a> &gt; <a>私房库</a> &gt; 的青蛙地区稳定期望
</div>
<div id="publish">
    <div>孙胜利: 定位球定位器定位器</div>
    <div class="quote">
        <p class="title">引用1楼 孙胜利 发表的: </p>
        内容http://localhost/http://localhost/
    </div>
    <form method="post">
        <textarea name="content" class="content"></textarea>
        <input class="reply" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>
<div id="footer" class="auto">
    <div class="bottom">
        <a>私房库</a>
    </div>
    <div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
</div>
</body>
</html>

<?php include 'inc/footer.inc.php' ?>
