<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
?>
<?php $this->need('header.php'); ?>
<?php if($this->options->Diy == '1') :?>

<?php $this->need('pages/diy-page.php'); ?>

  <?php endif; ?>

<?php if($this->options->Diy == '2' || empty($this->options->Diy)) :?>

<?php $this->need('pages/page.php'); ?>

  <?php endif; ?>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
