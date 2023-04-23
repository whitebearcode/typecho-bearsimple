<?php
/**
 * 
 * 用户中心
 * 
**/
$options= Helper::options();
header("HTTP/1.1 200 OK");
    header('Access-Control-Allow-Origin:*');
    header("Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept");
 $this->need('modules/UserCenter/common/head.php');
  ?>
  <link href="https://jsd.typecho.co.uk/froala/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
 
  <?php if(Bsoptions('AdControl') == true) :?>
          <?php if(Bsoptions('AdControl3') == true && !empty(Bsoptions('AdControl3Src'))) :?>
<?php billboard(Bsoptions('AdControl3Src'),'other'); ?>
  <?php endif; ?><?php endif; ?>
<div class="pure-g" id="layout">
          <div class="pure-u-1 pure-u-md-4-4">
        
                <div class="content_container">
  <style>
      #submit-bar{
          z-index: 999;
      }
  </style>
                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var session_current = sessionStorage.getItem("bearui_config_current");
	    if(session_current == 'bearui_info'){
	    $("#submit-btn").show();
	    }
	    else{
	    $("#submit-btn").hide();
	    }
	    if(session_current == 'bearui_tougao'){
	    $("#submit-btn-tougao").show();
	    }
	    else{
	    $("#submit-btn-tougao").hide();  
	    }
	    if(session_current !== 'bearui_tougao' && session_current !== 'bearui_info'){
	        $("#submit-bar").hide();
	    }
	    else{
	       $("#submit-bar").show(); 
	    }
                    
$(document).on("click",".tabs li",function(){
	    var session_current = sessionStorage.getItem("bearui_config_current");
	    if(session_current == 'bearui_info'){
	    $("#submit-btn").show();
	    }
	    else{
	    $("#submit-btn").hide(); 
	    }
	    if(session_current == 'bearui_tougao'){
	    $("#submit-btn-tougao").show();
	    }
	    else{
	    $("#submit-btn-tougao").hide();  
	    }
	    if(session_current !== 'bearui_tougao' && session_current !== 'bearui_info'){
	        $("#submit-bar").hide();
	    }
	    else{
	       $("#submit-bar").show(); 
	    }

	});
});
	</script>
<div class="bearui_config">
        <div>
            <div class="bearui_config__aside">
                <div class="logo">用户中心</div>
                <ul class="tabs">
                    <li class="item" data-current="bearui_notice"><i class="thumbtack icon"></i>  用户首页</li>
                    <li class="item" data-current="bearui_info"><i class="file alternate outline icon"></i> 资料信息</li>
                    <?php if(($this->user->group !== 'subscriber' && $this->user->submission == '1' && Bsoptions('UserCenter_tougaoOpen') == true) || $this->user->group == 'administrator'):?>
                    <li class="item" data-current="bearui_tougao"><i class="pencil alternate icon"></i> 我要投稿</li>
                    <?php endif; ?>
                    <li class="item" data-current="bearui_gaojian" id="gaojian_list"><i class="edit icon"></i> 稿件列表</li>
                    <li class="item" data-current="bearui_tongzhi"><i class="bullhorn icon"></i> 我的通知</li>
                    <?php if($this->user->group == 'administrator' || $this->user->group == 'editor'):?> <li class="item"><div hrefs="<?php $this->options->adminUrl();?>" target="_blank"><i class="cog icon"></i> 管理后台</div></li><?php endif; ?>
                    <li class="item" id="signout"><i class="sign out alternate icon"></i> 退出登录</li>
                </ul>
            </div>
        </div>
        <div class="bearui_config__notice">
                     
<?php if(Bsoptions('UserCenter_tips') !== ''):?>
         <div class="ui large info message">
 <?php echo Bsoptions('UserCenter_tips'); ?>
