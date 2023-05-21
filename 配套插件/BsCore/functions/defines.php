<?php


use IXR\Exception;
use Typecho\Common;
use Typecho\Cookie;
use Typecho\Db;
use Typecho\Widget;
require_once 'options.php';
require_once 'class-list-util.php';
require_once 'kses.php';


if (!defined('KB_IN_BYTES')){
    define( 'KB_IN_BYTES', 1024 );
}
if (!defined('MB_IN_BYTES')) {
    define( 'MB_IN_BYTES', 1024 * KB_IN_BYTES );
}
if (!defined('GB_IN_BYTES')) {
    define( 'GB_IN_BYTES', 1024 * MB_IN_BYTES );
}
if (!defined('TB_IN_BYTES')) {
    define( 'TB_IN_BYTES', 1024 * GB_IN_BYTES );
}


if (!function_exists('wp_is_stream')) {

    function wp_is_stream($path)
    {
        $scheme_separator = strpos($path, '://');

        if (false === $scheme_separator) {
            // $path isn't a stream.
            return false;
        }

        $stream = substr($path, 0, $scheme_separator);

        return in_array($stream, stream_get_wrappers(), true);
    }
}
if (!function_exists('wp_normalize_path')) {

    function wp_normalize_path($path)
    {
        $wrapper = '';

        if (wp_is_stream($path)) {
            list($wrapper, $path) = explode('://', $path, 2);

            $wrapper .= '://';
        }

        // Standardise all paths to use '/'.
        $path = str_replace('\\', '/', $path);

        // Replace multiple slashes down to a singular, allowing for network shares having two slashes.
        $path = preg_replace('|(?<=.)/+|', '/', $path);

        // Windows paths should uppercase the drive letter.
        if (':' === substr($path, 1, 1)) {
            $path = ucfirst($path);
        }

        return $wrapper . $path;
    }

}
if (!function_exists('is_ssl')) {

    function is_ssl()
    {
        if (isset($_SERVER['HTTPS'])) {
            if ('on' === strtolower($_SERVER['HTTPS'])) {
                return true;
            }

            if ('1' == $_SERVER['HTTPS']) {
                return true;
            }
        } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
            return true;
        }
        return false;
    }

}
if (!function_exists('get_parent_theme_file_uri')) {

    function get_parent_theme_file_uri()
    {
        return str_replace('/'.Helper::options()->theme, '', Helper::options()->themeUrl);
    }
}
if (!function_exists('apply_filters')) {

    function apply_filters($hook_name, $value)
    {
        //todo: do nothing now
        return $value;
    }
}
if (!function_exists('wp_check_invalid_utf8')) {
    function wp_check_invalid_utf8($string, $strip = false)
    {
        $string = (string)$string;

        if (0 === strlen($string)) {
            return '';
        }

        // must be utf-8 here!

        // Check for support for utf8 in the installed PCRE library once and store the result in a static.
        static $utf8_pcre = null;
        if (!isset($utf8_pcre)) {
            // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
            $utf8_pcre = @preg_match('/^./u', 'a');
        }
        // We can't demand utf8 in the PCRE installation, so just return the string in those cases.
        if (!$utf8_pcre) {
            return $string;
        }

        // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- preg_match fails when it encounters invalid UTF8 in $string.
        if (1 === @preg_match('/^./us', $string)) {
            return $string;
        }

        // Attempt to strip the bad chars if requested (not recommended).
        if ($strip && function_exists('iconv')) {
            return iconv('utf-8', 'utf-8', $string);
        }

        return '';
    }
}
if (!function_exists('wp_kses_normalize_entities')) {
    function wp_kses_normalize_entities($string, $context = 'html')
    {
        // Disarm all entities by converting & to &amp;
        $string = str_replace('&', '&amp;', $string);

        // Change back the allowed entities in our list of allowed entities.
        if ('xml' === $context) {
            $string = preg_replace_callback('/&amp;([A-Za-z]{2,8}[0-9]{0,2});/', 'wp_kses_xml_named_entities', $string);
        } else {
            $string = preg_replace_callback('/&amp;([A-Za-z]{2,8}[0-9]{0,2});/', 'wp_kses_named_entities', $string);
        }
        $string = preg_replace_callback('/&amp;#(0*[0-9]{1,7});/', 'wp_kses_normalize_entities2', $string);
        $string = preg_replace_callback('/&amp;#[Xx](0*[0-9A-Fa-f]{1,6});/', 'wp_kses_normalize_entities3', $string);

        return $string;
    }
}
if (!function_exists('_wp_specialchars')) {

    function _wp_specialchars($string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false)
    {
        $string = (string)$string;

        if (0 === strlen($string)) {
            return '';
        }

        // Don't bother if there are no specialchars - saves some processing.
        if (!preg_match('/[&<>"\']/', $string)) {
            return $string;
        }

        // Account for the previous behaviour of the function when the $quote_style is not an accepted value.
        if (empty($quote_style)) {
            $quote_style = ENT_NOQUOTES;
        } elseif (ENT_XML1 === $quote_style) {
            $quote_style = ENT_QUOTES | ENT_XML1;
        } elseif (!in_array($quote_style, array(ENT_NOQUOTES, ENT_COMPAT, ENT_QUOTES, 'single', 'double'), true)) {
            $quote_style = ENT_QUOTES;
        }

        // Store the site charset as a static to avoid multiple calls to wp_load_alloptions().
        $charset = 'UTF-8';


        $_quote_style = $quote_style;

        if ('double' === $quote_style) {
            $quote_style = ENT_COMPAT;
            $_quote_style = ENT_COMPAT;
        } elseif ('single' === $quote_style) {
            $quote_style = ENT_NOQUOTES;
        }

        if (!$double_encode) {
            // Guarantee every &entity; is valid, convert &garbage; into &amp;garbage;
            // This is required for PHP < 5.4.0 because ENT_HTML401 flag is unavailable.
            $string = wp_kses_normalize_entities($string, ($quote_style & ENT_XML1) ? 'xml' : 'html');
        }

        $string = htmlspecialchars($string, $quote_style, $charset, $double_encode);

        // Back-compat.
        if ('single' === $_quote_style) {
            $string = str_replace("'", '&#039;', $string);
        }

        return $string;
    }
}
if (!function_exists('esc_attr')) {

    function esc_attr($text)
    {
        $safe_text = wp_check_invalid_utf8($text);
        $safe_text = _wp_specialchars($safe_text, ENT_QUOTES);
        /**
         * Filters a string cleaned and escaped for output in an HTML attribute.
         *
         * Text passed to esc_attr() is stripped of invalid or special characters
         * before output.
         *
         * @param string $safe_text The text after it has been escaped.
         * @param string $text The text prior to being escaped.
         * @since 2.0.6
         *
         */
        return apply_filters('attribute_escape', $safe_text, $text);
    }
}
if (!function_exists('load_template')) {

    function load_template($_template_file, $require_once = true, $args = array())
    {
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        if (is_array($wp_query->query_vars)) {
            /*
             * This use of extract() cannot be removed. There are many possible ways that
             * templates could depend on variables that it creates existing, and no way to
             * detect and deprecate it.
             *
             * Passing the EXTR_SKIP flag is the safest option, ensuring globals and
             * function variables cannot be overwritten.
             */
            // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
            extract($wp_query->query_vars, EXTR_SKIP);
        }

        if (isset($s)) {
            $s = esc_attr($s);
        }

        if ($require_once) {
            require_once $_template_file;
        } else {
            require $_template_file;
        }
    }
}
if (!function_exists('wp_pre_kses_less_than')) {

    function wp_pre_kses_less_than($text)
    {
        return preg_replace_callback('%<[^>]*?((?=<)|>|$)%', 'wp_pre_kses_less_than_callback', $text);
    }
}
if (!function_exists('wp_strip_all_tags')) {

    function wp_strip_all_tags($string, $remove_breaks = false)
    {
        $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
        $string = strip_tags($string);

        if ($remove_breaks) {
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
        }

        return trim($string);
    }
}
if (!function_exists('_sanitize_text_fields')) {

    function _sanitize_text_fields($str, $keep_newlines = false)
    {
        if (is_object($str) || is_array($str)) {
            return '';
        }

        $str = (string)$str;

        $filtered = wp_check_invalid_utf8($str);

        if (strpos($filtered, '<') !== false) {
            $filtered = wp_pre_kses_less_than($filtered);
            // This will strip extra whitespace for us.
            $filtered = wp_strip_all_tags($filtered, false);

            // Use HTML entities in a special case to make sure no later
            // newline stripping stage could lead to a functional tag.
            $filtered = str_replace("<\n", "&lt;\n", $filtered);
        }

        if (!$keep_newlines) {
            $filtered = preg_replace('/[\r\n\t ]+/', ' ', $filtered);
        }
        $filtered = trim($filtered);

        $found = false;
        while (preg_match('/%[a-f0-9]{2}/i', $filtered, $match)) {
            $filtered = str_replace($match[0], '', $filtered);
            $found = true;
        }

        if ($found) {
            // Strip out the whitespace that may now exist after removing the octets.
            $filtered = trim(preg_replace('/ +/', ' ', $filtered));
        }

        return $filtered;
    }
}
if (!function_exists('sanitize_text_field')) {

    function sanitize_text_field($str)
    {
        $filtered = _sanitize_text_fields($str, false);

        /**
         * Filters a sanitized text field string.
         *
         * @param string $filtered The sanitized string.
         * @param string $str The string prior to being sanitized.
         * @since 2.9.0
         *
         */
        return apply_filters('sanitize_text_field', $filtered, $str);
    }
}
if (!function_exists('stripslashes_from_strings_only')) {

    function stripslashes_from_strings_only($value)
    {
        return is_string($value) ? stripslashes($value) : $value;
    }
}
if (!function_exists('map_deep')) {

    function map_deep($value, $callback)
    {
        if (is_array($value)) {
            foreach ($value as $index => $item) {
                $value[$index] = map_deep($item, $callback);
            }
        } elseif (is_object($value)) {
            $object_vars = get_object_vars($value);
            foreach ($object_vars as $property_name => $property_value) {
                $value->$property_name = map_deep($property_value, $callback);
            }
        } else {
            $value = call_user_func($callback, $value);
        }

        return $value;
    }
}
if (!function_exists('stripslashes_deep')) {

    function stripslashes_deep($value)
    {
        return map_deep($value, 'stripslashes_from_strings_only');
    }
}
if (!function_exists('wp_unslash')) {

    function wp_unslash($value)
    {
        return stripslashes_deep($value);
    }
}

