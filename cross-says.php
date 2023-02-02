<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
?>
<link rel="stylesheet" href="//deliver.application.pub/npm/@fancyapps/ui@4.0/dist/fancybox.css"
    />
<?php if($this->user->hasLogin()): ?>
<?php if(Bsoptions('Emoji') == true) :?>
  <link href="<?php AssetsDir();?>assets/vendors/bs-emoji/bs-emoji.css" rel="stylesheet" type="text/css">
  <?php endif; ?>
<div id="comments" class="ui comments" style="display:none;">
   
    	<form method="post" action="<?php $this->commentUrl() ?>" id="commentform" role="form" class="ui reply form">
      <div class="field">

<div class="ui mini basic icon buttons" style="float:right">
  <div class="ui button" id="insertimg"><i class="image icon" data-content="插入图片短代码"></i></div>
  <div class="ui button" id="insertimgs"><i class="images icon" data-content="插入相册短代码"></i></div>
  <div class="ui button" id="insertmark"><i class="bookmark icon" data-content="插入文字标记短代码"></i></div>
    <div class="ui button" id="insertruby"><i class="language icon" data-content="插入文字注音短代码"></i></div>
</div>
<input name="type" id="type" style="display:none" value="cross">
                <textarea rows="5" cols="30" name="text" id="textarea" placeholder="写一写你的最近动态~"<?php if(Bsoptions('Emoji') == true) :?> class="emotion"<?php endif; ?> required ><?php $this->remember('textarea'); ?></textarea>
            </div>
<?php if(Bsoptions('Emoji') == true) :?>
    <div class="circular ui icon button" id="facecross">

  <i class="smile beam outline icon"></i>
 </div>
 <div id="emoemo" class="notranslate" style="margin-top:-40px;margin-bottom:10px"></div>
 <?php endif; ?>
                <button type="submit" class="ui mini labeled submit icon  button" style="float:right"><i class="location arrow icon"></i><?php _e('发表动态'); ?></button>
           
    	</form>
    	</div>

    	 <?php endif; ?>
<br>
<?php function threadedComments($comments, $options) {
    $bsoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
 ?>
<div class="bs-timeline-block" id="<?php $comments->theId(); ?>">
			<div class="bs-timeline-img">
	<img src="<?php echo imgravatarq($comments->mail); ?>">		    
     	</div>
			<div class="bs-timeline-content break">
			    <?php $comments->date('Y-m-d H:i'); ?>
			    <hr class="crosshr">
       	<p> 
       	<?php echo ParseCross(reEmo($comments->content,'comment')); ?>	</p>
       	<?php if($bsoptions['Comment_like'] == true || $bsoptions['Comment_useragent'] == true):?>
      <hr class="crosshr">
   <?php endif; ?>
			    <?php if($bsoptions['Comment_like'] == true): ?>
	    	 <?php $agree = $options->hidden?array('agree' => 0, 'recording' => true):agreeNumforcomment($comments->coid);?>
        <div style="float:left">
          <i id="commentlike" class="like thumbs up red link icon" data-coid="<?php echo $comments->coid; ?>"></i><span class="agreenumcomment<?php echo $comments->coid; ?>"><?php echo $agree['agree']; ?></span>
        </div>
        <?php endif; ?>
        <?php if($bsoptions['Comment_useragent'] == true): ?>
         <div style="float:right"> <?php BearsimpleUserAgent::render($comments->agent); ?></div>
         <?php endif; ?>
    	</div>
    	
		</div>
<?php } ?>
     <?php $this->comments()->to($comments); ?>
     <?php if($this->commentsNum == '0'):?>
     <br>
     <article class="post">
        <center><svg t="1617683554811" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2629" width="200" height="200"><path d="M817.152 346.112c0-12.8-10.752-23.552-23.552-23.552h-28.672v281.6l-181.76 182.272H361.472v15.36c0 12.8 10.752 23.552 23.552 23.552l254.976-2.56 180.224-184.32-3.072-292.352z" fill="#E3EAED" p-id="2630"></path><path d="M332.8 705.536H258.56c-18.432 0-32.768-14.336-32.768-32.768V223.232c0-18.432 14.336-32.768 32.768-32.768H604.16c4.608 0 9.216 4.096 9.216 9.216 0 4.608-4.096 9.216-9.216 9.216H258.56c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336H332.8M686.08 299.52v-51.2c0-4.608 4.096-9.216 9.216-9.216 4.608 0 9.216 4.096 9.216 9.216v51.2" fill="#D3DBDE" p-id="2631"></path><path d="M608.768 797.184H350.208c-18.432 0-32.768-14.336-32.768-32.768V315.392c0-18.432 14.336-32.768 32.768-32.768h413.184c18.432 0 32.768 14.336 32.768 32.768v294.912l-187.392 186.88z m-258.56-496.64c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336h251.392l176.128-176.128v-286.72c0-7.68-6.656-14.336-14.336-14.336H350.208z" fill="#D3DBDE" p-id="2632"></path><path d="M601.088 778.752l177.152-176.128V322.56H394.752c-12.8 0-23.552 11.264-23.552 24.576v431.616h229.888z" fill="#F2F5F7" p-id="2633"></path><path d="M613.888 788.992h-18.432v-110.08c0-44.032 36.352-80.384 80.384-80.384h103.936v17.92H675.84c-34.304 0-62.464 27.648-62.464 62.464l0.512 110.08z m45.056-350.72H453.12c-6.656 0-12.288-5.632-12.288-12.288 0-6.656 5.632-12.288 12.288-12.288h205.824c6.656 0 12.288 5.632 12.288 12.288 0 7.168-5.632 12.288-12.288 12.288z m0-11.776v6.144-6.144z m1.536 71.168H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m0 71.68H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m-10.752-451.072c-5.12 0-9.216 4.096-9.216 9.216v61.44c0 5.12 4.096 9.216 9.216 9.216 4.608 0 9.216-4.096 9.216-9.216v-61.44c0-4.608-4.096-9.216-9.216-9.216z m114.688 17.408c-4.096-3.072-9.728-2.048-12.8 2.048l-35.84 49.664c-3.072 4.096-2.048 9.728 2.048 12.8 2.048 1.024 3.584 2.048 5.632 2.048 3.072 0 5.632-1.024 7.168-3.584l35.84-49.664c2.56-4.608 2.048-10.24-2.048-13.312z m58.88 71.168c-2.048-5.12-7.168-6.656-12.288-4.096l-55.296 25.6c-5.12 2.048-6.656 7.168-4.096 12.288 2.048 3.584 5.12 5.632 8.704 5.632 1.024 0 2.56 0 3.584-0.512l55.296-25.6c4.096-3.584 6.144-8.704 4.096-13.312z" fill="#D3DBDE" p-id="2634"></path></svg></center>
                <center><h2>暂无动态</h2></center>
            </article>
     <?php else:?>
         <section id="bs-timeline" class="bs-container nosearch">
     <?php
      ob_start();
   $comments->listComments();
   $comments_content = ob_get_contents();
      ob_end_clean();
   $comments_content = preg_replace("/<ol class=\"comment-list\">/sm", '', $comments_content);
   $comments_content = preg_replace("/<\/ol>/sm", '', $comments_content);
   echo $comments_content;
   ?>
