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
document.body.oncopy = function() {layer.msg('复制成功,若要转载请务必保留原文链接！', function(){});}; 
</script>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>


