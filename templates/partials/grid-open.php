<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * Partial: 页面网格开启
 *
 * 用法：
 *   <?php $this->need('templates/layouts/header.php'); ?>
 *   <?php $this->need('templates/partials/grid-open.php'); ?>
 *   <div class="page-card"> ... </div>
 *   <?php $this->need('templates/partials/grid-close.php'); ?>
 *   <?php $this->need('templates/layouts/sidebar.php'); ?>
 *   <?php $this->need('templates/layouts/footer.php'); ?>
 *
 * 输出：
 *   <div class="pure-g" id="layout">
 *     <div class="pure-u-1 pure-u-md-{3|4}-4">
 *       <div class="content_container">
 *
 * 列宽根据主题设置 site_style 自动适配。
 */
?>
<?php bs_page_wrapper_open(); ?>
