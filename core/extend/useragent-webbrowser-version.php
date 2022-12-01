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

// Detect Web Browser versions
function detect_browser_version($useragent,$title)
{
	//global $useragent;

	// Fix for Opera's UA string changes in v10.00+ (and others)
	$start=$title;
	if( (strtolower($title)==strtolower("Opera")
			|| strtolower($title)==strtolower("Opera Next")
			|| strtolower($title)==strtolower("Opera Labs"))
		&& preg_match('/Version/i', $useragent))
	{
		$start="Version";
	}
	elseif( (strtolower($title)==strtolower("Opera")
			|| strtolower($title)==strtolower("Opera Next")
			|| strtolower($title)==strtolower("Opera Developer"))
		&& preg_match('/OPR/i', $useragent))
	{
		$start="OPR";
	}
	elseif(strtolower($title)==strtolower("Opera Mobi")
		&& preg_match('/Version/i', $useragent))
	{
		$start="Version";
	}
	elseif(strtolower($title)==strtolower("Safari")
		&& preg_match('/Version/i', $useragent))
	{
		$start="Version";
	}
	elseif(strtolower($title)==strtolower("Pre")
		&& preg_match('/Version/i', $useragent))
	{
		$start="Version";
	}
	elseif(strtolower($title)==strtolower("Android Webkit"))
	{
		$start="Version";
	}
	elseif(strtolower($title)==strtolower("Links"))
	{
		$start="Links \\(";
	}
	elseif(strtolower($title)==strtolower("UC Browser"))
	{
		$start="UC Browse";
	}
	elseif(strtolower($title)==strtolower("TenFourFox"))
	{
		$start=" rv";
	}
	elseif(strtolower($title)==strtolower("Classilla"))
	{
		$start=" rv";
	}
	elseif(strtolower($title)==strtolower("SmartTV"))
	{
		$start="WebBrowser";
	}
	elseif(strtolower($title)==strtolower("MSIE") && preg_match('/\ rv:([.0-9a-zA-Z]+)/i', $useragent))
	{
		// We have IE11 or newer
		$start=" rv";
	}

	// Grab the browser version if its present
	preg_match('/'.$start.'[\ |\/|\:]?([.0-9a-zA-Z]+)/i', $useragent, $regmatch);
	$version=$regmatch[1];

	// Return browser Title and Version, but first..some titles need to be changed
	if(strtolower($title)=="msie"
		&& strtolower($version)=="7.0"
		&& preg_match('/Trident\/4.0/i', $useragent))
	{
		return " 8.0 (Compatibility Mode)"; // Fix for IE8 quirky UA string with Compatibility Mode enabled
	}
	elseif(strtolower($title)=="msie")
	{
		return " ".$version;
	}
	elseif(strtolower($title)=="NetFrontLifeBrowser")
	{
		return "NetFront Life ".$version;
	}
	elseif(strtolower($title)=="ninesky-android-mobile")
	{
		return "Ninesky ".$version;
	}
	elseif(strtolower($title)=="coc_coc_browser")
	{
		return "Coc Coc ".$version;
	}
	elseif(strtolower($title)=="gsa")
	{
		return "Google Search App ".$version;
	}
	elseif(strtolower($title)=="multi-browser")
	{
		return "Multi-Browser XP ".$version;
	}
	elseif(strtolower($title)=="nf-browser")
	{
		return "NetFront ".$version;
	}
	elseif(strtolower($title)=="semc-browser")
	{
		return "SEMC Browser ".$version;
	}
	elseif(strtolower($title)=="ucweb")
	{
		return "UC Browser ".$version;
	}
	elseif(strtolower($title)=="up.browser"
		|| strtolower($title)=="up.link")
	{
		return "Openwave Mobile Browser ".$version;
	}
	elseif(strtolower($title)=="chromeframe")
	{
		return "Google Chrome Frame ".$version;
	}
	elseif(strtolower($title)=="mozilladeveloperpreview")
	{
		return "Mozilla Developer Preview ".$version;
	}
	elseif(strtolower($title)=="multi-browser")
	{
		return "Multi-Browser XP ".$version;
	}
	elseif(strtolower($title)=="opera mobi")
	{
		return "Opera Mobile ".$version;
	}
	elseif(strtolower($title)=="osb-browser")
	{
		return "Gtk+ WebCore ".$version;
	}
	elseif(strtolower($title)=="tablet browser")
	{
		return "MicroB ".$version;
	}
	elseif(strtolower($title)=="tencenttraveler")
	{
		return "TT Explorer ".$version;
	}
	elseif(strtolower($title)=="crmo")
	{
		return "Chrome Mobile ".$version;
	}
	elseif(strtolower($title)=="smarttv")
	{
		return "Maple Browser ".$version;
	}
	elseif(strtolower($title)=="wp-android"
		|| strtolower($title)=="wp-iphone")
	{
		//TODO check into Android version being returned
		return "Wordpress App ".$version;
	}
	elseif(strtolower($title)=="atomicbrowser")
	{
		return "Atomic Web Browser ".$version;
	}
	elseif(strtolower($title)=="barcapro")
	{
		return "Barca Pro ".$version;
	}
	elseif(strtolower($title)=="dplus")
	{
		return "D+ ".$version;
	}
	elseif(strtolower($title)=="nichrome\/self")
	{
		return "Rambler browser ".$version;
	}
	elseif(strtolower($title)=="opera labs")
	{
		preg_match('/Edition\ Labs([\ ._0-9a-zA-Z]+);/i', $useragent, $regmatch);
		return $title.$regmatch[1]." ".$version;
	}
	elseif(strtolower($title)=="escape"
		|| strtolower($title)=="espial")
	{
		return $version;
	}
	else
	{
		return $title." ".$version;
	}
}

?>