</section>

<?php endif; ?>
    <?php
      ob_start(); 
      $comments->pageNav('&laquo;','&raquo;', 1, '');
      $content = ob_get_contents();
      ob_end_clean();
      if(Bsoptions('pagination_style') == '2'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<nav class="page-navigator">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<span class="page-number">...</span>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1">下一页</a>', $content);
      //适配旧版本
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1">下一页</a>', $content);
      ///--->
      $content = preg_replace("/<\/ol>/sm", '</nav>', $content);
      }
      if(empty(Bsoptions('pagination_style')) || Bsoptions('pagination_style') == '1'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<div class="ui circular labels" style="margin-top:30px"><div style="text-align:center">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<a class="ui large label">...</a>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui blue large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      //旧版本兼容
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui blue large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      
      $content = preg_replace("/<\/ol>/sm", '</div></div>', $content);
      }
      echo $content;
     ?>
<script>
$.getScript('//deliver.application.pub/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js',function(){
  Fancybox.bind('[data-fancybox="single"]', {
      groupAttr: false,
});
  Fancybox.bind('[data-fancybox="gallery"]', {
});
});
$(document).ready(function(){
$('#insertimg').on('click',function(){
insert('[bsimg]图片直链，带http(s)://[/bsimg]\n');
});
$('#insertmark').on('click',function(){
insert('[bsmark]要标注的文字[/bsmark]\n');
});
$('#insertruby').on('click',function(){
insert('[bsruby]要注音的文字[/bsruby]\n');
});
$('#insertimgs').on('click',function(){
insert('[bsgallery title="相册名"]\n[bsimg title="图片标题1"]图片1直链[/bsimg]\n[bsimg title="图片标题2"]图片2直链[/bsimg]\n[bsimg title="图片标题3"]图片3直链[/bsimg]\n[/bsgallery]\n');
});
function insert(tag) {
					var myField;
					if (document.getElementById('textarea') && document.getElementById('textarea').type == 'textarea') {
						myField = document.getElementById('textarea');
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
});
</script>
<?php if(Bsoptions('Compress') == true) :?></nocompress><?php endif; ?>