</div>
<?php endif;?>
                       <div class="ui white message">
  <div class="header">
    欢迎来到 <?php $options->title();?> 用户中心
  </div>
  <ul class="list">
    <li>今天是<?php monweek(); ?></li>
    <li>您的投稿文章数:<?php echo allpostnum($this->user->uid); ?>篇</li>
    <li>您的<?php if(Bsoptions('UserCenter_coin_name') !== ''):?><?php echo Bsoptions('UserCenter_coin_name'); ?><?php else:?>积分<?php endif;?>:<?php echo $this->user->coins; ?><?php if(Bsoptions('UserCenter_coin_dw') !== ''):?><?php echo Bsoptions('UserCenter_coin_dw'); ?><?php endif;?></li>
    <li>您的等级:<?php if(user_tier($this->user->coins) == ''):?>暂无等级<?php else:?><?php echo user_tier($this->user->coins); ?><?php endif;?></li>
<?php if(Bsoptions('UserCenter_sign') == true):?><li>每日签到: <?php echo user_sign($this->user->uid); ?></li><?php endif;?>
    <li>继续加油吧~</li>
  </ul>
</div>




     
       </div>



    <div id="user-form">
<ul class="bearui_content bearui_info">
<li>
<label class="typecho-label">
账号</label>
<input id="Username" name="Username" type="text" class="text" value="<?php echo $this->user->name; ?>" disabled/>
<p class="description">
*账号不允许更改</p>
</li>
</ul>
<ul class="bearui_content bearui_info">
<li>
<label class="typecho-label">
昵称</label>
<input id="screenName" name="screenName" type="text" class="text" value="<?php echo $this->user->screenName; ?>" />
<p class="description">
*该项为必填项，请填入您的个性昵称</p>
</li>
</ul>
<ul class="bearui_content bearui_info">
<li>
<label class="typecho-label">
您的个人主页地址</label>
<input id="userurl" name="url" type="text" class="text" value="<?php echo $this->user->url; ?>" />
<p class="description">
*该项为必填项，请填入您的个人主页地址</p>
</li>
</ul>
<ul class="bearui_content bearui_info">
<li>
<label class="typecho-label">
您的邮箱地址</label>
<input id="usermail" name="mail" type="text" class="text" value="<?php echo $this->user->mail; ?>" />
<p class="description">
*该项为必填项，请填入您的邮箱地址</p>
</li>
</ul>

<ul class="bearui_content bearui_tougao">
    <li>
<label class="typecho-label">
投稿须知</label>
<p class="description">
<?php if(Bsoptions('UserCenter_tougaotips') == ''):?>投稿前请注意投稿内容不得出现违法内容以及违禁词，违者将封禁投稿权限<?php else:?><?php echo Bsoptions('UserCenter_tougaotips'); ?><?php endif; ?> </p>
</li> 
</ul>
<ul class="bearui_content bearui_tougao">
<li>
<label class="typecho-label">
投稿标题</label>
<input id="tougao_title" name="tougao_title" type="text" class="text" />
<p class="description">
*该项为必填项，请填入投稿标题</p>
</li>
</ul>

<ul class="bearui_content bearui_tougao">
<li>
<label class="typecho-label">
投稿栏目</label>
<select name="category" id="tougao_category">
    <?php if(Bsoptions('UserCenter_postcate')[0] !== ''):?>
    <?php foreach(Bsoptions('UserCenter_postcate') as $postcate):?>
<option value="<?php echo $postcate; ?>">
<?php echo getCategoryName($postcate); ?></option>
<?php endforeach; ?>
<?php endif;?>

</select>
<p class="description">
*该项为必选项，请根据您所投稿的内容选择要投稿的栏目</p>
</li>
</ul>
       
<ul class="bearui_content bearui_tougao">
    <li>
<label class="typecho-label" for="description-0-3">
投稿内容</label>
<textarea class="textarea" id="tougao_textarea"></textarea>
<p class="description">
*该项为必填项，请填入您的投稿内容</p>
</li> 
</ul>
<ul class="bearui_content bearui_tougao">
<li>
                            <label for="token-input-tags" class="typecho-label">标签[多个标签使用英文逗号隔开]</label>
                            <input id="tags" name="tags" type="text" placeholder="请输入标签名" class="text"/>
         </li>         
       </ul>          
<ul class="bearui_content bearui_tougao">
    <li>
