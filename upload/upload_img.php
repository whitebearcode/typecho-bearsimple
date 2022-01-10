<?php
//BearSimple For Typecho
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods:post');
    date_default_timezone_set('PRC');
    
Typecho_Widget::widget('Widget_User')->to($user);
if($user->hasLogin()){
$dir = dirname(__FILE__).'/images/';
$arr = array(
'code' => 0,
'msg'=> '',
'data' =>array(
     'src' => $dir . $_FILES["file"]["name"]
     ),
);
if(!preg_match('/\.(jpg|png|gif|svg|ico|jpeg)/i',$_FILES["file"]["name"])){
    $arr['msg'] ='后缀不允许';
    unset($arr['data']);
    exit(json_encode($arr));
}
$file_info = $_FILES['file'];
 $file_error = $file_info['error'];
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}
else{
    chmod($dir,0755);
}
$file = $dir.$_FILES["file"]["name"];
if (!file_exists($file)) {
    if ($file_error == 0) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $dir. $_FILES["file"]["name"])) {
            $arr['code'] ="1";
            $arr['url'] =$_POST['domain'] . $_FILES["file"]["name"];
            $arr['msg'] ="上传成功";
        } else {
            $arr['msg'] = "上传失败";
        }
    } else {
        switch ($file_error) {
            case 1:
           $arr['msg'] ='上传文件超过了PHP配置文件中upload_max_filesize选项的值';
                break;
            case 2:
              $arr['msg'] ='超过了表单max_file_size限制的大小';
             break;
            case 3:
               $arr['msg'] ='文件部分被上传';
                break;
            case 4:
              $arr['msg'] ='没有选择上传文件';
                break;
            case 6:
                $arr['msg'] ='没有找到临时文件';
                break;
            case 7:
            case 8:
               $arr['msg'] = '系统错误';
                break;
        }
    }
} else {
    $arr['code'] ="1";
    $arr['url'] =$_POST['domain'] . $_FILES["file"]["name"];
    $arr['msg'] = $_FILES["file"]["name"];
}
}
else{
    $arr['code'] ="2";
    $arr['msg'] = "Not authorized.";
}
  exit(json_encode($arr));