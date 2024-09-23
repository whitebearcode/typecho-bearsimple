<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: link
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'CSF_Field_link' ) ) {
  class CSF_Field_link extends CSF_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'add_title'    => esc_html__( 'Add Link', 'csf' ),
        'edit_title'   => esc_html__( 'Edit Link', 'csf' ),
        'remove_title' => esc_html__( 'Remove Link', 'csf' ),
      ) );

      $default_values = array(
        'url'    => '',
        'text'  => '',
        'target' => '',
      );

      $value = wp_parse_args( $this->value, $default_values );

      $hidden = ( ! empty( $value['url'] ) || ! empty( $value['url'] ) || ! empty( $value['url'] ) ) ? ' hidden' : '';

      $maybe_hidden = ( empty( $hidden ) ) ? ' hidden' : '';

      echo $this->field_before();

      echo '<textarea readonly="readonly" class="csf--link hidden"></textarea>';

      echo '<div class="'. esc_attr( $maybe_hidden ) .'"><div class="csf--result">'. sprintf( '{url:"%s", text:"%s", target:"%s"}', $value['url'], $value['text'], $value['target'] ) .'</div></div>';

      echo '<input type="hidden" name="'. esc_attr( $this->field_name( '[url]' ) ) .'" value="'. esc_attr( $value['url'] ) .'"'. $this->field_attributes( array( 'class' => 'csf--url' ) ) .' />';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name( '[text]' ) ) .'" value="'. esc_attr( $value['text'] ) .'" class="csf--text" />';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name( '[target]' ) ) .'" value="'. esc_attr( $value['target'] ) .'" class="csf--target" />';

      echo '<a href="#" class="button button-primary csf--add'. esc_attr( $hidden ) .'">'. $args['add_title'] .'</a> ';
      echo '<a href="#" class="button csf--edit'. esc_attr( $maybe_hidden ) .'">'. $args['edit_title'] .'</a> ';
      echo '<a href="#" class="button csf-warning-primary csf--remove'. esc_attr( $maybe_hidden ) .'">'. $args['remove_title'] .'</a>';

      echo $this->field_after();

    }

    public function enqueue($enq_js = true) {

//      if ( ! wp_script_is( 'wplink' ) ) {
//        wp_enqueue_script( 'wplink' );
//      }
//
//      if ( ! wp_script_is( 'jquery-ui-autocomplete' ) ) {
//        wp_enqueue_script( 'jquery-ui-autocomplete' );
//      }

//      add_action( 'admin_print_footer_scripts', array( $this, 'add_wp_link_dialog' ) );
        if ($enq_js){
            $js_ = wp_localize_script('wplink',
                'wpLinkL10n',
                array(
                    'title'          => __( 'Insert/edit link' ),
                    'update'         => __( 'Update' ),
                    'save'           => __( 'Add Link' ),
                    'noTitle'        => __( '(no title)' ),
                    'noMatchesFound' => __( 'No results found.' ),
                    'linkSelected'   => __( 'Link selected.' ),
                    'linkInserted'   => __( 'Link inserted.' ),
                    /* translators: Minimum input length in characters to start searching posts in the "Insert/edit link" modal. */
                    'minInputLength' => "3"// __( 'minimum input length for searching post links' ),
                )). enqueue_script_helper('wplink');
            $this->wp_link_dialog();
            return $js_;
        }
    }

    public function add_wp_link_dialog() {

//      if ( ! class_exists( '_WP_Editors' ) ) {
//        require_once ABSPATH . WPINC .'/class-wp-editor.php';
//      }

//      wp_print_styles( 'editor-buttons' );
//
//      _WP_Editors::wp_link_dialog();

    }
    public function wp_link_dialog() {
          // `display: none` is required here, see #WP27605.
          ?>
          <div id="wp-link-backdrop" style="display: none"></div>
          <div id="wp-link-wrap" class="wp-core-ui" style="display: none" role="dialog" aria-labelledby="link-modal-title">
              <form id="wp-link" tabindex="-1">
                  <?php wp_nonce_field( 'internal-linking', '_ajax_linking_nonce', false ); ?>
                  <h1 id="link-modal-title"><?php _e( '插入/编辑 链接' ); ?></h1>
                  <button type="button" id="wp-link-close"><span class="screen-reader-text"><?php _e( '关闭' ); ?></span></button>
                  <div id="link-selector">
                      <div id="link-options">
                          <p class="howto" id="wplink-enter-url"><?php _e( '输入目标网址' ); ?></p>
                          <div>
                              <label><span><?php _e( '网址' ); ?></span>
                                  <input id="wp-link-url" type="text" aria-describedby="wplink-enter-url" /></label>
                          </div>
                          <div class="wp-link-text-field">
                              <label><span><?php _e( '文本' ); ?></span>
                                  <input id="wp-link-text" type="text" /></label>
                          </div>
                          <div class="link-target">
                              <label><span></span>
                                  <input type="checkbox" id="wp-link-target" /> <?php _e( '在新标签打开' ); ?></label>
                          </div>
                      </div>
                      <!--                        <p class="howto" id="wplink-link-existing-content">--><?php //_e( '或者链接到已存在的内容' ); ?><!--</p>-->
                      <!--                        <div id="search-panel">-->
                      <!--                            <div class="link-search-wrapper">-->
                      <!--                                <label>-->
                      <!--                                    <span class="search-label">--><?php //_e( '搜索' ); ?><!--</span>-->
                      <!--                                    <input type="search" id="wp-link-search" class="link-search-field" autocomplete="off" aria-describedby="wplink-link-existing-content" />-->
                      <!--                                    <span class="spinner"></span>-->
                      <!--                                </label>-->
                      <!--                            </div>-->
                      <!--                            <div id="search-results" class="query-results" tabindex="0">-->
                      <!--                                <ul></ul>-->
                      <!--                                <div class="river-waiting">-->
                      <!--                                    <span class="spinner"></span>-->
                      <!--                                </div>-->
                      <!--                            </div>-->
                      <!--                            <div id="most-recent-results" class="query-results" tabindex="0">-->
                      <!--                                <div class="query-notice" id="query-notice-message">-->
                      <!--                                    <em class="query-notice-default">--><?php //_e( '未指定搜索词。 显示最近的项目。' ); ?><!--</em>-->
                      <!--                                    <em class="query-notice-hint screen-reader-text">--><?php //__( '搜索或使用向上和向下箭头键选择项目。' ); ?><!--</em>-->
                      <!--                                </div>-->
                      <!--                                <ul></ul>-->
                      <!--                                <div class="river-waiting">-->
                      <!--                                    <span class="spinner"></span>-->
                      <!--                                </div>-->
                      <!--                            </div>-->
                      <!--                        </div>-->
                  </div>
                  <div class="submitbox">
                      <div id="wp-link-cancel">
                          <button type="button" class="button"><?php _e( '取消' ); ?></button>
                      </div>
                      <div id="wp-link-update">
                          <input type="submit" value="<?php _e( '添加链接' ); ?>" class="button button-primary" id="wp-link-submit" name="wp-link-submit">
                      </div>
                  </div>
              </form>
          </div>
          <?php

      }


  }
}
