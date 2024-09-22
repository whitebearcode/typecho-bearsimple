<?php
/**
 * 简洁清新淡雅，让写作回归内容本身<br><font color=red>建议使用PHP8.3，低于PHP8可能会出现报错<br>已初步适配Typecho v1.3，若有问题请及时反馈~</font>
 * @package BearSimple 
 * @author BearNotion
 * @version v2.7.8-release
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