if (!function_exists('wp_parse_str')) {
    function wp_parse_str($string, &$array)
    {
        parse_str((string)$string, $array);

        /**
         * Filters the array of variables derived from a parsed string.
         *
         * @param array $array The array populated with variables.
         * @since 2.2.1
         *
         */
        $array = apply_filters('wp_parse_str', $array);
    }
}
if (!function_exists('wp_parse_args')) {

    function wp_parse_args($args, $defaults = array())
    {
        if (is_object($args)) {
            $parsed_args = get_object_vars($args);
        } elseif (is_array($args)) {
            $parsed_args =& $args;
        } else {
            wp_parse_str($args, $parsed_args);
        }

        if (is_array($defaults) && $defaults) {
            return array_merge($defaults, $parsed_args);
        }
        return $parsed_args;
    }
}
if (!function_exists('wp_list_sort')) {

    function wp_list_sort($list, $orderby = array(), $order = 'ASC', $preserve_keys = false)
    {
        if (!is_array($list)) {
            return array();
        }

        $util = new WP_List_Util($list);

        return $util->sort($orderby, $order, $preserve_keys);
    }
}
if (!function_exists('wp_verify_nonce')) {

    function wp_verify_nonce($nonce, $action = -1)
    {
        // todo:Verifies that a correct security nonce was used with time limit.
        return true;
    }
}
if (!function_exists('wp_allowed_protocols')) {

    function wp_allowed_protocols()
    {
        static $protocols = array();

        if (empty($protocols)) {
            $protocols = array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'irc6', 'ircs', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'sms', 'svn', 'tel', 'fax', 'xmpp', 'webcal', 'urn');
        }

        return $protocols;
    }
}
if (!function_exists('wp_kses_no_null')) {

    function wp_kses_no_null($string, $options = null)
    {
        if (!isset($options['slash_zero'])) {
            $options = array('slash_zero' => 'remove');
        }

        $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $string);
        if ('remove' === $options['slash_zero']) {
            $string = preg_replace('/\\\\+0+/', '', $string);
        }

        return $string;
    }
}
if (!function_exists('wp_kses_split')) {

    function wp_kses_split($string, $allowed_html, $allowed_protocols)
    {
        global $pass_allowed_html, $pass_allowed_protocols;

        $pass_allowed_html = $allowed_html;
        $pass_allowed_protocols = $allowed_protocols;

        return preg_replace_callback('%(<!--.*?(-->|$))|(<[^>]*(>|$)|>)%', '_wp_kses_split_callback', $string);
    }
}
if (!function_exists('wp_kses')) {

    function wp_kses($string, $allowed_html, $allowed_protocols = array())
    {
        if (empty($allowed_protocols)) {
            $allowed_protocols = wp_allowed_protocols();
        }

        $string = wp_kses_no_null($string, array('slash_zero' => 'keep'));
        $string = wp_kses_normalize_entities($string);

        return wp_kses_split($string, $allowed_html, $allowed_protocols);
    }
}
if (!function_exists('wp_kses_post')) {

    function wp_kses_post($data)
    {
        return wp_kses($data, 'post');
    }
}
if (!function_exists('wp_kses_post_deep')) {

    function wp_kses_post_deep($data)
    {
        return map_deep($data, 'wp_kses_post');
    }
}
if (!function_exists('esc_html')) {

    function esc_html($text)
    {
        $safe_text = wp_check_invalid_utf8($text);
        $safe_text = _wp_specialchars($safe_text, ENT_QUOTES);
        /**
         * Filters a string cleaned and escaped for output in HTML.
         *
         * Text passed to esc_html() is stripped of invalid or special characters
         * before output.
         *
         * @param string $safe_text The text after it has been escaped.
         * @param string $text The text prior to being escaped.
         * @since 2.8.0
         *
         */
        return apply_filters('esc_html', $safe_text, $text);
    }
}
if (!function_exists('esc_html__')) {

    function esc_html__($text, $domain = 'default')
    {
        return esc_html(\Typecho\I18n::translate($text));
    }
}
if (!function_exists('esc_html_e')) {

    function esc_html_e($text, $domain = 'default')
    {
        echo esc_html(\Typecho\I18n::translate($text));
    }
}
if (!function_exists('__')) {

    function __($text, $domain = 'default')
    {
        return \Typecho\I18n::translate($text);
    }
}
if (!function_exists('_x')) {

    function _x($text, $context, $domain = 'default')
    {
        return \Typecho\I18n::translate($text);
    }
}
if (!function_exists('_ex')) {

    function _ex($text, $context, $domain = 'default')
    {
        echo _x($text, $context, $domain);
    }
}
if (!function_exists('esc_like')) {

    function esc_like($text)
    {
        return addcslashes($text, '_%\\');
    }
}
if (!function_exists('esc_attr_e')) {

    function esc_attr_e($text, $domain = 'default')
    {
        echo esc_attr(\Typecho\I18n::translate($text));
    }
}
if (!function_exists('is_user_logged_in')) {

    function is_user_logged_in()
    {
        $user = \Typecho\Widget::widget('Widget_User');
        return $user->hasLogin();
    }
}
if (!function_exists('wp_referer_field')) {
    function wp_referer_field($echo = true)
    {
        $referer_field = '<input type="hidden" name="_wp_http_referer" value="' . esc_attr(wp_unslash($_SERVER['REQUEST_URI'])) . '" />';

        if ($echo) {
            echo $referer_field;
        }

        return $referer_field;
    }
}
if (!function_exists('wp_nonce_field')) {

    function wp_nonce_field($action = -1, $name = '_wpnonce', $referer = true, $echo = true)
    {
        $name = esc_attr($name);
        $nonce_field = '<input type="hidden" id="' . $name . '" name="' . $name . '" value="' . $action . '" />';

        if ($referer) {
            $nonce_field .= wp_referer_field(false);
        }

        if ($echo) {
            echo $nonce_field;
        }

        return $nonce_field;
    }
}
if (!function_exists('mbstring_binary_safe_encoding')) {

    function mbstring_binary_safe_encoding($reset = false)
    {
        static $encodings = array();
        static $overloaded = null;

        if (is_null($overloaded)) {
            if (function_exists('mb_internal_encoding')
                && ((int)ini_get('mbstring.func_overload') & 2) // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.mbstring_func_overloadDeprecated
            ) {
                $overloaded = true;
            } else {
                $overloaded = false;
            }
        }

        if (false === $overloaded) {
            return;
        }

        if (!$reset) {
            $encoding = mb_internal_encoding();
            array_push($encodings, $encoding);
            mb_internal_encoding('ISO-8859-1');
        }

        if ($reset && $encodings) {
            $encoding = array_pop($encodings);
            mb_internal_encoding($encoding);
        }
    }
}
if (!function_exists('reset_mbstring_encoding')) {

    function reset_mbstring_encoding()
    {
        mbstring_binary_safe_encoding(true);
    }
}
if (!function_exists('seems_utf8')) {

    function seems_utf8($str)
    {
        mbstring_binary_safe_encoding();
        $length = strlen($str);
        reset_mbstring_encoding();
        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) {
                $n = 0; // 0bbbbbbb
            } elseif (($c & 0xE0) == 0xC0) {
                $n = 1; // 110bbbbb
            } elseif (($c & 0xF0) == 0xE0) {
                $n = 2; // 1110bbbb
            } elseif (($c & 0xF8) == 0xF0) {
                $n = 3; // 11110bbb
            } elseif (($c & 0xFC) == 0xF8) {
                $n = 4; // 111110bb
            } elseif (($c & 0xFE) == 0xFC) {
                $n = 5; // 1111110b
            } else {
                return false; // Does not match any model.
            }
            for ($j = 0; $j < $n; $j++) { // n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80)) {
                    return false;
                }
            }
        }
        return true;
    }
}
if (!function_exists('remove_accents')) {

    function remove_accents($string)
    {
        if (!preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }

        if (seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement.
                'ª' => 'a',
                'º' => 'o',
                'À' => 'A',
                'Á' => 'A',
                'Â' => 'A',
                'Ã' => 'A',
                'Ä' => 'A',
                'Å' => 'A',
                'Æ' => 'AE',
                'Ç' => 'C',
                'È' => 'E',
                'É' => 'E',
                'Ê' => 'E',
                'Ë' => 'E',
                'Ì' => 'I',
                'Í' => 'I',
                'Î' => 'I',
                'Ï' => 'I',
                'Ð' => 'D',
                'Ñ' => 'N',
                'Ò' => 'O',
                'Ó' => 'O',
                'Ô' => 'O',
                'Õ' => 'O',
                'Ö' => 'O',
                'Ù' => 'U',
                'Ú' => 'U',
                'Û' => 'U',
                'Ü' => 'U',
                'Ý' => 'Y',
                'Þ' => 'TH',
                'ß' => 's',
                'à' => 'a',
                'á' => 'a',
                'â' => 'a',
                'ã' => 'a',
                'ä' => 'a',
                'å' => 'a',
                'æ' => 'ae',
                'ç' => 'c',
                'è' => 'e',
                'é' => 'e',
                'ê' => 'e',
                'ë' => 'e',
                'ì' => 'i',
                'í' => 'i',
                'î' => 'i',
                'ï' => 'i',
                'ð' => 'd',
                'ñ' => 'n',
                'ò' => 'o',
                'ó' => 'o',
                'ô' => 'o',
                'õ' => 'o',
                'ö' => 'o',
                'ø' => 'o',
                'ù' => 'u',
                'ú' => 'u',
                'û' => 'u',
                'ü' => 'u',
                'ý' => 'y',
                'þ' => 'th',
                'ÿ' => 'y',
                'Ø' => 'O',
                // Decompositions for Latin Extended-A.
                'Ā' => 'A',
                'ā' => 'a',
                'Ă' => 'A',
                'ă' => 'a',
                'Ą' => 'A',
                'ą' => 'a',
                'Ć' => 'C',
                'ć' => 'c',
                'Ĉ' => 'C',
                'ĉ' => 'c',
                'Ċ' => 'C',
                'ċ' => 'c',
                'Č' => 'C',
                'č' => 'c',
                'Ď' => 'D',
                'ď' => 'd',
                'Đ' => 'D',
                'đ' => 'd',
                'Ē' => 'E',
                'ē' => 'e',
                'Ĕ' => 'E',
                'ĕ' => 'e',
                'Ė' => 'E',
                'ė' => 'e',
                'Ę' => 'E',
                'ę' => 'e',
                'Ě' => 'E',
                'ě' => 'e',
                'Ĝ' => 'G',
                'ĝ' => 'g',
                'Ğ' => 'G',
                'ğ' => 'g',
                'Ġ' => 'G',
                'ġ' => 'g',
                'Ģ' => 'G',
                'ģ' => 'g',
                'Ĥ' => 'H',
                'ĥ' => 'h',
                'Ħ' => 'H',
                'ħ' => 'h',
                'Ĩ' => 'I',
                'ĩ' => 'i',
                'Ī' => 'I',
                'ī' => 'i',
                'Ĭ' => 'I',
                'ĭ' => 'i',
                'Į' => 'I',
                'į' => 'i',
                'İ' => 'I',
                'ı' => 'i',
                'Ĳ' => 'IJ',
                'ĳ' => 'ij',
                'Ĵ' => 'J',
                'ĵ' => 'j',
                'Ķ' => 'K',
                'ķ' => 'k',
                'ĸ' => 'k',
                'Ĺ' => 'L',
                'ĺ' => 'l',
                'Ļ' => 'L',
                'ļ' => 'l',
                'Ľ' => 'L',
                'ľ' => 'l',
                'Ŀ' => 'L',
                'ŀ' => 'l',
                'Ł' => 'L',
                'ł' => 'l',
                'Ń' => 'N',
                'ń' => 'n',
                'Ņ' => 'N',
                'ņ' => 'n',
                'Ň' => 'N',
                'ň' => 'n',
                'ŉ' => 'n',
                'Ŋ' => 'N',
                'ŋ' => 'n',
                'Ō' => 'O',
                'ō' => 'o',
                'Ŏ' => 'O',
                'ŏ' => 'o',
                'Ő' => 'O',
                'ő' => 'o',
                'Œ' => 'OE',
                'œ' => 'oe',
                'Ŕ' => 'R',
                'ŕ' => 'r',
                'Ŗ' => 'R',
                'ŗ' => 'r',
                'Ř' => 'R',
                'ř' => 'r',
                'Ś' => 'S',
                'ś' => 's',
                'Ŝ' => 'S',
                'ŝ' => 's',
                'Ş' => 'S',
                'ş' => 's',
                'Š' => 'S',
                'š' => 's',
                'Ţ' => 'T',
                'ţ' => 't',
                'Ť' => 'T',
                'ť' => 't',
                'Ŧ' => 'T',
                'ŧ' => 't',
                'Ũ' => 'U',
                'ũ' => 'u',
                'Ū' => 'U',
                'ū' => 'u',
                'Ŭ' => 'U',
                'ŭ' => 'u',
                'Ů' => 'U',
                'ů' => 'u',
                'Ű' => 'U',
                'ű' => 'u',
                'Ų' => 'U',
                'ų' => 'u',
                'Ŵ' => 'W',
                'ŵ' => 'w',
                'Ŷ' => 'Y',
                'ŷ' => 'y',
                'Ÿ' => 'Y',
                'Ź' => 'Z',
                'ź' => 'z',
                'Ż' => 'Z',
                'ż' => 'z',
                'Ž' => 'Z',
                'ž' => 'z',
                'ſ' => 's',
                // Decompositions for Latin Extended-B.
                'Ș' => 'S',
                'ș' => 's',
                'Ț' => 'T',
                'ț' => 't',
                // Euro sign.
                '€' => 'E',
                // GBP (Pound) sign.
                '£' => '',
                // Vowels with diacritic (Vietnamese).
                // Unmarked.
                'Ơ' => 'O',
                'ơ' => 'o',
                'Ư' => 'U',
                'ư' => 'u',
                // Grave accent.
                'Ầ' => 'A',
                'ầ' => 'a',
                'Ằ' => 'A',
                'ằ' => 'a',
                'Ề' => 'E',
                'ề' => 'e',
                'Ồ' => 'O',
                'ồ' => 'o',
                'Ờ' => 'O',
                'ờ' => 'o',
                'Ừ' => 'U',
                'ừ' => 'u',
                'Ỳ' => 'Y',
                'ỳ' => 'y',
                // Hook.
                'Ả' => 'A',
                'ả' => 'a',
                'Ẩ' => 'A',
                'ẩ' => 'a',
                'Ẳ' => 'A',
                'ẳ' => 'a',
                'Ẻ' => 'E',
                'ẻ' => 'e',
                'Ể' => 'E',
                'ể' => 'e',
                'Ỉ' => 'I',
                'ỉ' => 'i',
                'Ỏ' => 'O',
                'ỏ' => 'o',
                'Ổ' => 'O',
                'ổ' => 'o',
                'Ở' => 'O',
                'ở' => 'o',
                'Ủ' => 'U',
                'ủ' => 'u',
                'Ử' => 'U',
                'ử' => 'u',
                'Ỷ' => 'Y',
                'ỷ' => 'y',
                // Tilde.
                'Ẫ' => 'A',
                'ẫ' => 'a',
                'Ẵ' => 'A',
                'ẵ' => 'a',
                'Ẽ' => 'E',
                'ẽ' => 'e',
                'Ễ' => 'E',
                'ễ' => 'e',
                'Ỗ' => 'O',
                'ỗ' => 'o',
                'Ỡ' => 'O',
                'ỡ' => 'o',
                'Ữ' => 'U',
                'ữ' => 'u',
                'Ỹ' => 'Y',
                'ỹ' => 'y',
                // Acute accent.
                'Ấ' => 'A',
                'ấ' => 'a',
                'Ắ' => 'A',
                'ắ' => 'a',
                'Ế' => 'E',
                'ế' => 'e',
                'Ố' => 'O',
                'ố' => 'o',
                'Ớ' => 'O',
                'ớ' => 'o',
                'Ứ' => 'U',
                'ứ' => 'u',
                // Dot below.
                'Ạ' => 'A',
                'ạ' => 'a',
                'Ậ' => 'A',
                'ậ' => 'a',
                'Ặ' => 'A',
                'ặ' => 'a',
                'Ẹ' => 'E',
                'ẹ' => 'e',
                'Ệ' => 'E',
                'ệ' => 'e',
                'Ị' => 'I',
                'ị' => 'i',
                'Ọ' => 'O',
                'ọ' => 'o',
                'Ộ' => 'O',
                'ộ' => 'o',
                'Ợ' => 'O',
                'ợ' => 'o',
                'Ụ' => 'U',
                'ụ' => 'u',
                'Ự' => 'U',
                'ự' => 'u',
                'Ỵ' => 'Y',
                'ỵ' => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin).
                'ɑ' => 'a',
                // Macron.
                'Ǖ' => 'U',
                'ǖ' => 'u',
                // Acute accent.
                'Ǘ' => 'U',
                'ǘ' => 'u',
                // Caron.
                'Ǎ' => 'A',
                'ǎ' => 'a',
                'Ǐ' => 'I',
                'ǐ' => 'i',
                'Ǒ' => 'O',
                'ǒ' => 'o',
                'Ǔ' => 'U',
                'ǔ' => 'u',
                'Ǚ' => 'U',
                'ǚ' => 'u',
                // Grave accent.
                'Ǜ' => 'U',
                'ǜ' => 'u',
            );

            // Used for locale-specific rules.
            $locale = get_locale();

            if (in_array($locale, array('de_DE', 'de_DE_formal', 'de_CH', 'de_CH_informal', 'de_AT'), true)) {
                $chars['Ä'] = 'Ae';
                $chars['ä'] = 'ae';
                $chars['Ö'] = 'Oe';
                $chars['ö'] = 'oe';
                $chars['Ü'] = 'Ue';
                $chars['ü'] = 'ue';
                $chars['ß'] = 'ss';
            } elseif ('da_DK' === $locale) {
                $chars['Æ'] = 'Ae';
                $chars['æ'] = 'ae';
                $chars['Ø'] = 'Oe';
                $chars['ø'] = 'oe';
                $chars['Å'] = 'Aa';
                $chars['å'] = 'aa';
            } elseif ('ca' === $locale) {
                $chars['l·l'] = 'll';
            } elseif ('sr_RS' === $locale || 'bs_BA' === $locale) {
                $chars['Đ'] = 'DJ';
                $chars['đ'] = 'dj';
            }

            $string = strtr($string, $chars);
        } else {
            $chars = array();
            // Assume ISO-8859-1 if not UTF-8.
            $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
                . "\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
                . "\xc3\xc4\xc5\xc7\xc8\xc9\xca"
                . "\xcb\xcc\xcd\xce\xcf\xd1\xd2"
                . "\xd3\xd4\xd5\xd6\xd8\xd9\xda"
                . "\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
                . "\xe4\xe5\xe7\xe8\xe9\xea\xeb"
                . "\xec\xed\xee\xef\xf1\xf2\xf3"
                . "\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
                . "\xfc\xfd\xff";

            $chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars = array();
            $double_chars['in'] = array("\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe");
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }
}
if (!function_exists('sanitize_title')) {

    function sanitize_title($title, $fallback_title = '', $context = 'save')
    {
        $raw_title = $title;

        if ('save' === $context) {
            $title = remove_accents($title);
        }

        /**
         * Filters a sanitized title string.
         *
         * @param string $title Sanitized title.
         * @param string $raw_title The title prior to sanitization.
         * @param string $context The context for which the title is being sanitized.
         * @since 1.2.0
         *
         */
        $title = apply_filters('sanitize_title', $title, $raw_title, $context);

        if ('' === $title || false === $title) {
            $title = $fallback_title;
        }

        return $title;
    }
}
global $allowedposttags, $allowedtags, $allowedentitynames, $allowedxmlentitynames;
if (!function_exists('wp_kses_named_entities')) {

    function wp_kses_named_entities($matches)
    {
        global $allowedentitynames;

        if (empty($matches[1])) {
            return '';
        }

        $i = $matches[1];
        return (!in_array($i, $allowedentitynames, true)) ? "&amp;$i;" : "&$i;";
    }
}
if (!function_exists('valid_unicode')) {

    function valid_unicode($i)
    {
        return (0x9 == $i || 0xa == $i || 0xd == $i ||
            (0x20 <= $i && $i <= 0xd7ff) ||
            (0xe000 <= $i && $i <= 0xfffd) ||
            (0x10000 <= $i && $i <= 0x10ffff));
    }
}
if (!function_exists('wp_kses_normalize_entities2')) {

    function wp_kses_normalize_entities2($matches)
    {
        if (empty($matches[1])) {
            return '';
        }

        $i = $matches[1];
        if (valid_unicode($i)) {
            $i = str_pad(ltrim($i, '0'), 3, '0', STR_PAD_LEFT);
            $i = "&#$i;";
        } else {
            $i = "&amp;#$i;";
        }

        return $i;
    }
}
if (!function_exists('wp_kses_normalize_entities3')) {

    function wp_kses_normalize_entities3($matches)
    {
        if (empty($matches[1])) {
            return '';
        }

        $hexchars = $matches[1];
        return (!valid_unicode(hexdec($hexchars))) ? "&amp;#x$hexchars;" : '&#x' . ltrim($hexchars, '0') . ';';
    }
}
if (!function_exists('_wp_kses_split_callback')) {

    function _wp_kses_split_callback($match)
    {
        global $pass_allowed_html, $pass_allowed_protocols;

        return wp_kses_split2($match[0], $pass_allowed_html, $pass_allowed_protocols);
    }
}
if (!function_exists('wp_kses_stripslashes')) {

    function wp_kses_stripslashes($string)
    {
        return preg_replace('%\\\\"%', '"', $string);
    }
}
if (!defined('CUSTOM_TAGS')) {
    define('CUSTOM_TAGS', false);
}
if (!function_exists('wp_kses_allowed_html')) {

    function wp_kses_allowed_html($context = '')
    {
        global $allowedposttags, $allowedtags, $allowedentitynames;

        if (is_array($context)) {
            // When `$context` is an array it's actually an array of allowed HTML elements and attributes.
            $html = $context;
            $context = 'explicit';

            /**
             * Filters the HTML tags that are allowed for a given context.
             *
             * @param array[] $html Allowed HTML tags.
             * @param string $context Context name.
             * @since 3.5.0
             *
             */
            return apply_filters('wp_kses_allowed_html', $html, $context);
        }

        switch ($context) {
            case 'post':
                /** This filter is documented in wp-includes/kses.php */
                $tags = apply_filters('wp_kses_allowed_html', $allowedposttags, $context);

                // 5.0.1 removed the `<form>` tag, allow it if a filter is allowing it's sub-elements `<input>` or `<select>`.
                if (!CUSTOM_TAGS && !isset($tags['form']) && (isset($tags['input']) || isset($tags['select']))) {
                    $tags = $allowedposttags;

                    $tags['form'] = array(
                        'action' => true,
                        'accept' => true,
                        'accept-charset' => true,
                        'enctype' => true,
                        'method' => true,
                        'name' => true,
                        'target' => true,
                    );

                    /** This filter is documented in wp-includes/kses.php */
                    $tags = apply_filters('wp_kses_allowed_html', $tags, $context);
                }

                return $tags;

            case 'user_description':
            case 'pre_user_description':
                $tags = $allowedtags;
                $tags['a']['rel'] = true;
                /** This filter is documented in wp-includes/kses.php */
                return apply_filters('wp_kses_allowed_html', $tags, $context);

            case 'strip':
                /** This filter is documented in wp-includes/kses.php */
                return apply_filters('wp_kses_allowed_html', array(), $context);

            case 'entities':
                /** This filter is documented in wp-includes/kses.php */
                return apply_filters('wp_kses_allowed_html', $allowedentitynames, $context);

            case 'data':
            default:
                /** This filter is documented in wp-includes/kses.php */
                return apply_filters('wp_kses_allowed_html', $allowedtags, $context);
        }
    }
}
if (!function_exists('wp_kses_uri_attributes')) {

    function wp_kses_uri_attributes()
    {
        $uri_attributes = array(
            'action',
            'archive',
            'background',
            'cite',
            'classid',
            'codebase',
            'data',
            'formaction',
            'href',
            'icon',
            'longdesc',
            'manifest',
            'poster',
            'profile',
            'src',
            'usemap',
            'xmlns',
        );

        /**
         * Filters the list of attributes that are required to contain a URL.
         *
         * Use this filter to add any `data-` attributes that are required to be
         * validated as a URL.
         *
         * @param string[] $uri_attributes HTML attribute names whose value contains a URL.
         * @since 5.0.1
         *
         */
        $uri_attributes = apply_filters('wp_kses_uri_attributes', $uri_attributes);

        return $uri_attributes;
    }
}
if (!function_exists('wp_kses_bad_protocol_once')) {

    function wp_kses_bad_protocol_once($string, $allowed_protocols, $count = 1)
    {
        $string = preg_replace('/(&#0*58(?![;0-9])|&#x0*3a(?![;a-f0-9]))/i', '$1;', $string);
        $string2 = preg_split('/:|&#0*58;|&#x0*3a;|&colon;/i', $string, 2);
        if (isset($string2[1]) && !preg_match('%/\?%', $string2[0])) {
            $string = trim($string2[1]);
            $protocol = wp_kses_bad_protocol_once2($string2[0], $allowed_protocols);
            if ('feed:' === $protocol) {
                if ($count > 2) {
                    return '';
                }
                $string = wp_kses_bad_protocol_once($string, $allowed_protocols, ++$count);
                if (empty($string)) {
                    return $string;
                }
            }
            $string = $protocol . $string;
        }

        return $string;
    }
}
if (!function_exists('wp_kses_decode_entities')) {

    function wp_kses_decode_entities($string)
    {
        $string = preg_replace_callback('/&#([0-9]+);/', '_wp_kses_decode_entities_chr', $string);
        $string = preg_replace_callback('/&#[Xx]([0-9A-Fa-f]+);/', '_wp_kses_decode_entities_chr_hexdec', $string);

        return $string;
    }
}
if (!function_exists('wp_kses_bad_protocol_once2')) {

    function wp_kses_bad_protocol_once2($string, $allowed_protocols)
    {
        $string2 = wp_kses_decode_entities($string);
        $string2 = preg_replace('/\s/', '', $string2);
        $string2 = wp_kses_no_null($string2);
        $string2 = strtolower($string2);

        $allowed = false;
        foreach ((array)$allowed_protocols as $one_protocol) {
            if (strtolower($one_protocol) == $string2) {
                $allowed = true;
                break;
            }
        }

        if ($allowed) {
            return "$string2:";
        } else {
            return '';
        }
    }
}
if (!function_exists('wp_kses_bad_protocol')) {

    function wp_kses_bad_protocol($string, $allowed_protocols)
    {
        $string = wp_kses_no_null($string);
        $iterations = 0;

        do {
            $original_string = $string;
            $string = wp_kses_bad_protocol_once($string, $allowed_protocols);
        } while ($original_string != $string && ++$iterations < 6);

        if ($original_string != $string) {
            return '';
        }

        return $string;
    }
}
if (!function_exists('wp_kses_hair')) {

    function wp_kses_hair($attr, $allowed_protocols)
    {
        $attrarr = array();
        $mode = 0;
        $attrname = '';
        $uris = wp_kses_uri_attributes();

        // Loop through the whole attribute list.

        while (strlen($attr) != 0) {
            $working = 0; // Was the last operation successful?

            switch ($mode) {
                case 0:
                    if (preg_match('/^([_a-zA-Z][-_a-zA-Z0-9:.]*)/', $attr, $match)) {
                        $attrname = $match[1];
                        $working = 1;
                        $mode = 1;
                        $attr = preg_replace('/^[_a-zA-Z][-_a-zA-Z0-9:.]*/', '', $attr);
                    }

                    break;

                case 1:
                    if (preg_match('/^\s*=\s*/', $attr)) { // Equals sign.
                        $working = 1;
                        $mode = 2;
                        $attr = preg_replace('/^\s*=\s*/', '', $attr);
                        break;
                    }

                    if (preg_match('/^\s+/', $attr)) { // Valueless.
                        $working = 1;
                        $mode = 0;
                        if (false === array_key_exists($attrname, $attrarr)) {
                            $attrarr[$attrname] = array(
                                'name' => $attrname,
                                'value' => '',
                                'whole' => $attrname,
                                'vless' => 'y',
                            );
                        }
                        $attr = preg_replace('/^\s+/', '', $attr);
                    }

                    break;

                case 2:
                    if (preg_match('%^"([^"]*)"(\s+|/?$)%', $attr, $match)) {
                        // "value"
                        $thisval = $match[1];
                        if (in_array(strtolower($attrname), $uris, true)) {
                            $thisval = wp_kses_bad_protocol($thisval, $allowed_protocols);
                        }

                        if (false === array_key_exists($attrname, $attrarr)) {
                            $attrarr[$attrname] = array(
                                'name' => $attrname,
                                'value' => $thisval,
                                'whole' => "$attrname=\"$thisval\"",
                                'vless' => 'n',
                            );
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace('/^"[^"]*"(\s+|$)/', '', $attr);
                        break;
                    }

                    if (preg_match("%^'([^']*)'(\s+|/?$)%", $attr, $match)) {
                        // 'value'
                        $thisval = $match[1];
                        if (in_array(strtolower($attrname), $uris, true)) {
                            $thisval = wp_kses_bad_protocol($thisval, $allowed_protocols);
                        }

                        if (false === array_key_exists($attrname, $attrarr)) {
                            $attrarr[$attrname] = array(
                                'name' => $attrname,
                                'value' => $thisval,
                                'whole' => "$attrname='$thisval'",
                                'vless' => 'n',
                            );
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("/^'[^']*'(\s+|$)/", '', $attr);
                        break;
                    }

                    if (preg_match("%^([^\s\"']+)(\s+|/?$)%", $attr, $match)) {
                        // value
                        $thisval = $match[1];
                        if (in_array(strtolower($attrname), $uris, true)) {
                            $thisval = wp_kses_bad_protocol($thisval, $allowed_protocols);
                        }

                        if (false === array_key_exists($attrname, $attrarr)) {
                            $attrarr[$attrname] = array(
                                'name' => $attrname,
                                'value' => $thisval,
                                'whole' => "$attrname=\"$thisval\"",
                                'vless' => 'n',
                            );
                        }
                        // We add quotes to conform to W3C's HTML spec.
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("%^[^\s\"']+(\s+|$)%", '', $attr);
                    }

                    break;
            } // End switch.

            if (0 == $working) { // Not well-formed, remove and try again.
                $attr = wp_kses_html_error($attr);
                $mode = 0;
            }
        } // End while.

        if (1 == $mode && false === array_key_exists($attrname, $attrarr)) {
            // Special case, for when the attribute list ends with a valueless
            // attribute like "selected".
            $attrarr[$attrname] = array(
                'name' => $attrname,
                'value' => '',
                'whole' => $attrname,
                'vless' => 'y',
            );
        }

        return $attrarr;
    }
}
if (!function_exists('wp_kses_html_error')) {

    function wp_kses_html_error($string)
    {
        return preg_replace('/^("[^"]*("|$)|\'[^\']*(\'|$)|\S)*\s*/', '', $string);
    }
}
if (!function_exists('wp_kses_attr')) {

    function wp_kses_attr($element, $attr, $allowed_html, $allowed_protocols)
    {
        if (!is_array($allowed_html)) {
            $allowed_html = wp_kses_allowed_html($allowed_html);
        }

        // Is there a closing XHTML slash at the end of the attributes?
        $xhtml_slash = '';
        if (preg_match('%\s*/\s*$%', $attr)) {
            $xhtml_slash = ' /';
        }

        // Are any attributes allowed at all for this element?
        $element_low = strtolower($element);
        if (empty($allowed_html[$element_low]) || true === $allowed_html[$element_low]) {
            return "<$element$xhtml_slash>";
        }

        // Split it.
        $attrarr = wp_kses_hair($attr, $allowed_protocols);

        // Check if there are attributes that are required.
        $required_attrs = array_filter(
            $allowed_html[$element_low],
            function ($required_attr_limits) {
                return isset($required_attr_limits['required']) && true === $required_attr_limits['required'];
            }
        );

        /*
         * If a required attribute check fails, we can return nothing for a self-closing tag,
         * but for a non-self-closing tag the best option is to return the element with attributes,
         * as KSES doesn't handle matching the relevant closing tag.
         */
        $stripped_tag = '';
        if (empty($xhtml_slash)) {
            $stripped_tag = "<$element>";
        }

        // Go through $attrarr, and save the allowed attributes for this element in $attr2.
        $attr2 = '';
        foreach ($attrarr as $arreach) {
            // Check if this attribute is required.
            $required = isset($required_attrs[strtolower($arreach['name'])]);

            if (wp_kses_attr_check($arreach['name'], $arreach['value'], $arreach['whole'], $arreach['vless'], $element, $allowed_html)) {
                $attr2 .= ' ' . $arreach['whole'];

                // If this was a required attribute, we can mark it as found.
                if ($required) {
                    unset($required_attrs[strtolower($arreach['name'])]);
                }
            } elseif ($required) {
                // This attribute was required, but didn't pass the check. The entire tag is not allowed.
                return $stripped_tag;
            }
        }

        // If some required attributes weren't set, the entire tag is not allowed.
        if (!empty($required_attrs)) {
            return $stripped_tag;
        }

        // Remove any "<" or ">" characters.
        $attr2 = preg_replace('/[<>]/', '', $attr2);

        return "<$element$attr2$xhtml_slash>";
    }
}
if (!function_exists('wp_kses_attr_check')) {

    function wp_kses_attr_check(&$name, &$value, &$whole, $vless, $element, $allowed_html)
    {
        $name_low = strtolower($name);
        $element_low = strtolower($element);

        if (!isset($allowed_html[$element_low])) {
            $name = '';
            $value = '';
            $whole = '';
            return false;
        }

        $allowed_attr = $allowed_html[$element_low];

        if (!isset($allowed_attr[$name_low]) || '' === $allowed_attr[$name_low]) {
            /*
             * Allow `data-*` attributes.
             *
             * When specifying `$allowed_html`, the attribute name should be set as
             * `data-*` (not to be mixed with the HTML 4.0 `data` attribute, see
             * https://www.w3.org/TR/html40/struct/objects.html#adef-data).
             *
             * Note: the attribute name should only contain `A-Za-z0-9_-` chars,
             * double hyphens `--` are not accepted by WordPress.
             */
            if (strpos($name_low, 'data-') === 0 && !empty($allowed_attr['data-*']) && preg_match('/^data(?:-[a-z0-9_]+)+$/', $name_low, $match)) {
                /*
                 * Add the whole attribute name to the allowed attributes and set any restrictions
                 * for the `data-*` attribute values for the current element.
                 */
                $allowed_attr[$match[0]] = $allowed_attr['data-*'];
            } else {
                $name = '';
                $value = '';
                $whole = '';
                return false;
            }
        }

        if ('style' === $name_low) {
            $new_value = safecss_filter_attr($value);

            if (empty($new_value)) {
                $name = '';
                $value = '';
                $whole = '';
                return false;
            }

            $whole = str_replace($value, $new_value, $whole);
            $value = $new_value;
        }

        if (is_array($allowed_attr[$name_low])) {
            // There are some checks.
            foreach ($allowed_attr[$name_low] as $currkey => $currval) {
                if (!wp_kses_check_attr_val($value, $vless, $currkey, $currval)) {
                    $name = '';
                    $value = '';
                    $whole = '';
                    return false;
                }
            }
        }

        return true;
    }
}
if (!function_exists('wp_kses_check_attr_val')) {

    function wp_kses_check_attr_val($value, $vless, $checkname, $checkvalue)
    {
        $ok = true;

        switch (strtolower($checkname)) {
            case 'maxlen':
                /*
                 * The maxlen check makes sure that the attribute value has a length not
                 * greater than the given value. This can be used to avoid Buffer Overflows
                 * in WWW clients and various Internet servers.
                 */

                if (strlen($value) > $checkvalue) {
                    $ok = false;
                }
                break;

            case 'minlen':
                /*
                 * The minlen check makes sure that the attribute value has a length not
                 * smaller than the given value.
                 */

                if (strlen($value) < $checkvalue) {
                    $ok = false;
                }
                break;

            case 'maxval':
                /*
                 * The maxval check does two things: it checks that the attribute value is
                 * an integer from 0 and up, without an excessive amount of zeroes or
                 * whitespace (to avoid Buffer Overflows). It also checks that the attribute
                 * value is not greater than the given value.
                 * This check can be used to avoid Denial of Service attacks.
                 */

                if (!preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/', $value)) {
                    $ok = false;
                }
                if ($value > $checkvalue) {
                    $ok = false;
                }
                break;

            case 'minval':
                /*
                 * The minval check makes sure that the attribute value is a positive integer,
                 * and that it is not smaller than the given value.
                 */

                if (!preg_match('/^\s{0,6}[0-9]{1,6}\s{0,6}$/', $value)) {
                    $ok = false;
                }
                if ($value < $checkvalue) {
                    $ok = false;
                }
                break;

            case 'valueless':
                /*
                 * The valueless check makes sure if the attribute has a value
                 * (like `<a href="blah">`) or not (`<option selected>`). If the given value
                 * is a "y" or a "Y", the attribute must not have a value.
                 * If the given value is an "n" or an "N", the attribute must have a value.
                 */

                if (strtolower($checkvalue) != $vless) {
                    $ok = false;
                }
                break;

            case 'values':
                /*
                 * The values check is used when you want to make sure that the attribute
                 * has one of the given values.
                 */

                if (false === array_search(strtolower($value), $checkvalue, true)) {
                    $ok = false;
                }
                break;

            case 'value_callback':
                /*
                 * The value_callback check is used when you want to make sure that the attribute
                 * value is accepted by the callback function.
                 */

                if (!call_user_func($checkvalue, $value)) {
                    $ok = false;
                }
                break;
        } // End switch.

        return $ok;
    }
}
if (!function_exists('safecss_filter_attr')) {

    function safecss_filter_attr($css, $deprecated = '')
    {

        $css = wp_kses_no_null($css);
        $css = str_replace(array("\n", "\r", "\t"), '', $css);

        $allowed_protocols = wp_allowed_protocols();

        $css_array = explode(';', trim($css));

        /**
         * Filters the list of allowed CSS attributes.
         *
         * @param string[] $attr Array of allowed CSS attributes.
         * @since 2.8.1
         *
         */
        $allowed_attr = apply_filters(
            'safe_style_css',
            array(
                'background',
                'background-color',
                'background-image',
                'background-position',
                'background-size',
                'background-attachment',
                'background-blend-mode',

                'border',
                'border-radius',
                'border-width',
                'border-color',
                'border-style',
                'border-right',
                'border-right-color',
                'border-right-style',
                'border-right-width',
                'border-bottom',
                'border-bottom-color',
                'border-bottom-left-radius',
                'border-bottom-right-radius',
                'border-bottom-style',
                'border-bottom-width',
                'border-bottom-right-radius',
                'border-bottom-left-radius',
                'border-left',
                'border-left-color',
                'border-left-style',
                'border-left-width',
                'border-top',
                'border-top-color',
                'border-top-left-radius',
                'border-top-right-radius',
                'border-top-style',
                'border-top-width',
                'border-top-left-radius',
                'border-top-right-radius',

                'border-spacing',
                'border-collapse',
                'caption-side',

                'columns',
                'column-count',
                'column-fill',
                'column-gap',
                'column-rule',
                'column-span',
                'column-width',

                'color',
                'filter',
                'font',
                'font-family',
                'font-size',
                'font-style',
                'font-variant',
                'font-weight',
                'letter-spacing',
                'line-height',
                'text-align',
                'text-decoration',
                'text-indent',
                'text-transform',

                'height',
                'min-height',
                'max-height',

                'width',
                'min-width',
                'max-width',

                'margin',
                'margin-right',
                'margin-bottom',
                'margin-left',
                'margin-top',

                'padding',
                'padding-right',
                'padding-bottom',
                'padding-left',
                'padding-top',

                'flex',
                'flex-basis',
                'flex-direction',
                'flex-flow',
                'flex-grow',
                'flex-shrink',

                'grid-template-columns',
                'grid-auto-columns',
                'grid-column-start',
                'grid-column-end',
                'grid-column-gap',
                'grid-template-rows',
                'grid-auto-rows',
                'grid-row-start',
                'grid-row-end',
                'grid-row-gap',
                'grid-gap',

                'justify-content',
                'justify-items',
                'justify-self',
                'align-content',
                'align-items',
                'align-self',

                'clear',
                'cursor',
                'direction',
                'float',
                'list-style-type',
                'object-position',
                'overflow',
                'vertical-align',
            )
        );

        /*
         * CSS attributes that accept URL data types.
         *
         * This is in accordance to the CSS spec and unrelated to
         * the sub-set of supported attributes above.
         *
         * See: https://developer.mozilla.org/en-US/docs/Web/CSS/url
         */
        $css_url_data_types = array(
            'background',
            'background-image',

            'cursor',

            'list-style',
            'list-style-image',
        );

        /*
         * CSS attributes that accept gradient data types.
         *
         */
        $css_gradient_data_types = array(
            'background',
            'background-image',
        );

        if (empty($allowed_attr)) {
            return $css;
        }

        $css = '';
        foreach ($css_array as $css_item) {
            if ('' === $css_item) {
                continue;
            }

            $css_item = trim($css_item);
            $css_test_string = $css_item;
            $found = false;
            $url_attr = false;
            $gradient_attr = false;

            if (strpos($css_item, ':') === false) {
                $found = true;
            } else {
                $parts = explode(':', $css_item, 2);
                $css_selector = trim($parts[0]);

                if (in_array($css_selector, $allowed_attr, true)) {
                    $found = true;
                    $url_attr = in_array($css_selector, $css_url_data_types, true);
                    $gradient_attr = in_array($css_selector, $css_gradient_data_types, true);
                }
            }

            if ($found && $url_attr) {
                // Simplified: matches the sequence `url(*)`.
                preg_match_all('/url\([^)]+\)/', $parts[1], $url_matches);

                foreach ($url_matches[0] as $url_match) {
                    // Clean up the URL from each of the matches above.
                    preg_match('/^url\(\s*([\'\"]?)(.*)(\g1)\s*\)$/', $url_match, $url_pieces);

                    if (empty($url_pieces[2])) {
                        $found = false;
                        break;
                    }

                    $url = trim($url_pieces[2]);

                    if (empty($url) || wp_kses_bad_protocol($url, $allowed_protocols) !== $url) {
                        $found = false;
                        break;
                    } else {
                        // Remove the whole `url(*)` bit that was matched above from the CSS.
                        $css_test_string = str_replace($url_match, '', $css_test_string);
                    }
                }
            }

            if ($found && $gradient_attr) {
                $css_value = trim($parts[1]);
                if (preg_match('/^(repeating-)?(linear|radial|conic)-gradient\(([^()]|rgb[a]?\([^()]*\))*\)$/', $css_value)) {
                    // Remove the whole `gradient` bit that was matched above from the CSS.
                    $css_test_string = str_replace($css_value, '', $css_test_string);
                }
            }

            if ($found) {
                // Allow CSS calc().
                $css_test_string = preg_replace('/calc\(((?:\([^()]*\)?|[^()])*)\)/', '', $css_test_string);
                // Allow CSS var().
                $css_test_string = preg_replace('/\(?var\(--[a-zA-Z0-9_-]*\)/', '', $css_test_string);

                // Check for any CSS containing \ ( & } = or comments,
                // except for url(), calc(), or var() usage checked above.
                $allow_css = !preg_match('%[\\\(&=}]|/\*%', $css_test_string);

                /**
                 * Filters the check for unsafe CSS in `safecss_filter_attr`.
                 *
                 * Enables developers to determine whether a section of CSS should be allowed or discarded.
                 * By default, the value will be false if the part contains \ ( & } = or comments.
                 * Return true to allow the CSS part to be included in the output.
                 *
                 * @param bool $allow_css Whether the CSS in the test string is considered safe.
                 * @param string $css_test_string The CSS string to test.
                 * @since 5.5.0
                 *
                 */
                $allow_css = apply_filters('safecss_filter_attr_allow_css', $allow_css, $css_test_string);

                // Only add the CSS part if it passes the regex check.
                if ($allow_css) {
                    if ('' !== $css) {
                        $css .= ';';
                    }

                    $css .= $css_item;
                }
            }
        }

        return $css;
    }
}
if (!function_exists('wp_kses_split2')) {

    function wp_kses_split2($string, $allowed_html, $allowed_protocols)
    {
        $string = wp_kses_stripslashes($string);

        // It matched a ">" character.
        if ('<' !== substr($string, 0, 1)) {
            return '&gt;';
        }

        // Allow HTML comments.
        if ('<!--' === substr($string, 0, 4)) {
            $string = str_replace(array('<!--', '-->'), '', $string);
            while (($newstring = wp_kses($string, $allowed_html, $allowed_protocols)) != $string) {
                $string = $newstring;
            }
            if ('' === $string) {
                return '';
            }
            // Prevent multiple dashes in comments.
            $string = preg_replace('/--+/', '-', $string);
            // Prevent three dashes closing a comment.
            $string = preg_replace('/-$/', '', $string);
            return "<!--{$string}-->";
        }

        // It's seriously malformed.
        if (!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9-]+)([^>]*)>?$%', $string, $matches)) {
            return '';
        }

        $slash = trim($matches[1]);
        $elem = $matches[2];
        $attrlist = $matches[3];

        if (!is_array($allowed_html)) {
            $allowed_html = wp_kses_allowed_html($allowed_html);
        }

        // They are using a not allowed HTML element.
        if (!isset($allowed_html[strtolower($elem)])) {
            return '';
        }

        // No attributes are allowed for closing elements.
        if ('' !== $slash) {
            return "</$elem>";
        }

        return wp_kses_attr($elem, $attrlist, $allowed_html, $allowed_protocols);
    }
}
if (!function_exists('_wp_kses_decode_entities_chr_hexdec')) {

    function _wp_kses_decode_entities_chr_hexdec($match)
    {
        return chr(hexdec($match[1]));
    }
}
if (!function_exists('_wp_kses_decode_entities_chr')) {

    function _wp_kses_decode_entities_chr($match)
    {
        return chr($match[1]);
    }
}
if (!function_exists('_deep_replace')) {

    function _deep_replace($search, $subject)
    {
        $subject = (string)$subject;

        $count = 1;
        while ($count) {
            $subject = str_replace($search, '', $subject, $count);
        }

        return $subject;
    }
}
if (!function_exists('_wp_translate_php_url_constant_to_key')) {

    function _wp_translate_php_url_constant_to_key($constant)
    {
        $translation = array(
            PHP_URL_SCHEME => 'scheme',
            PHP_URL_HOST => 'host',
            PHP_URL_PORT => 'port',
            PHP_URL_USER => 'user',
            PHP_URL_PASS => 'pass',
            PHP_URL_PATH => 'path',
            PHP_URL_QUERY => 'query',
            PHP_URL_FRAGMENT => 'fragment',
        );

        if (isset($translation[$constant])) {
            return $translation[$constant];
        } else {
            return false;
        }
    }
}
if (!function_exists('_get_component_from_parsed_url_array')) {

    function _get_component_from_parsed_url_array($url_parts, $component = -1)
    {
        if (-1 === $component) {
            return $url_parts;
        }

        $key = _wp_translate_php_url_constant_to_key($component);
        if (false !== $key && is_array($url_parts) && isset($url_parts[$key])) {
            return $url_parts[$key];
        } else {
            return null;
        }
    }
}
if (!function_exists('wp_parse_url')) {

    function wp_parse_url($url, $component = -1)
    {
        $to_unset = array();
        $url = (string)$url;

        if ('//' === substr($url, 0, 2)) {
            $to_unset[] = 'scheme';
            $url = 'placeholder:' . $url;
        } elseif ('/' === substr($url, 0, 1)) {
            $to_unset[] = 'scheme';
            $to_unset[] = 'host';
            $url = 'placeholder://placeholder' . $url;
        }

        $parts = parse_url($url);

        if (false === $parts) {
            // Parsing failure.
            return $parts;
        }

        // Remove the placeholder values.
        foreach ($to_unset as $key) {
            unset($parts[$key]);
        }

        return _get_component_from_parsed_url_array($parts, $component);
    }
}
if (!function_exists('esc_url')) {

    function esc_url($url, $protocols = null, $_context = 'display')
    {
        $original_url = $url;

        if ('' === $url) {
            return $url;
        }

        $url = str_replace(' ', '%20', ltrim($url));
        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\[\]\\x80-\\xff]|i', '', $url);

        if ('' === $url) {
            return $url;
        }

        if (0 !== stripos($url, 'mailto:')) {
            $strip = array('%0d', '%0a', '%0D', '%0A');
            $url = _deep_replace($strip, $url);
        }

        $url = str_replace(';//', '://', $url);
        /*
         * If the URL doesn't appear to contain a scheme, we presume
         * it needs http:// prepended (unless it's a relative link
         * starting with /, # or ?, or a PHP file).
         */
        if (strpos($url, ':') === false && !in_array($url[0], array('/', '#', '?'), true) &&
            !preg_match('/^[a-z0-9-]+?\.php/i', $url)) {
            $url = 'http://' . $url;
        }

        // Replace ampersands and single quotes only when displaying.
        if ('display' === $_context) {
            $url = wp_kses_normalize_entities($url);
            $url = str_replace('&amp;', '&#038;', $url);
            $url = str_replace("'", '&#039;', $url);
        }

        if ((false !== strpos($url, '[')) || (false !== strpos($url, ']'))) {

            $parsed = wp_parse_url($url);
            $front = '';

            if (isset($parsed['scheme'])) {
                $front .= $parsed['scheme'] . '://';
            } elseif ('/' === $url[0]) {
                $front .= '//';
            }

            if (isset($parsed['user'])) {
                $front .= $parsed['user'];
            }

            if (isset($parsed['pass'])) {
                $front .= ':' . $parsed['pass'];
            }

            if (isset($parsed['user']) || isset($parsed['pass'])) {
                $front .= '@';
            }

            if (isset($parsed['host'])) {
                $front .= $parsed['host'];
            }

            if (isset($parsed['port'])) {
                $front .= ':' . $parsed['port'];
            }

            $end_dirty = str_replace($front, '', $url);
            $end_clean = str_replace(array('[', ']'), array('%5B', '%5D'), $end_dirty);
            $url = str_replace($end_dirty, $end_clean, $url);

        }

        if ('/' === $url[0]) {
            $good_protocol_url = $url;
        } else {
            if (!is_array($protocols)) {
                $protocols = wp_allowed_protocols();
            }
            $good_protocol_url = wp_kses_bad_protocol($url, $protocols);
            if (strtolower($good_protocol_url) != strtolower($url)) {
                return '';
            }
        }

        /**
         * Filters a string cleaned and escaped for output as a URL.
         *
         * @param string $good_protocol_url The cleaned URL to be returned.
         * @param string $original_url The URL prior to cleaning.
         * @param string $_context If 'display', replace ampersands and single quotes only.
         * @since 2.3.0
         *
         */
        return apply_filters('clean_url', $good_protocol_url, $original_url, $_context);
    }
}
if (!function_exists('__checked_selected_helper')) {

    function __checked_selected_helper($helper, $current, $echo, $type)
    { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionDoubleUnderscore,PHPCompatibility.FunctionNameRestrictions.ReservedFunctionNames.FunctionDoubleUnderscore
        if ((string)$helper === (string)$current) {
            $result = " $type='$type'";
        } else {
            $result = '';
        }

        if ($echo) {
            echo $result;
        }

        return $result;
    }
}
if (!function_exists('checked')) {

    function checked($checked, $current = true, $echo = true)
    {
        return __checked_selected_helper($checked, $current, $echo, 'checked');
    }
}
if (!function_exists('selected')) {

    function selected($selected, $current = true, $echo = true)
    {
        return __checked_selected_helper($selected, $current, $echo, 'selected');
    }
}
if (!function_exists('disabled')) {

    function disabled($disabled, $current = true, $echo = true)
    {
        return __checked_selected_helper($disabled, $current, $echo, 'disabled');
    }
}
if (!function_exists('wp_readonly')) {

    function wp_readonly($readonly, $current = true, $echo = true)
    {
        return __checked_selected_helper($readonly, $current, $echo, 'readonly');
    }
}

