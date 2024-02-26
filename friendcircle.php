<?php
    /**
    * 朋友圈
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>
<link href="<?php AssetsDir();?>assets/vendors/friendcircle/friendcircle.css?v=3" rel="stylesheet" type="text/css">

<?php

$parameter= array(
   'parentId'      => $this->hidden ? 0 : $this->cid,
   'parentContent' => $this->row,
   'respondId'     => $this->respondId,
   'commentPage'   => $this->request->filter('int')->commentPage,
   'commentsPageSize' => '4',
   'allowComment'  => $this->allow('comment')
);
$this->widget('BearSimple_Widget_Friendcircle_Archive',$parameter)->to($comments);
?>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> divided items segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="fan green icon"></i><?php $this->title() ?></h2>
    <div class="friendcircle-container">
        <section class="friendcircle-bg">
            <img data-fancybox="image" src="<?php if(Bsoptions('fcircle_Background') == null): ?><?php AssetsDir();?>assets/images/mountain.webp<?php else:?><?php echo Bsoptions('fcircle_Background');?><?php endif;?>" class="friendcircle-bg-img">
            <img src="<?php if(Bsoptions('fcircle_Avatar') == null): ?><?php AssetsDir();?>assets/images/circle_defaultAvatar.jpg<?php else:?><?php echo Bsoptions('fcircle_Avatar');?><?php endif;?>" class="friendcircle-bg-author">
            <span class="friendcircle-bg-author-name"><?php if(Bsoptions('fcircle_Name') == null): ?>神秘人<?php else:?><?php echo Bsoptions('fcircle_Name');?><?php endif;?></span>
            <span class="friendcircle-bg-author-sign"><?php if(Bsoptions('fcircle_Sign') == null): ?>神秘人的朋友圈<?php else:?><?php echo Bsoptions('fcircle_Sign');?><?php endif;?></span>
        </section>
        <button class="friendcircle-add" id="friendcircle-add" style="display:none">发表朋友圈</button>
        
    <div class="ui active inverted dimmer" id="circleDeleteLoad" style="display:none">
    <div class="ui active green elastic loader"></div>
  </div>
  
  
<div class="friendcircle-popup friendcirclex" role="alert">
<div class="ui active inverted dimmer" id="circleSendLoad" style="display:none">
    <div class="ui active green elastic loader"></div>
  </div>
  <form method="post" action="<?php editurl($this->commentUrl) ?>" name="friendcircleform" id="commentform" class="friendcircle-form">
    <div class="friendcircle-popup-container">
      <p style="float:left">
        <div class="friendcircle-popup-close friendcircle-close-button">
          <i class="chevron left icon" style="pointer-events:none;"></i>
        </div>
    </p>
  <div class="submit" style="float:right">
      
        <button type="submit" name="submit" id="submit">发表</button>
      </div>
      <div class="message">
        <textarea name="text" id="text"  class="emotion" placeholder="这一刻的想法..."></textarea>
       
      </div>
      <input type="text" id="vtype" name="vtype" value="friendcircle" style="display:none">
        <div class="circular ui icon button" id="facecircle">
  <i class="smile beam outline icon"></i>
 </div>
 <div class="emoemo" class="ignore"  translate="no" style="position: relative;margin-top:-20px"></div>
      <br>
      
 

                        
<div id="getUpload">
				<div class="ui icon tiny button" name="btn" id="btn"><i class="image outline icon"></i> 上传图片</div>
				<ul id="ul_pics" class="ul_pics clearfix"></ul>
		</div>


 
      <br>
      <div class="message_action">
          <div class="getMap">
      <i class="map marker alternate large green icon"></i><div class="ui mini button" id="getMap">获取当前位置信息</div><input name="getMapInput" id="getMapInput" value="" style="display:none"></div>
      <div class="canRead">
      <i class="user alternate large green icon"></i> 
      <div class="ui right aligned toggle checkbox">
        <input type="checkbox" id="getRead" name="getRead">
       <label>仅自己可见</label>
      </div>
  

  
  
      </div>
      </div>
    </div>
    
  
    
  </form>
  
 
</div>


<?php if (!$comments->have()): ?> 
<center>
    <div style="margin-top:40px">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="1.128" y1="0.988" x2="0.364" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="c" x1="1" y1="0.5" x2="0.112" y2="1.125" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#747f95"/></linearGradient><linearGradient id="d" x1="-0.392" y1="1.114" x2="0.5" y2="0.396" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#ebedf5"/></linearGradient><linearGradient id="e" x1="-0.906" y1="1.646" x2="0.636" y2="0.061" xlink:href="#d"/><linearGradient id="f" x1="-0.109" y1="1.931" x2="0.736" y2="0.141" xlink:href="#d"/></defs><g transform="translate(-135 -375)"><circle cx="184" cy="184" r="184" transform="translate(191 443)" fill="#f3f3fa"/><path d="M2925,350h0c-8.837,0-16-32.235-16-72s7.163-72,16-72c.038,0,11.813.471,18.75-7.529s9-14.486,9-24.469c0-34.257,14.681-58.6,28.25-63.313,3.909-.688,10,.818,16-4.354s8-9.372,8-16.333c0-37.555,12.536-68,28-68s28,30.445,28,68c0,6.961-.667,10.328,5.333,15.5s14.76,4.5,18.667,5.187c13.569,4.714,24,33.055,24,67.312a101.212,101.212,0,0,0,2.333,20s4.485,11.842,11,5.5,9.13-14.885,10.25-22.871C3135.767,157.923,3142.61,142,3149,142c6.519,0,12.127,16.566,14.645,40.566.741,7.066,2.2,11.743,6.521,17.6A14.3,14.3,0,0,0,3180.92,206H3181c6.488,0,12.073,16.409,14.617,40.308.5,4.725.982,7.6,5.3,11.527S3212.884,262,3212.884,262l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573C3227.336,294.758,3229,311.835,3229,330c0,6.817-.237,13.546-.7,20H2925Zm303.3,0h0Z" transform="translate(-2718 397)" fill="url(#a)"/><path d="M117,208H.7c-.466-6.453-.7-13.181-.7-20,0-18.163,1.664-35.24,4.686-48.083a58.6,58.6,0,0,1,5.086-14.573C11.745,121.8,13.84,120,16,120l.116,0s7.651-.242,11.967-4.166,4.8-6.8,5.3-11.527C35.927,80.408,41.513,64,48,64a16.6,16.6,0,0,0,3.3-1.014A6.153,6.153,0,0,0,53.365,61.5c6.515-6.342,9.13-14.884,10.25-22.871C66.8,15.924,73.642,0,80.032,0,86.55,0,92.158,16.566,94.676,40.567c.742,7.065,2.2,11.742,6.521,17.6A14.3,14.3,0,0,0,111.951,64h.081c6.487,0,12.073,16.409,14.617,40.307.5,4.725.983,7.6,5.3,11.527S143.915,120,143.915,120l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573c3.022,12.844,4.686,29.921,4.686,48.083,0,6.818-.237,13.546-.7,20H117Zm42.328,0h0ZM.7,208h0Z" transform="translate(350.969 539)" fill="url(#a)"/><path d="M2989,62c-10.838-4.087-16.3,0-32,0-26.51,0-48-8.954-48-20s21.49-20,48-20h256a16,16,0,1,1,0,32s-15.5,0-27.5,3S3165,68.714,3165,68.714,3127.392,110,3081,110c-38.041,0-70.176-13.246-80.647-31.653C2998.219,74.6,2999.838,66.087,2989,62Z" transform="translate(-2702 701)" fill="#d1d6e2"/><path d="M-2493,98s-56.355,45.651-64,16,74.25-17.75-16,72" transform="translate(3044 409)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2" stroke-dasharray="10"/><path d="M4,2.2C7.15-.75,16,0,16,0s-1.5,4-2.6,8-.232,5.942-1.8,8C7.6,21.25,0,21,0,21s.75-3.4,2-8S.85,5.15,4,2.2Z" transform="translate(447 603.085)" fill="#909aa9"/><ellipse cx="10" cy="4" rx="10" ry="4" transform="translate(294 787)" fill="url(#c)"/><path d="M8.44,24s8.115-6,6.94-10S11.51,9.625,9.775,6.125A11.222,11.222,0,0,1,8.44,0S1.767,2.625,1.5,9.375C1.38,12.419,4.436,14.344,6.171,18A32.451,32.451,0,0,1,8.44,24Z" transform="translate(287 794.497) rotate(-90)" fill="#909aa9"/><path d="M0,0,57,4.5,136,0l31.5,12,17,10-37,8.5-24.5-5-58,5L4,23Z" transform="translate(191 699)" fill="#fff"/><path d="M-1.4,1.2,60,9l58.75-5.25L143,9l36-9V24.5L144.4,29l-16.2-7.25L95.6,23l-5.1,1.5L67.2,21.75,5,23.25S2.8,16.713,1.2,11.2-1.4,1.2-1.4,1.2Z" transform="translate(196 720)" fill="#eceff5"/><ellipse cx="43" cy="9.5" rx="43" ry="9.5" transform="translate(253 701)" fill="#ebedf5"/><g transform="translate(63 354)"><g transform="translate(258.49 305.55)"><path d="M525.021,66.584a31.23,31.23,0,0,1,7.085,10.425c2.772,6.6,5.877,13.459,8.386,14.78s3.695,10.033-8.053,8.185S525.021,66.584,525.021,66.584Z" transform="translate(-524.241 -66.584)" fill="#fff"/><path d="M525.494,68.3a32.341,32.341,0,0,1,6.953,16.851c.847,8.628,2.933,13.332,5.151,13.016a12.659,12.659,0,0,1-5.991-.025C528.092,97.37,524.074,68.412,525.494,68.3Z" transform="translate(-523.763 -65.64)" fill="url(#d)"/></g><path d="M537.949,131.675a34.415,34.415,0,0,0,14.137,1.09c6.9-.975,8.727-13.747-.647-15.059-7.267-1.02-6.026-12.167-7.366-22.433s-6.56-18.848-7.364-23.026,4.251-9.233,3.614-18.062c-.652-9.065-6.3-10.479-8.307-10.074s-3.609,2.392-6.154,3.47-6.292-.673-11.112,1.619-9.377,7.547-9.377,7.547c-2.009,2.561.4,10.648-.938,14.691s-6.694,39.223-6.56,49.062,6.426,16.715,19.952,18.467,19.419-.606,19.856-4.448c.279-2.443,1.905-11.053-7.8-12.535-4.83-.74-7.363-1.347-7.363-1.347" transform="translate(-279.872 225.445)" fill="#fff"/><path d="M519.206,44.961s.961-1.578,1.726-1.594c1.313-.026,2.7,1.631,2.7,1.631S519.249,46.731,519.206,44.961Z" transform="translate(-268.363 226.187)" fill="#757f95"/><path d="M522.077,37.922c-2.054-.536-2.278,2.085-2.278,2.085s-2.89-.313-2.6,1.743c.357,2.566,5.831,2.443,5.831,2.443S524.583,38.578,522.077,37.922Z" transform="translate(-269.464 223.151)" fill="#757f95"/><path d="M505.743,52.715s-6.088-1.338-6.755,3.318,4.181,7.509,7.656.6" transform="translate(-279.292 231.235)" fill="#fff"/><path d="M503.084,74.624s-1.45,17.9,1.1,22.385c2.3,4.044,10.662,5.138,16.755,4.63a25.038,25.038,0,0,0,6.013-1.246c6.068-2.157,2.831-6.2,0-8.893s-3.738-10.346-8.593-14.5" transform="translate(-276.501 243.626)" fill="url(#e)"/><path d="M514.078,48.635a.6.6,0,0,0-.522.31v0l-.009.014a4.814,4.814,0,0,1-3.228,2.322l-.019,0,0,0a.6.6,0,0,0-.509.5l-.011,0-.406,1.078s.341-.014.842-.088l.057-.307.11-.584v.865c.188-.031.389-.073.6-.121v-.747l.064.454.037.268a5.609,5.609,0,0,0,2.386-1.138,4.083,4.083,0,0,0,1.152-1.977c.04-.155.054-.248.054-.248A.6.6,0,0,0,514.078,48.635Z" transform="translate(-273.668 229.087)" fill="#757f95"/><path d="M531.516,76.393c-3.6-3.507-6.766.555-6.766.555s-6.2-4.888-8.5.26C513.373,83.63,528.051,94,528.051,94S535.2,79.982,531.516,76.393Z" transform="translate(-270.216 243.516)" fill="url(#f)"/><path d="M504.118,75.051s5.02,15.274,7.571,19.76c3.236,5.688,9.468,8.51,15.533,6.355s2.831-5.527,0-8.223S523.148,81.155,518.293,77" transform="translate(-277.496 242.564)" fill="#fff"/></g><path d="M0,9.833l18-9.5,2.667,4v8.2L13,18,8.167,12.532,0,13.671Z" transform="translate(377 777)" fill="#eceff5"/><path d="M4,3.167,18,0V10l-5,3.167-4.833-4L0,10Z" transform="translate(377 777)" fill="#fff"/><path d="M-.211,18.893,16,12l.246,14.107-2.084,4.646L0,31Z" transform="matrix(1, 0.017, -0.017, 1, 400.376, 734.864)" fill="#eceff5"/><path d="M9.75,12H16l-3.75,7H0Z" transform="translate(400 735)" fill="#fff"/><g transform="translate(447 690)"><path d="M97,0,63.923,4.5,24.316,0,8.523,12,0,22l18.55,8.5,12.283-5,29.079,5,23.488-5,6.467-12.126Z" transform="translate(-1 12)" fill="#fff"/><path d="M81.149.607l-28.1,3.945L26.17,1.9l-11.1,2.655L-2.651-1.333V12.391l17.083,2.276L21.846,11l14.917.632,2.334.759L49.759,11l28.991,1.391s-1.4-1.778,0-4.724A43.992,43.992,0,0,0,81.149.607Z" transform="translate(1.651 35.333)" fill="#eceff5"/></g></g></svg></div>
           <h2 class="post-title">博主当前还没有朋友圈呢~</h2>
        
              
  </center>
  <?php endif;?>
<?php if ($comments->have()): ?>    
    <br>
    
     <?php
      ob_start();
   $comments->listComments();
   $comments_content = ob_get_contents();
      ob_end_clean();
   $comments_content = preg_replace("/<ol class=\"comment-list\">/sm", '<ul id="friendcircle-list" class="friendcircle-list friendcircle-list-front">', $comments_content);
   $comments_content = preg_replace("/<\/ol>/sm", '</ul>', $comments_content);
   echo $comments_content;
   ?>


    <?php

      ob_start(); 

      $comments->pageNav('&laquo;','&raquo;', 1, '');
      $content = ob_get_contents();
      ob_end_clean();
      
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<div class="ui  labels" style="margin-top:30px"><div style="text-align:center">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<a class="ui large label">...</a>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui green large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      //旧版本兼容
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui green large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      
      $content = preg_replace("/<\/ol>/sm", '</div></div>', $content);
      echo $content;
     ?>

    <?php endif; ?>
    


        </div>
    
 <div id="friendcircle-actions" class="friendcircle-icons hidden">
			<a class="circle-like" style="cursor: default;"><i class="heart outline icon"></i> 赞</a>
		<a class="circle-comment" style="cursor: default;"><i class="comment alternate outline icon"></i> 评论</a>
		
		</div>



<div id="friendcircle-comment-container" style="display:none">
   
  <div class="ui active inverted dimmer" id="circleLoad" style="display:none">
    <div class="ui active green elastic loader"></div>
  </div>


             <div class="friendcircle-comment-types">
                 
                 <div id="nologinshow" style="display:none">
            <input type="text" id="friendcircle-comment-nickname" placeholder="昵称*">
            <input type="email" id="friendcircle-comment-email" placeholder="邮箱*">
            <input type="url" id="friendcircle-comment-url" placeholder="网址">
            </div>
            <div id="loginshowlabel" style="display:none;padding-left: 5px;">
                <div class="ui image label" style="float:left">
  <img src="<?php echo imgravatarq($this->user->mail); ?>">
  <name id="authorname"></name>
</div>
                   </div>
            <textarea id="friendcircle-comment-textarea" class="emotion_circle" required="" spellcheck="false" maxlength="500" onchange="this.value=this.value.substring(0, 500)" onkeydown="this.value=this.value.substring(0, 500)" onkeyup="this.value=this.value.substring(0, 500)" placeholder="评论内容"></textarea>
            <button id="friendcircle-comment-submit">发送</button>
            <button id="friendcircle-comment-cancelsubmit">取消</button>
              <div class="circular ui icon button friendcircle-comment-emoji" id="facecirclecomment">
  <i class="smile beam outline icon"></i>
 </div>
          
                
            </div>
 <div  class="ignore emoemo"  translate="no"></div>
            
         </div>
      

</div></div>



<script src="<?php AssetsDir();?>assets/vendors/friendcircle/toolbar.js"></script>

<script src="<?php AssetsDir();?>assets/vendors/friendcircle/moxie.js"></script>
<script src="<?php AssetsDir();?>assets/vendors/friendcircle/plupload.js"></script>





      <script>
      $(function(){
          
          function autoResize(element) {
  element.style.height = 'auto';
  element.style.height = `${element.scrollHeight}px`;
}

var textarea = document.getElementById('friendcircle-comment-textarea');
$("#friendcircle-comment-textarea").on("input propertychange",function(){

    autoResize(this);
    if(this.value.length){
    $("#friendcircle-comment-container").attr("style", "box-shadow: inset 0px 0px 0px 1px #07c160;");
    $("#friendcircle-comment-submit").addClass("friendcircle-comment-readySubmit");
    }
    else{
    $("#friendcircle-comment-container").attr("style", "box-shadow: inset 0px 0px 0px 0px #07c160;");
    $("#friendcircle-comment-submit").removeClass("friendcircle-comment-readySubmit");    
    }
});


          $('.circle-action').on('mouseenter',function(){
              window.localStorage.setItem('reply-coid', $(this).attr('data-coid'));
          });
          dom = function (id) {
            return document.getElementById(id);
        };
        create = function (tag, attr) {
            var el = document.createElement(tag);
        
            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }
        
            return el;
        };
        $('.circle-like').on('click',function(){
            $('.circle-like').css("pointer-events","none");
            var coid = window.localStorage.getItem('reply-coid');
            $.ajax({
        url: '<?php getCircleAction();?>',
        type: 'POST',
        dataType: 'html',
        data: {
                            "action": 'like',
                            "coid":coid
                        },
                        
        
        success: function(response) {
            $('.circle-like').css("pointer-events","auto");
            json = JSON.parse(response);
            if(json.code == 500){
                $('body').toast({
							    title:'点赞失败',
							    class: 'warning',
							    message: json.msg, 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
							return false;
            }
           $('body').toast({
							    title:'点赞成功',
							    class: 'success',
							    message: '您已点赞成功~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
		    
			if(json.likeUser !== '' && json.likeVisitor !== ''){
			    json.likeVisitor = '，'+json.likeVisitor;
			}

		   if(!$("#friendcircle-comments-"+coid).length){
		       $("#friendcircle-action-"+coid).after('<div class="friendcircle-comments" id="friendcircle-comments-'+coid+'"><span id="friendcircle-comments-like-'+coid+'"><i class="heart outline icon"></i> '+json.likeUser+json.likeVisitor+'</span></div>');
		   }
		   if($("#friendcircle-comments-"+coid).length && !$("#friendcircle-comments-like-"+coid).length){
			$("#friendcircle-comments-"+coid).prepend('<span id="friendcircle-comments-like-'+coid+'"><i class="heart outline icon"></i> '+json.likeUser+json.likeVisitor+'</span><hr>');
			}
			if($("#friendcircle-comments-"+coid).length && $("#friendcircle-comments-like-"+coid).length){
			$("#friendcircle-comments-like-"+coid).empty().html('<i class="heart outline icon"></i> '+json.likeUser+json.likeVisitor);
			}
			
			
			
				
        },
        
        error: function(req, status, error) {
            $('.circle-like').css("pointer-events","auto");
          $('body').toast({
							    title:'点赞失败',
							    class: 'error',
							    message: '网络错误', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
        }
    });
    
    
    
        });
        
        $('.circle-comment-children').on('click',function(){
            window.localStorage.setItem('reply-coid', $(this).attr('data-coid'));
              var response = dom('friendcircle-comment-container');
              var com = dom('circle-children-'+$(this).attr('data-coid'));
                com.appendChild(response).style.display = "block";
                $("#friendcircle-comment-textarea").attr("placeholder", "回复"+$(this).attr('data-parentName')+":");
                document.getElementById("friendcircle-comment-textarea").focus();
          });
          $('.circle-comment').on('click',function(){
              var response = dom('friendcircle-comment-container');
              var com = dom('comment-'+window.localStorage.getItem('reply-coid'));
             $("#friendcircle-comment-textarea").attr("placeholder", "回复<?php echo $this->author->screenName;?>:");
                com.appendChild(response).style.display = "block";
               document.getElementById("friendcircle-comment-textarea").focus();
          });
         
         $('#friendcircle-comment-cancelsubmit').on('click',function(){
             var response = dom('friendcircle-comment-container');
              response.style.display = "none";
         });
         $('.circle-delete').on('click',function(){
             var coid = $(this).attr('data-coid');
             var confirms = confirm("是否删除这条朋友圈?");
             if(confirms == true){
                $("#circleDeleteLoad").fadeIn();
                $.ajax({
                        type: "POST",
                        async:true,
                        url: window.location.href,
                        data: {
                            "action": 'deleteCircle',
                            "coid":coid
                        },
                        dateType: "json",
                        success: function(url) {
                            $.ajax({
                        type: "GET",
                        async:true,
                        url: url,
                        dateType: "json",
                        success: function(json) {
                            
                            
                 $.ajax({
                        type: "POST",
                        async:true,
                        url: '<?php getCircleAction();?>',
                        data: {
                            "action": 'delete',
                            "coid":coid
                        },
                        dateType: "json",
                        success: function(json) {
                    
                            $('body').toast({
							    title:'删除成功',
							    class: 'success',
							    message: '您已成功删除，即将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							setTimeout(function() {
            window.location.reload();
            },2000);
                          
                            
                    
                        }
     });
     
     
                        },
                        error: function() {
                           alert('删除失败~');
                        }
                    });
                          
                            
                    
                        }
     });
                
                
                
                
                
                
                
             }
         });
         $('#friendcircle-comment-submit').on('click',function(){
             $("#friendcircle-comment-submit").css("pointer-events","none");
             $("#circleLoad").fadeIn();
             if(!$('#friendcircle-comment-nickname').val()){
                 $('body').toast({
							    title:'啊哦',
							    class: 'warning',
							    message: '您还没填写昵称！', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
				$("#circleLoad").fadeOut();
				$("#friendcircle-comment-submit").css("pointer-events","auto");
				return false;
             };
             if(!$('#friendcircle-comment-email').val()){
                 $('body').toast({
							    title:'啊哦',
							    class: 'warning',
							    message: '您还没填写邮箱！', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
				$("#circleLoad").fadeOut();
				$("#friendcircle-comment-submit").css("pointer-events","auto");
				return false;
             };
             $.ajax({
        url: '<?php editurl($this->commentUrl) ?>',
        type: 'POST',
        dataType: 'json',
        data: {
                            "author": $('#friendcircle-comment-nickname').val(),
                            "mail": $('#friendcircle-comment-email').val(),
                            "url": $('#friendcircle-comment-url').val(),
                            "text": $('#friendcircle-comment-textarea').val(),
                            "SecurityToken": $('#SecurityToken').val(),
                            "parent": window.localStorage.getItem('reply-coid'),
                        },
                        
        
        success: function(response) {
           $('body').toast({
							    title:'评论成功',
							    class: 'success',
							    message: '您已评论成功，将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							window.location.reload();
        },
        
        error: function(req, status, error) {
          var div = $('<div>');
        div.html(req.responseText);
        var content = div.find('.container');
        if(content.length > 0){
            $('body').toast({
							    title:'评论失败',
							    class: 'error',
							    message: content.text(), 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
           $("#friendcircle-comment-submit").css("pointer-events","auto");
           $("#circleLoad").fadeOut();
        }
        else{
         $('body').toast({
							    title:'评论成功',
							    class: 'success',
							    message: '您已评论成功，将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
         window.location.reload();
        }
        }
    });
    
    
         });
         
         
      });
      <?php
    $phpMaxFilesize = function_exists('ini_get') ? trim(ini_get('upload_max_filesize')) : 0;

if (preg_match("/^([0-9]+)([a-z]{1,2})$/i", $phpMaxFilesize, $matches)) {
    $phpMaxFilesize = strtolower($matches[1] . $matches[2] . (1 == strlen($matches[2]) ? 'b' : ''));
}
    ?>

		var uploader = new plupload.Uploader({
				runtimes: 'html5,flash,silverlight,html4',
				browse_button: 'btn',
				url: "<?php $this->security->index('/action/upload?cid='.$this->cid);?>",
				flash_swf_url   :   '<?php AssetsDir();?>assets/vendors/friendcircle/Moxie.swf',
            filters         :   {
                max_file_size       :   '<?php echo $phpMaxFilesize;?>',
                mime_types          :   [{'title' : '允许上传的文件', 'extensions' : 'gif,jpg,jpeg,png,bmp,webp'}],
                prevent_duplicates  :   false
            },
				multi_selection: false, 
				init: {
					FilesAdded: function(up, files) { //文件上传前
						if (up.files.length > 9) {
							alert("抱歉，仅能上传9张图片~");
							uploader.destroy();
						} else {
							var li = '';
							plupload.each(files, function(file) { //遍历文件
								li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
							});
							$("#ul_pics").append(li);
							uploader.start();
						}
					},
					UploadProgress: function(up, file) { 
						var percent = file.percent;
						$("#" + file.id).find('.bar').css({
							"width": percent + "%"
						});
						$("#" + file.id).find(".percent").text(percent + "%");
					},
					FileUploaded: function(up, file, info) {
						var data = eval("(" + info.response + ")");
						$("#" + file.id).html("<div class='img'><img data-fancybox='image' src='" + data[0] + "'/><input name='image' value='" + data[0] + "' style='display:none'></div>");
					},
					Error: function(up, err) {
						alert(err.message);
					}
				}
			});
			uploader.init();
			
			
		
    
$(function () {

    getCommentInfo();

function getCookie(name){
    const strcookie = document.cookie;
    const arrcookie = strcookie.split("; ");
    for (let i = 0; i < arrcookie.length; i++) {
        const arr = arrcookie[i].split("=");
        if (arr[0] === name){
            return arr[1];
        }
    }
    return "";
};
function getCommentInfo(){
    let nick = document.getElementById('friendcircle-comment-nickname');
    let mail = document.getElementById('friendcircle-comment-email');
    let url = document.getElementById('friendcircle-comment-url');
    let nick_value = decodeURIComponent(getCookie('<?php echo Typecho_Cookie::getPrefix()?>__typecho_remember_author'));
    let mail_value = decodeURIComponent(getCookie('<?php echo Typecho_Cookie::getPrefix()?>__typecho_remember_mail'));
    let url_value = decodeURIComponent(getCookie('<?php echo Typecho_Cookie::getPrefix()?>__typecho_remember_url'));
    if (nick && nick_value!== 'null') nick.value = nick_value;
    if (mail && mail_value!== 'null') mail.value = mail_value;
    if (url && url_value!== 'null') url.value = url_value;
    $.post('<?php getIsLogin(); ?>',{action:'find'},function (res) {
        res = JSON.parse(res);
        switch(res.code){
            case 0 :
        $('#loginshowlabel').hide();
    $('#nologinshow').show();
    break;
    case 1 :
        $('#friendcircle-add').fadeIn();
        $('.circle-delete').fadeIn();
        $('#loginshowlabel').show();
    $('#nologinshow').hide();
    $('#authorname').html(res.name);
    break;
        }
    });



     $.post('<?php getCommentAction(); ?>',{action:'getCommentToken'},function (res) {
         res = JSON.parse(res);
         if(res.code == 1){
        var tokenInput=$("<input type=\"hidden\" name=\"SecurityToken\"  id=\"SecurityToken\">");
tokenInput.attr("value", res.token);
$("#commentform").append(tokenInput);
         }
    })
}



function closeForm() {
  $('.friendcircle-popup').removeClass('is-visible');
}


$('#getMap').on('click', function (event) {
    $('#getMap').html('正在获取您的位置，请稍等...');
    $('#getMap').css("pointer-events","none");
    $.post(window.location.href,{action:'getmap'},function (res) {
        $('#getMap').html(res);
        $('#getMapInput').val(res);
    });
});
  
  $('#friendcircle-add').on('click', function () {
 
    $('.friendcirclex').addClass('is-visible');
    document.getElementById("text").focus();
   
  });


  $('.friendcircle-popup').on('click', function (event) {
    if ($(event.target).is('.friendcircle-popup-close') || $(event.target).is('.friendcircle-popup')) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });

 
  $(document).keyup(function (event) {
    if (event.which == '27') {
      $('.friendcircle-popup').removeClass('is-visible');
    }
  });


function undatakey(formdata,name)
{
    result = '';
    for(var i in formdata.split("&")){
        var row = formdata.split("&")[i];
        var key = row.split("=")[0];
        var value = row.split("=")[1];
        if(key != name){
            result = result + row + "&";
        }
    }
    
    return result;
}


$('#commentform').submit(function(e) {
    e.preventDefault();
    var formData = undatakey($('#commentform').serialize(),'image').slice(0, -1);
var resources = '';
$('input[name=image]').each(function () {
   resources +=  $(this).val()+',';
});
$("#commentform").css("pointer-events","none");
             $("#circleSendLoad").fadeIn();
             
             
    if(!$('#text').val()){
                 $('body').toast({
							    title:'啊哦',
							    class: 'warning',
							    message: '动态内容不能为空哦！', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
$("#commentform").css("pointer-events","auto");
             $("#circleSendLoad").fadeOut();	
             return false;
    };					
    $.ajax({
        url: '<?php editurl($this->commentUrl) ?>',
        type: 'POST',
        dataType: 'json',
        data: formData+ '&resources=' + encodeURIComponent(resources.substring(0,resources.length -1)),
        
        success: function(response) {
           $('body').toast({
							    title:'发表成功',
							    class: 'success',
							    message: '您已发表成功，将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							window.location.reload();
        },
        
        error: function(req, status, error) {
          var div = $('<div>');
        div.html(req.responseText);
        var content = div.find('.container');
        if(content.length > 0){
        $("#commentform").css("pointer-events","auto");
             $("#circleSendLoad").fadeOut();
         $('body').toast({
							    title:'发表失败',
							    class: 'error',
							    message: content.text(), 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
        }
        else{
         $('body').toast({
							    title:'发表成功',
							    class: 'success',
							    message: '您已发表成功，将自动刷新~', 
							    showIcon: 'grin beam outline',
							    showProgress: 'top',
							});
							window.location.reload();
        }
        }
    });
});




 
});

    </script>
<script>

	$(function() {

$('.friendcircle-icons a').on('click', function( event ) {
				event.preventDefault();
			});

			$('div[data-toolbar="friendcircle-actions"]').toolbar({
			    content: '#friendcircle-actions',
			    position: 'left',
			});


		});
</script>


<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>

    
             
<?php $this->need('compoment/foot.php'); ?>