<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
?>
<?php $this->need('header.php');
?>
<?php if($this->options->Diy == '1') :?>

<?php $this->need('pages/diy-post.php'); ?>

  <?php endif; ?>

<?php if($this->options->Diy == '2' || empty($this->options->Diy)) :?>

<?php $this->need('pages/post.php'); ?>

  <?php endif; ?>
<?php if($this->options->Readmode == "1"): ?> 
<?php $this->need('modules/readmode.php'); ?>
  <?php endif; ?>


<script type="text/javascript" src="<?php AssetsDir();?>assets/js/bearsimple_single.js?v=<?php  echo themeVersion(); ?>"></script>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>