if (!function_exists('is_rtl')) {

    function is_rtl()
    {
        // nont support this mode
        return false;
    }
}
/**
 * Returns the time-dependent variable for nonce creation.
 *
 * A nonce has a lifespan of two ticks. Nonces in their second tick may be
 * updated, e.g. by autosave.
 *
 * @return float Float value rounded up to the next highest integer.
 * @since 2.5.0
 *
 */
if (!defined('MINUTE_IN_SECONDS')){
    define('MINUTE_IN_SECONDS', 60);
}
if (!defined('HOUR_IN_SECONDS')){
    define('HOUR_IN_SECONDS', 60 * MINUTE_IN_SECONDS);
}
if (!defined('DAY_IN_SECONDS')){
    define('DAY_IN_SECONDS', 24 * HOUR_IN_SECONDS);
}
if (!defined('WEEK_IN_SECONDS')){
    define('WEEK_IN_SECONDS', 7 * DAY_IN_SECONDS);
}
if (!defined('MONTH_IN_SECONDS')){
    define('MONTH_IN_SECONDS', 30 * DAY_IN_SECONDS);
}
if (!defined('YEAR_IN_SECONDS')){
    define('YEAR_IN_SECONDS', 365 * DAY_IN_SECONDS);
}
if (!function_exists('wp_nonce_tick')) :

    function wp_nonce_tick()
    {
        /**
         * Filters the lifespan of nonces in seconds.
         *
         * @param int $lifespan Lifespan of nonces in seconds. Default 86,400 seconds, or one day.
         * @since 2.5.0
         *
         */
        $nonce_life = apply_filters('nonce_life', DAY_IN_SECONDS);

        return ceil(time() / ($nonce_life / 2));
    }
