<?php use Widget\Options;

if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Array search key & value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'csf_array_search' ) ) {
  function csf_array_search( $array, $key, $value ) {

    $results = array();

    if ( is_array( $array ) ) {
      if ( isset( $array[$key] ) && $array[$key] == $value ) {
        $results[] = $array;
      }

      foreach ( $array as $sub_array ) {
        $results = array_merge( $results, csf_array_search( $sub_array, $key, $value ) );
      }

    }

    return $results;

  }
}

/**
 *
 * Between Microtime
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'csf_timeout' ) ) {
  function csf_timeout( $timenow, $starttime, $timeout = 30 ) {
    return ( ( $timenow - $starttime ) < $timeout ) ? true : false;
  }
}

/**
 *
 * Check for wp editor api
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! function_exists( 'csf_wp_editor_api' ) ) {
  function csf_wp_editor_api() {
    global $wp_version;
    return version_compare( $wp_version, '4.8', '>=' );
  }
}


if (!function_exists('get_plugin_theme_name')){
    function get_plugin_theme_name(){
        $requestObject = \Typecho\Request::getInstance();
        $curUri = $requestObject->getRequestUri();
        if (strpos($curUri, 'options-plugin.php')!==false){ // if is plugin
            parse_str(parse_url($curUri,PHP_URL_QUERY),$query_arr);

            if (array_key_exists('config', $query_arr)){
                return $query_arr['config'];

            }
        } elseif (strpos($curUri, 'options-theme.php')!==false){
            $options = Options::alloc();
            return $options->theme;
        }
        return null;
    }
}
