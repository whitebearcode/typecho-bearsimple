<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * Partial: SEO meta tags
 *
 * 用法（在 head 区域）：<?php $this->need('templates/partials/seo-meta.php'); ?>
 *
 * 输出 OG/Twitter/标准 meta 标签 + Canonical + JSON-LD。
 * 数据来源：当前归档/文章/页面 + 主题设置。
 */
?>
<?php if (!defined('BS_PARTIAL_SEO_META')):
    define('BS_PARTIAL_SEO_META', 1);
    $title = $this->title();
    $description = $this->is('single') && $this->fields->seo_dec
        ? $this->fields->seo_dec
        : ($this->is('category') && $this->getDescription() !== null
            ? $this->getDescription()
            : Helper::options()->description);
    $url = $this->permalink();
?>
<meta name="description" content="<?php echo htmlspecialchars((string)$description, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:title" content="<?php echo htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars((string)$description, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars((string)$url, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:type" content="<?php echo $this->is('single') ? 'article' : 'website'; ?>">
<meta property="og:site_name" content="<?php echo htmlspecialchars((string)Helper::options()->title, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="canonical" href="<?php echo htmlspecialchars((string)$url, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>
