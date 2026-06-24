<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * Partial: Pagination 通用分页导航
 *
 * 用法：<?php $this->need('templates/partials/pagination.php'); ?>
 *
 * 替代每个模板中重复的分页 <nav> 块。
 * 调用前需设置 $bs_pagination_prev / $bs_pagination_next，或依赖 $this 上下文。
 */
?>
<?php if (!defined('BS_PARTIAL_PAGINATION')):
    define('BS_PARTIAL_PAGINATION', 1);
    $prevUrl = isset($bs_pagination_prev) ? $bs_pagination_prev : null;
    $nextUrl = isset($bs_pagination_next) ? $bs_pagination_next : null;
?>
<nav class="bs-pagination" aria-label="分页导航">
    <?php if ($prevUrl): ?>
        <a class="bs-page-link bs-page-prev" href="<?php echo $prevUrl; ?>" rel="prev">« 上一页</a>
    <?php endif; ?>
    <span class="bs-page-current"><?php echo $this->_currentPage(); ?></span>
    <?php if ($nextUrl): ?>
        <a class="bs-page-link bs-page-next" href="<?php echo $nextUrl; ?>" rel="next">下一页 »</a>
    <?php endif; ?>
</nav>
<?php endif; ?>
