<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
?>
<?php $this->need('header.php'); ?>
<?php if($this->options->Diy == '1') :?>

<?php $this->need('pages/diy-post.php'); ?>

  <?php endif; ?>

<?php if($this->options->Diy == '2' || empty($this->options->Diy)) :?>

<?php $this->need('pages/post.php'); ?>

  <?php endif; ?>
<script type='text/javascript'>
document.body.oncopy = function() {layer.msg('复制成功,若要转载请务必保留原文链接！');};

$(document).ready(function(){
  $("#smallsize").click(function(event){
    event.preventDefault();
    $(".post-content h1").animate({"font-size":"24px"});
    $(".post-content h2").animate({"font-size":"16px"});
    $(".post-content h3").animate({"font-size":"8px"});
    $(".post-content p").animate({"font-size":"12px"});
  });
  $("#middlesize").click(function(event){
    event.preventDefault();
    $(".post-content h1").animate({"font-size":"34px"});
    $(".post-content h2").animate({"font-size":"26px"});
    $(".post-content h3").animate({"font-size":"18px"});
    $(".post-content p").animate({"font-size":"20px"});
    
  });
  
  $("#bigsize").click(function(event){
    event.preventDefault();
    $(".post-content h1").animate({"font-size":"44px"});
    $(".post-content h2").animate({"font-size":"36px"});
    $(".post-content h3").animate({"font-size":"28px"});
    $(".post-content p").animate({"font-size":"26px"});
  });
});
</script>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>