<label class="typecho-label" for="description-0-3">
验证码</label>
<div id="captcha"></div>
<input type="text" class="text" id="captcha_verify"  placeholder="输入验证码，区分大小写">
<p class="description">
*请填入以上验证码，区分大小写</p>
</li> 
</ul>
<ul class="bearui_content bearui_tougao">

      <div class="required"><font color=red>*</font>若提交，则表示您已阅读本站投稿须知并严格遵守本站关于投稿的相关要求</div>

</ul>



<ul class="bearui_content bearui_gaojian">
     <div class="ui segment">
  <i class="exclamation circle icon"></i>
  审核通过的文章可以通过点击投稿标题进入文章页面噢~
</div>
<table class="ui striped table" style="word-break:break-all">
  <thead>
    <tr>
      <th>投稿标题</th>
      <th>投稿时间</th>
      <th>投稿栏目</th>
      <th>状态</th>
    </tr>
  </thead>
  <tbody id="postfl">
    
  </tbody>
</table>
    <div class="postpagelist"></div>
</ul>




<ul class="bearui_content bearui_tongzhi">
 
   <div class="ui secondary menu" id="uitab">
    <a class="active item" data-tab="first">个人通知</a>
  <a class="item" data-tab="second">系统通知</a>
</div>
<div class="ui bottom attached active tab " data-tab="first">
   <div class="ui accordion">
     <?php if(userNotify($this->user->uid) !== ''):?>
    <?php foreach(userNotify($this->user->uid) as $usertz):?>
 <div class="title">
    <i class="dropdown icon"></i>
    <?php echo $usertz['notifytitle'];?> - <?php  echo $usertz['notifytime'];?>
  </div>
  <div class="content">
    <p class="transition hidden"><?php echo $usertz['notifytext'];?></p>
  </div>
<?php endforeach; ?>
<?php endif; ?>
  

</div>

</div>

<div class="ui bottom attached tab " data-tab="second">
    
    
       <div class="ui accordion">
     <?php if(Bsoptions('UserCenter_tab')['UserCenter_tongzhi'][0] !== ''):?>
    <?php foreach(Bsoptions('UserCenter_tab')['UserCenter_tongzhi'] as $systemtz):?>
 <div class="title">
    <i class="dropdown icon"></i>
    <?php if($systemtz['UserCenter_tongzhi_title'] == ''):?>无<?php else:?><?php echo $systemtz['UserCenter_tongzhi_title'];?><?php endif; ?> - <?php $date = DateTime::createFromFormat('m/d/Y', $systemtz['UserCenter_tongzhi_date']); echo $date->format('Y年m月d日');?>
  </div>
  <div class="content">
 <p class="transition hidden"><?php if($systemtz['UserCenter_tongzhi_text'] == ''):?>暂无内容<?php else:?><?php echo $systemtz['UserCenter_tongzhi_text'];?><?php endif; ?></p>
  </div>
<?php endforeach; ?>
<?php endif; ?>
  
</div>
    
    
    
    </div>

    
</ul>
<ul class="typecho-option typecho-option-submit" id="submit-bar">
<li>
<div class="ui large button" id="submit-btn" style="display:none">
提交修改</div>
<div class="ui large button" id="submit-btn-tougao" style="display:none">
提交投稿</div>
</li>
</ul>




</div>





            </div>
      
    



        
        </div></div>
