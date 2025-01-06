<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="comment-card">
<h3 class="ui header">

  <i class="comment alternate outline icon"></i>评论区
</h3>
<br>
<link href="<?php echo Bsoptions('artalk_backend');?>/dist/Artalk.css" rel="stylesheet" />

<div id="Comments"></div>
<script>
$(function(){
    $.getScript('<?php echo Bsoptions('artalk_backend');?>/dist/Artalk.js',function(){
       Artalk.init({
  el:        '#Comments',
  pageKey:   '<?php echo $this->permalink;?>',
  pageTitle: '',
  server:    '<?php echo Bsoptions('artalk_backend');?>',
  site:      '<?php echo Bsoptions('artalk_sitename');?>',
}); 
    })
    
    
})

</script>
    </div>
    
</div>


</div>