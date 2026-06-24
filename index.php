<?php
/**
 * 简洁清新淡雅，让写作回归内容本身<br><font color=red>建议使用PHP8.2，低于PHP8可能会出现报错<br>已适配Typecho v1.3，若有兼容性问题请及时反馈~</font>
 * @package BearSimple 
 * @author BearNotion
 * @version v2.9.9-release
 * @link https://www.bearnotion.ru/
 * 
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('templates/layouts/header.php');
  ?>


<?php $this->need('templates/pages/index-content.php'); ?>


<?php $this->need('templates/layouts/sidebar.php'); ?>
<?php $this->need('templates/layouts/footer.php'); ?>