endif;


if (!function_exists('wp_create_nonce')) :
    /**
     * Creates a cryptographic token tied to a specific action, user, user session,
     * and window of time.
     *
     * @param string|int $action Scalar value to add context to the nonce.
     * @return string The token.
     * @since 2.0.3
     * @since 4.0.0 Session tokens were integrated with nonce creation
     *
     */
    function wp_create_nonce($action = -1)
    {
        // todo:add token
//        $user = wp_get_current_user();
//        $uid  = (int) $user->ID;
        $uid = 0;
        if (!$uid) {
            /** This filter is documented in wp-includes/pluggable.php */
            $uid = apply_filters('nonce_user_logged_out', $uid, $action);
        }

//        $token = wp_get_session_token();
        $token = 'todotoken';
        $i = wp_nonce_tick();

        return substr(\Typecho\Common::hash($i . '|' . $action . '|' . $uid . '|' . $token, 'nonce'), -12, 10);
    }
endif;
if (!function_exists('get_locale')) :
    function get_locale()
    {
        return 'zh_CN';
    }

endif;
if (!function_exists('absint')) {

    function absint($maybeint)
    {
        return abs((int)$maybeint);
    }
}
if (!function_exists('get_post_type_object')) {

    function get_post_type_object($post_type)
    {
        // todo:fix global
        global $wp_post_types;

        if (!is_scalar($post_type) || empty($wp_post_types[$post_type])) {
            return null;
        }

        return $wp_post_types[$post_type];
    }
}
if (!function_exists('ty_is_admin')) {

    function ty_is_admin()
    {
        $user = Widget::widget('Widget_User');
        return $user->pass('administrator', false);
    }
}
if (!function_exists('sanitize_key')) {

    function sanitize_key($key)
    {
        $sanitized_key = '';

        if (is_scalar($key)) {
            $sanitized_key = strtolower($key);
            $sanitized_key = preg_replace('/[^a-z0-9_\-]/', '', $sanitized_key);
        }

        /**
         * Filters a sanitized key string.
         *
         * @param string $sanitized_key Sanitized key.
         * @param string $key The key prior to sanitization.
         * @since 3.0.0
         *
         */
        return apply_filters('sanitize_key', $sanitized_key, $key);
    }
}
if (!function_exists('is_wp_error')) {

    function is_wp_error($thing)
    {
        // todo:check this func
        $is_wp_error = ($thing instanceof \Typecho\Exception);


        return $is_wp_error;
    }
}
if (!function_exists('get_current_blog_id')) {

    function get_current_blog_id()
    {
        global $blog_id;
        if (!isset($blog_id)) {
            $blog_id = 1;
        }
        return absint($blog_id);
    }
}
if (!function_exists('get_registered_nav_menus')) {

    function get_registered_nav_menus()
    {
        global $_wp_registered_nav_menus;
        if (isset($_wp_registered_nav_menus)) {
            return $_wp_registered_nav_menus;
        }
        return array();
    }
}
if (!function_exists('is_multisite')) {

    function is_multisite()
    {
        if (defined('MULTISITE')) {
            return MULTISITE;
        }

        if (defined('SUBDOMAIN_INSTALL') || defined('VHOST') || defined('SUNRISE')) {
            return true;
        }

        return false;
    }
}
if (!function_exists('get_post_types')) {

    function get_post_types($args = array(), $output = 'names', $operator = 'and')
    {
//    global $wp_post_types;
//
//    $field = ('names' === $output) ? 'name' : false;
//
//    return wp_filter_object_list($wp_post_types, $args, $operator, $field);
        if ($output == 'names') {
            return ['post', 'page', 'post_draft', 'attachment'];
        }
    }
}
if (!function_exists('esc_textarea')) {

    function esc_textarea($text)
    {
        $safe_text = htmlspecialchars($text, ENT_QUOTES, get_option('blog_charset'));
        /**
         * Filters a string cleaned and escaped for output in a textarea element.
         *
         * @param string $safe_text The text after it has been escaped.
         * @param string $text The text prior to being escaped.
         * @since 3.1.0
         *
         */
        return apply_filters('esc_textarea', $safe_text, $text);
    }
}
if (!function_exists('format_to_edit')) {

    function format_to_edit($content, $rich_text = false)
    {
        /**
         * Filters the text to be formatted for editing.
         *
         * @param string $content The text, prior to formatting for editing.
         * @since 1.2.0
         *
         */
        $content = apply_filters('format_to_edit', $content);
        if (!$rich_text) {
            $content = esc_textarea($content);
        }
        return $content;
    }
}
if (!function_exists('wp_is_mobile')) {

    function wp_is_mobile()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $is_mobile = false;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // Many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }

        /**
         * Filters whether the request should be treated as coming from a mobile device or not.
         *
         * @param bool $is_mobile Whether the request is from a mobile device or not.
         * @since 4.9.0
         *
         */
        return apply_filters('wp_is_mobile', $is_mobile);
    }
}
if (!function_exists('option_value')) {

    function option_value($key)
    {
        $db = Typecho\Db::get();
        $options = $db->fetchObject($db->select('value')->from('table.options')
            ->where('name = ?', $key));


        return $options->$key;
    }
}
if (!function_exists('user_can_richedit')) {

    function user_can_richedit()
    {
        global $wp_rich_edit, $is_gecko, $is_opera, $is_safari, $is_chrome, $is_IE, $is_edge;

        if (!isset($wp_rich_edit)) {
            $wp_rich_edit = false;
            $user = Widget::widget('Widget_User');

            if ('true' === option_value('useRichEditor') || !$user->hasLogin()) { // Default to 'true' for logged out users.
                if ($is_safari) {
                    $wp_rich_edit = !wp_is_mobile() || (preg_match('!AppleWebKit/(\d+)!', $_SERVER['HTTP_USER_AGENT'], $match) && (int)$match[1] >= 534);
                } elseif ($is_IE) {
                    $wp_rich_edit = (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0;') !== false);
                } elseif ($is_gecko || $is_chrome || $is_edge || ($is_opera && !wp_is_mobile())) {
                    $wp_rich_edit = true;
                }
            }
        }

        /**
         * Filters whether the user can access the visual editor.
         *
         * @param bool $wp_rich_edit Whether the user can access the visual editor.
         * @since 2.1.0
         *
         */
        return apply_filters('user_can_richedit', $wp_rich_edit);
    }
}
if (!function_exists('sanitize_post_field')) {

    function sanitize_post_field($field, $value, $post_id, $context = 'display')
    {
        $int_fields = array('ID', 'post_parent', 'menu_order');
        if (in_array($field, $int_fields, true)) {
            $value = (int)$value;
        }

        // Fields which contain arrays of integers.
        $array_int_fields = array('ancestors');
        if (in_array($field, $array_int_fields, true)) {
            $value = array_map('absint', $value);
            return $value;
        }

        if ('raw' === $context) {
            return $value;
        }

        $prefixed = false;
        if (false !== strpos($field, 'post_')) {
            $prefixed = true;
            $field_no_prefix = str_replace('post_', '', $field);
        }

        if ('edit' === $context) {
            $format_to_edit = array('post_content', 'post_excerpt', 'post_title', 'post_password');

            if ($prefixed) {

                /**
                 * Filters the value of a specific post field to edit.
                 *
                 * The dynamic portion of the hook name, `$field`, refers to the post
                 * field name.
                 *
                 * @param mixed $value Value of the post field.
                 * @param int $post_id Post ID.
                 * @since 2.3.0
                 *
                 */
                $value = apply_filters("edit_{$field}", $value, $post_id);

                /**
                 * Filters the value of a specific post field to edit.
                 *
                 * The dynamic portion of the hook name, `$field_no_prefix`, refers to
                 * the post field name.
                 *
                 * @param mixed $value Value of the post field.
                 * @param int $post_id Post ID.
                 * @since 2.3.0
                 *
                 */
                $value = apply_filters("{$field_no_prefix}_edit_pre", $value, $post_id);
            } else {
                $value = apply_filters("edit_post_{$field}", $value, $post_id);
            }

            if (in_array($field, $format_to_edit, true)) {
                if ('post_content' === $field) {
                    $value = format_to_edit($value, user_can_richedit());
                } else {
                    $value = format_to_edit($value);
                }
            } else {
                $value = esc_attr($value);
            }
        } elseif ('db' === $context) {
            if ($prefixed) {

                /**
                 * Filters the value of a specific post field before saving.
                 *
                 * The dynamic portion of the hook name, `$field`, refers to the post
                 * field name.
                 *
                 * @param mixed $value Value of the post field.
                 * @since 2.3.0
                 *
                 */
                $value = apply_filters("pre_{$field}", $value);

                /**
                 * Filters the value of a specific field before saving.
                 *
                 * The dynamic portion of the hook name, `$field_no_prefix`, refers
                 * to the post field name.
                 *
                 * @param mixed $value Value of the post field.
                 * @since 2.3.0
                 *
                 */
                $value = apply_filters("{$field_no_prefix}_save_pre", $value);
            } else {
                $value = apply_filters("pre_post_{$field}", $value);

                /**
                 * Filters the value of a specific post field before saving.
                 *
                 * The dynamic portion of the hook name, `$field`, refers to the post
                 * field name.
                 *
                 * @param mixed $value Value of the post field.
                 * @since 2.3.0
                 *
                 */
                $value = apply_filters("{$field}_pre", $value);
            }
        } else {

            // Use display filters by default.
            if ($prefixed) {

                /**
                 * Filters the value of a specific post field for display.
                 *
                 * The dynamic portion of the hook name, `$field`, refers to the post
                 * field name.
                 *
                 * @param mixed $value Value of the prefixed post field.
                 * @param int $post_id Post ID.
                 * @param string $context Context for how to sanitize the field.
                 *                        Accepts 'raw', 'edit', 'db', 'display',
                 *                        'attribute', or 'js'. Default 'display'.
                 * @since 2.3.0
                 *
                 */
                $value = apply_filters("{$field}", $value, $post_id, $context);
            } else {
                $value = apply_filters("post_{$field}", $value, $post_id, $context);
            }

            if ('attribute' === $context) {
                $value = esc_attr($value);
            } elseif ('js' === $context) {
                $value = esc_js($value);
            }
        }

        // Restore the type for integer fields after esc_attr().
        if (in_array($field, $int_fields, true)) {
            $value = (int)$value;
        }

        return $value;
    }
}
if (!function_exists('esc_js')) {

    function esc_js($text)
    {
        $safe_text = wp_check_invalid_utf8($text);
        $safe_text = _wp_specialchars($safe_text, ENT_COMPAT);
        $safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes($safe_text));
        $safe_text = str_replace("\r", '', $safe_text);
        $safe_text = str_replace("\n", '\\n', addslashes($safe_text));
        /**
         * Filters a string cleaned and escaped for output in JavaScript.
         *
         * Text passed to esc_js() is stripped of invalid or special characters,
         * and properly slashed for output.
         *
         * @param string $safe_text The text after it has been escaped.
         * @param string $text The text prior to being escaped.
         * @since 2.0.6
         *
         */
        return apply_filters('js_escape', $safe_text, $text);
    }
}
if (!function_exists('sanitize_post')) {

    function sanitize_post($post, $context = 'display')
    {
        if (is_object($post)) {
            // Check if post already filtered for this context.
            if (isset($post->filter) && $context == $post->filter) {
                return $post;
            }
            if (!isset($post->ID)) {
                $post->ID = 0;
            }
            foreach (array_keys(get_object_vars($post)) as $field) {
                $post->$field = sanitize_post_field($field, $post->$field, $post->ID, $context);
            }
            $post->filter = $context;
        } elseif (is_array($post)) {
            // Check if post already filtered for this context.
            if (isset($post['filter']) && $context == $post['filter']) {
                return $post;
            }
            if (!isset($post['cid'])) {
                $post['cid'] = 0;
            }
            foreach (array_keys($post) as $field) {
                $post[$field] = sanitize_post_field($field, $post[$field], $post['ID'], $context);
            }
            $post['filter'] = $context;
        }
        return $post;
    }
}
if (!defined('OBJECT')){
    define('OBJECT', 'OBJECT');
}
// phpcs:ignore Generic.NamingConventions.UpperCaseConstantName.ConstantNotUpperCase
if (!defined('object')) {
    define('object', 'OBJECT'); // Back compat.
}

