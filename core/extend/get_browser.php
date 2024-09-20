<?php

/**
 * Copyright 2008-2016 Kyle Baker (Email: kyleabaker@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

/* Partly modified by Hakula */

/* Detect Web Browser Version */
function get_browser_version($ua, $title) {
    // Grab the browser version if it's present
    preg_match('/' . $title . '[\ |\/|\:]?([.0-9a-zA-Z]+)/i', $ua, $regmatch);
    $version = (is_null($regmatch[1])) ? '' : $regmatch[1];
    return $version;
}

/* Detect Web Browsers */
function get_browser_name($ua) {
    $version = '';
    $code = null;

    if (preg_match('/360se/i', $ua)) {
        $title = '360 安全浏览器';
        $code = '360';
    } elseif (preg_match('/baidubrowser/i', $ua) || preg_match('/\ Spark/i', $ua)) {
        $title = '百度浏览器';
        $version = get_browser_version($ua, 'Browser');
        $code = 'BaiduBrowser';
    } elseif (preg_match('/SE\ /i', $ua) && preg_match('/MetaSr/i', $ua)) {
        $title = '搜狗高速浏览器';
        $code = 'Sogou-Explorer';
    } elseif (preg_match('/QQBrowser/i', $ua) || preg_match('/MQQBrowser/i', $ua)) {
        $title = 'QQ 浏览器';
        $version = get_browser_version($ua, 'QQBrowser');
        $code = 'QQBrowser';
    } elseif (preg_match('/chromeframe/i', $ua)) {
        $title = 'Google Chrome Frame';
        $version = get_browser_version($ua, 'chromeframe');
        $code = 'Chrome';
    } elseif (preg_match('/Chromium/i', $ua)) {
        $title = 'Chromium';
        $version = get_browser_version($ua, 'Chromium');
    } elseif (preg_match('/CrMo/i', $ua)) {
        $title = 'Google Chrome Mobile';
        $version = get_browser_version($ua, 'CrMo');
        $code = 'Chrome';
    } elseif (preg_match('/CriOS/i', $ua)) {
        $title = 'Google Chrome for iOS';
        $version = get_browser_version($ua, 'CriOS');
        $code = 'Chrome';
    } elseif (preg_match('/Maxthon/i', $ua)) {
        $title = '傲游浏览器';
        $version = get_browser_version($ua, 'Maxthon');
        $code = 'Maxthon';
    } elseif (preg_match('/MiuiBrowser/i', $ua)) {
        $title = 'MIUI Browser';
        $version = get_browser_version($ua, 'MiuiBrowser');
        $code = 'MIUI-Browser';
    } elseif (preg_match('/TheWorld/i', $ua)) {
        $title = '世界之窗浏览器';
        $code = 'TheWorld';
    } elseif (preg_match('/UBrowser/i', $ua)) {
        $title = 'UC 浏览器';
        $version = get_browser_version($ua, 'UBrowser');
        $code = 'UC';
    } elseif (preg_match('/UCBrowser/i', $ua)) {
        $title = 'UC 浏览器';
        $version = get_browser_version($ua, 'UCBrowser');
        $code = 'UC';
    } elseif (preg_match('/UC\ Browser/i', $ua)) {
        $title = 'UC 浏览器';
        $version = get_browser_version($ua, 'UC Browser');
        $code = 'UC';
    } elseif (preg_match('/UCWEB/i', $ua)) {
        $title = 'UC 浏览器';
        $version = get_browser_version($ua, 'UCWEB');
        $code = 'UC';
    } elseif (preg_match('/BlackBerry/i', $ua)) {
        $title = 'BlackBerry';
    } elseif (preg_match('/Coast/i', $ua)) {
        $title = 'Coast';
        $version = get_browser_version($ua, 'Coast');
        $code = 'Opera';
    } elseif (preg_match('/IEMobile/i', $ua)) {
        $title = 'IE Mobile';
        $code = 'IE';
    } elseif (preg_match('/LG Browser/i', $ua)) {
        $title = 'LG Web Browser';
        $version = get_browser_version($ua, 'Browser');
        $code = 'LG';
    } elseif (preg_match('/Navigator/i', $ua)) {
        $title = 'Netscape Navigator';
        $code = 'Netscape';
    } elseif (preg_match('/Netscape/i', $ua)) {
        $title = 'Netscape';
    } elseif (preg_match('/Nintendo 3DS/i', $ua)) {
        $title = 'Nintendo 3DS';
        $code = 'Nintendo';
    } elseif (preg_match('/NintendoBrowser/i', $ua)) {
        $title = 'Nintendo Browser';
        $version = get_browser_version($ua, 'Browser');
        $code = 'Nintendo';
    } elseif (preg_match('/NokiaBrowser/i', $ua)) {
        $title = 'Nokia Browser';
        $version = get_browser_version($ua, 'Browser');
        $code = 'Nokia';
    } elseif (preg_match('/Opera Mini/i', $ua)) {
        $title = 'Opera Mini';
        $code = 'Opera';
    } elseif (preg_match('/Opera Mobi/i', $ua)) {
        if (preg_match('/Version/i', $ua)) {
            $version = get_browser_version($ua, 'Version');
        } else {
            $version = get_browser_version($ua, 'Opera Mobi');
        }
        $title = 'Opera Mobile';
        $code = 'Opera';
    } elseif (preg_match('/Opera/i', $ua) || preg_match('/OPR/i', $ua)) {
        $title = 'Opera';
        $code = 'Opera';
        // How is version stored on this Opera ua?
        if (preg_match('/Version/i', $ua)) {
            $version = get_browser_version($ua, 'Version');
        } elseif (preg_match('/OPR/i', $ua)) {
            $version = get_browser_version($ua, 'OPR');
        } else {
            // Use Opera as fallback since full title may change (Next, Developer, etc.)
            $version = get_browser_version($ua, 'Opera');
        }
        // Parse full edition name, ex: Opera/9.80 (X11; Linux x86_64; U; Edition Labs Camera and Pages; Ubuntu/11.10; en) Presto/2.9.220 Version/12.00
        if (preg_match('/Edition ([\ ._0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $title .= ' ' . $regmatch[1];
        } elseif (preg_match('/Opera ([\ ._0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $title .= ' ' . $regmatch[1];
        }
    } elseif (preg_match('/PlayStation\ 4/i', $ua)) {
        $title = 'PS4 Web Browser';
        $code = 'PS4';
    } elseif (preg_match('/SEMC-Browser/i', $ua)) {
        $title = 'SEMC Browser';
        $version = get_browser_version($ua, 'SEMC-Browser');
        $code = 'Sony';
    } elseif (preg_match('/SEMC-java/i', $ua)) {
        $title = 'SEMC Java';
        $code = 'Sony';
    } elseif (preg_match('/Series60/i', $ua) && !preg_match('/Symbian/i', $ua)) {
        $title = 'Nokia S60';
        $version = get_browser_version($ua, 'Series60');
        $code = 'Nokia';
    } elseif (preg_match('/S60/i', $ua) && !preg_match('/Symbian/i', $ua)) {
        $title = 'Nokia S60';
        $version = get_browser_version($ua, 'S60');
        $code = 'Nokia';
    } elseif (preg_match('/TencentTraveler/i', $ua)) {
        $title = 'TT 浏览器';
        $version = get_browser_version($ua, 'TencentTraveler');
        $code = 'QQBrowser';
    } elseif ((preg_match('/Ubuntu\;\ Mobile/i', $ua) || preg_match('/Ubuntu\;\ Tablet/i', $ua) && preg_match('/WebKit/i', $ua))) {
        $title = 'Ubuntu Web Browser';
        $code = 'Ubuntu';
    } elseif (preg_match('/AppleWebkit/i', $ua) && preg_match('/Android/i', $ua) && !preg_match('/Chrome/i', $ua)) {
        $title = 'Android Webkit';
        $version = get_browser_version($ua, 'Version');
        $code = 'Android-Webkit';
    } elseif (preg_match('/Chrome/i', $ua) && preg_match('/Mobile/i', $ua) && (preg_match('/Version/i', $ua) || preg_match('/wv/i', $ua))) {
        $title = 'WebView';
        $version = get_browser_version($ua, 'Version');
        $code = 'Android-Webkit';
    }
    // Pulled out of order to help ensure better detection for above browsers
    elseif (preg_match('/Edge/i', $ua) && preg_match('/Chrome/i', $ua) && preg_match('/Safari/i', $ua)) {
        $title = 'Microsoft Edge';
        $version = get_browser_version($ua, 'Edge');
        $code = 'Edge';
    } elseif (preg_match('/Chrome/i', $ua)) {
        $title = 'Google Chrome';
        $version = get_browser_version($ua, 'Chrome');
        $code = 'Chrome';
    } elseif (preg_match('/Safari/i', $ua) && !preg_match('/Nokia/i', $ua)) {
        $title = 'Safari';
        $code = 'Safari';
        if (preg_match('/Version/i', $ua)) {
            $version = get_browser_version($ua, 'Version');
        }
        if (preg_match('/Mobile Safari/i', $ua)) {
            $title = 'Mobile ' . $title;
        }
    } elseif (preg_match('/Nokia/i', $ua)) {
        $title = 'Nokia Web Browser';
        $code = 'Nokia';
    } elseif (preg_match('/Firefox/i', $ua)) {
        $title = 'Firefox';
        $version = get_browser_version($ua, 'Firefox');
    } elseif (preg_match('/MSIE/i', $ua) || preg_match('/Trident/i', $ua)) {
        $title = 'Internet Explorer';
        $code = 'IE';
        if (preg_match('/\ rv:([.0-9a-zA-Z]+)/i', $ua)) {
            // IE11 or newer
            $version = get_browser_version($ua, ' rv');
        } else {
            // IE10 or older, regex: '/MSIE[\ |\/]?([.0-9a-zA-Z]+)/i'
            $version = get_browser_version($ua, 'MSIE');
        }
        // Detect compatibility mode for IE
        if ($version === '7.0' && preg_match('/Trident\/4.0/i', $ua)) {
            $version = '8.0 (Compatibility Mode)';
        }
    } elseif (preg_match('/Mozilla/i', $ua)) {
        $title = 'Mozilla';
        $version = get_browser_version($ua, ' rv');
        if (empty($version)) {
            $title .= ' Compatible';
            $code = 'Mozilla';
        }
    }
    // No Web browser match
    else {
        $title = 'Other Browser';
        $code = 'Others';
    }
    if (is_null($code)) {
        $code = $title;
    }
    if ($version != '') {
        $title .= " $version";
    }

    $result['code'] = $code;
    $result['title'] = $title;
    return $result;
}
