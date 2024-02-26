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
  <link rel="stylesheet" href="https://staticfile.typecho.co.uk/fancybox/fancybox.min.css">
  <link href="https://staticfile.typecho.co.uk/froala/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
 <?php if(Bsoptions('Emoji') == true) :?>
  <link href="<?php AssetsDir();?>assets/vendors/bs-emoji/bs-emoji.css" rel="stylesheet" type="text/css">
  <?php endif; ?>
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
	    if(session_current == 'bearui_says'){
	    $("#submit-btn-says").show();
	    }
	    else{
	    $("#submit-btn-says").hide();  
	    }
	    if(session_current !== 'bearui_tougao' && session_current !== 'bearui_info'&& session_current !== 'bearui_says'){
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
	    if(session_current == 'bearui_says'){
	    $("#submit-btn-says").show();
	    }
	    else{
	    $("#submit-btn-says").hide();  
	    }
	    if(session_current !== 'bearui_tougao' && session_current !== 'bearui_info'&& session_current !== 'bearui_says'){
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
                    <li class="item" data-current="bearui_says"><i class="heart icon"></i> 我的动态</li>
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
    <li>您的个人主页:<a href="<?php echo Helper::options()->siteUrl().'index.php/author/'.$this->user->uid; ?>" target="_blank">戳这里</a></li>
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
<ul class="bearui_content bearui_info">
<li>
<label class="typecho-label">
您的个性签名</label>
<input id="usersignature" name="signature" type="text" class="text" value="<?php if($this->user->person_Signature == 0):?>这个人太懒了，没有留下个性签名<?php else:?><?php echo $this->user->person_Signature; ?><?php endif; ?>" />
<p class="description">
请填入您的个性签名</p>
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


<ul class="bearui_content bearui_says">
<li>
<label class="typecho-label">
今天发点什么动态？</label>

<form class="ui form" id="saysform">
  <div class="field">
      <div class="ui mini basic icon button" id="editing" style="float:left;display:none"><i class="edit icon"></i></div>
      <div class="ui mini basic icon buttons" style="float:right">
  <div class="ui button" id="insertimg"><i class="image icon" data-content="插入图片短代码"></i></div>
  <div class="ui button" id="insertmark"><i class="bookmark icon" data-content="插入文字标记短代码"></i></div>
    <div class="ui button" id="insertruby"><i class="language icon" data-content="插入文字注音短代码"></i></div>
</div>
      <textarea rows="5" cols="30" name="saystext" id="saystext" placeholder="写一写你的最近动态~"<?php if(Bsoptions('Emoji') == true) :?> class="emotion"<?php endif; ?> required ></textarea>
    
<?php if(Bsoptions('Emoji') == true) :?>
    <div class="circular ui icon button" id="facesays">

  <i class="smile beam outline icon"></i>
 </div>
 <div class="emoemo" class="notranslate" style="margin-top:-30px;margin-bottom:10px"></div>
 <?php endif; ?>
 <input type="text" name="sid" id="edit-sid" value=""  class="hidden">
 <input type="text" name="type" value="submitsays" class="hidden">
<div class="ui segment">
    <div class="field">
      <div class="ui toggle checkbox">
        <input type="checkbox" name="saysprivate"  class="hidden">
        <label>该动态仅自己可见</label>
      </div>
    </div>
  </div>
  
  </div>
</form>
<p class="description">
*发表您的每日动态，记录美好生活</p>
</li>
</ul>
<ul class="bearui_content bearui_says">
<li>
<label class="typecho-label">
动态列表</label>


<div class="comments-container">
	

		<ul id="comments-list" class="comments-list">
			<div id="saysfl">
			
		</div>
<div class="sayspagelist"></div>
		</ul>
</div>


</li>
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
<div class="ui large button" id="submit-btn-says" style="display:none">
发布动态</div>
</li>
</ul>




</div>





            </div>
      
    



        
        </div></div>
<script src="https://staticfile.typecho.co.uk/froala/js/froala_editor.pkgd.min.js"></script>
<script src="https://staticfile.typecho.co.uk/froala/js/languages/zh_cn.js"></script>
<script>

  $(document).ready(function() {
    
$.getScript('https://staticfile.typecho.co.uk/fancybox/fancybox.umd.min.js',function(){
  Fancybox.bind('[data-fancybox="single"]', {
      groupAttr: false,
});
  Fancybox.bind('[data-fancybox="gallery"]', {
});
});
$('#insertimg').on('click',function(){
insert('[bsimg]图片直链，带http(s)://[/bsimg]\n');
});
$('#insertmark').on('click',function(){
insert('[bsmark]要标注的文字[/bsmark]\n');
});
$('#insertruby').on('click',function(){
insert('[bsruby]要注音的文字[/bsruby]\n');
});
function insert(tag) {
					var myField;
					if (document.getElementById('saystext') && document.getElementById('saystext').type == 'textarea') {
						myField = document.getElementById('saystext');
					} else {
						return false;
					};
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					};
					if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					};
				};

      

        const editor = new FroalaEditor('#tougao_textarea',
  {language: 'zh_cn',
  toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  'fontFamily', 'fontSize',   'inlineStyle', 'paragraphStyle', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertTable',  'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'selectAll'],
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
                        async:true,
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
                            if(dipage > postmax){
                              postpage = postmax;
                            }
                            else if(dipage < 1){
                               postpage = 1; 
                            }
                            else{
                              postpage = dipage;  
                            }
                            
                           
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
                        async:true,
                        url: window.location.href,
                        data: {
                            "action": 'editprofile',
                        },
                        dateType: "json",
                        success: function(url) {
                            $.ajax({
                        type: "POST",
                        async:true,
                        url: url,
                        data: {
                            "screenName": $("#screenName").val(),
                            "url": $("#userurl").val(),
                            "mail": $("#usermail").val(),
                            "do": 'profile',
                        },
                        dateType: "json",
                        success: function(json) {
                            $.post('<?php getUserAction(); ?>',{type:'editUserSignature',person_Signature:$("#usersignature").val()});
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
                        async:true,
                        url: window.location.href,
                        data: {
                            "action": 'signout',
                        },
                        dateType: "json",
                        success: function(url) {
                            $.ajax({
                        type: "GET",
                        async:true,
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
                        async:true,
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
                        async:true,
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
							    message: '啊哦，似乎网络出现了什么问题，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							
                        }
     });
   
});


$(document).off('click','#submit-btn-says').on('click','#submit-btn-says',function(){
        if(!$('#saystext').val()){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '检测到发表的动态内容为空，请重新输入~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							return false;
    }
   $("#submit-btn-says").css("pointer-events","none").addClass('loading'); 
   
   $.ajax({
                        type: "POST",
                        async:true,
                        url: '<?php getUserAction();?>',
                        dateType: "json",
                        data: 
                        $("#saysform").serialize()
                        ,
                        success: function(json) {
                            json = JSON.parse(json);
                            if(json.code== 1 && json.sid == ''){
                              $('body').toast({
							    title:'动态发表成功',
							    class: 'success',
						        message: '您已成功发表动态,即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});  
                                	setTimeout(function() {
            window.location.reload();
            },2000);
                            }
                            else if(json.code== 1 && json.sid){
                              $('body').toast({
							    title:'动态修改成功',
							    class: 'success',
						        message: '您已成功修改动态,即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});  
                                	setTimeout(function() {
            window.location.reload();
            },2000);
                            }
                            else{
                              $('body').toast({
							    title:'提交失败',
							    class: 'warning',
							    message: '啊哦，似乎网络出现了什么问题，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});  
                            }
                    
                        },
                        error: function() {
                            $('body').toast({
							    title:'提交失败',
							    class: 'warning',
							    message: '啊哦，似乎网络出现了什么问题，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							
                        }
     });
   
});






//获取动态数据
  getsaysdata();
var sayspage = 1;
                var saysn = 0;
                var saysmax = 1;
function getsaysdata(){
     $.ajax({
                        type: "POST",
                        async:true,
                        url: '<?php getUserAction(); ?>',
                        data: {
                            "type": 'getsays',
                            "page": sayspage,
                            'index':'2'
                        },
                        dateType: "json",
                        success: function(data) {
                     
                            json = JSON.parse(data);
if(json.list == ''){
    saysn = json.total;
                            saysmax = json.max;
                                var strs = " ";
                                strs += '<article class="post"><center><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="1.128" y1="0.988" x2="0.364" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="c" x1="1" y1="0.5" x2="0.112" y2="1.125" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#747f95"/></linearGradient></defs><g transform="translate(-135 -375)"><circle cx="184" cy="184" r="184" transform="translate(191 443)" fill="#f3f3fa"/><path d="M2925,350h0c-8.837,0-16-32.235-16-72s7.163-72,16-72c.038,0,11.813.471,18.75-7.529s9-14.486,9-24.469c0-34.257,14.681-58.6,28.25-63.313,3.909-.688,10,.818,16-4.354s8-9.372,8-16.333c0-37.555,12.536-68,28-68s28,30.445,28,68c0,6.961-.667,10.328,5.333,15.5s14.76,4.5,18.667,5.187c13.569,4.714,24,33.055,24,67.312a101.212,101.212,0,0,0,2.333,20s4.485,11.842,11,5.5,9.13-14.885,10.25-22.871C3135.767,157.923,3142.61,142,3149,142c6.519,0,12.127,16.566,14.645,40.566.741,7.066,2.2,11.743,6.521,17.6A14.3,14.3,0,0,0,3180.92,206H3181c6.488,0,12.073,16.409,14.617,40.308.5,4.725.982,7.6,5.3,11.527S3212.884,262,3212.884,262l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573C3227.336,294.758,3229,311.835,3229,330c0,6.817-.237,13.546-.7,20H2925Zm303.3,0h0Z" transform="translate(-2718 397)" fill="url(#a)"/><path d="M117,208H.7c-.466-6.453-.7-13.181-.7-20,0-18.163,1.664-35.24,4.686-48.083a58.6,58.6,0,0,1,5.086-14.573C11.745,121.8,13.84,120,16,120l.116,0s7.651-.242,11.967-4.166,4.8-6.8,5.3-11.527C35.927,80.408,41.513,64,48,64a16.6,16.6,0,0,0,3.3-1.014A6.153,6.153,0,0,0,53.365,61.5c6.515-6.342,9.13-14.884,10.25-22.871C66.8,15.924,73.642,0,80.032,0,86.55,0,92.158,16.566,94.676,40.567c.742,7.065,2.2,11.742,6.521,17.6A14.3,14.3,0,0,0,111.951,64h.081c6.487,0,12.073,16.409,14.617,40.307.5,4.725.983,7.6,5.3,11.527S143.915,120,143.915,120l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573c3.022,12.844,4.686,29.921,4.686,48.083,0,6.818-.237,13.546-.7,20H117Zm42.328,0h0ZM.7,208h0Z" transform="translate(350.969 539)" fill="url(#a)"/><path d="M2989,62c-10.838-4.087-16.3,0-32,0-26.51,0-48-8.954-48-20s21.49-20,48-20h256a16,16,0,1,1,0,32s-15.5,0-27.5,3S3165,68.714,3165,68.714,3127.392,110,3081,110c-38.041,0-70.176-13.246-80.647-31.653C2998.219,74.6,2999.838,66.087,2989,62Z" transform="translate(-2702 701)" fill="#d1d6e2"/><path d="M-2493,98s-56.355,45.651-64,16,74.25-17.75-16,72" transform="translate(3044 409)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2" stroke-dasharray="10"/><path d="M4,2.2C7.15-.75,16,0,16,0s-1.5,4-2.6,8-.232,5.942-1.8,8C7.6,21.25,0,21,0,21s.75-3.4,2-8S.85,5.15,4,2.2Z" transform="translate(447 603.085)" fill="#909aa9"/><ellipse cx="10" cy="4" rx="10" ry="4" transform="translate(294 787)" fill="url(#c)"/><path d="M8.44,24s8.115-6,6.94-10S11.51,9.625,9.775,6.125A11.222,11.222,0,0,1,8.44,0S1.767,2.625,1.5,9.375C1.38,12.419,4.436,14.344,6.171,18A32.451,32.451,0,0,1,8.44,24Z" transform="translate(287 794.497) rotate(-90)" fill="#909aa9"/><path d="M0,0,57,4.5,136,0l31.5,12,17,10-37,8.5-24.5-5-58,5L4,23Z" transform="translate(191 699)" fill="#fff"/><path d="M-1.4,1.2,60,9l58.75-5.25L143,9l36-9V24.5L144.4,29l-16.2-7.25L95.6,23l-5.1,1.5L67.2,21.75,5,23.25S2.8,16.713,1.2,11.2-1.4,1.2-1.4,1.2Z" transform="translate(196 720)" fill="#eceff5"/><path d="M0,9.833l18-9.5,2.667,4v8.2L13,18,8.167,12.532,0,13.671Z" transform="translate(377 777)" fill="#eceff5"/><path d="M4,3.167,18,0V10l-5,3.167-4.833-4L0,10Z" transform="translate(377 777)" fill="#fff"/><path d="M-.211,18.893,16,12l.246,14.107-2.084,4.646L0,31Z" transform="matrix(1, 0.017, -0.017, 1, 400.376, 734.864)" fill="#eceff5"/><path d="M9.75,12H16l-3.75,7H0Z" transform="translate(400 735)" fill="#fff"/><g transform="translate(447 690)"><path d="M97,0,63.923,4.5,24.316,0,8.523,12,0,22l18.55,8.5,12.283-5,29.079,5,23.488-5,6.467-12.126Z" transform="translate(-1 12)" fill="#fff"/><path d="M81.149.607l-28.1,3.945L26.17,1.9l-11.1,2.655L-2.651-1.333V12.391l17.083,2.276L21.846,11l14.917.632,2.334.759L49.759,11l28.991,1.391s-1.4-1.778,0-4.724A43.992,43.992,0,0,0,81.149.607Z" transform="translate(1.651 35.333)" fill="#eceff5"/></g></g></svg><h2>这里暂时没有动态~</h2></center></article>';
                                $("#saysfl").html(strs);
                                
                            }
                            else{
                                saysn = json.total;
                            saysmax = json.max;
content2(json.list);
pageList();
}

                        },
                        complete: function() {
                            <?php if(Bsoptions('Lazyload') == true) :?>
                           lazyLoad();
                           <?php endif; ?>
                            
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                     function pageList() {
                    sayspage = Math.min(sayspage, saysmax);
                    sayspage = Math.max(sayspage, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ sayspage +">共" + saysn + "条</a><a class=\"ui label\" data-page="+ sayspage +">第" + sayspage + "/" + saysmax + "页</a>";
                    html += '<a class=\"ui label\"  data-page="1">首页</a>';
                    html += (sayspage > 1) ? '<a class=\"ui label\"  data-page="' + (sayspage - 1) + '">上一页</a>' : '<a class=\"ui label\"  data-page="1">上一页</a>';
                    html += (sayspage < saysmax) ? '<a class=\"ui label\"  data-page="' + (sayspage + 1) + '">下一页</a>' : '<a class=\"ui label\"  data-page="' + saysmax + '">下一页</a>';
                    html += '<a class=\"ui label\"  data-page="' + saysmax + '">尾页</a><div class=\"ui mini input\"><input id=\"dipagex\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" >跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        sayspage = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipagex").value;
                            if(dipage > saysmax){
                              sayspage = saysmax;
                            }
                            else if(dipage < 1){
                               sayspage = 1; 
                            }
                            else{
                              sayspage = dipage;  
                            }

                        };
                        
                        getsaysdata();
                    });
                    
                    
                    $(".sayspagelist").html($html);
                }

                
     function content2(lists) {
                    var str2 = " ";
                    var privatesays = " ";
                    for(var i in lists) {
                        if(lists[i]['saysprivate'] == 'on'){
                          privatesays = '不公开';  
                        }
                        else{
                          privatesays = '';    
                        }
str2 += '<li><div class="comment-main-level"><div class="comment-avatar"><img <?php if(Bsoptions('Lazyload') == true): ?>class="lazy"<?php endif; ?> <?php if(Bsoptions('Lazyload') == true): ?> data-<?php endif; ?>src="<?php echo imgravatarq(getAuthorInfo($this->user->uid,'mail')); ?>"></div><div class="comment-box"><div class="comment-head"><h6 class="comment-name by-author"><?php echo getAuthorInfo($this->user->uid,'screenName'); ?></h6> <span>' + lists[i]['saystime'] + '</span> <span style="float:right">'+ privatesays +'</span><i class="thumbs up red icon"></i><spanx class="clikenum">' + lists[i]['sayslike'] + '</spanx></div><div class="comment-content">' + lists[i]['saystext'] + '</div><div style="display:none" id="edit-' + lists[i]['saysid']+'">' + lists[i]['saystext_sim'] + '</div></div></div><span class="ui small icon red basic label delete" style="float:right;margin-top:15px" data-sid="' + lists[i]['saysid'] + '"><i class="times icon"></i> 删除</span><span class="ui small icon blue basic label edit" style="float:right;margin-top:15px;margin-right:10px" data-sid="' + lists[i]['saysid'] + '" data-time="' + lists[i]['saystime'] + '" data-private="'+ lists[i]['saysprivate'] +'"><i class="edit icon"></i> 修改</span><span class="ui small icon blue basic label" id="editcancel-' + lists[i]['saysid'] + '" style="float:right;margin-top:15px;margin-right:10px;display:none" data-sid="' + lists[i]['saysid'] + '"><i class="edit icon"></i> 取消修改</span></li>';
$("#saysfl").html(str2);
}
}
}
$(document).off('click','.ui.small.icon.red.basic.label.delete').on('click','.ui.small.icon.red.basic.label.delete',function(){
   $.ajax({
                        type: "POST",
                        async:true,
                        url: '<?php getUserAction();?>',
                        dateType: "json",
                        data: {
                        "type":'deletesays',
                        "saysid":$(this).attr('data-sid')
                        }
                        ,
                        success: function(data) {
                            if(data== 1){
                              $('body').toast({
							    title:'动态删除成功',
							    class: 'success',
						        message: '您已成功删除动态~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});  
                                getsaysdata();
                            }
                            else{
                              $('body').toast({
							    title:'动态删除失败',
							    class: 'warning',
							    message: '啊哦，似乎网络出现了什么问题，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});  
                            }
                    
                        },
                        error: function() {
                            $('body').toast({
							    title:'动态删除失败',
							    class: 'warning',
							    message: '啊哦，似乎网络出现了什么问题，请稍后再试~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							
                        }
     });
     
});


$(document).off('click','.ui.small.icon.blue.basic.label.edit').on('click','.ui.small.icon.blue.basic.label.edit',function(){
   const _parent = $('.ui.small.icon.blue.basic.label.edit');
   $('textarea[name=saystext]').val($.trim($("#edit-"+$(this).attr('data-sid')).text())).focus();
   if($(this).attr('data-private') == 'on'){
   $('input:checkbox').eq(1).prop("checked",true); 
   }
   $('#editing').html('正在修改 '+$(this).attr('data-time')+' 发布的动态').show();
   $('#submit-btn-says').text('修改动态');
   $('.ui.small.icon.blue.basic.label.edit').not(this).css("pointer-events","none");
   $(this).hide();
    if($(this).css('display')=='none'){
	 $('#editcancel-'+$(this).attr('data-sid')).fadeIn();
}
$('#edit-sid').val($(this).attr('data-sid'));

$(document).on('click','#editcancel-'+$(this).attr('data-sid'),function(){
     _parent.show();
    $('#submit-btn-says').text('发布动态');
    $('#editcancel-'+$(this).attr('data-sid')).hide();
    $('.ui.small.icon.blue.basic.label.edit').not(this).css("pointer-events","auto");
    $('#editing').hide();
    $("textarea[name=saystext]").val('');
    $('input:checkbox').eq(1).prop("checked",false); 
    $('#edit-sid').val('');
});

});

});
</script>

<?php $this->need('compoment/foot.php'); ?>
