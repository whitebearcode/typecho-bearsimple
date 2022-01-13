<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if($this->options->Diy == '1') :?>

<?php $this->need('pages/diy-sidebar.php'); ?>

  <?php endif; ?>

<?php if($this->options->Diy == '2' || empty($this->options->Diy)) :?>

<?php $this->need('pages/sidebar.php'); ?>

  <?php endif; ?>