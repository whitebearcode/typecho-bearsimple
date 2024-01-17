<?php

use Typecho\Common;
use Typecho\Plugin;
use Utils\Helper;
use Typecho\I18n;
use Widget\Themes\Config;

if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Setup Class
 * 入口文件
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if (!defined('WP_PLUGIN_URL')){
    define('WP_PLUGIN_URL', Helper::options()->pluginUrl);
}
if (!class_exists('CSF_Setup')) {
    class CSF_Setup
    {

        // Default constants
        public static $premium = false;
        public static $version = '1.1.0';
        public static $dir = '';
        public static $url = '';
        public static $css = '';
        public static $file = '';
        public static $enqueue = false;
        public static $webfonts = array();
        public static $subsets = array();
        public static $inited = array();
        public static $fields = array();
        public static $args = array(
            'admin_options' => array(),
            'customize_options' => array(),
            'metabox_options' => array(),
            'nav_menu_options' => array(),
            'profile_options' => array(),
            'taxonomy_options' => array(),
            'widget_options' => array(),
            'comment_options' => array(),
            'shortcode_options' => array(),
        );

        public static $plugin_name = '';

        // Shortcode instances
        public static $shortcode_instances = array();

        private static $instance = null;

        public static $cfs_options = array();
        private static $enqueue_media = false;

        public static $render_static_style = false;
        public static $render_static_script = false;

        public static function initCFS($file = __FILE__, $premium = false)
        {

            // Set file constant
            self::$file = $file;

            // Set file constant
            self::$premium = $premium;

            // Set constants
            self::constants();
            // Include files
            self::includes();

            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;

        }

        public static function activateEvent()
        {
            $db = \Typecho\Db::get();
            $adapter = $db->getAdapterName();
            if ("Pdo_Mysql" === $adapter || "Mysql" === $adapter|| "Mysqli" === $adapter) {
            $option_val_type = $db->fetchObject($db->query('SELECT DATA_TYPE as dt FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = \''.$db->getPrefix().'options\' and column_name=\'value\''))->dt;
            if ($option_val_type == 'text')
            {
                $db->query('alter table `'.$db->getPrefix().'options` modify column `value` longtext');
            }
            }
        }

        public static function load_statics(){
            $requestObject = \Typecho\Request::getInstance();
            $curUri = $requestObject->getRequestUri();

            $isPlugin = strpos($curUri, 'options-plugin.php')!==false;
            $isTheme = strpos($curUri, 'options-theme.php')!==false;
            $usingBSF = true;
            if ($isTheme){
                if (!Config::isExists()){
                    return false;
                }
            } elseif ($isPlugin){
                $pluginName = get_plugin_theme_name();
                /** 获取插件入口 */
                [$pluginFileName, $className] = Plugin::portal(
                    $pluginName,
                    __TYPECHO_ROOT_DIR__ . '/' . __TYPECHO_PLUGIN_DIR__
                );
                // 引入插件文件，主要是为了在 header 获取相应配置，否则 $fields 获取不到
                require_once $pluginFileName;

//                /** 判断实例化是否成功 */
//                if (
//                    class_exists($className) || method_exists($className, 'activate')
//                ) {
//                    call_user_func([$className, 'activate']);
//                }

                //
                if (empty(CSF::$fields[$pluginName])) {
                    $usingBSF = false;
                }
            }
            $loads_statics = ($isPlugin || $isTheme) && $usingBSF;


            return $loads_statics;
        }
        public static function get_enqueue_style($header = null)
        {
            $loads_statics = self::load_statics();
            // 仅在插件页或者主题页添加
            if ($loads_statics) { // if is plugin
                if (self::$render_static_style) return $header;
                $style = '<link rel="stylesheet" href="//lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.4/css/all.min.css?ver=5.15.4">' .
                    '<link rel="stylesheet" href="//lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.4/css/v4-shims.min.css?ver=5.15.4">'.
                    '<link rel="stylesheet" href="' . self::include_plugin_url('assets/css/style.min.css') . '">'.
                    '<link rel="stylesheet" href="' . self::include_plugin_url('assets/css/color-picker.min.css') . '">'.
                    '<link href="//lib.baomitu.com/fomantic-ui/2.9.3/semantic.min.css" rel="stylesheet">' .
                    '<link href="//lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.css" type="text/css" rel="stylesheet" />' .
                    '<style>ul.token-input-list { list-style: none; margin: 0; padding: 0 4px; min-height: 32px;  cursor: text; z-index: 99999!important; background-color: #FFF; clear: left; border-radius: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }

ul.token-input-list li { margin: 4px 0;border-radius: 8px; }

ul.token-input-list li input { padding: 0; border: 0; width: 100%; -webkit-appearance: caret; }

li.token-input-token { padding: 0 6px; height: 37px; line-height: 37px; background-color: #F3F3F0; cursor: default; font-size: .92857em; text-align: right; white-space: nowrap; }

li.token-input-token p { float: left; display: inline; margin: 8px 0; }

li.token-input-token span { color: #BBB; font-weight: bold; cursor: pointer; }

li.token-input-selected-token { background-color: #E9E9E6; }

li.token-input-input-token { padding: 0 4px; }

div.token-input-dropdown { position: absolute; background-color: #FFF; overflow: hidden; border: 1px solid #D9D9D6; border-top-width: 0; cursor: default; z-index: 999999999999!important; font-size: .92857em;border-radius: 8px; }

div.token-input-dropdown p { margin: 0; padding: 5px 10px; color: #777; font-weight: bold; }

div.token-input-dropdown ul { list-style: none; margin: 0; padding: 0; }

div.token-input-dropdown ul li { padding: 4px 10px; background-color: #FFF; }

div.token-input-dropdown ul li.token-input-dropdown-item { background-color: #FFF; }

div.token-input-dropdown ul li em { font-style: normal; }

div.token-input-dropdown ul li.token-input-selected-dropdown-item { background-color: #467B96; color: #FFF; }
.typecho-page-title{
    margin-top:30px;
}
.typecho-option-tabs{
margin-top:20px!important;
}
.typecho-page-title,
.typecho-option-tabs{
margin-left:20px;
}
</style>'.
                    self::add_admin_enqueue_scripts(false).
                    '<script>_wpUtilSettings={ajax:{url: "'. Common::url('/bsoptions/ajax', Helper::options()->index).'"}};window.ajaxurl=_wpUtilSettings.ajax.url;</script>';
                     
                self::$render_static_style = true;
                return $header . $style;
            }
            return $header;
        }

        public static function get_enqueue_script($old = null)
        {
            $loads_statics = self::load_statics();
            // 仅在插件页或者主题页添加 class
            if ($loads_statics) { // if is plugin
                if (self::$render_static_script) return $old;
                $script = '<script src="' . self::include_plugin_url('assets/js/lodash.min.js') . '?v=2.2.4"></script>' .
                    '<script src="' . self::include_plugin_url('assets/js/plugins.min.js') . '?v=2.2.4"></script>' .
                    '<script src="' . self::include_plugin_url('assets/js/main.min.js') . '?v=2.2.4"></script>' .
                    '<script src="' . self::include_plugin_url('assets/js/iris.min.js') . '?v=2.2.4"></script>' .
                    '<script src="//lib.baomitu.com/jquery-tokeninput/1.7.0/jquery.tokeninput.min.js?v=2.2.4"></script>'.
                    '<script src="' . self::include_plugin_url('assets/js/color-picker.min.js') . '?v=2.2.4"></script>' .
                    '<script src="' . self::include_plugin_url('assets/js/jquery/ui/core.min.js') . '?v=2.2.4"></script>' .
                    '<script src="' . self::include_plugin_url('assets/js/jquery/ui/draggable.min.js') . '?v=2.2.4"></script>' .
                    '<script src="' . self::include_plugin_url('assets/js/jquery/ui/mouse.min.js') . '?v=2.2.4"></script>' .
                    '<script src="' . self::include_plugin_url('assets/js/jquery/ui/menu.min.js') . '?v=2.2.4"></script>' .
                    '<script src="//lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/toastr.js/2.1.4/toastr.min.js?v=2.2.4"></script>'.
                    '<script src="' . self::include_plugin_url('assets/js/backend.js') . '?v=2.5.1"></script>'.
                    '<script src="' . self::include_plugin_url('assets/js/uuidv4.min.js') . '?v=2.2.4"></script>'.
                    '<script src="' . self::include_plugin_url('assets/js/IndexNowViewScript.js') . '?v=2.2.4"></script>'.
                    self::add_admin_enqueue_scripts().

                    '<script>handleGenerate();csf_vars={color_palette:{},i18n:{confirm:"确定吗？",typing_text:"请输入 %s 个或更多字",searching_text:"搜索...",no_results_text:"没有搜到"}}</script>';
                echo $old . $script;
                if (self::$enqueue_media){
                    wp_print_media_templates();
                }
                self::$render_static_script = true;
                return $old . $script;
            }
            return $old ;
        }

        // Initalize
        public function __construct()
        {
            // reset enqueue
            reset_enqueue_array();
//      // Init action
//      do_action( 'csf_init' );
//
//      // Setup textdomain
            self::textdomain();
//
//      add_action( 'after_setup_theme', array( 'CSF', 'setup' ) );
//      add_action( 'init', array( 'CSF', 'setup' ) );
//      add_action( 'switch_theme', array( 'CSF', 'setup' ) );
//      add_action( 'admin_enqueue_scripts', array( 'CSF', 'add_admin_enqueue_scripts' ) );
//      add_action( 'wp_enqueue_scripts', array( 'CSF', 'add_typography_enqueue_styles' ), 80 );

//      add_action( 'wp_enqueue_scripts', array( 'CSF', 'Widget' ), 80 );
//      add_action( 'wp_head', array( 'CSF', 'add_custom_css' ), 80 );
//      add_filter( 'admin_body_class', array( 'CSF', 'add_admin_body_class' ) );
        }

        // Setup frameworks
        public static function setup($pluginName, $params_ = null)
        {
            self::$plugin_name = $pluginName;
            // Welcome
//            self::include_plugin_file('views/welcome.php');

            // Setup admin option framework
            $params = array();
            // set default form action
            $form_action = Helper::security()->getIndex('/bsoptions/save?plugin=' . $pluginName);
            // 默认之类 key value 只有一个，否则会出现处理异常
            if (class_exists('CSF_Options') && !empty(self::$args['admin_options'])) {
                foreach (self::$args['admin_options'] as $key => $value) {
                    if ($key != $pluginName){
                        continue;
                    }
                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
                        $value['form_action'] = $form_action;
                        $value['ajax_save'] = true;

                        $params['args'] = $value;
                        $params['sections'] = self::$args['sections'][$key];

                        self::$inited[$key] = true;
                        if (is_array($params_)){
                            $params = array_merge($params,$params_);
                        }

                        $op_obj = CSF_Options::instance($key, $params);
                        update_bs_key_params($key, $op_obj);

                        if (!empty($value['show_in_customizer'])) {
                            $value['output_css'] = false;
                            $value['enqueue_webfont'] = false;
                            self::$args['customize_options'][$key] = $value;
                            self::$inited[$key] = null;
                        }

                    }
                }
            }

            // todo:
//            // Setup customize option framework
//            $params = array();
//            if (class_exists('CSF_Customize_Options') && !empty(self::$args['customize_options'])) {
//                foreach (self::$args['customize_options'] as $key => $value) {
//                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
//
//                        $params['args'] = $value;
//                        $params['sections'] = self::$args['sections'][$key];
//                        self::$inited[$key] = true;
//
//                        CSF_Customize_Options::instance($key, $params);
//
//                    }
//                }
//            }
//
//            // Setup metabox option framework
//            $params = array();
//            if (class_exists('CSF_Metabox') && !empty(self::$args['metabox_options'])) {
//                foreach (self::$args['metabox_options'] as $key => $value) {
//                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
//
//                        $params['args'] = $value;
//                        $params['sections'] = self::$args['sections'][$key];
//                        self::$inited[$key] = true;
//
//                        CSF_Metabox::instance($key, $params);
//
//                    }
//                }
//            }
//
//            // Setup nav menu option framework
//            $params = array();
//            if (class_exists('CSF_Nav_Menu_Options') && !empty(self::$args['nav_menu_options'])) {
//                foreach (self::$args['nav_menu_options'] as $key => $value) {
//                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
//
//                        $params['args'] = $value;
//                        $params['sections'] = self::$args['sections'][$key];
//                        self::$inited[$key] = true;
//
//                        CSF_Nav_Menu_Options::instance($key, $params);
//
//                    }
//                }
//            }
//
//            // Setup profile option framework
//            $params = array();
//            if (class_exists('CSF_Profile_Options') && !empty(self::$args['profile_options'])) {
//                foreach (self::$args['profile_options'] as $key => $value) {
//                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
//
//                        $params['args'] = $value;
//                        $params['sections'] = self::$args['sections'][$key];
//                        self::$inited[$key] = true;
//
//                        CSF_Profile_Options::instance($key, $params);
//
//                    }
//                }
//            }
//
//            // Setup taxonomy option framework
//            $params = array();
//            if (class_exists('CSF_Taxonomy_Options') && !empty(self::$args['taxonomy_options'])) {
//                $taxonomy = (isset($_GET['taxonomy'])) ? sanitize_text_field(wp_unslash($_GET['taxonomy'])) : '';
//                foreach (self::$args['taxonomy_options'] as $key => $value) {
//                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
//
//                        $params['args'] = $value;
//                        $params['sections'] = self::$args['sections'][$key];
//                        self::$inited[$key] = true;
//
//                        CSF_Taxonomy_Options::instance($key, $params);
//
//                    }
//                }
//            }
//
//            // Setup widget option framework
//            if (class_exists('CSF_Widget') && class_exists('WP_Widget_Factory') && !empty(self::$args['widget_options'])) {
//                $wp_widget_factory = new WP_Widget_Factory();
//                global $wp_widget_factory;
//                foreach (self::$args['widget_options'] as $key => $value) {
//                    if (!isset(self::$inited[$key])) {
//
//                        self::$inited[$key] = true;
//                        $wp_widget_factory->register(CSF_Widget::instance($key, $value));
//
//                    }
//                }
//            }
//
//            // Setup comment option framework
//            $params = array();
//            if (class_exists('CSF_Comment_Metabox') && !empty(self::$args['comment_options'])) {
//                foreach (self::$args['comment_options'] as $key => $value) {
//                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
//
//                        $params['args'] = $value;
//                        $params['sections'] = self::$args['sections'][$key];
//                        self::$inited[$key] = true;
//
//                        CSF_Comment_Metabox::instance($key, $params);
//
//                    }
//                }
//            }
//
//            // Setup shortcode option framework
//            $params = array();
//            if (class_exists('CSF_Shortcoder') && !empty(self::$args['shortcode_options'])) {
//                foreach (self::$args['shortcode_options'] as $key => $value) {
//                    if (!empty(self::$args['sections'][$key]) && !isset(self::$inited[$key])) {
//
//                        $params['args'] = $value;
//                        $params['sections'] = self::$args['sections'][$key];
//                        self::$inited[$key] = true;
//
//                        CSF_Shortcoder::instance($key, $params);
//
//                    }
//                }
//
//                // Once editor setup for gutenberg and media buttons
//                if (class_exists('CSF_Shortcoder') && !empty(self::$shortcode_instances)) {
//                    foreach (self::$shortcode_instances as $instance) {
//                        if (!empty($instance['show_in_editor'])) {
//                            CSF_Shortcoder::once_editor_setup();
//                            break;
//                        }
//                    }
//                }
//
//            }

//            do_action('csf_loaded');

        }

        public static function setTypechoOptionForm($form)
        {
            $val = new \Typecho\Widget\Helper\Form\Element\Hidden('bsOptionsHide',
                NULL,
                "bsOptionsHide",
                'bs选项框架隐藏val',
                '');
            $form->addInput($val);
            $form->setAttribute('style','display:none');

            return $form;
        }

        // Create options
        public static function createOptions($id, $args = array())
        {
            self::$args['admin_options'][$id] = $args;
        }

        // Create customize options
        public static function createCustomizeOptions($id, $args = array())
        {
            self::$args['customize_options'][$id] = $args;
        }

        // Create metabox options
        public static function createMetabox($id, $args = array())
        {
            self::$args['metabox_options'][$id] = $args;
        }

        // Create menu options
        public static function createNavMenuOptions($id, $args = array())
        {
            self::$args['nav_menu_options'][$id] = $args;
        }

        // Create shortcoder options
        public static function createShortcoder($id, $args = array())
        {
            self::$args['shortcode_options'][$id] = $args;
        }

        // Create taxonomy options
        public static function createTaxonomyOptions($id, $args = array())
        {
            self::$args['taxonomy_options'][$id] = $args;
        }

        // Create profile options
        public static function createProfileOptions($id, $args = array())
        {
            self::$args['profile_options'][$id] = $args;
        }

        // Create widget
        public static function createWidget($id, $args = array())
        {
            self::$args['widget_options'][$id] = $args;
            self::set_used_fields($args);
        }

        // Create comment metabox
        public static function createCommentMetabox($id, $args = array())
        {
            self::$args['comment_options'][$id] = $args;
        }

        // Create section
        public static function createSection($id, $sections)
        {
            self::$args['sections'][$id][] = $sections;
            self::set_used_fields($sections, $id);
        }

        // Set directory constants
        public static function constants()
        {

            // We need this path-finder code for set URL of framework
            $dirname = str_replace('//', '/', wp_normalize_path(dirname(dirname(self::$file))));
//      \Typecho\Widget::widget('Widget_Archive')
            $theme_dir = str_replace('//', '/', wp_normalize_path(Helper::options()->pluginDir));
            $theme_dir = str_replace('usr/plugins', 'usr/themes', $theme_dir);

            $plugin_dir = Helper::options()->pluginDir;
            $plugin_dir = str_replace('\\', '/', $plugin_dir);
            $plugin_dir = str_replace('/opt/bitnami', '/bitnami', $plugin_dir);

            $located_plugin = (preg_match('#' . self::sanitize_dirname($plugin_dir) . '#', self::sanitize_dirname($dirname))) ? true : false;
            $directory = ($located_plugin) ? $plugin_dir : $theme_dir;
            $directory_uri = ($located_plugin) ? WP_PLUGIN_URL : get_parent_theme_file_uri();

            $foldername = str_replace($directory, '', $dirname);

//            $protocol_uri = (is_ssl()) ? 'https' : 'http';
//      $directory_uri  = set_url_scheme( $directory_uri, $protocol_uri );

            self::$dir = $dirname;
            self::$url = $directory_uri . $foldername;
        }

        public static function located_plugin(): bool
        {
            $dirname = str_replace('//', '/', wp_normalize_path(dirname(self::$file, 2)));
            $plugin_dir = Helper::options()->pluginDir;
            $plugin_dir = str_replace('\\', '/', $plugin_dir);
            $plugin_dir = str_replace('/opt/bitnami', '/bitnami', $plugin_dir);
            return (bool)preg_match('#' . self::sanitize_dirname($plugin_dir) . '#', self::sanitize_dirname($dirname));
        }

        // Include file helper
        public static function include_plugin_file($file, $load = true)
        {

            $path = '';
            $file = ltrim($file, '/');

            if (file_exists(self::$dir . '/' . $file)) {
                $path = self::$dir . '/' . $file;
            }

            if (!empty($path) && !empty($file) && $load) {

                global $wp_query;

                if (is_object($wp_query) && function_exists('load_template')) {

                    load_template($path, true);

                } else {
                    require_once($path);

                }

            } else {

                return self::$dir . '/' . $file;

            }

        }

        // Is active plugin helper
        public static function is_active_plugin($file = '')
        {
            return in_array($file, (array)get_option('active_plugins', array()));
        }

        // Sanitize dirname
        public static function sanitize_dirname($dirname)
        {
            return preg_replace('/[^A-Za-z]/', '', $dirname);
        }

        // Set url constant
        public static function include_plugin_url($file)
        {

            return esc_url(self::$url) . '/' . ltrim($file, '/');
        }

        // Include files
        public static function includes()
        {
            // include router
            self::include_plugin_file('classes/bsRouter.class.php');

            // Include common functions
            self::include_plugin_file('functions/actions.php');
            self::include_plugin_file('functions/helpers.php');
            self::include_plugin_file('functions/sanitize.php');
            self::include_plugin_file('functions/validate.php');

            // Include free version classes
            self::include_plugin_file('classes/abstract.class.php');
            self::include_plugin_file('classes/fields.class.php');
            self::include_plugin_file('classes/admin-options.class.php');

            // Include premium version classes
            if (self::$premium) {
                self::include_plugin_file('classes/customize-options.class.php');
                self::include_plugin_file('classes/metabox-options.class.php');
                self::include_plugin_file('classes/nav-menu-options.class.php');
                self::include_plugin_file('classes/profile-options.class.php');
                self::include_plugin_file('classes/shortcode-options.class.php');
                self::include_plugin_file('classes/taxonomy-options.class.php');
                self::include_plugin_file('classes/widget-options.class.php');
                self::include_plugin_file('classes/comment-options.class.php');
            }

            // Include all framework fields
            $fields = apply_filters('csf_fields', array(
                'accordion',
                'background',
                'backup',
                'border',
                'button_set',
                'callback',
                'checkbox',
                'code_editor',
                'color',
                'color_group',
                'content',
                'date',
                'datetime',
                'dimensions',
                'fieldset',
                'gallery',
                'group',
                'heading',
                'icon',
                'image_select',
                'link',
                'link_color',
                'map',
                'media',
                'notice',
                'number',
                'palette',
                'radio',
                'repeater',
                'select',
                'slider',
                'sortable',
                'sorter',
                'spacing',
                'spinner',
                'subheading',
                'submessage',
                'switcher',
                'tabbed',
                'text',
                'textarea',
                'typography',
                'upload',
                'wp_editor',
            ));

            if (!empty($fields)) {
                foreach ($fields as $field) {
                    if (!class_exists('CSF_Field_' . $field) && class_exists('CSF_Fields')) {
                        self::include_plugin_file('fields/' . $field . '/' . $field . '.php');
                    }
                }
            }

        }

        // Setup textdomain
        public static function textdomain()
        {
        }

        // Set all of used fields
        public static function set_used_fields($sections, $id)
        {

            if (!empty($sections['fields'])) {

                foreach ($sections['fields'] as $field) {

                    if (!empty($field['fields'])) {
                        self::set_used_fields($field, $id);
                    }

                    if (!empty($field['tabs'])) {
                        self::set_used_fields(array('fields' => $field['tabs']), $id);
                    }

                    if (!empty($field['accordions'])) {
                        self::set_used_fields(array('fields' => $field['accordions']), $id);
                    }

                    if (!empty($field['type'])) {
                        self::$fields[$id][$field['type']] = $field;
                    }

                }

            }

        }

        // Enqueue admin and fields styles and scripts

        /**
         * @throws \IXR\Exception
         */
        public static function add_admin_enqueue_scripts($enq_js = true)
        {

//            if (!self::$enqueue) {
//
//                // Loads scripts and styles only when needed
//                $wpscreen = get_current_screen();
//
//                if (!empty(self::$args['admin_options'])) {
//                    foreach (self::$args['admin_options'] as $argument) {
//                        if (substr($wpscreen->id, -strlen($argument['menu_slug'])) === $argument['menu_slug']) {
//                            self::$enqueue = true;
//                        }
//                    }
//                }
//
//                if (!empty(self::$args['metabox_options'])) {
//                    foreach (self::$args['metabox_options'] as $argument) {
//                        if (in_array($wpscreen->post_type, (array)$argument['post_type'])) {
//                            self::$enqueue = true;
//                        }
//                    }
//                }
//
//                if (!empty(self::$args['taxonomy_options'])) {
//                    foreach (self::$args['taxonomy_options'] as $argument) {
//                        if (in_array($wpscreen->taxonomy, (array)$argument['taxonomy'])) {
//                            self::$enqueue = true;
//                        }
//                    }
//                }
//
//                if (!empty(self::$shortcode_instances)) {
//                    foreach (self::$shortcode_instances as $argument) {
//                        if (($argument['show_in_editor'] && $wpscreen->base === 'post') || $argument['show_in_custom']) {
//                            self::$enqueue = true;
//                        }
//                    }
//                }
//
//                if (!empty(self::$args['widget_options']) && ($wpscreen->id === 'widgets' || $wpscreen->id === 'customize')) {
//                    self::$enqueue = true;
//                }
//
//                if (!empty(self::$args['customize_options']) && $wpscreen->id === 'customize') {
//                    self::$enqueue = true;
//                }
//
//                if (!empty(self::$args['nav_menu_options']) && $wpscreen->id === 'nav-menus') {
//                    self::$enqueue = true;
//                }
//
//                if (!empty(self::$args['profile_options']) && ($wpscreen->id === 'profile' || $wpscreen->id === 'user-edit')) {
//                    self::$enqueue = true;
//                }
//
//                if (!empty(self::$args['comment_options']) && $wpscreen->id === 'comment') {
//                    self::$enqueue = true;
//                }
//
//                if ($wpscreen->id === 'tools_page_csf-welcome') {
//                    self::$enqueue = true;
//                }
//
//            }

//            if (!apply_filters('csf_enqueue_assets', self::$enqueue)) {
//                return;
//            }

            // todo:Admin utilities
//            wp_enqueue_media();


            // Enqueue fields scripts and styles

            $enqueued = array();
            $style_or_script = '';
            // get plugin or theme first 根据主题或者插件的名字配置
            $ptid = get_plugin_theme_name();
            if ($ptid == null){
                return $style_or_script;
            }

            if (!empty(self::$fields[$ptid])) {
                foreach (self::$fields[$ptid] as $field) {
                    if (!empty($field['type'])) {
                        $type = $field['type'];
                        if (in_array($type,['media','upload'])){
                            self::$enqueue_media = true;
                        }else {
                            $classname = 'CSF_Field_' . $type;
                            if (class_exists($classname) && method_exists($classname, 'enqueue')) {
                                $instance = new $classname($field);
                                if (method_exists($classname, 'enqueue')) {
                                    $style_or_script = $style_or_script.$instance->enqueue($enq_js);
                                }
                                unset($instance);
                            }
                        }

                    }
                }
            }



            return $style_or_script;
//
//            do_action('csf_enqueue');

        }


        // Add custom css to front page
        public static function add_custom_css()
        {

            if (!empty(self::$css)) {
                echo '<style type="text/css">' . wp_strip_all_tags(self::$css) . '</style>';
            }

        }

        // Add a new framework field
        public static function field($field = array(), $value = '', $unique = '', $where = '', $parent = '')
        {

            // Check for unallow fields
            if (!empty($field['_notice'])) {

                $field_type = $field['type'];

                $field = array();
                $field['content'] = esc_html__('Oops! Not allowed.', 'csf') . ' <strong>(' . $field_type . ')</strong>';
                $field['type'] = 'notice';
                $field['style'] = 'danger';

            }

            $depend = '';
            $visible = '';
            $unique = (!empty($unique)) ? $unique : '';

            $class = (!empty($field['class'])) ? ' ' . esc_attr($field['class']) : '';
            $is_pseudo = (!empty($field['pseudo'])) ? ' csf-pseudo-field' : '';
            $field_type = (!empty($field['type'])) ? esc_attr($field['type']) : '';

            if (!empty($field['dependency'])) {

                $dependency = $field['dependency'];
                $depend_visible = '';
                $data_controller = '';
                $data_condition = '';
                $data_value = '';
                $data_global = '';

                if (is_array($dependency[0])) {
                    $data_controller = implode('|', array_column($dependency, 0));
                    $data_condition = implode('|', array_column($dependency, 1));
                    $data_value = implode('|', array_column($dependency, 2));
                    $data_global = implode('|', array_column($dependency, 3));
                    $depend_visible = implode('|', array_column($dependency, 4));
                } else {
                    $data_controller = (!empty($dependency[0])) ? $dependency[0] : '';
                    $data_condition = (!empty($dependency[1])) ? $dependency[1] : '';
                    $data_value = (!empty($dependency[2])) ? $dependency[2] : '';
                    $data_global = (!empty($dependency[3])) ? $dependency[3] : '';
                    $depend_visible = (!empty($dependency[4])) ? $dependency[4] : '';
                }

                $depend .= ' data-controller="' . esc_attr($data_controller) . '"';
                $depend .= ' data-condition="' . esc_attr($data_condition) . '"';
                $depend .= ' data-value="' . esc_attr($data_value) . '"';
                $depend .= (!empty($data_global)) ? ' data-depend-global="true"' : '';

                $visible = (!empty($depend_visible)) ? ' csf-depend-visible' : ' csf-depend-hidden';

            }

            // These attributes has been sanitized above.
            echo '<div class="csf-field csf-field-' . $field_type . $is_pseudo . $class . $visible . '"' . $depend . '>';
            if (!empty($field_type)) {

                if (!empty($field['title'])) {
                    echo '<div class="csf-title">';
                    echo '<h4>' . $field['title'] . '</h4>';
                    echo (!empty($field['subtitle'])) ? '<div class="csf-subtitle-text">' . $field['subtitle'] . '</div>' : '';
                    echo '</div>';
                }

                echo (!empty($field['title'])) ? '<div class="csf-fieldset">' : '';
                if ($value == "") $value = null;
                if (is_array($value)){
//                    $notset = false;
                    foreach ($value as $key => $val){

                        if (empty($val)){
//                            $notset = true;
                        }
                    }
//                    if ($notset){
//                        $value = null;
//                    }
                }
                $value = (!isset($value) && isset($field['default'])) ? $field['default'] : $value;

                $value = (isset($field['value'])) ? $field['value'] : $value;

                $classname = 'CSF_Field_' . $field_type;

                if (class_exists($classname)) {
                    $instance = new $classname($field, $value, $unique, $where, $parent);
                    $instance->render();
                } else {
                    echo '<p>' . esc_html__('Field not found!', 'csf') . '</p>';
                }

            } else {
                echo '<p>' . esc_html__('Field not found!', 'csf') . '</p>';
            }

            echo (!empty($field['title'])) ? '</div>' : '';
            echo '<div class="clear"></div>';
            echo '</div>';

        }

    }

}

CSF_Setup::initCFS(__FILE__, false);

