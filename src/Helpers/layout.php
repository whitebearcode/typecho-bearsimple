<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 布局助手
 *
 * 提供跨模板复用的布局相关辅助函数：
 * - bs_content_columns()        公共网格列宽类
 * - bs_asset_url()              带版本号的资源 URL
 * - bs_page_wrapper_open()      开启标准页面网格
 * - bs_page_wrapper_close()     关闭标准页面网格
 * - bs_theme_version()          主题版本号（缓存到静态变量）
 *
 * 命名空间：bs_*  (BearSimple)
 */

if (!function_exists('bs_content_columns')) {
    /**
     * 返回内容列的 pure.css 类
     *
     * 逻辑：site_style == '2' 时使用 4-4 列；其余使用 3-4 列
     * 原模板中 17+ 处重复了此内联三元表达式
     */
    function bs_content_columns(): string
    {
        $style = (string) Bsoptions('site_style', '1');
        $span = ($style === '2') ? '4' : '3';
        return "pure-u-1 pure-u-md-{$span}-4";
    }
}

if (!function_exists('bs_asset_url')) {
    /**
     * 生成带版本号的资源 URL
     *
     * 用法：<?php echo bs_asset_url('assets/styles/main.css'); ?>
     * 输出：/usr/themes/bearsimple/assets/styles/main.css?v=2.9.9.20250803
     *
     * 消除模板中重复的 AssetsDir() + ?v= + themeVersion() 三段
     */
    function bs_asset_url(string $path): string
    {
        return AssetsDir() . $path . '?v=' . themeVersion();
    }
}

if (!function_exists('bs_page_wrapper_open')) {
    /**
     * 输出标准页面网格的开启标签
     *
     * 等价于：
     *   <div class="pure-g" id="layout">
     *     <div class="pure-u-1 pure-u-md-? -4">
     *       <div class="content_container">
     *
     * 后续由模板输出实际 page-card 内容
     */
    function bs_page_wrapper_open(): void
    {
        echo '<div class="pure-g" id="layout">' . "\n";
        echo '    <div class="' . bs_content_columns() . '">' . "\n";
        echo '        <div class="content_container">' . "\n";
    }

    /**
     * 输出标准页面网格的关闭标签
     */
    function bs_page_wrapper_close(): void
    {
        echo "        </div>\n";
        echo "    </div>\n";
        echo "</div>\n";
    }
}

if (!function_exists('bs_theme_version')) {
    /**
     * 缓存版本号（减少函数调用）
     */
    function bs_theme_version(): string
    {
        static $version = null;
        return $version ??= themeVersion();
    }
}