if (!defined('OBJECT_K')){
    define('OBJECT_K', 'OBJECT_K');
}

if (!defined('ARRAY_A')){
    define('ARRAY_A', 'ARRAY_A');
}

if (!defined('ARRAY_N')) {
    define('ARRAY_N', 'ARRAY_N');
}

if (!function_exists('get_post')) {
    function get_post($post = null, $output = OBJECT, $filter = 'raw')
    {
        if (empty($post) && isset($GLOBALS['post'])) {
            $post = $GLOBALS['post'];
        }
        $db = Db::get();
        if ($post instanceof \Widget\Base\Contents) {
            $_post = $post;
        } elseif (is_object($post)) { // not work
            return $post;
        } else {
            if (is_array($post) and array_key_exists('cid', $post)) {
                $_post = (object)$post;

            } else {
                $_post = $db->fetchObject($db->select()->from('table.contents')->where('cid = ?', $post));
            }

        }

        if (!$_post) {
            return null;
        }

//    $_post = $_post->filter($filter);

        if (ARRAY_A === $output) {
            return $_post->to_array();
        } elseif (ARRAY_N === $output) {
            return array_values($_post->to_array());
        }

        return $_post;
    }
}
if (!function_exists('get_term')) {

    function get_term($cat = null, $output = OBJECT, $filter = 'raw')
    {
        $db = Db::get();
        $_cat = $db->fetchRow($db->select()->from('table.metas')->where('mid = ?',$cat));
        if (ARRAY_A === $output) {
            return $_cat;
        } elseif (ARRAY_N === $output) {
            return array_values($_cat);
        }
        return (OBJECT)$_cat;
    }
}
if (!function_exists('convert_to_object')) {

    function convert_to_object($data)
    {
        return (object)$data;
    }
}
if (!function_exists('get_the_title')) {

    function get_the_title($post = 0)
    {
        $post = get_post($post);

        $title = isset($post->title) ? $post->title : '';
        $id = isset($post->cid) ? $post->cid : 0;

        if (!ty_is_admin()) {
            if (!empty($post->post_password)) {

                /* translators: %s: Protected post title. */
                $prepend = __('Protected: %s');

                /**
                 * Filters the text prepended to the post title for protected posts.
                 *
                 * The filter is only applied on the front end.
                 *
                 * @param string $prepend Text displayed before the post title.
                 *                         Default 'Protected: %s'.
                 * @param WP_Post $post Current post object.
                 * @since 2.8.0
                 *
                 */
                $protected_title_format = apply_filters('protected_title_format', $prepend, $post);
                $title = sprintf($protected_title_format, $title);
            } elseif (isset($post->status) && 'private' === $post->status) {

                /* translators: %s: Private post title. */
                $prepend = __('Private: %s');

                /**
                 * Filters the text prepended to the post title of private posts.
                 *
                 * The filter is only applied on the front end.
                 *
                 * @param string $prepend Text displayed before the post title.
                 *                         Default 'Private: %s'.
                 * @param WP_Post $post Current post object.
                 * @since 2.8.0
                 *
                 */
                $private_title_format = apply_filters('private_title_format', $prepend, $post);
                $title = sprintf($private_title_format, $title);
            }
        }

        /**
         * Filters the post title.
         *
         * @param string $title The post title.
         * @param int $id The post ID.
         * @since 0.71
         *
         */
        return apply_filters('the_title', $title, $id);
    }
}
if (!function_exists('get_user_by')) {

    function get_user_by($type, $key)
    {
        $db = Typecho\Db::get();

        return $db->fetchObject($db->select()->from('table.users')->where($type . ' = ?', $key));
    }
}
if (!function_exists('urlencode_deep')) {

    function urlencode_deep($value)
    {
        return map_deep($value, 'urlencode');
    }
}
if (!function_exists('build_query')) {

    function build_query($data)
    {
        return _http_build_query($data, null, '&', '', false);
    }
}
if (!function_exists('add_query_arg')) {

    function add_query_arg(...$args)
    {
        if (is_array($args[0])) {
            if (count($args) < 2 || false === $args[1]) {
                $uri = $_SERVER['REQUEST_URI'];
            } else {
                $uri = $args[1];
            }
        } else {
            if (count($args) < 3 || false === $args[2]) {
                $uri = $_SERVER['REQUEST_URI'];
            } else {
                $uri = $args[2];
            }
        }

        $frag = strstr($uri, '#');
        if ($frag) {
            $uri = substr($uri, 0, -strlen($frag));
        } else {
            $frag = '';
        }

        if (0 === stripos($uri, 'http://')) {
            $protocol = 'http://';
            $uri = substr($uri, 7);
        } elseif (0 === stripos($uri, 'https://')) {
            $protocol = 'https://';
            $uri = substr($uri, 8);
        } else {
            $protocol = '';
        }

        if (strpos($uri, '?') !== false) {
            list($base, $query) = explode('?', $uri, 2);
            $base .= '?';
        } elseif ($protocol || strpos($uri, '=') === false) {
            $base = $uri . '?';
            $query = '';
        } else {
            $base = '';
            $query = $uri;
        }

        wp_parse_str($query, $qs);
        $qs = urlencode_deep($qs); // This re-URL-encodes things that were already in the query string.
        if (is_array($args[0])) {
            foreach ($args[0] as $k => $v) {
                $qs[$k] = $v;
            }
        } else {
            $qs[$args[0]] = $args[1];
        }

        foreach ($qs as $k => $v) {
            if (false === $v) {
                unset($qs[$k]);
            }
        }

        $ret = build_query($qs);
        $ret = trim($ret, '?');
        $ret = preg_replace('#=(&|$)#', '$1', $ret);
        $ret = $protocol . $base . $ret . $frag;
        $ret = rtrim($ret, '?');
        $ret = str_replace('?#', '#', $ret);
        return $ret;
    }
}
if (!function_exists('remove_query_arg')) {

    /**
     * Removes an item or items from a query string.
     *
     * @param string|string[] $key Query key or keys to remove.
     * @param false|string $query Optional. When false uses the current URL. Default false.
     * @return string New URL query string.
     * @since 1.5.0
     *
     */
    function remove_query_arg($key, $query = false)
    {
        if (is_array($key)) { // Removing multiple keys.
            foreach ($key as $k) {
                $query = add_query_arg($k, false, $query);
            }
            return $query;
        }
        return add_query_arg($key, false, $query);
    }
}
if (!function_exists('admin_url')) {

    function admin_url($path = '', $scheme = 'admin')
    {
        return get_admin_url(null, $path, $scheme);
    }
}
if (!function_exists('get_admin_url')) {

    /**
     * Retrieves the URL to the admin area for a given site.
     *
     * @param int|null $blog_id Optional. Site ID. Default null (current site).
     * @param string $path Optional. Path relative to the admin URL. Default empty.
     * @param string $scheme Optional. The scheme to use. Accepts 'http' or 'https',
     *                          to force those schemes. Default 'admin', which obeys
     *                          force_ssl_admin() and is_ssl().
     * @return string Admin URL link with optional path appended.
     * @since 3.0.0
     *
     */
    function get_admin_url($blog_id = null, $path = '', $scheme = 'admin')
    {
        $url = Helper::options()->adminUrl;

        if ($path && is_string($path)) {
            $url .= ltrim($path, '/');
        }

        /**
         * Filters the admin area URL.
         *
         * @param string $url The complete admin area URL including scheme and path.
         * @param string $path Path relative to the admin area URL. Blank string if no path is specified.
         * @param int|null $blog_id Site ID, or null for the current site.
         * @param string|null $scheme The scheme to use. Accepts 'http', 'https',
         *                             'admin', or null. Default 'admin', which obeys force_ssl_admin() and is_ssl().
         * @since 2.8.0
         * @since 5.8.0 The `$scheme` parameter was added.
         *
         */
        return apply_filters('admin_url', $url, $path, $blog_id, $scheme);
    }
}
if (!function_exists('_http_build_query')) {

    function _http_build_query($data, $prefix = null, $sep = null, $key = '', $urlencode = true)
    {
        $ret = array();

        foreach ((array)$data as $k => $v) {
            if ($urlencode) {
                $k = urlencode($k);
            }
            if (is_int($k) && null != $prefix) {
                $k = $prefix . $k;
            }
            if (!empty($key)) {
                $k = $key . '%5B' . $k . '%5D';
            }
            if (null === $v) {
                continue;
            } elseif (false === $v) {
                $v = '0';
            }

            if (is_array($v) || is_object($v)) {
                array_push($ret, _http_build_query($v, '', $sep, $k, $urlencode));
            } elseif ($urlencode) {
                array_push($ret, $k . '=' . urlencode($v));
            } else {
                array_push($ret, $k . '=' . $v);
            }
        }

        if (null === $sep) {
            $sep = ini_get('arg_separator.output');
        }

        return implode($sep, $ret);
    }
}

