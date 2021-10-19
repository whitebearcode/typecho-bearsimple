<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');

  ?>
<?php if($this->options->Diy == '1') :?>

<?php $this->need('pages/diy-archive.php'); ?>

  <?php endif; ?>

<?php if($this->options->Diy == '2' || empty($this->options->Diy)) :?>

<?php $this->need('pages/archive.php'); ?>

  <?php endif; ?>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>