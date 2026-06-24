<?php
/**
 * BearSimple 主题引导文件
 *
 * 由 functions.php 在主题加载时统一引入。
 * 集中加载通用 Helper 与核心 Service，避免在调用点散落 require_once。
 *
 * 使用：
 *   bs_load('helper', 'functions');   // 加载 src/Helpers/functions.php
 *   bs_load('service', 'CommentService');
 *   bs_load('controller', 'AjaxController');
 */

if (!defined('BS_BOOTSTRAPPED')) {
    define('BS_BOOTSTRAPPED', true);
}

require_once __DIR__ . '/paths.php';

// 通用工具（按使用频度排序，热路径靠前）
bs_load('helper', 'functions');      // 核心函数库（原 core/func.php）
bs_load('helper', 'general');        // 通用函数
bs_load('helper', 'parser');         // 解析器（原 core/parse.php）
bs_load('helper', 'http-client');    // HTTP 客户端（原 core/curl.php）
bs_load('helper', 'gravatar');       // Gravatar 头像
bs_load('helper', 'assets');         // 资源路径
bs_load('helper', 'layout');         // 布局助手（列宽/资产 URL/网格包装）
bs_load('helper', 'compress-html');  // HTML 压缩
bs_load('helper', 'analytics');      // 统计（原 core/tongji.php）
bs_load('helper', 'security-check'); // 安全检测
bs_load('helper', 'encryptor');      // 加密
bs_load('helper', 'user-center');    // 用户中心辅助
bs_load('helper', 'browser');        // 浏览器检测
bs_load('helper', 'os');             // 操作系统检测
bs_load('helper', 'utility');        // 杂项工具
bs_load('helper', 'pinyin');         // 拼音处理

// 核心 Widget（被多个 Controller 依赖，提前加载避免重复判断）
bs_load('widget', 'DomWidget');
