<?php
/**
 * 
 * 用户中心暂未动工
 * 
**/
$options= Helper::options();
header("HTTP/1.1 200 OK");
    header('Access-Control-Allow-Origin:*');
    header("Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept");
 
echo '
<title>用户中心 - '.$options->title.'</title>
<link href="https://cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">


<div class="ui icon warning message">
  <i class="bolt loading icon"></i>
  <div class="content">
    <div class="header">
      很抱歉，暂时还没开放
    </div>
    <p>该页面正在施工中，请稍后查看~</p>
  </div>
</div>
';