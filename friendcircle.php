<?php
    /**
    * 朋友圈
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>
   
<link href="<?php AssetsDir();?>assets/vendors/friendcircle/friendcircle.css" rel="stylesheet" type="text/css">
<link href="<?php AssetsDir();?>assets/vendors/bs-emoji/bs-emoji.css" rel="stylesheet" type="text/css">

<?php
$parameter= array(
   'parentId'      => $this->hidden ? 0 : $this->cid,
   'parentContent' => $this->row,
   'respondId'     => $this->respondId,
   'commentPage'   => $this->request->filter('int')->commentPage,
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
        <button class="friendcircle-add" id="friendcircle-add" style="display:none">发表动态</button>
        
    
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
			if(json.likeUser!=='' && json.likeVisitor !== null){
			    json.likeVisitor = '，'+json.likeVisitor;
			}
			else{
			    json.likeVisitor = '';
			}
		   if(!$("#friendcircle-comments-"+coid).length){
		       $("#friendcircle-action-"+coid).after('<div class="friendcircle-comments" id="friendcircle-comments-'+coid+'"><span id="friendcircle-comments-like-'+coid+'"><i class="heart outline icon"></i> '+json.likeUser+'，'+json.likeVisitor+'</span></div>');
		   }
		   if($("#friendcircle-comments-"+coid).length && !$("#friendcircle-comments-like-"+coid).length){
			$("#friendcircle-comments-"+coid).prepend('<span id="friendcircle-comments-like-'+coid+'"><i class="heart outline icon"></i> '+json.likeUser+'，'+json.likeVisitor+'</span><hr>');
			}
			if($("#friendcircle-comments-"+coid).length && $("#friendcircle-comments-like-"+coid).length){
			$("#friendcircle-comments-like-"+coid).empty().html('<i class="heart outline icon"></i> '+json.likeUser+json.likeVisitor);
			}
			
			
			
				
        },
        
        error: function(req, status, error) {
          $('body').toast({
							    title:'点赞失败',
							    class: 'success',
							    message: '您已点赞成功~', 
							    showIcon: 'grin beam outline',
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
          });
          $('.circle-comment').on('click',function(){
              var response = dom('friendcircle-comment-container');
              var com = dom('comment-'+window.localStorage.getItem('reply-coid'));
             $("#friendcircle-comment-textarea").attr("placeholder", "回复<?php echo $this->author->screenName;?>:");
                com.appendChild(response).style.display = "block";
          });
         
         $('#friendcircle-comment-cancelsubmit').on('click',function(){
             var response = dom('friendcircle-comment-container');
              response.style.display = "none";
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
				url: "<?php $this->security->index('/action/upload');?>",
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