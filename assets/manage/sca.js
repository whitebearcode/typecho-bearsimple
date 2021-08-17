/**
 * 
 * 主题设置开关JS
 * Update 12/08/2021
 * 
**/

//自定义Gravatar
  $(document).ready(function(){
var cur = "";
$('#Gravatar-0-6').change(function(){
    var a=$(this).children('option:selected').val();
    
    if(a=='7'){
        $("#typecho-option-item-GravatarUrl-6").show();
    }else{
        $("#typecho-option-item-GravatarUrl-6").hide();
    }
})
var options=$("#Gravatar-0-6 option:selected").val();
if(options !== '7'){
$("#typecho-option-item-GravatarUrl-6").hide();
}
//自定义储存

	     $(document).ready(function(){
$('#Assets-0-8').change(function(){
var a1=$(this).children('option:selected').val();

if(a1=='3'){
    $("#typecho-option-item-Assets_Custom-8").show();
}
else{
$("#typecho-option-item-Assets_Custom-8").hide();
}
})
var options1=$("#Assets-0-8 option:selected").val();
if(options1 !== '3'){
$("#typecho-option-item-Assets_Custom-8").hide();
}

})


//文章置顶

	     $(document).ready(function(){

$('#Sticky-0-17').change(function(){
var a2=$(this).children('option:selected').val();

if(a2=='1'){
     $("#typecho-option-item-sticky_cids-17").show();
    $("#typecho-option-item-sticky_html-18").show();
}
else{
$("#typecho-option-item-sticky_cids-17").hide();
    $("#typecho-option-item-sticky_html-18").hide();
}
})
var options2=$("#Sticky-0-17 option:selected").val();
if(options2 !== '1'){
$("#typecho-option-item-sticky_cids-17").hide();
    $("#typecho-option-item-sticky_html-18").hide();
}
})



//文章展现样式



$(document).ready(function(){
	         
$('#Article_forma-0-20').change(function(){
var a3=$(this).children('option:selected').val();
if(a3 == '1'){
    //简洁图文
$("#typecho-option-item-Article_forma_pic-21").show();
$("#typecho-option-item-Article_time-22").show();
   //图底文字
$("#typecho-option-item-Article_forma_pic2-23").hide();
$("#typecho-option-item-Article_time2-24").hide();   
//纯文字2
$("#typecho-option-item-Article_time3-20").hide();
}
else if(a3=='3'){
      //图底文字
$("#typecho-option-item-Article_forma_pic2-23").show();
$("#typecho-option-item-Article_time2-24").show();    
     //简洁图文
$("#typecho-option-item-Article_forma_pic-21").hide();
$("#typecho-option-item-Article_time-22").hide();
//纯文字2
$("#typecho-option-item-Article_time3-20").hide();
}
else if(a3=='4'){
    //纯文字2
$("#typecho-option-item-Article_time3-20").show();  
      //图底文字
$("#typecho-option-item-Article_forma_pic2-23").hide();
$("#typecho-option-item-Article_time2-24").hide();    
     //简洁图文
$("#typecho-option-item-Article_forma_pic-21").hide();
$("#typecho-option-item-Article_time-22").hide();
}
else{
     //简洁图文
$("#typecho-option-item-Article_forma_pic-21").hide();
$("#typecho-option-item-Article_time-22").hide();
   //图底文字
$("#typecho-option-item-Article_forma_pic2-23").hide();
$("#typecho-option-item-Article_time2-24").hide();   
//纯文字2
$("#typecho-option-item-Article_time3-20").hide();
}
})
var options3=$("#Article_forma-0-20 option:selected").val();
if(options3 !== '1'){
     //简洁图文
$("#typecho-option-item-Article_forma_pic-21").hide();
$("#typecho-option-item-Article_time-22").hide();


}
if(options3 !== '3'){
   //图底文字
$("#typecho-option-item-Article_forma_pic2-23").hide();
$("#typecho-option-item-Article_time2-24").hide();   

}
if(options3 !== '4'){

//纯文字2
$("#typecho-option-item-Article_time3-20").hide();
}


})


//DNS预解析

	     $(document).ready(function(){

$('#DNSYJX-0-81').change(function(){
var a4=$(this).children('option:selected').val();

if(a4=='1'){
     $("#typecho-option-item-DNSADDRESS1-81").show();
    $("#typecho-option-item-DNSADDRESS2-82").show();
    $("#typecho-option-item-DNSADDRESS3-83").show();
}
else{
$("#typecho-option-item-DNSADDRESS1-81").hide();
    $("#typecho-option-item-DNSADDRESS2-82").hide();
    $("#typecho-option-item-DNSADDRESS3-83").hide();
}
})
var options4=$("#DNSYJX-0-81 option:selected").val();
if(options4 !== '1'){
$("#typecho-option-item-DNSADDRESS1-81").hide();
    $("#typecho-option-item-DNSADDRESS2-82").hide();
    $("#typecho-option-item-DNSADDRESS3-83").hide();
}
})




//幻灯片

	     $(document).ready(function(){

$('#Slidersss-0-13').change(function(){
var a5=$(this).children('option:selected').val();

if(a5=='1'){
    $("#typecho-option-item-SliderIndexs-13").show();
    $("#typecho-option-item-SliderOthers-14").show();
    $("#typecho-option-item-SliderPics-15").show();
}
else{
$("#typecho-option-item-SliderIndexs-13").hide();
    $("#typecho-option-item-SliderOthers-14").hide();
    $("#typecho-option-item-SliderPics-15").hide();
}
})
var options5=$("#Slidersss-0-13 option:selected").val();
if(options5 !== '1'){
$("#typecho-option-item-SliderIndexs-13").hide();
    $("#typecho-option-item-SliderOthers-14").hide();
    $("#typecho-option-item-SliderPics-15").hide();
}
})

//弹窗

	     $(document).ready(function(){

$('#Popup-0-112').change(function(){
var a6=$(this).children('option:selected').val();

if(a6=='1'){
$("#typecho-option-item-PopupText-112").show();
    $("#typecho-option-item-PopupUrl-113").show();
}
else{
$("#typecho-option-item-PopupText-112").hide();
    $("#typecho-option-item-PopupUrl-113").hide();
}
})
var options6=$("#Popup-0-112 option:selected").val();
if(options6 !== '1'){
$("#typecho-option-item-PopupText-112").hide();
    $("#typecho-option-item-PopupUrl-113").hide();
}
})

//友链
$(document).ready(function(){
$('#FriendLinkChoose-0-11').change(function(){
var a7=$(this).children('option:selected').val();

if(a7=='1'){
$("#typecho-option-item-FriendLink-11").show();
}
else{
$("#typecho-option-item-FriendLink-11").hide();
}
})
var options7=$("#Slidersss-0-13 option:selected").val();
if(options7 !== '1'){
$("#typecho-option-item-FriendLink-11").hide();
}
})

//其他设置
//返回顶部
$(document).ready(function(){
$('#Top-0-108').change(function(){
var a8=$(this).children('option:selected').val();

if(a8=='1'){
$("#typecho-option-item-TopSrc-108").show();
}
else{
$("#typecho-option-item-TopSrc-108").hide();
}
})
var options8=$("#Top-0-108 option:selected").val();
if(options8 !== '1'){
$("#typecho-option-item-TopSrc-108").hide();
}
})

//翻译
$(document).ready(function(){
$('#Translate-0-106').change(function(){
var a9=$(this).children('option:selected').val();

if(a9=='1'){
$("#typecho-option-item-TranslateLanguage-106").show();
}
else{
$("#typecho-option-item-TranslateLanguage-106").hide();
}
})
var options9=$("#Translate-0-106 option:selected").val();
if(options9 !== '1'){
$("#typecho-option-item-TranslateLanguage-106").hide();
}
})

//缓存
$(document).ready(function(){
$('#Cache-0-90').change(function(){
var a10=$(this).children('option:selected').val();

if(a10=='1'){
$("#typecho-option-item-cache_dir-90").show();
$("#typecho-option-item-cache_timeout-91").show();
}
else{
$("#typecho-option-item-cache_dir-90").hide();
$("#typecho-option-item-cache_timeout-91").hide();

}
})
var options10=$("#Cache-0-90 option:selected").val();
if(options10 !== '1'){
$("#typecho-option-item-cache_dir-90").hide();
$("#typecho-option-item-cache_timeout-91").hide();


}
})

//第三方分享
$(document).ready(function(){
$('#Share-0-78').change(function(){
var a11=$(this).children('option:selected').val();

if(a11=='1'){
$("#typecho-option-item-Shares-78").show();
}
else{
$("#typecho-option-item-Shares-78").hide();
}
})
var options11=$("#Share-0-78 option:selected").val();
if(options11 !== '1'){
$("#typecho-option-item-Shares-78").hide();
}
})

//评论字数限制
$(document).ready(function(){
$('#Entermaxlength-0-115').change(function(){
var a12=$(this).children('option:selected').val();

if(a12=='1'){
$("#typecho-option-item-Entermaxlengths-115").show();
}
else{
$("#typecho-option-item-Entermaxlengths-115").hide();
}
})
var options12=$("#Entermaxlength-0-115 option:selected").val();
if(options12 !== '1'){
$("#typecho-option-item-Entermaxlengths-115").hide();
}
})

//代码高亮
$(document).ready(function(){
$('#Codehightlight-0-120').change(function(){
var a13=$(this).children('option:selected').val();

if(a13=='1'){
$("#typecho-option-item-code_style-120").show();
$("#typecho-option-item-showLineNumber-121").show();
}
else{
$("#typecho-option-item-code_style-120").hide();
$("#typecho-option-item-showLineNumber-121").hide();
}
})
var options13=$("#Codehightlight-0-120 option:selected").val();
if(options13 !== '1'){
$("#typecho-option-item-code_style-120").hide();
$("#typecho-option-item-showLineNumber-121").hide();
}
})

//打赏
$(document).ready(function(){
$('#RewardOpen-0-28').change(function(){
var a14=$(this).children('option:selected').val();

if(a14=='1'){
$("#typecho-option-item-RewardOpenPaypal-28").show();
$("#typecho-option-item-RewardOpenPaypalText-29").show();
$("#typecho-option-item-RewardOpenAlipay-30").show();
$("#typecho-option-item-RewardOpenAlipayText-31").show();
$("#typecho-option-item-RewardOpenWechat-32").show();
$("#typecho-option-item-RewardOpenWechatText-33").show();
}
else{
$("#typecho-option-item-RewardOpenPaypal-28").hide();
$("#typecho-option-item-RewardOpenPaypalText-29").hide();
$("#typecho-option-item-RewardOpenAlipay-30").hide();
$("#typecho-option-item-RewardOpenAlipayText-31").hide();
$("#typecho-option-item-RewardOpenWechat-32").hide();
$("#typecho-option-item-RewardOpenWechatText-33").hide();
}
})
var options14=$("#RewardOpen-0-28 option:selected").val();
if(options14 !== '1'){
$("#typecho-option-item-RewardOpenPaypal-28").hide();
$("#typecho-option-item-RewardOpenPaypalText-29").hide();
$("#typecho-option-item-RewardOpenAlipay-30").hide();
$("#typecho-option-item-RewardOpenAlipayText-31").hide();
$("#typecho-option-item-RewardOpenWechat-32").hide();
$("#typecho-option-item-RewardOpenWechatText-33").hide();
}
})



//区块
//右侧最近文章
$(document).ready(function(){
$('#LastArticle-0-61').change(function(){
var a16=$(this).children('option:selected').val();

if(a16=='1'){
$("#typecho-option-item-LastArticleNumber-61").show();
}
else{
$("#typecho-option-item-LastArticleNumber-61").hide();
}
})
var options16=$("#LastArticle-0-61 option:selected").val();
if(options16 !== '1'){
$("#typecho-option-item-LastArticleNumber-61").hide();
}
})

//行为验证

$(document).ready(function(){
	         
$('#VerifyChoose-0-37').change(function(){
var a15=$(this).children('option:selected').val();
if(a15 == '1'){
    //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").hide();
$("#typecho-option-item-Verify22_Paneltitle-38").hide();
$("#typecho-option-item-Verify22_Paneldec-39").hide();
$("#typecho-option-item-Verify22_Panelclose-40").hide();
$("#typecho-option-item-Verify22_Panelsuccess-41").hide();
$("#typecho-option-item-Verify22_Panelerror-42").hide();
$("#typecho-option-item-Verify22_Panelimg-43").hide();
$("#typecho-option-item-Verify22_Paneltime-44").hide();
$("#typecho-option-item-Verify22_PanelslideDifference-45").hide();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").hide();
//Vaptcha
$("#typecho-option-item-vid-47").hide();
//无感认证
$("#typecho-option-item-protection_level-48").hide();
$("#typecho-option-item-delay_time-49").hide();
$("#typecho-option-item-banned_action-50").hide();
$("#typecho-option-item-spam_ip_action-51").hide();
$("#typecho-option-item-banned_ip_list-52").hide();
$("#typecho-option-item-alert_message-53").hide();

}
else if(a15=='11'){
    //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").hide();
$("#typecho-option-item-Verify22_Paneltitle-38").hide();
$("#typecho-option-item-Verify22_Paneldec-39").hide();
$("#typecho-option-item-Verify22_Panelclose-40").hide();
$("#typecho-option-item-Verify22_Panelsuccess-41").hide();
$("#typecho-option-item-Verify22_Panelerror-42").hide();
$("#typecho-option-item-Verify22_Panelimg-43").hide();
$("#typecho-option-item-Verify22_Paneltime-44").hide();
$("#typecho-option-item-Verify22_PanelslideDifference-45").hide();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").hide();
//Vaptcha
$("#typecho-option-item-vid-47").hide();
//无感认证
$("#typecho-option-item-protection_level-48").hide();
$("#typecho-option-item-delay_time-49").hide();
$("#typecho-option-item-banned_action-50").hide();
$("#typecho-option-item-spam_ip_action-51").hide();
$("#typecho-option-item-banned_ip_list-52").hide();
$("#typecho-option-item-alert_message-53").hide();
}
else if(a15=='2'){
    //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").hide();
$("#typecho-option-item-Verify22_Paneltitle-38").hide();
$("#typecho-option-item-Verify22_Paneldec-39").hide();
$("#typecho-option-item-Verify22_Panelclose-40").hide();
$("#typecho-option-item-Verify22_Panelsuccess-41").hide();
$("#typecho-option-item-Verify22_Panelerror-42").hide();
$("#typecho-option-item-Verify22_Panelimg-43").hide();
$("#typecho-option-item-Verify22_Paneltime-44").hide();
$("#typecho-option-item-Verify22_PanelslideDifference-45").hide();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").hide();
//Vaptcha
$("#typecho-option-item-vid-47").show();
//无感认证
$("#typecho-option-item-protection_level-48").hide();
$("#typecho-option-item-delay_time-49").hide();
$("#typecho-option-item-banned_action-50").hide();
$("#typecho-option-item-spam_ip_action-51").hide();
$("#typecho-option-item-banned_ip_list-52").hide();
$("#typecho-option-item-alert_message-53").hide();
}
else if(a15=='22'){
        //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").show();
$("#typecho-option-item-Verify22_Paneltitle-38").show();
$("#typecho-option-item-Verify22_Paneldec-39").show();
$("#typecho-option-item-Verify22_Panelclose-40").show();
$("#typecho-option-item-Verify22_Panelsuccess-41").show();
$("#typecho-option-item-Verify22_Panelerror-42").show();
$("#typecho-option-item-Verify22_Panelimg-43").show();
$("#typecho-option-item-Verify22_Paneltime-44").show();
$("#typecho-option-item-Verify22_PanelslideDifference-45").show();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").show();
//Vaptcha
$("#typecho-option-item-vid-47").hide();
//无感认证
$("#typecho-option-item-protection_level-48").hide();
$("#typecho-option-item-delay_time-49").hide();
$("#typecho-option-item-banned_action-50").hide();
$("#typecho-option-item-spam_ip_action-51").hide();
$("#typecho-option-item-banned_ip_list-52").hide();
$("#typecho-option-item-alert_message-53").hide();
}
else if(a15=='4'){
        //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").hide();
$("#typecho-option-item-Verify22_Paneltitle-38").hide();
$("#typecho-option-item-Verify22_Paneldec-39").hide();
$("#typecho-option-item-Verify22_Panelclose-40").hide();
$("#typecho-option-item-Verify22_Panelsuccess-41").hide();
$("#typecho-option-item-Verify22_Panelerror-42").hide();
$("#typecho-option-item-Verify22_Panelimg-43").hide();
$("#typecho-option-item-Verify22_Paneltime-44").hide();
$("#typecho-option-item-Verify22_PanelslideDifference-45").hide();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").hide();
//Vaptcha
$("#typecho-option-item-vid-47").hide();
//无感认证
$("#typecho-option-item-protection_level-48").show();
$("#typecho-option-item-delay_time-49").show();
$("#typecho-option-item-banned_action-50").show();
$("#typecho-option-item-spam_ip_action-51").show();
$("#typecho-option-item-banned_ip_list-52").show();
$("#typecho-option-item-alert_message-53").show();
}
else if(a15=='3'){
        //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").hide();
$("#typecho-option-item-Verify22_Paneltitle-38").hide();
$("#typecho-option-item-Verify22_Paneldec-39").hide();
$("#typecho-option-item-Verify22_Panelclose-40").hide();
$("#typecho-option-item-Verify22_Panelsuccess-41").hide();
$("#typecho-option-item-Verify22_Panelerror-42").hide();
$("#typecho-option-item-Verify22_Panelimg-43").hide();
$("#typecho-option-item-Verify22_Paneltime-44").hide();
$("#typecho-option-item-Verify22_PanelslideDifference-45").hide();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").hide();
//Vaptcha
$("#typecho-option-item-vid-47").hide();
//无感认证
$("#typecho-option-item-protection_level-48").hide();
$("#typecho-option-item-delay_time-49").hide();
$("#typecho-option-item-banned_action-50").hide();
$("#typecho-option-item-spam_ip_action-51").hide();
$("#typecho-option-item-banned_ip_list-52").hide();
$("#typecho-option-item-alert_message-53").hide();
}
else{
        //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").hide();
$("#typecho-option-item-Verify22_Paneltitle-38").hide();
$("#typecho-option-item-Verify22_Paneldec-39").hide();
$("#typecho-option-item-Verify22_Panelclose-40").hide();
$("#typecho-option-item-Verify22_Panelsuccess-41").hide();
$("#typecho-option-item-Verify22_Panelerror-42").hide();
$("#typecho-option-item-Verify22_Panelimg-43").hide();
$("#typecho-option-item-Verify22_Paneltime-44").hide();
$("#typecho-option-item-Verify22_PanelslideDifference-45").hide();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").hide();
//Vaptcha
$("#typecho-option-item-vid-47").hide();
//无感认证
$("#typecho-option-item-protection_level-48").hide();
$("#typecho-option-item-delay_time-49").hide();
$("#typecho-option-item-banned_action-50").hide();
$("#typecho-option-item-spam_ip_action-51").hide();
$("#typecho-option-item-banned_ip_list-52").hide();
$("#typecho-option-item-alert_message-53").hide();
}
})
var options15=$("#VerifyChoose-0-37 option:selected").val();
if(options15 !== '2'){
$("#typecho-option-item-vid-47").hide();


}
if(options15 !== '22'){
        //拼图滑块
$("#typecho-option-item-Verify22_Buttontext-37").hide();
$("#typecho-option-item-Verify22_Paneltitle-38").hide();
$("#typecho-option-item-Verify22_Paneldec-39").hide();
$("#typecho-option-item-Verify22_Panelclose-40").hide();
$("#typecho-option-item-Verify22_Panelsuccess-41").hide();
$("#typecho-option-item-Verify22_Panelerror-42").hide();
$("#typecho-option-item-Verify22_Panelimg-43").hide();
$("#typecho-option-item-Verify22_Paneltime-44").hide();
$("#typecho-option-item-Verify22_PanelslideDifference-45").hide();
$("#typecho-option-item-Verify22_PaneldefaultDifference-46").hide();

}
if(options15 !== '4'){
//无感认证
$("#typecho-option-item-protection_level-48").hide();
$("#typecho-option-item-delay_time-49").hide();
$("#typecho-option-item-banned_action-50").hide();
$("#typecho-option-item-spam_ip_action-51").hide();
$("#typecho-option-item-banned_ip_list-52").hide();
$("#typecho-option-item-alert_message-53").hide();
}
})

//区块
//广告
$(document).ready(function(){
$('#AdControl-0-63').change(function(){
var a17=$(this).children('option:selected').val();

if(a17=='1'){
$("#typecho-option-item-AdControl1-63").show();
$("#typecho-option-item-AdControl1Src-64").show();
$("#typecho-option-item-AdControl1Url-65").show();
$("#typecho-option-item-AdControl2-66").show();
$("#typecho-option-item-AdControl2Src-67").show();
$("#typecho-option-item-AdControl2Url-68").show();
$("#typecho-option-item-AdControl3-69").show();
$("#typecho-option-item-AdControl3Src-70").show();
$("#typecho-option-item-AdControl3Url-71").show();
$("#typecho-option-item-AdControl4-72").show();
$("#typecho-option-item-AdControl4Src-73").show();
$("#typecho-option-item-AdControl4Url-74").show();
}
else{
$("#typecho-option-item-AdControl1-63").hide();
$("#typecho-option-item-AdControl1Src-64").hide();
$("#typecho-option-item-AdControl1Url-65").hide();
$("#typecho-option-item-AdControl2-66").hide();
$("#typecho-option-item-AdControl2Src-67").hide();
$("#typecho-option-item-AdControl2Url-68").hide();
$("#typecho-option-item-AdControl3-69").hide();
$("#typecho-option-item-AdControl3Src-70").hide();
$("#typecho-option-item-AdControl3Url-71").hide();
$("#typecho-option-item-AdControl4-72").hide();
$("#typecho-option-item-AdControl4Src-73").hide();
$("#typecho-option-item-AdControl4Url-74").hide();
}
})
var options17=$("#AdControl-0-63 option:selected").val();
if(options17 !== '1'){
$("#typecho-option-item-AdControl1-63").hide();
$("#typecho-option-item-AdControl1Src-64").hide();
$("#typecho-option-item-AdControl1Url-65").hide();
$("#typecho-option-item-AdControl2-66").hide();
$("#typecho-option-item-AdControl2Src-67").hide();
$("#typecho-option-item-AdControl2Url-68").hide();
$("#typecho-option-item-AdControl3-69").hide();
$("#typecho-option-item-AdControl3Src-70").hide();
$("#typecho-option-item-AdControl3Url-71").hide();
$("#typecho-option-item-AdControl4-72").hide();
$("#typecho-option-item-AdControl4Src-73").hide();
$("#typecho-option-item-AdControl4Url-74").hide();
}
})

})