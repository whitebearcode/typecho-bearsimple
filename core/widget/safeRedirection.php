<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    $refer = str_replace($removeChar, "", $_SERVER['HTTP_REFERER']);
     echo <<<EOF
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no, viewport-fit=cover" />
<title>{$options->title} 免责声明</title>
<style>
body {
	background-color:#fafcfa;
	padding:0;
	margin:0;
	color:#333;
	font-size:16px;
}
.wrapper {
	margin:0 auto;
	margin-top:100px;
	display: flex;
  justify-content: center;
  align-items: center;
}
.main {
	background-color:#fff;
	padding:40px;
	padding-bottom:25px;
    border-radius: 5px;
	box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 1);
	-moz-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 1);
	-webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 1);
}
.logo {
	text-align:center;
  	margin-bottom: 20px;
}
.title {
	text-align:center;
	font-size:26px;
	color:#2a8c2a;
}
.content {
	border-top:1px solid #ddd;
	margin-top: 20px;
	padding: 25px 20px;
}
.footer {
	border-top:1px solid #ddd;
	padding-top:20px;
	font-size:14px;
	text-align: center;
	color: #999;
}
a, a:hover, a:active {color:#999; text-decoration:none;}
  
.content p{line-height: 30px;}
.content a, .content a:hover, .content a:active {color: #00e;}
</style>
</head>

<body>
	<div class="wrapper">
		<div class="main">
          	<div class="logo"><h1>{$options->title}</h1></div>
			<div class="title">免责声明</div>
			<div class="content">
              <p>您从 <b>{$refer}</b> 进入本站，<b>{$refer}</b> 网站的内容与本站无关。</p>
			</div>
			<div class="footer">
				<a href="{$_SERVER['REQUEST_URI']}" style="display: inline-block;background: #155bd5;color: #fff;height: 44px;line-height: 44px;font-size: 14px;padding: 0 30px;border-radius: 30px;">点击继续访问我们的网站</a>
			</div>
		</div>
	</div>
</body>
</html>
EOF;

           