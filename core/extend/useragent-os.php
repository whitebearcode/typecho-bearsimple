<?php
/* Copyright 2008-2015  Kyle Baker  (email: kyleabaker@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Detect Operating System
function detect_os($useragent)
{

	if(preg_match('/AmigaOS/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/AmigaOS";
		$title="AmigaOS";

		if(preg_match('/AmigaOS\ ([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="amigaos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Android/i', $useragent))
	{
		$link="http://www.android.com/";
		$title="Android";
		$code="android";

		if(preg_match('/Android[\ |\/]?([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version=$regmatch[1];
			$title.=" ".$version;
		}

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/[^A-Za-z]Arch/i', $useragent))
	{
		$link="http://www.archlinux.org/";
		$title="Arch Linux";
		$code="archlinux";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/BeOS/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/BeOS";
		$title="BeOS";
		$code="beos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/CentOS/i', $useragent))
	{
		$link="http://www.centos.org/";
		$title="CentOS";

		if(preg_match('/.el([.0-9a-zA-Z]+).centos/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="centos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Chakra/i', $useragent))
	{
		$link="http://www.chakra-linux.org/";
		$title="Chakra Linux";
		$code="chakra";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/CrOS/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Google_Chrome_OS";
		$title="Google Chrome OS";
		$code="chromeos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Crunchbang/i', $useragent))
	{
		$link="http://www.crunchbanglinux.org/";
		$title="Crunchbang";
		$code="crunchbang";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Debian/i', $useragent))
	{
		$link="http://www.debian.org/";
		$title="Debian GNU/Linux";
		$code="debian";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/DragonFly/i', $useragent))
	{
		$link="http://www.dragonflybsd.org/";
		$title="DragonFly BSD";
		$code="dragonflybsd";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Edubuntu/i', $useragent))
	{
		$link="http://www.edubuntu.org/";
		$title="Edubuntu";

		if(preg_match('/Edubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version.=" ".$regmatch[1];
		}

		if($regmatch[1] < 10)
		{
			$code="edubuntu-1";
		}
		else
		{
			$code="edubuntu-2";
		}

		if(strlen($version) > 1)
		{
			$title.=$version;
		}

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Fedora/i', $useragent))
	{
		$link="http://www.fedoraproject.org/";
		$title="Fedora";

		if(preg_match('/.fc([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="fedora";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Foresight\ Linux/i', $useragent))
	{
		$link="http://www.foresightlinux.org/";
		$title="Foresight Linux";

		if(preg_match('/Foresight\ Linux\/([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="foresight";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/FreeBSD/i', $useragent))
	{
		$link="http://www.freebsd.org/";
		$title="FreeBSD";
		$code="freebsd";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Gentoo/i', $useragent))
	{
		$link="http://www.gentoo.org/";
		$title="Gentoo";
		$code="gentoo";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Inferno/i', $useragent))
	{
		$link="http://www.vitanuova.com/inferno/";
		$title="Inferno";
		$code="inferno";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/IRIX/i', $useragent))
	{
		$link="http://www.sgi.com/partners/?/technology/irix/";
		$title="IRIX Linux";

		if(preg_match('/IRIX(64)?\ ([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			if($regmatch[1])
			{
				$title.=" x".$regmatch[1];
			}
			if($regmatch[2])
			{
				$title.=" ".$regmatch[2];
			}
		}

		$code="irix";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Kanotix/i', $useragent))
	{
		$link="http://www.kanotix.com/";
		$title="Kanotix";
		$code="kanotix";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Knoppix/i', $useragent))
	{
		$link="http://www.knoppix.net/";
		$title="Knoppix";
		$code="knoppix";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Kubuntu/i', $useragent))
	{
		$link="http://www.kubuntu.org/";
		$title="Kubuntu";

		if(preg_match('/Kubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version.=" ".$regmatch[1];
		}

		if($regmatch[1] < 10)
		{
			$code="kubuntu-1";
		}
		else
		{
			$code="kubuntu-2";
		}

		if(strlen($version) > 1)
		{
			$title.=$version;
		}

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/LindowsOS/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/Lsongs";
		$title="LindowsOS";
		$code="lindowsos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Linspire/i', $useragent))
	{
		$link="http://www.linspire.com/";
		$title="Linspire";
		$code="lindowsos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Linux\ Mint/i', $useragent))
	{
		$link="http://www.linuxmint.com/";
		$title="Linux Mint";

		if(preg_match('/Linux\ Mint\/([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="linuxmint";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Lubuntu/i', $useragent))
	{
		$link="http://www.lubuntu.net/";
		$title="Lubuntu";

		if(preg_match('/Lubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version.=" ".$regmatch[1];
		}

		if($regmatch[1] < 10)
		{
			$code="lubuntu-1";
		}
		else
		{
			$code="lubuntu-2";
		}

		if(strlen($version) > 1)
		{
			$title.=$version;
		}

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Mac/i', $useragent)
		|| preg_match('/Darwin/i', $useragent))
	{
		$link="http://www.apple.com/macosx/";

		if(preg_match('/Mac OS X/i', $useragent))
		{
			$title=substr($useragent, strpos(strtolower($useragent), strtolower("Mac OS X")));
			$title=substr($title, 0, strpos($title, ")"));

			if(strpos($title, ";"))
			{
				$title=substr($title, 0, strpos($title, ";"));
			}

			$title=str_replace("_", ".", $title);
			$code="mac-3";
		}
		elseif(preg_match('/Mac OSX/i', $useragent))
		{
			$title=substr($useragent, strpos(strtolower($useragent), strtolower("Mac OS X")));
			$title=substr($title, 0, strpos($title, ")"));

			if(strpos($title, ";"))
			{
				$title=substr($title, 0, strpos($title, ";"));
			}

			$title=str_replace("_", ".", $title);
			$code="mac-2";
		}
		elseif(preg_match('/Darwin/i', $useragent))
		{
			$title="Mac OS Darwin";
			$code="mac-1";
		}
		else
		{
			$title="Macintosh";
			$code="mac-1";
		}
	}
	elseif(preg_match('/Mageia/i', $useragent))
	{
		$link="http://www.mageia.org/";
		$title="Mageia";
		$code="mageia";
	}
	elseif(preg_match('/Mandriva/i', $useragent))
	{
		$link="http://www.mandriva.com/";
		$title="Mandriva";

		if(preg_match('/mdv([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="mandriva";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/moonOS/i', $useragent))
	{
		$link="http://www.moonos.org/";
		$title="moonOS";

		if(preg_match('/moonOS\/([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="moonos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/MorphOS/i', $useragent))
	{
		$link="http://www.morphos-team.net/";
		$title="MorphOS";
		$code="morphos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/NetBSD/i', $useragent))
	{
		$link="http://www.netbsd.org/";
		$title="NetBSD";
		$code="netbsd";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Nova/i', $useragent))
	{
		$link="http://www.nova.cu";
		$title="Nova";

		if(preg_match('/Nova[\/|\ ]([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version.=" ".$regmatch[1];
		}

		if(strlen($version) > 1)
		{
			$title.=$version;
		}

		$code="nova";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/OpenBSD/i', $useragent))
	{
		$link="http://www.openbsd.org/";
		$title="OpenBSD";
		$code="openbsd";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Oracle/i', $useragent))
	{
		$link="http://www.oracle.com/us/technologies/linux/";
		$title="Oracle";

		if(preg_match('/.el([._0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" Enterprise Linux ".str_replace("_", ".", $regmatch[1]);
		}
		else
		{
			$title.=" Linux";
		}

		$code="oracle";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Pardus/i', $useragent))
	{
		$link="http://www.pardus.org.tr/en/";
		$title="Pardus";
		$code="pardus";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/PCLinuxOS/i', $useragent))
	{
		$link="http://www.pclinuxos.com/";
		$title="PCLinuxOS";

		if(preg_match('/PCLinuxOS\/[.\-0-9a-zA-Z]+pclos([.\-0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".str_replace("_", ".", $regmatch[1]);
		}

		$code="pclinuxos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Red\ Hat/i', $useragent)
		|| preg_match('/RedHat/i', $useragent))
	{
		$link="http://www.redhat.com/";
		$title="Red Hat";

		if(preg_match('/.el([._0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" Enterprise Linux ".str_replace("_", ".", $regmatch[1]);
		}

		$code="red-hat";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Rosa/i', $useragent))
	{
		$link="http://www.rosalab.com/";
		$title="Rosa Linux";
		$code="rosa";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Sabayon/i', $useragent))
	{
		$link="http://www.sabayonlinux.org/";
		$title="Sabayon Linux";
		$code="sabayon";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Slackware/i', $useragent))
	{
		$link="http://www.slackware.com/";
		$title="Slackware";
		$code="slackware";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Solaris/i', $useragent))
	{
		$link="http://www.sun.com/software/solaris/";
		$title="Solaris";
		$code="solaris";
	}
	elseif(preg_match('/SunOS/i', $useragent))
	{
		$link="http://www.sun.com/software/solaris/";
		$title="Solaris";
		$code="solaris";
	}
	elseif(preg_match('/Suse/i', $useragent))
	{
		$link="http://www.opensuse.org/";
		$title="openSUSE";
		$code="suse";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Symb[ian]?[OS]?/i', $useragent))
	{
		$link="http://www.symbianos.org/";
		$title="SymbianOS";

		if(preg_match('/Symb[ian]?[OS]?\/([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$title.=" ".$regmatch[1];
		}

		$code="symbianos";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Unix/i', $useragent))
	{
		$link="http://www.unix.org/";
		$title="Unix";
		$code="unix";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/VectorLinux/i', $useragent))
	{
		$link="http://www.vectorlinux.com/";
		$title="VectorLinux";
		$code="vectorlinux";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Venenux/i', $useragent))
	{
		$link="http://www.venenux.org/";
		$title="Venenux GNU Linux";
		$code="venenux";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/webOS/i', $useragent))
	{
		$link="http://en.wikipedia.org/wiki/WebOS";
		$title="Palm webOS";
		$code="palm";
	}
	elseif(preg_match('/Windows/i', $useragent)
		|| preg_match('/WinNT/i', $useragent)
		|| preg_match('/Win32/i', $useragent))
	{
		$link="http://www.microsoft.com/windows/";

		if(preg_match('/Windows NT 10.0; Win64; x64/i', $useragent)
			|| preg_match('/Windows NT 10.0; WOW64/i', $useragent)
			|| preg_match('/Windows NT 6.4; Win64; x64/i', $useragent)
			|| preg_match('/Windows NT 6.4; WOW64/i', $useragent))
		{
			$title="Windows 10 x64 Edition";
			$code="win-6";
		}
		elseif(preg_match('/Windows NT 10.0/i', $useragent)
			|| preg_match('/Windows NT 6.4/i', $useragent))
		{
			$title="Windows 10";
			$code="win-6";
		}
		elseif(preg_match('/Windows NT 6.3; Win64; x64/i', $useragent)
			|| preg_match('/Windows NT 6.3; WOW64/i', $useragent))
		{
			$title="Windows 8.1 x64 Edition";
			$code="win-5";
		}
		elseif(preg_match('/Windows NT 6.3/i', $useragent))
		{
			$title="Windows 8.1";
			$code="win-5";
		}
		elseif(preg_match('/Windows NT 6.2; Win64; x64/i', $useragent)
			|| preg_match('/Windows NT 6.2; WOW64/i', $useragent))
		{
			$title="Windows 8 x64 Edition";
			$code="win-5";
		}
		elseif(preg_match('/Windows NT 6.2/i', $useragent))
		{
			$title="Windows 8";
			$code="win-5";
		}
		elseif(preg_match('/Windows NT 6.1; Win64; x64/i', $useragent)
			|| preg_match('/Windows NT 6.1; WOW64/i', $useragent))
		{
			$title="Windows 7 x64 Edition";
			$code="win-4";
		}
		elseif(preg_match('/Windows NT 6.1/i', $useragent))
		{
			$title="Windows 7";
			$code="win-4";
		}
		elseif(preg_match('/Windows NT 6.0/i', $useragent))
		{
			$title="Windows Vista";
			$code="win-3";
		}
		elseif(preg_match('/Windows NT 5.2 x64/i', $useragent))
		{
			$title="Windows XP x64 Edition";
			$code="win-2";
		}
		elseif(preg_match('/Windows NT 5.2; Win64; x64/i', $useragent))
		{
			$title="Windows Server 2003 x64 Edition";
			$code="win-2";
		}
		elseif(preg_match('/Windows NT 5.2/i', $useragent))
		{
			$title="Windows Server 2003";
			$code="win-2";
		}
		elseif(preg_match('/Windows NT 5.1/i', $useragent)
			|| preg_match('/Windows XP/i', $useragent))
		{
			$title="Windows XP";
			$code="win-2";
		}
		elseif(preg_match('/Windows NT 5.01/i', $useragent))
		{
			$title="Windows 2000, Service Pack 1 (SP1)";
			$code="win-1";
		}
		elseif(preg_match('/Windows NT 5.0/i', $useragent)
			|| preg_match('/Windows 2000/i', $useragent))
		{
			$title="Windows 2000";
			$code="win-1";
		}
		elseif(preg_match('/Windows NT 4.0/i', $useragent)
			|| preg_match('/WinNT4.0/i', $useragent))
		{
			$title="Microsoft Windows NT 4.0";
			$code="win-1";
		}
		elseif(preg_match('/Windows NT 3.51/i', $useragent)
			|| preg_match('/WinNT3.51/i', $useragent))
		{
			$title="Microsoft Windows NT 3.11";
			$code="win-1";
		}
		elseif(preg_match('/Windows 3.11/i', $useragent)
			|| preg_match('/Win3.11/i', $useragent)
			|| preg_match('/Win16/i', $useragent))
		{
			$title="Microsoft Windows 3.11";
			$code="win-1";
		}
		elseif(preg_match('/Windows 3.1/i', $useragent))
		{
			$title="Microsoft Windows 3.1";
			$code="win-1";
		}
		elseif(preg_match('/Windows 98; Win 9x 4.90/i', $useragent)
			|| preg_match('/Win 9x 4.90/i', $useragent)
			|| preg_match('/Windows ME/i', $useragent))
		{
			$title="Windows Millennium Edition (Windows Me)";
			$code="win-1";
		}
		elseif(preg_match('/Win98/i', $useragent))
		{
			$title="Windows 98 SE";
			$code="win-1";
		}
		elseif(preg_match('/Windows 98/i', $useragent)
			|| preg_match('/Windows\ 4.10/i', $useragent))
		{
			$title="Windows 98";
			$code="win-1";
		}
		elseif(preg_match('/Windows 95/i', $useragent)
			|| preg_match('/Win95/i', $useragent))
		{
			$title="Windows 95";
			$code="win-1";
		}
		elseif(preg_match('/Windows CE/i', $useragent))
		{
			$title="Windows CE";
			$code="win-2";
		}
		elseif(preg_match('/WM5/i', $useragent))
		{
			$title="Windows Mobile 5";
			$code="win-phone";
		}
		elseif(preg_match('/WindowsMobile/i', $useragent))
		{
			$title="Windows Mobile";
			$code="win-phone";
		}
		else
		{
			$title="Windows";
			$code="win-2";
		}
	}
	elseif(preg_match('/Xandros/i', $useragent))
	{
		$link="http://www.xandros.com/";
		$title="Xandros";
		$code="xandros";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Xubuntu/i', $useragent))
	{
		$link="http://www.xubuntu.org/";
		$title="Xubuntu";

		if(preg_match('/Xubuntu[\/|\ ]([.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version.=" ".$regmatch[1];
		}

		if($regmatch[1] < 10)
		{
			$code="xubuntu-1";
		}
		else
		{
			$code="xubuntu-2";
		}

		if(strlen($version) > 1)
		{
			$title.=$version;
		}

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Zenwalk/i', $useragent))
	{
		$link="http://www.zenwalk.org/";
		$title="Zenwalk GNU Linux";
		$code="zenwalk";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}

	// Pulled out of order to help ensure better detection for above platforms
	elseif(preg_match('/Ubuntu/i', $useragent))
	{
		$link="http://www.ubuntu.com/";
		$title="Ubuntu";

		if(preg_match('/Ubuntu[\/|\ ]([.0-9]+[.0-9a-zA-Z]+)/i', $useragent, $regmatch))
		{
			$version.=" ".$regmatch[1];
		}

		if($regmatch[1] < 10)
		{
			$code="ubuntu-1";
		}
		else
		{
			$code="ubuntu-2";
		}

		if(strlen($version) > 1)
		{
			$title.=$version;
		}

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/Linux/i', $useragent))
	{
		$link="http://www.linux.org/";
		$title="GNU/Linux";
		$code="linux";

		if(preg_match('/x86_64/i', $useragent))
		{
			$title.=" x64";
		}
	}
	elseif(preg_match('/J2ME\/MIDP/i', $useragent))
	{
		$link="http://java.sun.com/javame/";
		$title="J2ME/MIDP Device";
		$code="java";
	}
	else
	{
		return "";
	}


	$result['code'] = $code;
	$result['title'] = $title;
	return $result;
}

?>
