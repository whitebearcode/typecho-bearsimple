<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * Partial: 页脚脚本与统计
 *
 * 用法：<?php $this->need('templates/partials/footer-scripts.php'); ?>
 *
 * 集中输出公共脚本块，消除每个模板底部重复的 <script> 与统计。
 */
?>
<?php if (!defined('BS_PARTIAL_FOOTER_SCRIPTS')):
    define('BS_PARTIAL_FOOTER_SCRIPTS', 1);
?>
<script src="<?php echo bs_asset_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo bs_asset_url('assets/scripts/app.bundle.min.js'); ?>"></script>
<?php if (function_exists('tongji') && Bsoptions('TongjiEnable') == true): ?>
    <?php echo tongji(); ?>
<?php endif; ?>
<?php endif; ?>
