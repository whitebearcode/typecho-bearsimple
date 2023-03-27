<?php
    /**
    * 友链[新]
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>

 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
                    <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                <h2><i class="jsfiddle icon"></i> <?php $this->title() ?></h2>  
<div class="ui secondary menu" id="uitab">
    <a class="active item" data-tab="first">友链列表</a>
  <a class="item" data-tab="second">友链说明</a>
                      <?php if(Bsoptions('FriendLinkSubmit') == true || Bsoptions('FriendLinkSubmit') == ''): ?><a class="item" data-tab="third">提交友链</a><?php endif; ?>
</div>
<div class="ui bottom attached active tab " data-tab="first">
  <div class="ui four doubling cards" style="word-break:break-all;">
      <?php foreach(get_friendlink() as $link): ?>
      <div class="card" hrefs="<?php echo $link['friendurl']; ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><div class="content"><div class="center aligned header"><?php echo $link['friendname']; ?></div><div class="center aligned description"><p><?php echo $link['frienddec']; ?></p></div></div><div class="extra content"><div class="center aligned author"><img class="ui avatar image <?php if(Bsoptions('Lazyload') == true): ?> lazyload bs-blur<?php endif; ?>" data-src="<?php echo $link['friendpic']; ?>" src="<?php echo $link['friendpic']; ?>"><?php echo $link['friendname']; ?></div></div></div>
      <?php endforeach; ?>
     </div>
</div>
<div class="ui bottom attached tab " data-tab="second">
  <?php echo reEmoPost(ShortCode($this->content,$this,$this->user->hasLogin(),$this->fields->ArticleType)); ?>
</div>

<div class="ui bottom attached tab " data-tab="third">



<form class="ui form" id="friendform">
  <div class="field">
    <label class="required">友链名称</label>
    <input type="text" id="friendname" name="friendname" placeholder="填写友链名称" required>
  </div>
  <div class="field">
    <label class="required">友链网址</label>
    <input type="text" id="friendurl" name="friendurl" placeholder="填写友链网址，包含http(s)://" required>
  </div>
  <?php if(Bsoptions('FriendLinkLogomust') == true):?>
  <div class="field">
    <label class="required">友链图标</label>
    <input type="text" id="friendpic" name="friendpic" placeholder="填写友链图标地址，包含http(s)://">
  </div>
  <?php else:?>
  <div class="field" style="display:none;">
    <label class="required">友链图标</label>
    <input type="text" id="friendpic" name="friendpic"  placeholder="填写友链图标地址，包含http(s)://" value="<?php if(empty(Bsoptions('FriendLinkLogoDefault'))):?><?php AssetsDir();?>assets/images/default-logo.png<?php else:?><?php echo Bsoptions('FriendLinkLogoDefault'); ?><?php endif; ?>" disabled="">
  </div>
  <?php endif; ?>
  <div class="field">
    <label class="required">友链描述</label>
    <input type="text" id="frienddec" name="frienddec" placeholder="填写友链描述" required>
  </div>
  <div class="field">
    <label id="contm"<?php if(Bsoptions('FriendLinkEmailmust') == true):?> class="required"<?endif; ?>>联系邮箱</label>
    <input type="text" id="contactmail" name="contactmail" placeholder="填写联系邮箱" <?php if(empty(Bsoptions('FriendLinkLogoDefault'))):?>required<?endif; ?>>
  </div>
  <div class="field">
  <label class="required">验证码</label>
   <div id="captcha">
    </div>
        <div class="field">
    <input style="width:200px" type="text" id="captcha_verify" name="captcha_verify" placeholder="输入验证码，区分大小写">
  </div>
  </div>
<div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
  <div class="ui button" id="friendbtn" onclick="getFormInfo();">提交</div>
</form>


</div>

<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<script>
$(function(){
    createCaptcha();
})
var code;
function createCaptcha() {
  document.getElementById('captcha').innerHTML = "";
  var charsArray =
  "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
  var lengthOtp = 6;
  var captcha = [];
  for (var i = 0; i < lengthOtp; i++) {
    //below code will not allow Repetition of Characters
    var index = Math.floor(Math.random() * charsArray.length + 1); //get the next character from the array
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
  //storing captcha so that can validate you can save it somewhere else according to your specific requirements
  code = captcha.join("");
  document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
}

//友链提交JS

function getElements(formId) {  
  var form = document.getElementById(formId);  
  var elements = new Array();  
  var tagElements = form.getElementsByTagName('input');  
  for (var j = 0; j < tagElements.length; j++){ 
     elements.push(tagElements[j]); 
 
  } 
  return elements;  
};  
 
function input(element) {  
  switch (element.type.toLowerCase()) {  
   case 'text':  
    return [element.name, element.value];  
  }  
  return false;  
};  

function serializeElement(element) {  
  var method = element.tagName.toLowerCase();  
  var parameter = input(element);  
  if (parameter) {  
   var key = encodeURIComponent(parameter[0]);  
   if (key.length == 0) return;  
   if (parameter[1].constructor != Array)  
    parameter[1] = [parameter[1]];  
   var values = parameter[1];  
   var results = [];  
   for (var i=0; i<values.length; i++) {  
    results.push(encodeURIComponent(values[i]));  
   }  
   return results.join('&');  
  }  
 };  
 
function serializeForm(formId) {  
  var elements = getElements(formId);  
  var queryComponents = new Array();  
  for (var i = 0; i < elements.length; i++) {  
   var queryComponent = serializeElement(elements[i]);  
   if (queryComponent)  
    queryComponents.push(queryComponent);  
  };
  
  return queryComponents.join('&'); 
};  

function getFormInfo(){ 
  var params = serializeForm('friendform');
  getData(filterXSS(params));
}; 
function getData(data) {
    let friendName = document.getElementById('friendname');
    let friendUrl = document.getElementById('friendurl');
    let friendPic = document.getElementById('friendpic');
    let friendDec = document.getElementById('frienddec');
    let contactMail = document.getElementById('contactmail');
    let captcha = document.getElementById('captcha_verify');
    let rejectWord = new RegExp("[`~!#$^*|{}';',\\[\\]<>《》~！#￥……*（）——|{}【】‘；：”“'。，、？ ]");
    let checkmail = /^[a-zA-Z0-9]+([-_.][A-Za-zd]+)*@([a-zA-Z0-9]+[-.])+[A-Za-zd]{2,5}$/;
    if($("#contm").hasClass('required')){
    if(contactMail.value == '' || rejectWord.test(contactMail.value) ||checkmail.test(contactMail.value) == false){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您的联系邮箱为空或者包含违规字符，也有可能是非邮箱正确格式哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }    
    };
    if(friendName.value == '' || rejectWord.test(friendName.value)){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您的友链名称为空或者包含违规字符哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }
    else if(friendUrl.value == '' || rejectWord.test(friendUrl.value)){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您的友链网址为空或者包含违规字符哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }
    else if(friendPic.value == '' || rejectWord.test(friendPic.value)){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您的友链LOGO图标地址为空或者包含违规字符哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }
    else if(friendDec.value == ''){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您的友链描述为空或者包含违规字符哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }
    else if(captcha.value == ''){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '验证码为空哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }
    else if(captcha.value !== code){
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
    $("#friendbtn").css("pointer-events","none").addClass('loading');
                    $.ajax({
                        type: "GET",
                        url: "<?php getFriendFile(); ?>",
                        data: {
                            "data": data
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                    $('body').toast({
							    title:'提交成功',
							    class: 'green',
							    message: '您的友链申请已提交成功，请等待博主审核～', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
										});
										window.location.reload();
                            
                        },
                        complete: function() {
//预留方法
                        },
                        error: function() {
                            alert("提交过程中出现错误，请稍后再试~~");
                        }
                    });
                };
 </script> 
</div>

</div>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>