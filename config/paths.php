<?php
/**
 * BearSimple 主题路径配置
 *
 * 集中管理所有目录路径，避免在多个文件中硬编码字符串。
 * 修改目录结构时只需更新此文件。
 */

if (!defined('BS_THEME_ROOT')) {
    define('BS_THEME_ROOT', __DIR__ . '/..');
}

// 分层路径
defined('BS_PATH_TEMPLATES') or define('BS_PATH_TEMPLATES', '/templates');
defined('BS_PATH_SRC') or define('BS_PATH_SRC', '/src');
defined('BS_PATH_MODULES') or define('BS_PATH_MODULES', '/modules');
defined('BS_PATH_ASSETS') or define('BS_PATH_ASSETS', '/assets');
defined('BS_PATH_CONFIG') or define('BS_PATH_CONFIG', '/config');
defined('BS_PATH_STORAGE') or define('BS_PATH_STORAGE', '/storage');

// 业务层子目录
defined('BS_PATH_HELPERS') or define('BS_PATH_HELPERS', BS_PATH_SRC . '/Helpers');
defined('BS_PATH_SERVICES') or define('BS_PATH_SERVICES', BS_PATH_SRC . '/Services');
defined('BS_PATH_CONTROLLERS') or define('BS_PATH_CONTROLLERS', BS_PATH_SRC . '/Controllers');
defined('BS_PATH_WIDGETS') or define('BS_PATH_WIDGETS', BS_PATH_SRC . '/Widgets');
defined('BS_PATH_INTEGRATIONS') or define('BS_PATH_INTEGRATIONS', BS_PATH_SRC . '/Integrations');
defined('BS_PATH_MODELS') or define('BS_PATH_MODELS', BS_PATH_SRC . '/Models');

// 表现层子目录
defined('BS_PATH_LAYOUTS') or define('BS_PATH_LAYOUTS', BS_PATH_TEMPLATES . '/layouts');
defined('BS_PATH_PAGES') or define('BS_PATH_PAGES', BS_PATH_TEMPLATES . '/pages');
defined('BS_PATH_PARTIALS') or define('BS_PATH_PARTIALS', BS_PATH_TEMPLATES . '/partials');

// 资源子目录
defined('BS_PATH_STYLES') or define('BS_PATH_STYLES', BS_PATH_ASSETS . '/styles');
defined('BS_PATH_SCRIPTS') or define('BS_PATH_SCRIPTS', BS_PATH_ASSETS . '/scripts');
defined('BS_PATH_MEDIA') or define('BS_PATH_MEDIA', BS_PATH_ASSETS . '/media');
defined('BS_PATH_VENDOR') or define('BS_PATH_VENDOR', BS_PATH_ASSETS . '/vendor');

/**
 * 加载 src/ 下的 Helpers 与 Services（按需）
 *
 * 替代原 core/func.php、core/general.php 等散落的 require_once。
 */
if (!function_exists('bs_load')) {
    function bs_load(string $type, string $name): void
    {
        static $map = [
            'helper'    => BS_PATH_HELPERS,
            'service'   => BS_PATH_SERVICES,
            'controller' => BS_PATH_CONTROLLERS,
            'widget'    => BS_PATH_WIDGETS,
        ];
        $dir = $map[$type] ?? null;
        if ($dir === null) {
            return;
        }
        $file = __DIR__ . '/..' . $dir . '/' . $name . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
}
