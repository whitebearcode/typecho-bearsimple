<?php

if ( ! defined( 'CUSTOM_TAGS' ) ) {
    define( 'CUSTOM_TAGS', false );
}

// Ensure that these variables are added to the global namespace
// (e.g. if using namespaces / autoload in the current PHP environment).
global $allowedposttags, $allowedtags, $allowedentitynames, $allowedxmlentitynames;


/**
 * Helper function to add global attributes to a tag in the allowed HTML list.
 *
 * @since 3.5.0
 * @since 5.0.0 Added support for `data-*` wildcard attributes.
 * @since 6.0.0 Added `dir`, `lang`, and `xml:lang` to global attributes.
 *
 * @access private
 * @ignore
 *
 * @param array $value An array of attributes.
 * @return array The array of attributes with global attributes added.
 */
if (!function_exists('_wp_add_global_attributes')){
    function _wp_add_global_attributes( $value ) {
        $global_attributes = array(
            'aria-describedby' => true,
            'aria-details'     => true,
            'aria-label'       => true,
            'aria-labelledby'  => true,
            'aria-hidden'      => true,
            'class'            => true,
            'data-*'           => true,
            'dir'              => true,
            'id'               => true,
            'lang'             => true,
            'style'            => true,
            'title'            => true,
            'role'             => true,
            'xml:lang'         => true,
        );

        if ( true === $value ) {
            $value = array();
        }

        if ( is_array( $value ) ) {
            return array_merge( $value, $global_attributes );
        }

        return $value;
    }
}


