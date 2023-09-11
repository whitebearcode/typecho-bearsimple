<?php
    /**
    * 友链[新]
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>
<?php if(Bsoptions('FriendLinkSkin') == '1'): ?>
<link rel="stylesheet" type="text/css" href="<?php AssetsDir();?>assets/css/modules/friendlink_custom.css?v=<?php echo themeVersion(); ?>">
<?php endif; ?>
 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
                    <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                <h2><i class="jsfiddle icon"></i> <?php $this->title() ?></h2>  
<div class="ui secondary pointing menu" id="uitab">
    <a class="active item" data-tab="first"><i class="list icon"></i>友链列表</a>
  <a class="item" data-tab="second"><i class="bullhorn icon"></i>友链说明</a>
                      <?php if(Bsoptions('FriendLinkSubmit') == true || Bsoptions('FriendLinkSubmit') == ''): ?><a class="item" data-tab="third"><i class="hand holding heart icon"></i>提交友链</a><?php endif; ?>
</div>
<div class="ui bottom attached active tab " data-tab="first">
    


<?php if(Bsoptions('FriendLinkSkin') == '1'): ?>
<div class="page friend">
				<ul class="friend-ul grid w-full grid-cols-3 gap-4 sm:grid-cols-4 xl:grid-cols-5">
				     <?php foreach(get_friendlink() as $link): ?>
					<li class="relative inline-block transform overflow-hidden text-center duration-300 hover:-translate-y-1">
						<a href="<?php echo $link['friendurl']; ?>" class="block h-full w-full py-4"
						   <?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?> rel="noopener noreferrer"><?php echo $link['friendname']; ?></a>
						<img class="friend-img absolute right-0 top-0 h-full transform rounded-full duration-300 <?php if(Bsoptions('Lazyload') == true): ?> lazy<?php endif; ?>"
							 <?php if(Bsoptions('Lazyload') == true): ?> data-<?php endif; ?>src="<?php echo $link['friendpic']; ?>" alt="<?php echo $link['friendname']; ?>" />
					</li>
					<?php endforeach; ?>
				
				
				</ul>
</div>
<?php endif;?>
<?php if(Bsoptions('FriendLinkSkin') == '0' || Bsoptions('FriendLinkSkin') == ''): ?>
  <div class="ui four doubling cards" style="word-break:break-all;">
      <?php foreach(get_friendlink() as $link): ?>
      <div class="card" hrefs="<?php echo $link['friendurl']; ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><div class="content"><div class="center aligned header"><?php echo $link['friendname']; ?></div><div class="center aligned description"><p><?php echo $link['frienddec']; ?></p></div></div><div class="extra content"><div class="center aligned author"><img class="ui avatar image <?php if(Bsoptions('Lazyload') == true): ?> lazy<?php endif; ?>" <?php if(Bsoptions('Lazyload') == true): ?> data-<?php endif; ?>src="<?php echo $link['friendpic']; ?>"><?php echo $link['friendname']; ?></div></div></div>
      <?php endforeach; ?>
     </div>
     <?php endif;?>
     
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
    <label class="required">您站点的友链放置页面网址</label>
    <input type="text" id="friendcheckurl" name="checkurl" placeholder="填写您站点的友链放置页面网址" required>
  </div>


<?php switch(Bsoptions('VerifyChoose')) :?>
<?php case '1' :?>
             <?php \BsCore\Plugin::spam_protection_mathjia();?>
            <div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
   <div class="ui button" id="friendbtn" >提交</div>
             <?php break; ?>
             <?php case '11' :?>
             <?php \BsCore\Plugin::spam_protection_mathjian();?>
             <div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
<div class="ui button" id="friendbtn" >提交</div>
             <?php break; ?>
              <?php case '22-2' :?>
             <?php \BsCore\Plugin::spam_protection_question();?>
            <div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
<div class="ui button" id="friendbtn">提交</div>
             <?php break; ?>
             <?php case '2' :?>
          
             
             <?php $this->need('modules/Verify/BearCaptcha/Vaptcha/Vaptcha_Link.php'); ?>
    <div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
<div class="ui button" id="friendbtn"  style="pointer-events:none">提交</div>
             <?php break; ?>
             <?php case '2-1' :?>
       
             <?php $this->need('modules/Verify/BearCaptcha/Dingxiang/DX_Captcha_Link.php'); ?>
             <div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
<div class="ui button" id="friendbtn"  style="pointer-events:none">提交</div>
             <?php break; ?>
             <?php case '2-2' :?>
            
             <?php $this->need('modules/Verify/BearCaptcha/Turnstile/Turnstile_Link.php'); ?>
             <div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
<div class="ui button" id="friendbtn"  style="pointer-events:none">提交</div>
             <?php break; ?>
              <?php case '2-3' :?>
          
             <?php $this->need('modules/Verify/BearCaptcha/Geetest/Geetest_Link.php'); ?>
             <div class="field">
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
	<div class="ui button" id="friendbtn"  style="pointer-events:none">提交</div>
             <?php break; ?>
             <?php case '22' :?>
          
             <p>
             <span class="ui button" id="bsverify" onclick="verify();" style="float:left;" disabled><i class="cloudversify icon"></i><?php if(empty(Bsoptions('Verify22_Buttontext'))){echo '人机验证';}else{
			echo Bsoptions('Verify22_Buttontext');}
			  ?></span>
			  <div class="field"><div style="height:5px"></div>
      <label class="required">若提交，则表示您已阅读本站友链相关说明并严格遵守本站关于友链的相关要求</label>
</div>
			  <div class="ui button" id="friendbtn"  style="pointer-events:none">提交</div>

</p>
<?php $this->need('modules/Verify/BearCaptcha/Captcha/Captcha_Link.php'); ?>
             <?php break; ?>
     <?php case '3' || '' :?>
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
         <div class="ui button" id="friendbtn">提交</div>
             <?php break; ?>
 <?php endswitch; ?>
  
</form>


</div>

<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<script>
$(function(){
    <?php if(Bsoptions('VerifyChoose') == '3'||Bsoptions('VerifyChoose') == '') :?>
    createCaptcha();
    <?php endif; ?>
    getTokenInfo();
    $('#friendbtn').on('click',function(){
        let friendName = document.getElementById('friendname');
    let friendUrl = document.getElementById('friendurl');
    let friendPic = document.getElementById('friendpic');
    let friendDec = document.getElementById('frienddec');
    let contactMail = document.getElementById('contactmail');
    let checkurl = document.getElementById('friendcheckurl');
    <?php if(Bsoptions('VerifyChoose') == '3'||Bsoptions('VerifyChoose') == '') :?>
    let captcha = document.getElementById('captcha_verify');
    <?php endif; ?>
    let rejectWord = new RegExp("[`~!#$^*|{}';',\\[\\]<>《》~！#￥……*（）——|{}【】‘；：”“'。，、？ ]");
    let checkmail = /^[a-zA-Z0-9]+([-_.][A-Za-zd]+)*@([a-zA-Z0-9]+[-.])+[A-Za-zd]{2,5}$/;
    if($("#contm").hasClass('required')){
    if(contactMail.value == ''){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您的联系邮箱为空,请务必填写哦', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
        return false;
    }    
    
    if(rejectWord.test(contactMail.value) ||checkmail.test(contactMail.value) == false){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您的联系邮箱包含违规字符，也有可能是非邮箱正确格式哦', 
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
    else if(checkurl.value == '' || rejectWord.test(checkurl.value)){
        $('body').toast({
							    title:'温馨提示~',
							    class: 'warning',
							    message: '您站点的友链放置页面网址为空或者包含违规字符哦', 
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
    <?php if(Bsoptions('VerifyChoose') == '3'||Bsoptions('VerifyChoose') == '') :?>
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
    <?php endif; ?>
    $("#friendbtn").css("pointer-events","none").addClass('loading');
                    $.ajax({
                        type: "POST",
                        url: "<?php getFriendFile(); ?>",
                        data: $("#friendform").serialize(),
                        dateType: "json",
                        success: function(json) {
                            jsonx = json.trim();
                            result = JSON.parse(jsonx);
                       switch(result.code){  
                           case 1:
                    $('body').toast({
							    title:'提交成功',
							    class: 'green',
							    message: '您的友链申请已提交成功，请等待博主审核～', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
										});
										window.location.reload();
										break;
						case 0:
						$('body').toast({
							    title:'提交失败',
							    class: 'warning',
							    message: result.msg, 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
										});
						$("#friendbtn").css("pointer-events","auto").removeClass('loading');
						    break;
                       }
                        },
                        error: function() {
                            alert("提交过程中出现错误，请稍后再试~~");
                        }
                    });
});
 });
function getTokenInfo(){
     $.post('<?php getCommentAction(); ?>',{action:'getCommentToken'},function (res) {
         res = JSON.parse(res);
         if(res.code == 1){
        var tokenInput=$("<input type=\"hidden\" name=\"SecurityToken\"  id=\"SecurityToken\">");
tokenInput.attr("value", res.token);
$("#friendform").append(tokenInput);
         }
    })
}
var code;
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
 </script> 

</div>

</div>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>