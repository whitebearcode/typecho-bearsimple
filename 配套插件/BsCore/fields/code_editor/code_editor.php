<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: code_editor
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('CSF_Field_code_editor')) {
    class CSF_Field_code_editor extends CSF_Fields
    {

        public $version = '5.65.2';
        public $cdn_url = 'https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/codemirror/';
        public $theme_url = 'https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/codemirror/5.65.2/theme/shadowfox.min.css';

        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {

            $default_settings = array(
                'tabSize' => 2,
                'lineNumbers' => true,
                'theme' => 'default',
                'mode' => 'htmlmixed',
                'cdnURL' => $this->cdn_url . $this->version,
            );

            $settings = (!empty($this->field['settings'])) ? $this->field['settings'] : array();
            $settings = wp_parse_args($settings, $default_settings);

            echo $this->field_before();
            echo '<textarea name="' . esc_attr($this->field_name()) . '"' . $this->field_attributes() . ' data-editor="' . esc_attr(json_encode($settings)) . '">' . $this->value . '</textarea>';
            echo $this->field_after();

        }

        public function enqueue($enq_js = true)
        {

            $page = (!empty($_GET['page'])) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';

            // Do not loads CodeMirror in revslider page.
            if (in_array($page, array('revslider'))) {
                return '';
            }
            if ($enq_js){
                return enqueue_script_helper('csf-codemirror', esc_url($this->cdn_url . $this->version . '/codemirror.min.js')).
                    enqueue_script_helper('csf-codemirror-loadmode', esc_url($this->cdn_url . $this->version . '/addon/mode/loadmode.min.js'));
            } else {
                return enqueue_style_helper('csf-codemirror-css', esc_url($this->cdn_url . $this->version . '/codemirror.min.css'));
            }

        }

    }
}
