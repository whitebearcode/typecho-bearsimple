<?php 


$UpgradePassword= new Typecho_Widget_Helper_Form_Element_Text('UpgradePassword', null, '', '升级密钥', '请填入升级密钥,建议复杂点,在线升级时为保证安全，需要该密钥进行鉴权。');
    $UpgradePassword->setAttribute('class', 'bearui_content bearui_upgrade');
    $form->addInput($UpgradePassword);
    
    $UpgradePasswords = base64_encode($options->UpgradePassword);
    //$randkey = randomkeys(9);
    if (!empty($options->UpgradePassword)){
        $filedir = str_replace('core','',dirname(__FILE__));
        $file = $filedir.'/vendors/Upgrade/Upgrade'.$UpgradePasswords.'.Key';
        $files = $options->siteUrl.'/usr/themes/bearsimple/vendors/Upgrade/Upgrade.php';
        if(false!==fopen($file,'w+')){
            file_put_contents($file,$UpgradePasswords);
        }
$themeversion = themeVersion();
if($Versions['version'] > $themeversion){
$message = "<div id=\"upgrade\" class=\"ui error message\" style=\"display:none\">
  <div class=\"header\">
    检测到当前最新版本V{$Versions['version']}，您的版本为{$themeversion}，建议您立即完成升级！
  </div>
  <p>养成按时升级更新的好习惯是非常有必要的！</p>

  <div id=\"update-btn\" name=\"type\" class=\"ui negative basic button\"/>立即升级</div>

</div>
";
}
else if($Versions['version'] <= $themeversion){
$message = "<div id=\"upgrade\" class=\"ui positive message\" style=\"display:none\">
  <div class=\"header\">
    您当前为最新版本V{$themeversion}，不需要升级！
  </div>
  <p>有新版本就更新是一种好习惯，继续保持！</p>
</div>
";
}
else{
$message = "<div id=\"upgrade\" class=\"ui warning message\" style=\"display:none\">
  <div class=\"header\">
    您的版本为{$themeversion}，当前未检测到最新版本，请稍后再试！
  </div>
  <p>养成按时升级更新的好习惯是非常有必要的！</p>
</div>
";
}

$Htmls = <<<HTML
<link href="https://cdn.bootcdn.net/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.min.css" rel="stylesheet">
 <center><h2 class="ui icon header">
  <i class="blue cloud download icon"></i>
  <div class="content">
    在线升级
    <div class="sub header">您可以通过本功能将主题升级至最新版本</div>
  </div>
</h2>

	<input type="hidden" id='upgradekey' name="upgradekey" value="{$UpgradePasswords}" placeholder="Key" autocomplete="off" disabled>
	<input type="hidden" id='upgradeurl' name="upgradeurl" value="{$files}" placeholder="upgradeurl" autocomplete="off" disabled>
<div class="ui message">
  <div class="header">
    升级相关事项
  </div>
  <p>考虑到各种玄学因素，升级前务必先备份数据，切记！</p>
</div>
<div id="upgradeclick" class="medium ui button">
  检测新版本
</div>
    
    <div id="upgradecheck"  class="ui icon message" style="display:none">
  <i class="notched circle loading icon"></i>
  <div class="content">
    <div class="header">
      正在检测中，请稍等片刻
    </div>
    <p>我们将比对最新版本与您当前的版本.....</p>
  </div>
</div>

{$message}
  
</center>

<script src="https://cdn.bootcdn.net/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.min.js"></script>
 <script>

 document.getElementById("upgradeclick").onclick = function(){
    $("#upgradecheck").show();
    //3秒后隐藏
            setTimeout(function(){
            $("#upgradecheck").hide();
            $("#upgrade").show();
            },3000);
}

 $(".ui.negative.basic.button").on("click", function () {
  var upgradekey = document.getElementById("upgradekey").value;
  var upgradeurl = document.getElementById("upgradeurl").value;
  		sweetUpgrade(upgradekey,upgradeurl);
    })
    function sweetUpgrade(upgradekey,upgradeurl) {
      Swal.fire({
        icon: 'warning',
        type: 'warning', // 弹框类型
        title: '', //标题
        text: "再次确认，是否已完成备份？若确定请点击下方确定升级按钮", //显示内容
        confirmButtonColor: '#3085d6', // 确定按钮的 颜色
        confirmButtonText: '确定升级', // 确定按钮的 文字
        showCancelButton: true, // 是否显示取消按钮
        cancelButtonColor: '#d33', // 取消按钮的 颜色
        cancelButtonText: "我考虑考虑", // 取消按钮的 文字

        focusCancel: true, // 是否聚焦 取消按钮
        reverseButtons: true // 是否 反转 两个按钮的位置 默认是 左边 确定 右边 取消
      }).then((isConfirm) => {
        try {
          //判断 是否 点击的 确定按钮
          if (isConfirm.value) {
              Swal.fire("指令下达成功","正在升级中，请稍等片刻，升级过程中请勿刷新！","info");
            ajax({
			    type:"post",
			    url:upgradeurl,
			    data:{"upgradekey":upgradekey},
			    success:function(data){
			    	if(data.status==200 && data.code==1){
			    		Swal.fire("BearSimple主题升级成功！", data.message, "success").then((isConfirm) => window.location.reload());
			    	}
			    	else if(data.status==200 && data.code==2){
			    		Swal.fire("Sorry", data.message, "info").then((isConfirm) => window.location.reload());
			    	}else{
			    		Swal.fire("升级失败", data.message, "error");
			    	}
			
			    }
			})
          } else {
          }
        } catch (e) {
          alert(e);
        }
      });
    }
    
   function ajax(options){
	    //创建一个ajax对象
	    var xhr = new XMLHttpRequest() || new ActiveXObject("Microsoft,XMLHTTP");
	    //数据的处理 {a:1,b:2} a=1&b=2;
	    if(typeof(options.data)!='string'){
            var str = "";
            for(var key in options.data){
                str+="&"+key+"="+options.data[key];
            }
            str = str.slice(1)
        }else{
            var str = options.data;
        }
	    options.dataType=options.dataType||'json';
	    if(options.type == "get"){
	        var url = options.url+"?"+str;
	        xhr.open("get",url);
	        xhr.send();
	    }else if(options.type == "post"){
	        xhr.open("post",options.url);
	        xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	        xhr.send(str)
	    }
	    //监听
	    xhr.onreadystatechange = function(){
	        //当请求成功的时候
	        if(xhr.readyState == 4 && xhr.status == 200){
	            var d = xhr.responseText;
	            d = JSON.parse(d);
	            //将请求的数据传递给成功回调函数
	            options.success&&options.success(d,xhr.responseXML)
	        }else if(xhr.status != 200){
	            //当失败的时候将服务器的状态传递给失败的回调函数
	            options.error&&options.error(xhr.status);
	        }
	    }
	}
</script>
HTML;

    
	$layouts = new Typecho_Widget_Helper_Layout();
	$layouts->html(_t($Htmls));
	$layouts->setAttribute('class', 'bearui_content bearui_upgrade');
	$form->addItem($layouts);
}