<script src="https://jsd.typecho.co.uk/froala/js/froala_editor.pkgd.min.js"></script>
<script src="https://jsd.typecho.co.uk/froala/js/languages/zh_cn.js"></script>
<script>

  $(document).ready(function() {
    


      

        const editor = new FroalaEditor('#tougao_textarea',
  {language: 'zh_cn',
  toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize',   'inlineStyle', 'paragraphStyle', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertTable',  'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
    pluginsEnabled: ['image', 'table', 'lists','charCounter','fullscreen','link','fontSize','quote','align'],
    linkConvertEmailAddress: false,
    linkInsertButtons: ['linkBack'],
    imageUpload:false,
  }
  );  
     
  
    getpostdata();
    //获取文章数据
var postpage = 1;
                var postn = 0;
                var postmax = 1;
function getpostdata(){
     $.ajax({
                        type: "POST",
                        url: '<?php getUserAction(); ?>',
                        data: {
                            "type": 'getallpost',
                            "page": postpage
                        },
                        dateType: "json",
                        success: function(data) {
                     
                            json = JSON.parse(data);
if(json.list == ''){
    postn = json.total;
                            postmax = json.max;
                                var strs = " ";
                                strs += '<tr></tr>';
                                $("#postfl").html(strs);
                            }
                            else{
                                postn = json.total;
                            postmax = json.max;
content2(json.list);
}

                        },
                        complete: function() {
                            pageList();
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                    function pageList() {
                    postpage = Math.min(postpage, postmax);
                    postpage = Math.max(postpage, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ postpage +">共" + postn + "条</a><a class=\"ui label\" data-page="+ postpage +">第" + postpage + "/" + postmax + "页</a>";
                    html += '<a class=\"ui label\"  data-page="1">首页</a>';
                    html += (postpage > 1) ? '<a class=\"ui label\"  data-page="' + (postpage - 1) + '">上一页</a>' : '<a class=\"ui label\"  data-page="1">上一页</a>';
                    html += (postpage < postmax) ? '<a class=\"ui label\"  data-page="' + (postpage + 1) + '">下一页</a>' : '<a class=\"ui label\"  data-page="' + postmax + '">下一页</a>';
                    html += '<a class=\"ui label\"  data-page="' + postmax + '">尾页</a><div class=\"ui mini input\"><input id=\"dipage\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" >跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        postpage = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipage").value;
                            switch(dipage){
                            case dipage < 1 :
                                postpage = 1;
                            break;
                            case dipage > postmax:
                                postpage = postmax;
                            break;
                            default:
                            postpage = dipage;
                        };
                        };
                        getpostdata();
                    });
                    
                    
                    $(".postpagelist").html($html);
                }
                
                
     function content2(lists) {
                    var str2 = " ";
                    for(var i in lists) {
str2 += '<tr><td>' + lists[i]['post_title'] + '</td><td>' + lists[i]['post_time'] + '</td><td>' + lists[i]['post_category'] + '</td><td>' + lists[i]['post_status'] + '</td></tr>';
$("#postfl").html(str2);
}
}
}



    createCaptcha();

var code;
var captcha = document.getElementById('captcha_verify');
function createCaptcha() {
  document.getElementById('captcha').innerHTML = "";
  var charsArray =
  "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
  var lengthOtp = 6;
  var captcha = [];
  for (var i = 0; i < lengthOtp; i++) {
    var index = Math.floor(Math.random() * charsArray.length + 1);
    if (captcha.indexOf(charsArray[index]) == -1)
    captcha.push(charsArray[index]);else
    i--;
  }
  var canv = document.createElement("canvas");
  canv.id = "captcha";
  canv.width = 100;
  canv.height = 50;
  var ctx = canv.getContext("2d");
  ctx.font = "25px Georgia";
  ctx.strokeText(captcha.join(""), 0, 30);
  code = captcha.join("");
  document.getElementById("captcha").appendChild(canv);
}
$(document).off('click','#submit-btn').on('click','#submit-btn',function(){
     $("#submit-btn").css("pointer-events","none").addClass('loading');
     $.ajax({
                        type: "POST",
                        url: window.location.href,
                        data: {
                            "action": 'editprofile',
                        },
                        dateType: "json",
                        success: function(url) {
                            $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            "screenName": $("#screenName").val(),
                            "url": $("#userurl").val(),
                            "mail": $("#usermail").val(),
                            "do": 'profile',
                        },
                        dateType: "json",
                        success: function(json) {
                            $('body').toast({
							    title:'个人资料修改成功',
							    class: 'success',
							    message: '您已成功修改，即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							setTimeout(function() {
            window.location.reload();
            },2000);
                        },
                        error: function() {
                            $('body').toast({
							    title:'个人资料修改成功',
							    class: 'success',
							    message: '您已成功修改，即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							setTimeout(function() {
            window.location.reload();
            },2000);
                        }
                    });
                          
                            
                    
                        }
     });
     
});

