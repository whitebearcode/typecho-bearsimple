<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
?>
<?php $this->need('compoment/head.php');?>

<?php if(Bsoptions('Diy') == true) :?>
<?php $this->need('pages/diy-post.php'); ?>
  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>
<?php $this->need('pages/post.php'); ?>
  <?php endif; ?>
<?php if(Bsoptions('Readmode') == true): ?>  
<?php $this->need('modules/readmode.php'); ?>
  <?php endif; ?>


<script type="text/javascript" src="<?php AssetsDir();?>assets/js/bearsimple_single.js?v=<?php  echo themeVersion(); ?>"></script>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>


