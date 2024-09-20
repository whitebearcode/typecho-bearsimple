<?php
/**
 * 简洁清新淡雅，让写作回归内容本身<br><font color=red>建议PHP版本: 8.3<br>暂不支持Typecho v1.3<br>目前最高支持版本Typecho v1.2.1 正式版</font>
 * @package BearSimple 
 * @author BearNotion
 * @version v2.7.7-release
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
