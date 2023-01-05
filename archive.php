<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php $this->need('compoment/head.php');?>
<?php if(Bsoptions('Diy') == true) :?>

<?php $this->need('pages/diy-archive.php'); ?>

  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>

<?php $this->need('pages/archive.php'); ?>

  <?php endif; ?>

<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>