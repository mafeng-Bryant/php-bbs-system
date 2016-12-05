<?php

function upload($save_path,$custom_upload_max_filesize,$key,$type=array('jpg','jpeg','gif','png','txt')){
    $return_data = array();

    //获取PHP设置的最大上传文件大小
    $phpini = ini_get('upload_max_filesize');
    $phpini_unit = strtoupper(substr($phpini,-1));
    $phpini_number = substr($phpini,0,-1);
    $phpini_multipe  = get_muliple($phpini_unit);
    $phpini_bytes = $phpini_multipe*$phpini_number;

    //用户上传的文件大小
    $customp_unit = strtoupper(substr($custom_upload_max_filesize,-1));
    $custom_number = substr($custom_upload_max_filesize,0,-1);
    $custom_multipe  = get_muliple($customp_unit);
    $custom_bytes = $custom_multipe*$custom_number;

    if ($custom_bytes > $phpini_bytes){
        $return_data['error'] = '传入的文件大于php配置里面文件大小';
        $return_data['return'] = false;
        return $return_data;
    }

    $arr_errors=array(
        1=>'上传的文件超过了 php.ini中 upload_max_filesize 选项限制的值',
        2=>'上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
        3=>'文件只有部分被上传',
        4=>'没有文件被上传',
        6=>'找不到临时文件夹',
        7=>'文件写入失败'
    );

    if(!isset($_FILES[$key]['error'])){
        $return_data['error']='由于未知原因导致，上传失败，请重试！';
        $return_data['return']=false;
        return $return_data;
    }

    if ($_FILES[$key]['error']!=0){
        $return_data['error'] = $arr_errors[$_FILES['error']];
        $return_data['return'] = false;
        return $return_data;
    }

    if(!is_uploaded_file($_FILES[$key]['tmp_name'])){
        echo "12737881237871273";
        $return_data['error']='您上传的文件不是通过 HTTP POST方式上传的！';
        $return_data['return']=false;
        return $return_data;
    }

    if ($_FILES[$key]['size'] > $custom_bytes){
        $return_data['error'] = '上传的文件大小超过了程序作者限定的'.$custom_upload_max_filesize;
        $return_data['return'] = false;
        return $return_data;
    }

    $arr_filename = pathinfo($_FILES[$key]['name']);
    if (!isset($arr_filename['extension'])){
        $arr_filename['extension'] = '';
    }

    //验证后缀名
   if (!in_array($arr_filename['extension'],$type)){
    $return_data['error'] = '上传的文件类型必须是'.implode(',',$type).'这其中的一个';
    $return_data['return'] = false;
    return $return_data;
   }

   if (!file_exists($save_path)){
       if(!mkdir($save_path,0777,true)){
         $return_data['error'] = '上传文件保存目录创建失败，请检查权限!';
         $return_data['return'] = false;
         return $return_data;
     }
   }

   $new_filename = str_replace('.','',uniqid(mt_rand(10000,99999),true));
   if ($arr_filename['extension']!=''){
      $new_filename.=".{$arr_filename['extension']}";
   }

   $save_path = rtrim($save_path,'/').'/';
   if (!move_uploaded_file($_FILES[$key]['tmp_name'],$save_path.$new_filename)){
       $return_data['error'] = '临时文件移动失败，请检查权限!';
       $return_data['return'] = false;
       return $return_data;
   }

    $return_data['return'] = true;
    return $return_data;
}

function get_muliple($unit){
    switch ($unit){
        case 'K':
            $multipe = 1024;
            return $multipe;
            break;
        case 'M':
            $multipe = 1024*1024;
            return $multipe;
            break;
        case 'G':
            $multipe = 1024*1024*1024;
            return $multipe;
            break;
        default:
           return false;
        break;
    }
}

if (isset($_POST['submit'])){
   $upload = upload('upload/','2M','myfile');
  if (!$upload['return']){
    var_dump($upload['error']);
  }
}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title>上传页面</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="myfile" />

    <input type="submit" name="submit" value="开始上传" />
</form>
</body>
</html>