if ( ! CUSTOM_TAGS ) {
    /**
     * KSES global for default allowable HTML tags.
     *
     * Can be overridden with the `CUSTOM_TAGS` constant.
     *
     * @var array[] $allowedposttags Array of default allowable HTML tags.
     * @since 2.0.0
     */
    $allowedposttags = array(
        'address'    => array(),
        'a'          => array(
            'href'     => true,
            'rel'      => true,
            'rev'      => true,
            'name'     => true,
            'target'   => true,
            'download' => array(
                'valueless' => 'y',
            ),
        ),
        'abbr'       => array(),
        'acronym'    => array(),
        'area'       => array(
            'alt'    => true,
            'coords' => true,
            'href'   => true,
            'nohref' => true,
            'shape'  => true,
            'target' => true,
        ),
        'article'    => array(
            'align' => true,
        ),
        'aside'      => array(
            'align' => true,
        ),
        'audio'      => array(
            'autoplay' => true,
            'controls' => true,
            'loop'     => true,
            'muted'    => true,
            'preload'  => true,
            'src'      => true,
        ),
        'b'          => array(),
        'bdo'        => array(),
        'big'        => array(),
        'blockquote' => array(
            'cite' => true,
        ),
        'br'         => array(),
        'button'     => array(
            'disabled' => true,
            'name'     => true,
            'type'     => true,
            'value'    => true,
        ),
        'caption'    => array(
            'align' => true,
        ),
        'cite'       => array(),
        'code'       => array(),
        'col'        => array(
            'align'   => true,
            'char'    => true,
            'charoff' => true,
            'span'    => true,
            'valign'  => true,
            'width'   => true,
        ),
        'colgroup'   => array(
            'align'   => true,
            'char'    => true,
            'charoff' => true,
            'span'    => true,
            'valign'  => true,
            'width'   => true,
        ),
        'del'        => array(
            'datetime' => true,
        ),
        'dd'         => array(),
        'dfn'        => array(),
        'details'    => array(
            'align' => true,
            'open'  => true,
        ),
        'div'        => array(
            'align' => true,
        ),
        'dl'         => array(),
        'dt'         => array(),
        'em'         => array(),
        'fieldset'   => array(),
        'figure'     => array(
            'align' => true,
        ),
        'figcaption' => array(
            'align' => true,
        ),
        'font'       => array(
            'color' => true,
            'face'  => true,
            'size'  => true,
        ),
        'footer'     => array(
            'align' => true,
        ),
        'h1'         => array(
            'align' => true,
        ),
        'h2'         => array(
            'align' => true,
        ),
        'h3'         => array(
            'align' => true,
        ),
        'h4'         => array(
            'align' => true,
        ),
        'h5'         => array(
            'align' => true,
        ),
        'h6'         => array(
            'align' => true,
        ),
        'header'     => array(
            'align' => true,
        ),
        'hgroup'     => array(
            'align' => true,
        ),
        'hr'         => array(
            'align'   => true,
            'noshade' => true,
            'size'    => true,
            'width'   => true,
        ),
        'i'          => array(),
        'img'        => array(
            'alt'      => true,
            'align'    => true,
            'border'   => true,
            'height'   => true,
            'hspace'   => true,
            'loading'  => true,
            'longdesc' => true,
            'vspace'   => true,
            'src'      => true,
            'usemap'   => true,
            'width'    => true,
        ),
        'ins'        => array(
            'datetime' => true,
            'cite'     => true,
        ),
        'kbd'        => array(),
        'label'      => array(
            'for' => true,
        ),
        'legend'     => array(
            'align' => true,
        ),
        'li'         => array(
            'align' => true,
            'value' => true,
        ),
        'main'       => array(
            'align' => true,
        ),
        'map'        => array(
            'name' => true,
        ),
        'mark'       => array(),
        'menu'       => array(
            'type' => true,
        ),
        'nav'        => array(
            'align' => true,
        ),
        'object'     => array(
            'data' => array(
                'required'       => true,
                'value_callback' => '_wp_kses_allow_pdf_objects',
            ),
            'type' => array(
                'required' => true,
                'values'   => array( 'application/pdf' ),
            ),
        ),
        'p'          => array(
            'align' => true,
        ),
        'pre'        => array(
            'width' => true,
        ),
        'q'          => array(
            'cite' => true,
        ),
        'rb'         => array(),
        'rp'         => array(),
        'rt'         => array(),
        'rtc'        => array(),
        'ruby'       => array(),
        's'          => array(),
        'samp'       => array(),
        'span'       => array(
            'align' => true,
        ),
        'section'    => array(
            'align' => true,
        ),
        'small'      => array(),
        'strike'     => array(),
        'strong'     => array(),
        'sub'        => array(),
        'summary'    => array(
            'align' => true,
        ),
        'sup'        => array(),
        'table'      => array(
            'align'       => true,
            'bgcolor'     => true,
            'border'      => true,
            'cellpadding' => true,
            'cellspacing' => true,
            'rules'       => true,
            'summary'     => true,
            'width'       => true,
        ),
        'tbody'      => array(
            'align'   => true,
            'char'    => true,
            'charoff' => true,
            'valign'  => true,
        ),
        'td'         => array(
            'abbr'    => true,
            'align'   => true,
            'axis'    => true,
            'bgcolor' => true,
            'char'    => true,
            'charoff' => true,
            'colspan' => true,
            'headers' => true,
            'height'  => true,
            'nowrap'  => true,
            'rowspan' => true,
            'scope'   => true,
            'valign'  => true,
            'width'   => true,
        ),
        'textarea'   => array(
            'cols'     => true,
            'rows'     => true,
            'disabled' => true,
            'name'     => true,
            'readonly' => true,
        ),
        'tfoot'      => array(
            'align'   => true,
            'char'    => true,
            'charoff' => true,
            'valign'  => true,
        ),
        'th'         => array(
            'abbr'    => true,
            'align'   => true,
            'axis'    => true,
            'bgcolor' => true,
            'char'    => true,
            'charoff' => true,
            'colspan' => true,
            'headers' => true,
            'height'  => true,
            'nowrap'  => true,
            'rowspan' => true,
            'scope'   => true,
            'valign'  => true,
            'width'   => true,
        ),
        'thead'      => array(
            'align'   => true,
            'char'    => true,
            'charoff' => true,
            'valign'  => true,
        ),
        'title'      => array(),
        'tr'         => array(
            'align'   => true,
            'bgcolor' => true,
            'char'    => true,
            'charoff' => true,
            'valign'  => true,
        ),
        'track'      => array(
            'default' => true,
            'kind'    => true,
            'label'   => true,
            'src'     => true,
            'srclang' => true,
        ),
        'tt'         => array(),
        'u'          => array(),
        'ul'         => array(
            'type' => true,
        ),
        'ol'         => array(
            'start'    => true,
            'type'     => true,
            'reversed' => true,
        ),
        'var'        => array(),
        'video'      => array(
            'autoplay'    => true,
            'controls'    => true,
            'height'      => true,
            'loop'        => true,
            'muted'       => true,
            'playsinline' => true,
            'poster'      => true,
            'preload'     => true,
            'src'         => true,
            'width'       => true,
        ),
    );

    /**
     * @var array[] $allowedtags Array of KSES allowed HTML elements.
     * @since 1.0.0
     */
    $allowedtags = array(
        'a'          => array(
            'href'  => true,
            'title' => true,
        ),
        'abbr'       => array(
            'title' => true,
        ),
        'acronym'    => array(
            'title' => true,
        ),
        'b'          => array(),
        'blockquote' => array(
            'cite' => true,
        ),
        'cite'       => array(),
        'code'       => array(),
        'del'        => array(
            'datetime' => true,
        ),
        'em'         => array(),
        'i'          => array(),
        'q'          => array(
            'cite' => true,
        ),
        's'          => array(),
        'strike'     => array(),
        'strong'     => array(),
    );

    /**
     * @var string[] $allowedentitynames Array of KSES allowed HTML entity names.
     * @since 1.0.0
     */
    $allowedentitynames = array(
        'nbsp',
        'iexcl',
        'cent',
        'pound',
        'curren',
        'yen',
        'brvbar',
        'sect',
        'uml',
        'copy',
        'ordf',
        'laquo',
        'not',
        'shy',
        'reg',
        'macr',
        'deg',
        'plusmn',
        'acute',
        'micro',
        'para',
        'middot',
        'cedil',
        'ordm',
        'raquo',
        'iquest',
        'Agrave',
        'Aacute',
        'Acirc',
        'Atilde',
        'Auml',
        'Aring',
        'AElig',
        'Ccedil',
        'Egrave',
        'Eacute',
        'Ecirc',
        'Euml',
        'Igrave',
        'Iacute',
        'Icirc',
        'Iuml',
        'ETH',
        'Ntilde',
        'Ograve',
        'Oacute',
        'Ocirc',
        'Otilde',
        'Ouml',
        'times',
        'Oslash',
        'Ugrave',
        'Uacute',
        'Ucirc',
        'Uuml',
        'Yacute',
        'THORN',
        'szlig',
        'agrave',
        'aacute',
        'acirc',
        'atilde',
        'auml',
        'aring',
        'aelig',
        'ccedil',
        'egrave',
        'eacute',
        'ecirc',
        'euml',
        'igrave',
        'iacute',
        'icirc',
        'iuml',
        'eth',
        'ntilde',
        'ograve',
        'oacute',
        'ocirc',
        'otilde',
        'ouml',
        'divide',
        'oslash',
        'ugrave',
        'uacute',
        'ucirc',
        'uuml',
        'yacute',
        'thorn',
        'yuml',
        'quot',
        'amp',
        'lt',
        'gt',
        'apos',
        'OElig',
        'oelig',
        'Scaron',
        'scaron',
        'Yuml',
        'circ',
        'tilde',
        'ensp',
        'emsp',
        'thinsp',
        'zwnj',
        'zwj',
        'lrm',
        'rlm',
        'ndash',
        'mdash',
        'lsquo',
        'rsquo',
        'sbquo',
        'ldquo',
        'rdquo',
        'bdquo',
        'dagger',
        'Dagger',
        'permil',
        'lsaquo',
        'rsaquo',
        'euro',
        'fnof',
        'Alpha',
        'Beta',
        'Gamma',
        'Delta',
        'Epsilon',
        'Zeta',
        'Eta',
        'Theta',
        'Iota',
        'Kappa',
        'Lambda',
        'Mu',
        'Nu',
        'Xi',
        'Omicron',
        'Pi',
        'Rho',
        'Sigma',
        'Tau',
        'Upsilon',
        'Phi',
        'Chi',
        'Psi',
        'Omega',
        'alpha',
        'beta',
        'gamma',
        'delta',
        'epsilon',
        'zeta',
        'eta',
        'theta',
        'iota',
        'kappa',
        'lambda',
        'mu',
        'nu',
        'xi',
        'omicron',
        'pi',
        'rho',
        'sigmaf',
        'sigma',
        'tau',
        'upsilon',
        'phi',
        'chi',
        'psi',
        'omega',
        'thetasym',
        'upsih',
        'piv',
        'bull',
        'hellip',
        'prime',
        'Prime',
        'oline',
        'frasl',
        'weierp',
        'image',
        'real',
        'trade',
        'alefsym',
        'larr',
        'uarr',
        'rarr',
        'darr',
        'harr',
        'crarr',
        'lArr',
        'uArr',
        'rArr',
        'dArr',
        'hArr',
        'forall',
        'part',
        'exist',
        'empty',
        'nabla',
        'isin',
        'notin',
        'ni',
        'prod',
        'sum',
        'minus',
        'lowast',
        'radic',
        'prop',
        'infin',
        'ang',
        'and',
        'or',
        'cap',
        'cup',
        'int',
        'sim',
        'cong',
        'asymp',
        'ne',
        'equiv',
        'le',
        'ge',
        'sub',
        'sup',
        'nsub',
        'sube',
        'supe',
        'oplus',
        'otimes',
        'perp',
        'sdot',
        'lceil',
        'rceil',
        'lfloor',
        'rfloor',
        'lang',
        'rang',
        'loz',
        'spades',
        'clubs',
        'hearts',
        'diams',
        'sup1',
        'sup2',
        'sup3',
        'frac14',
        'frac12',
        'frac34',
        'there4',
    );

    /**
     * @var string[] $allowedxmlentitynames Array of KSES allowed XML entity names.
     * @since 5.5.0
     */
    $allowedxmlentitynames = array(
        'amp',
        'lt',
        'gt',
        'apos',
        'quot',
    );

    $allowedposttags = array_map( '_wp_add_global_attributes', $allowedposttags );
} else {
    $allowedtags     = wp_kses_array_lc( $allowedtags );
    $allowedposttags = wp_kses_array_lc( $allowedposttags );
}

/**
 * Converts the keys of an array to lowercase.
 *
 * @since 1.0.0
 *
 * @param array $inarray Unfiltered array.
 * @return array Fixed array with all lowercase keys.
 */
if (!function_exists('wp_kses_array_lc')) {
    function wp_kses_array_lc($inarray)
    {
        $outarray = array();

        foreach ((array)$inarray as $inkey => $inval) {
            $outkey = strtolower($inkey);
            $outarray[$outkey] = array();

            foreach ((array)$inval as $inkey2 => $inval2) {
                $outkey2 = strtolower($inkey2);
                $outarray[$outkey][$outkey2] = $inval2;
            }
        }

        return $outarray;
    }
}

