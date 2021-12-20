<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
if (isset($_POST['agree'])) {
    if ($_POST['agree'] == $this->cid) {
        exit(agree($this->cid));
    }
    exit('error');
}
?>
<?php $this->need('header.php');
?>
<?php if($this->options->Diy == '1') :?>

<?php $this->need('pages/diy-post.php'); ?>

  <?php endif; ?>

<?php if($this->options->Diy == '2' || empty($this->options->Diy)) :?>

<?php $this->need('pages/post.php'); ?>

  <?php endif; ?>
<script type='text/javascript'>
document.body.oncopy = function() {toastr.success('复制成功,若要转载请务必保留原文链接！');   };

$(document).ready(function(){
  $("#smallsize").click(function(event){
    event.preventDefault();
    $(".post-content").animate({"font-size":"14px"});
  });
  $("#middlesize").click(function(event){
    event.preventDefault();
    $(".post-content").animate({"font-size":"24px"});
    
  });
  
  $("#bigsize").click(function(event){
    event.preventDefault();
    $(".post-content").animate({"font-size":"34px"});
  });
});
</script>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>


