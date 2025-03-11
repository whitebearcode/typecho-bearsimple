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

/* Detect Operating System */
function get_os($ua) {
    $version = null;
    $code = null;

    if (preg_match('/Windows/i', $ua) || preg_match('/WinNT/i', $ua) || preg_match('/Win32/i', $ua)) {
        $title = 'Windows';
        if (preg_match('/Windows NT 10.0/i', $ua) || preg_match('/Windows NT 6.4/i', $ua)) {
            $version = '10';
            $code = 'Windows-10';
        } elseif (preg_match('/Windows NT 6.3/i', $ua)) {
            $version = '8.1';
            $code = 'Windows-8';
        } elseif (preg_match('/Windows NT 6.2/i', $ua)) {
            $version = '8';
            $code = 'Windows-8';
        } elseif (preg_match('/Windows NT 6.1/i', $ua)) {
            $version = '7';
        } elseif (preg_match('/Windows NT 6.0/i', $ua)) {
            $version = 'Vista';
        } elseif (preg_match('/Windows NT 5.2 x64/i', $ua)) {
            $version = 'XP'; // x64 Edition very similar to Win 2003
        } elseif (preg_match('/Windows NT 5.2/i', $ua)) {
            $version = 'Server 2003';
        } elseif (preg_match('/Windows NT 5.1/i', $ua) || preg_match('/Windows XP/i', $ua)) {
            $version = 'XP';
        } elseif (preg_match('/Windows NT 5.01/i', $ua)) {
            $version = '2000 (SP1)';
        } elseif (preg_match('/Windows NT 5.0/i', $ua) || preg_match('/Windows NT5/i', $ua) || preg_match('/Windows 2000/i', $ua)) {
            $version = '2000';
        } elseif (preg_match('/Windows NT 4.0/i', $ua) || preg_match('/WinNT4.0/i', $ua)) {
            $version = 'NT 4.0';
        } elseif (preg_match('/Windows NT 3.51/i', $ua) || preg_match('/WinNT3.51/i', $ua)) {
            $version = 'NT 3.11';
        } elseif (preg_match('/Windows NT/i', $ua) || preg_match('/WinNT/i', $ua)) {
            $version = 'NT';
        } elseif (preg_match('/Windows 3.11/i', $ua) || preg_match('/Win3.11/i', $ua) || preg_match('/Win16/i', $ua)) {
            $version = '3.11';
        } elseif (preg_match('/Windows 3.1/i', $ua)) {
            $version = '3.1';
        } elseif (preg_match('/Windows 98; Win 9x 4.90/i', $ua) || preg_match('/Win 9x 4.90/i', $ua) || preg_match('/Windows ME/i', $ua)) {
            $version = 'ME';
        } elseif (preg_match('/Win98/i', $ua)) {
            $version = '98 SE';
        } elseif (preg_match('/Windows 98/i', $ua) || preg_match('/Windows\ 4.10/i', $ua)) {
            $version = '98';
        } elseif (preg_match('/Windows 95/i', $ua) || preg_match('/Win95/i', $ua)) {
            $version = '95';
        } elseif (preg_match('/Windows CE/i', $ua)) {
            $version = 'CE';
        } elseif (preg_match('/WM5/i', $ua)) {
            $version = 'Mobile 5';
        } elseif (preg_match('/WindowsMobile/i', $ua)) {
            $version = 'Mobile';
        }
    } elseif (preg_match('/Android/i', $ua)) {
        $title = 'Android';
        if (preg_match('/Android[\ |\/]?([.0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $version = $regmatch[1];
        }
    } elseif (preg_match('/Mac/i', $ua) || preg_match('/Darwin/i', $ua)) {
        $title = 'Mac OS X';
        $code = 'Apple';
        if (preg_match('/Mac OS X/i', $ua) || preg_match('/Mac OSX/i', $ua)) {
            if (preg_match('/iPhone/i', $ua)) {
                $title = 'iOS';
                $version = substr($ua, strpos(strtolower($ua), strtolower('iPhone OS')) + 10);
                // Parse iOS version number
                $version = substr($version, 0, strpos($version, 'l') - 1);
            } elseif (preg_match('/iPad/i', $ua)) {
                $title = 'iOS';
                $version = substr($ua, strpos(strtolower($ua), strtolower('CPU OS')) + 7);
                $version = substr($version, 0, strpos($version, 'l') - 1);
            } elseif (preg_match('/Mac OS X/i', $ua)) {
                $version = substr($ua, strpos(strtolower($ua), strtolower('OS X')) + 5);
                // Parse OS X version number
                $version = substr($version, 0, strpos($version, ')'));
            } else {
                $version = substr($ua, strpos(strtolower($ua), strtolower('OSX')) + 4);
                $version = substr($version, 0, strpos($version, ')'));
            }
            // Parse OS X version number
            if (strpos($version, ';') > -1) {
                $version = substr($version, 0, strpos($version, ';'));
            }
            // Beautify version format
            $version = str_replace('_', '.', $version);
        } elseif (preg_match('/Darwin/i', $ua)) {
            $title = 'Mac OS Darwin';
        } else {
            $title = 'Macintosh';
        }
    } elseif (preg_match('/[^A-Za-z]Arch/i', $ua)) {
        $title = 'Arch Linux';
        $code = 'Arch-Linux';
    } elseif (preg_match('/BlackBerry/i', $ua)) {
        $title = 'BlackBerryOS';
    } elseif (preg_match('/CentOS/i', $ua)) {
        $title = 'CentOS';
        if (preg_match('/.el([.0-9a-zA-Z]+).centos/i', $ua, $regmatch)) {
            $version = $regmatch[1];
        }
    } elseif (preg_match('/CrOS/i', $ua)) {
        $title = 'Google Chrome OS';
        $code = 'Chrome-OS';
    } elseif (preg_match('/Debian/i', $ua)) {
        $title = 'Debian GNU/Linux';
        $code = 'Debian';
    } elseif (preg_match('/Fedora/i', $ua)) {
        $title = 'Fedora';
        if (preg_match('/.fc([.0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $version = $regmatch[1];
        }
    } elseif (preg_match('/FreeBSD/i', $ua)) {
        $title = 'FreeBSD';
    } elseif (preg_match('/OpenBSD/i', $ua)) {
        $title = 'OpenBSD';
    } elseif (preg_match('/Oracle/i', $ua)) {
        $title = 'Oracle';
        $code = 'Oracle-Linux';
        if (preg_match('/.el([._0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $title .= ' Enterprise Linux';
            $version = str_replace('_', '.', $regmatch[1]);
        } else {
            $title .= ' Linux';
        }
    } elseif (preg_match('/Red\ Hat/i', $ua) || preg_match('/RedHat/i', $ua)) {
        $title = 'Red Hat';
        $code = 'Red-Hat';
        if (preg_match('/.el([._0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $title .= ' Enterprise Linux';
            $version = str_replace('_', '.', $regmatch[1]);
        }
    } elseif (preg_match('/Solaris/i', $ua) || preg_match('/SunOS/i', $ua)) {
        $title = 'Solaris';
    } elseif (preg_match('/Symb[ian]?[OS]?/i', $ua)) {
        $title = 'SymbianOS';
        if (preg_match('/Symb[ian]?[OS]?\/([.0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $version = $regmatch[1];
        }
    } elseif (preg_match('/Ubuntu/i', $ua)) {
        $title = 'Ubuntu';
        if (preg_match('/Ubuntu[\/|\ ]([.0-9]+[.0-9a-zA-Z]+)/i', $ua, $regmatch)) {
            $version = $regmatch[1];
        }
    } elseif (preg_match('/Linux/i', $ua)) {
        $title = 'GNU/Linux';
        $code = 'Linux';
    } elseif (preg_match('/J2ME\/MIDP/i', $ua)) {
        $title = 'J2ME/MIDP Device';
        $code = 'Java';
    }
    // No OS match
    else {
        $title = 'Other System';
        $code = 'Others';
    }
    // Check x64 architecture
    if (preg_match('/x86_64/i', $ua)) {
        // If version isn't null append 64 bit, otherwise set it to x64
        $version = (is_null($version)) ? 'x64' : "$version x64";
    } elseif ((preg_match('/Windows/i', $ua) || preg_match('/WinNT/i', $ua) || preg_match('/Win32/i', $ua))
        && (preg_match('/Win64/i', $ua) || preg_match('/x64/i', $ua) || preg_match('/WOW64/i', $ua))
    ) {
        $version .= ' x64 Edition';
    }

    if (is_null($code)) {
        $code = $title;
    }
    // Append version to title
    if (isset($version)) {
        $title .= " $version";
    }
    $result['code'] = $code;
    $result['title'] = $title;
    return $result;
}