global $register_script;
$register_script = [];
if (!function_exists('enqueue_script_helper')) {

    function enqueue_script_helper($script_name, $src = '', $ret = true)
    {
        global $register_script;
        if (in_array($script_name, $register_script)) {
            return '';
        } else {
            $register_script [] = $script_name;
        }

        $script_name = str_replace('-', '/', $script_name);
        if ($src) {
            if (!$ret) {
                echo '<script type="text/javascript" src="' . $src . '"></script>';
                return '';
            }
            return '<script type="text/javascript" src="' . $src . '"></script>';
        } else {
            if (!$ret) {
                echo '<script type="text/javascript" src="' . CSF::include_plugin_url('assets/js/' . $script_name . '.min.js') . '"></script>';
                return '';
            }
            return '<script type="text/javascript" src="' . CSF::include_plugin_url('assets/js/' . $script_name . '.min.js') . '"></script>';
        }

    }
}

global $register_style;
$register_style = [];
if (!function_exists('enqueue_style_helper')) {
    function enqueue_style_helper($style_name, $src = '', $ret = true)
    {
        global $register_style;
        if (in_array($style_name, $register_style)) {
            return '';
        } else {
            $register_style [] = $style_name;
        }
        $style_path_name = str_replace($style_name, '-', '/');
        if ($src) {
            if (!$ret) {
                echo '<link id="' . $style_name . '" rel="stylesheet" type="text/css" href="' . $src . '" media="screen">';
                return '';
            }
            return '<link id="' . $style_name . '" rel="stylesheet" type="text/css" href="' . $src . '" media="screen">';
        } else {
            if (!$ret) {
                echo '<script id="' . $style_name . '" type="text/javascript" src="' . CSF::include_plugin_url('assets/js/' . $style_path_name . '.min.js') . '"></script>';
                return '';
            }
            return '<script id="' . $style_name . '" type="text/javascript" src="' . CSF::include_plugin_url('assets/js/' . $style_path_name . '.min.js') . '"></script>';
        }

    }
}
if (!function_exists('wp_localize_script')) {

    function wp_localize_script($handle, $object_name, $l10n)
    {
        global $register_script;

        if ('jquery' === $handle) {
            $handle = 'jquery-core';
        }

        if (is_array($l10n) && isset($l10n['l10n_print_after'])) { // back compat, preserve the code in 'l10n_print_after' if present.
            $after = $l10n['l10n_print_after'];
            unset($l10n['l10n_print_after']);
        }

        if (!is_array($l10n)) {
            throw new Exception('l10n 参数必须为数组', 50);
        }

        if (is_string($l10n)) {
            $l10n = html_entity_decode($l10n, ENT_QUOTES, 'UTF-8');
        } else {
            foreach ((array)$l10n as $key => $value) {
                if (!is_scalar($value)) {
                    continue;
                }

                $l10n[$key] = html_entity_decode((string)$value, ENT_QUOTES, 'UTF-8');
            }
        }

        $script = "var $object_name = " . json_encode($l10n) . ';';

        if (!empty($after)) {
            $script .= "\n$after;";
        }

        if (!array_key_exists($handle, $register_script)) {
            $register_script[$handle] = [];
        }
        $data_ = $register_script[$handle];

        if (!array_key_exists('data', $data_)) {
            $data_['data'] = '';
        }
        $data = $data_['data'];

        if (!empty($data)) {
            $script = "$data\n$script";
        }
        $register_script[$handle]['data'] = $script;
        return '<script type="text/javascript">' . $script . '</script>';
    }
}
if (!function_exists('reset_enqueue_array')) {

    function reset_enqueue_array()
    {
        global $register_script;
        global $register_style;
        $register_script = [];
        $register_style = [];
    }
}
if (!function_exists('get_status_header_desc')) {
    function get_status_header_desc($code)
    {
        global $wp_header_to_desc;

        $code = absint($code);

        if (!isset($wp_header_to_desc)) {
            $wp_header_to_desc = array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                102 => 'Processing',
                103 => 'Early Hints',

                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                207 => 'Multi-Status',
                226 => 'IM Used',

                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                306 => 'Reserved',
                307 => 'Temporary Redirect',
                308 => 'Permanent Redirect',

                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                418 => 'I\'m a teapot',
                421 => 'Misdirected Request',
                422 => 'Unprocessable Entity',
                423 => 'Locked',
                424 => 'Failed Dependency',
                426 => 'Upgrade Required',
                428 => 'Precondition Required',
                429 => 'Too Many Requests',
                431 => 'Request Header Fields Too Large',
                451 => 'Unavailable For Legal Reasons',

                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported',
                506 => 'Variant Also Negotiates',
                507 => 'Insufficient Storage',
                510 => 'Not Extended',
                511 => 'Network Authentication Required',
            );
        }

        if (isset($wp_header_to_desc[$code])) {
            return $wp_header_to_desc[$code];
        } else {
            return '';
        }
    }
}
if (!function_exists('wp_get_server_protocol')) {
    function wp_get_server_protocol()
    {
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : '';
        if (!in_array($protocol, array('HTTP/1.1', 'HTTP/2', 'HTTP/2.0', 'HTTP/3'), true)) {
            $protocol = 'HTTP/1.0';
        }
        return $protocol;
    }
}
if (!function_exists('status_header')) {
    function status_header($code, $description = '')
    {
        if (!$description) {
            $description = get_status_header_desc($code);
        }

        if (empty($description)) {
            return;
        }

        $protocol = wp_get_server_protocol();
        $status_header = "$protocol $code $description";
        if (function_exists('apply_filters')) {

            /**
             * Filters an HTTP status header.
             *
             * @param string $status_header HTTP status header.
             * @param int $code HTTP status code.
             * @param string $description Description for the status code.
             * @param string $protocol Server protocol.
             * @since 2.2.0
             *
             */
            $status_header = apply_filters('status_header', $status_header, $code, $description, $protocol);
        }

        if (!headers_sent()) {
            header($status_header, true, $code);
        }
    }
}
if (!function_exists('wp_send_json_error')) {
    function wp_send_json_error($responseObj, $data = null, $status_code = null, $options = 0)
    {
        $response = array('success' => false);

        if (isset($data)) {
            if (is_wp_error($data)) {
                $result = array();
                foreach ($data->errors as $code => $messages) {
                    foreach ($messages as $message) {
                        $result[] = array(
                            'code' => $code,
                            'message' => $message,
                        );
                    }
                }

                $response['data'] = $result;
            } else {
                $response['data'] = $data;
            }
        }
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=' . get_option('blog_charset'));
            if (null !== $status_code) {
                status_header($status_code);
            }
        }
        $responseObj->throwJson($response);
    }
}
if (!function_exists('wp_send_json_success')) {
    function wp_send_json_success($responseObj, $data = null, $status_code = null, $options = 0)
    {
        $response = array('success' => true);

        if (isset($data)) {
            $response['data'] = $data;
        }

        if (!headers_sent()) {
            header('Content-Type: application/json; charset=' . get_option('blog_charset'));
            if (null !== $status_code) {
                status_header($status_code);
            }
        }
        $responseObj->throwJson($response);
    }
}
if (!function_exists('wp_protect_special_option')) {
    function wp_protect_special_option($option)
    {
        if ('alloptions' === $option || 'notoptions' === $option) {
            die(
            sprintf(
            /* translators: %s: Option name. */
                __('%s is a protected WP option and may not be modified'),
                esc_html($option)
            )
            );
        }
    }
}
if ( ! function_exists( 'check_ajax_referer' ) ) :
    /**
     * Verifies the Ajax request to prevent processing requests external of the blog.
     *
     * @since 2.0.3
     *
     * @param int|string   $action    Action nonce.
     * @param false|string $query_arg Optional. Key to check for the nonce in `$_REQUEST` (since 2.5). If false,
     *                                `$_REQUEST` values will be evaluated for '_ajax_nonce', and '_wpnonce'
     *                                (in that order). Default false.
     * @param bool         $die       Optional. Whether to die early when the nonce cannot be verified.
     *                                Default true.
     * @return int|false 1 if the nonce is valid and generated between 0-12 hours ago,
     *                   2 if the nonce is valid and generated between 12-24 hours ago.
     *                   False if the nonce is invalid.
     */
    function check_ajax_referer( $action = -1, $query_arg = false, $die = true ) {
        if ( -1 == $action ) {
            throw new \Typecho\Exception( __( 'You should specify an action to be verified by using the first parameter.' ));
        }

        $nonce = '';

        if ( $query_arg && isset( $_REQUEST[ $query_arg ] ) ) {
            $nonce = $_REQUEST[ $query_arg ];
        } elseif ( isset( $_REQUEST['_ajax_nonce'] ) ) {
            $nonce = $_REQUEST['_ajax_nonce'];
        } elseif ( isset( $_REQUEST['_wpnonce'] ) ) {
            $nonce = $_REQUEST['_wpnonce'];
        }

        $result = wp_verify_nonce( $nonce, $action );



        if ( $die && false === $result ) {
            die( '-1' );
        }

        return $result;
    }
