<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$link = connectMySql();

if (!($member_id = is_login($link))){

}

$template['title'] = '首页';
$template['css']=array('style/public.css','style/index.css');

?>

<?php include 'inc/header.inc.php' ?>

<div id="hot" class="auto">
    <div class="title">热门动态</div>
    <ul class="newlist">
        <!-- 20条 -->
        <li><a href="#">[库队]</a> <a href="#">私房库实战项目录制中...</a></li>

    </ul>
    <div style="clear:both;"></div>
</div>

<?php
$query = "select * from sfk_father_module order by sort desc";
$result_father = execute($link,$query);
while($data_father=mysqli_fetch_assoc($result_father)) {
    ?>
    <div class="box auto">
        <div class="title">
            <?php echo $data_father['module_name']?>
        </div>
        <div class="classList">
            <?php
            $sql = "select * from sfk_son_module where father_module_id = {$data_father['id']}";
            $result_son = execute($link,$sql);
            if (mysqli_num_rows($result_son)){
                while ($data_son = mysqli_fetch_assoc($result_son)){
                    $sql1="select count(*) from sfk_content where module_id={$data_son['id']} and time > CURDATE()";
                    $today_count=num($link,$sql1);
                     $sql2 ="select count(*) from sfk_content where module_id={$data_son['id']}";
                    $total_count =num($link,$sql2);
$html=<<<A
            <div class="childBox new">
            <h2><a href="#">{$data_son['module_name']}</a><span>(今日{$today_count})</span></h2>
            帖子：{$total_count}<br />
            </div>  
A;
           echo $html;
             }
            }else {
                echo '<div style="padding:10px 0;">暂无子版块...</div>';
            }
            ?>
            <div style="clear:both;"></div>
        </div>
    </div>
    <?php
}?>

<?php include 'inc/footer.inc.php' ?>