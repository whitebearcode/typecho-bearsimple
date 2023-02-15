<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if(Bsoptions('Diy') == true) :?>

<?php $this->need('pages/diy-sidebar.php'); ?>

  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>

<?php $this->need('pages/sidebar.php'); ?>

  <?php endif; ?>