<?php
/**
 * 简洁清新淡雅，让写作回归内容本身
 * @package BearSimple 
 * @author WhiteBear
 * @version v2.2.8-release
 * @link https://www.bearnotion.ru/
 * 
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('compoment/head.php');

  ?>

<?php if(Bsoptions('Diy') == true) :?>

<?php $this->need('pages/diy-index.php'); ?>

  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>

<?php $this->need('pages/index-z.php'); ?>

  <?php endif; ?>

<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>
