<?php
date_default_timezone_set('Asia/Shanghai');//设置时区
session_start();
header("Content-type: text/html; charset=utf8");
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'Life');
define('DB_PORT', 3306);
//绝对路径
define('SA_PATH',dirname(dirname(__FILE__)));
//项目的目录
define('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',SA_PATH).'/');

?>