endif;


if (!function_exists('wp_using_ext_object_cache')) {
    function wp_using_ext_object_cache($using = null)
    {
        global $_wp_using_ext_object_cache;
        $current_using = $_wp_using_ext_object_cache;
        if (null !== $using) {
            $_wp_using_ext_object_cache = $using;
        }
        return $current_using;
    }
}
if (!function_exists('get_current_user_id')) {
    function get_current_user_id()
    {
        $cookieUid = Cookie::get('__typecho_uid');
        $db = Db::get();
        if (null !== $cookieUid) {
            /** 验证登陆 */
            $user = $db->fetchRow($db->select()->from('table.users')
                ->where('uid = ?', intval($cookieUid))
                ->limit(1));

            $cookieAuthCode = Cookie::get('__typecho_authCode');
            if ($user && Common::hashValidate($user['authCode'], $cookieAuthCode)) {
                return (isset($user->id) ? (int)$user->id : 0);
            }

        }
        return 0;
    }
}
if (!function_exists('get_post_stati')) {
    function get_post_stati($args = array(), $output = 'names', $operator = 'and')
    {
        //todo: post status

        return ['publish', 'hidden', 'private'];

    }
}
if (!function_exists('_real_escape')) {
    function _real_escape($string)
    {
        if (!is_scalar($string)) {
            return '';
        }
        // not working
//    $adapter = Db::get()->getAdapterName();
//    Db::get()->getConfig()
//    if ( $adapter == 'Mysqli' ) {
//        $escaped = mysqli_real_escape_string( $this->dbh, $string );
//    } else {
//        $escaped = mysql_real_escape_string( $string, $this->dbh );
//    }
//    return $this->add_placeholder_escape( $escaped );
        return $string;
    }
}
if (!function_exists('esc_sql')) {
    function esc_sql($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $data[$k] = esc_sql($v);
                } else {
                    $data[$k] = _real_escape($v);
                }
            }
        } else {
            $data = _real_escape($data);
        }

        return $data;
    }
}