$(document).off('click','#signout').on('click','#signout',function(){
     $.ajax({
                        type: "POST",
                        url: window.location.href,
                        data: {
                            "action": 'signout',
                        },
                        dateType: "json",
                        success: function(url) {
                            $.ajax({
                        type: "GET",
                        url: url,
                        dateType: "json",
                        success: function(json) {
                            $('body').toast({
							    title:'您已退出登录',
							    class: 'success',
							    message: '您已退出登录，3秒后返回首页~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							setTimeout(function() {
            window.location = '<?php $this->options->siteUrl();?>';
            },2000);
                        },
                        error: function() {
                            $('body').toast({
							    title:'您已退出登录',
							    class: 'success',
							    message: '您已退出登录，3秒后返回首页~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							setTimeout(function() {
            window.location = '<?php $this->options->siteUrl();?>';
            },2000);
                        }
                    });
                          
                            
                    
                        }
     });
     
});

$(document).off('click','#submit-btn-tougao').on('click','#submit-btn-tougao',function(){
    if(!$("#tougao_title").val()){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '检测到投稿标题为空，请重新输入~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							return false;
    }
    if(!$("#tougao_category").find("option:selected").val()){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '检测到投稿栏目为空，请重新输入~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							return false;
    }
    if(!editor.html.get()){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '检测到投稿内容为空，请重新输入~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							return false;
    }
        if(captcha.value == ''){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '验证码为空哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }
    if(captcha.value !== code){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '验证码错误，请重新输入', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
										createCaptcha();
        return false;
    };
    $("#submit-btn-tougao").css("pointer-events","none").addClass('loading');
    $.ajax({
                        type: "POST",
                        url: window.location.href,
                        data: {
                            "action": 'tougao',
                        },
                        dateType: "json",
                        success: function(url) {
                            $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            "title": $("#tougao_title").val(),
                            "category": $("#tougao_category").find("option:selected").val(),
                            "created": '<?php echo time(); ?>',
                            'text': editor.html.get(),
                            'tags':filterXSS($("#tags").val()),
                            "do": 'publish',
                            "cid": '',
                            "allowComment":'1'
                            
                        },
                        dateType: "json",
                        success: function(json) {
                            $('body').toast({
							    title:'投稿成功',
							    class: 'success',
							    message: '您已成功投稿，即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							setTimeout(function() {
            window.location.reload();
            $('#gaojian_list').click();
            },2000);
            
                        },
                        error: function() {
                            $('body').toast({
							    title:'投稿成功',
							    class: 'success',
							    message: '您已成功投稿，即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							setTimeout(function() {
            window.location.reload();
            $('#gaojian_list').click();
            },2000);
                        }
                    });
                          
                            
                    
                        }
     });
     
});

$(document).off('click','#b-sign').on('click','#b-sign',function(){
   $("#b-sign").css("pointer-events","none").addClass('loading'); 
   
   $.ajax({
                        type: "GET",
                        url: '<?php getSign(); ?>',
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            if(json.code == 1){
                                var signcoin = '';
                         if(json.signcoin){
                             signcoin = ',获得'+json.signcoin+'<?php if(Bsoptions('UserCenter_coin_dw') !== ''):?><?php echo Bsoptions('UserCenter_coin_dw'); ?><?php endif;?><?php if(Bsoptions('UserCenter_coin_name') !== ''):?><?php echo Bsoptions('UserCenter_coin_name'); ?><?php else:?>积分<?php endif;?>'
                         }
                         else{
                             signcoin = '';
                         }
                              $('body').toast({
							    title:'签到成功',
							    class: 'success',
							    position:'centered',
						        message: '您已成功签到'+signcoin+',即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});  
                                	setTimeout(function() {
            window.location.reload();
            },2000);
                            }
                            else{
                              $('body').toast({
							    title:'签到失败',
							    class: 'warning',
							    position:'centered',
							    message: '啊哦，似乎网络出现了什么问题，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});  
                            }
                    
                        },
                        error: function() {
                            $('body').toast({
							    title:'签到失败',
							    class: 'warning',
							    position:'centered',
							    message: '啊哦，似乎网络出现了什么问题，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							
                        }
     });
   
});
});
</script>

<?php $this->need('compoment/foot.php'); ?>