if (!function_exists('wp_parse_list')) {
    function wp_parse_list($list)
    {
        if (!is_array($list)) {
            return preg_split('/[\s,]+/', $list, -1, PREG_SPLIT_NO_EMPTY);
        }

        return $list;
    }
}
if (!function_exists('wp_parse_id_list')) {
    function wp_parse_id_list($list)
    {
        $list = wp_parse_list($list);

        return array_unique(array_map('absint', $list));
    }
}
if (!function_exists('wp_array_slice_assoc')) {
    function wp_array_slice_assoc($array, $keys)
    {
        $slice = array();

        foreach ($keys as $key) {
            if (isset($array[$key])) {
                $slice[$key] = $array[$key];
            }
        }

        return $slice;
    }
}
if (!function_exists('wp_cache_init')) {
    function wp_cache_init()
    {
        $GLOBALS['wp_object_cache'] = new WP_Object_Cache();
    }
}
if (!function_exists('wp_suspend_cache_addition')) {
    function wp_suspend_cache_addition($suspend = null)
    {
        static $_suspend = false;

        if (is_bool($suspend)) {
            $_suspend = $suspend;
        }

        return $_suspend;
    }
}
if (!function_exists('wp_cache_add')) {
    function wp_cache_add($key, $data, $group = '', $expire = 0)
    {
        global $wp_object_cache;

        return $wp_object_cache->add($key, $data, $group, (int)$expire);
    }
}
if (!function_exists('wp_cache_get')) {
    function wp_cache_get($key, $group = '', $force = false, &$found = null)
    {
        global $wp_object_cache;

        return $wp_object_cache->get($key, $group, $force, $found);
    }
}
if (!function_exists('wp_cache_set')) {
    function wp_cache_set($key, $data, $group = '', $expire = 0)
    {
        global $wp_object_cache;

        return $wp_object_cache->set($key, $data, $group, (int)$expire);
    }
}
if (!function_exists('wp_cache_get_multiple')) {
    function wp_cache_get_multiple($keys, $group = '', $force = false)
    {
        global $wp_object_cache;

        return $wp_object_cache->get_multiple($keys, $group, $force);
    }
}
if (!function_exists('wp_cache_flush')) {
    function wp_cache_flush()
    {
        global $wp_object_cache;

        return $wp_object_cache->flush();
    }
}
if (!function_exists('wp_cache_delete')) {
    function wp_cache_delete($key, $group = '')
    {
        global $wp_object_cache;

        return $wp_object_cache->delete($key, $group);
    }
}
if (!function_exists('wp_cache_get_last_changed')) {
    function wp_cache_get_last_changed($group)
    {
        $last_changed = wp_cache_get('last_changed', $group);

        if (!$last_changed) {
            $last_changed = microtime();
            wp_cache_set('last_changed', $last_changed, $group);
        }

        return $last_changed;
    }
}
if (!function_exists('update_term_cache')) {
    function update_term_cache($terms, $taxonomy = '')
    {
        foreach ((array)$terms as $term) {
            // Create a copy in case the array was passed by reference.

            $_term = clone $term;
            // Object ID should not be cached.
            unset($_term->object_id);

            wp_cache_add($term->mid, $_term, 'terms');
        }
    }
}

if (!function_exists('_device_can_upload')) {
    function _device_can_upload()
    {
        if (!wp_is_mobile()) {
            return true;
        }

        $ua = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($ua, 'iPhone') !== false
            || strpos($ua, 'iPad') !== false
            || strpos($ua, 'iPod') !== false) {
            return preg_match('#OS ([\d_]+) like Mac OS X#', $ua, $version) && version_compare($version[1], '6', '>=');
        }

        return true;
    }
}
if (!function_exists('is_upload_space_available')) {
    function is_upload_space_available()
    {
        // todo: add button control
        return true;
    }
}
if (!function_exists('wp_convert_hr_to_bytes')) {
    function wp_convert_hr_to_bytes($value)
    {
        $value = strtolower(trim($value));
        $bytes = (int)$value;

        if (false !== strpos($value, 'g')) {
            $bytes *= GB_IN_BYTES;
        } elseif (false !== strpos($value, 'm')) {
            $bytes *= MB_IN_BYTES;
        } elseif (false !== strpos($value, 'k')) {
            $bytes *= KB_IN_BYTES;
        }

        // Deal with large (float) values which run into the maximum integer size.
        return min($bytes, PHP_INT_MAX);
    }
}
if (!function_exists('wp_max_upload_size')) {
    function wp_max_upload_size()
    {
        $u_bytes = wp_convert_hr_to_bytes(ini_get('upload_max_filesize'));
        $p_bytes = wp_convert_hr_to_bytes(ini_get('post_max_size'));

        /**
         * Filters the maximum upload size allowed in php.ini.
         *
         * @param int $size Max upload size limit in bytes.
         * @param int $u_bytes Maximum upload filesize in bytes.
         * @param int $p_bytes Maximum size of POST data in bytes.
         * @since 2.5.0
         *
         */
        return apply_filters('upload_size_limit', min($u_bytes, $p_bytes), $u_bytes, $p_bytes);
    }
}
if (!function_exists('number_format_i18n')) {
    function number_format_i18n($number, $decimals = 0)
    {
        global $wp_locale;

        if (isset($wp_locale)) {
            $formatted = number_format($number, absint($decimals), $wp_locale->number_format['decimal_point'], $wp_locale->number_format['thousands_sep']);
        } else {
            $formatted = number_format($number, absint($decimals));
        }

        /**
         * Filters the number formatted based on the locale.
         *
         * @param string $formatted Converted number in string format.
         * @param float $number The number to convert based on locale.
         * @param int $decimals Precision of the number of decimal places.
         * @since 4.9.0 The `$number` and `$decimals` parameters were added.
         *
         * @since 2.8.0
         */
        return apply_filters('number_format_i18n', $formatted, $number, $decimals);
    }
}
if (!function_exists('size_format')) {
    function size_format($bytes, $decimals = 0)
    {
        $quant = array(
            /* translators: Unit symbol for terabyte. */
            _x('TB', 'unit symbol') => TB_IN_BYTES,
            /* translators: Unit symbol for gigabyte. */
            _x('GB', 'unit symbol') => GB_IN_BYTES,
            /* translators: Unit symbol for megabyte. */
            _x('MB', 'unit symbol') => MB_IN_BYTES,
            /* translators: Unit symbol for kilobyte. */
            _x('KB', 'unit symbol') => KB_IN_BYTES,
            /* translators: Unit symbol for byte. */
            _x('B', 'unit symbol') => 1,
        );

        if (0 === $bytes) {
            /* translators: Unit symbol for byte. */
            return number_format_i18n(0, $decimals) . ' ' . _x('B', 'unit symbol');
        }

        foreach ($quant as $unit => $mag) {
            if ((float)$bytes >= $mag) {
                return number_format_i18n($bytes / $mag, $decimals) . ' ' . $unit;
            }
        }

        return false;
    }
}
if (!function_exists('wp_get_audio_extensions')) {
    function wp_get_audio_extensions()
    {
        /**
         * Filters the list of supported audio formats.
         *
         * @param string[] $extensions An array of supported audio formats. Defaults are
         *                            'mp3', 'ogg', 'flac', 'm4a', 'wav'.
         * @since 3.6.0
         *
         */
        return apply_filters('wp_audio_extensions', array('mp3', 'ogg', 'flac', 'm4a', 'wav'));
    }
}
if (!function_exists('wp_get_video_extensions')) {
    function wp_get_video_extensions()
    {
        /**
         * Filters the list of supported video formats.
         *
         * @param string[] $extensions An array of supported video formats. Defaults are
         *                             'mp4', 'm4v', 'webm', 'ogv', 'flv'.
         * @since 3.6.0
         *
         */
        return apply_filters('wp_video_extensions', array('mp4', 'm4v', 'webm', 'ogv', 'flv'));
    }
}

if (!function_exists('getAttachmentTypes')) {
    function getAttachmentTypes()
    {

        $attachmentTypesResult = [];

        if (null != Helper::options()->attachmentTypes) {
            $attachmentTypes = str_replace(
                ['@image@', '@media@', '@doc@'],
                [
                    'gif,jpg,jpeg,png,tiff,bmp,webp', 'mp3,mp4,mov,wmv,wma,rmvb,rm,avi,flv,ogg,oga,ogv',
                    'txt,doc,docx,xls,xlsx,ppt,pptx,zip,rar,pdf'
                ],
                Helper::options()->attachmentTypes
            );
            $attachmentTypesResult = array_unique(array_map('trim', preg_split("/(,|\.)/", $attachmentTypes)));

        }
        return $attachmentTypesResult;
    }
}
