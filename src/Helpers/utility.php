<?php
function chunkSplit($string,$length,$end,$once=false) {
	$array = array();
	$strlen = mb_strlen($string);
	while($strlen) {
		$array[] = mb_substr($string, 0, $length, "utf-8");
		if($once)
		return $array[0] . $end;
		$string = mb_substr($string, $length, $strlen, "utf-8");
		$strlen = mb_strlen($string);
	}
	return implode($end, $array);
}
function ServerInfo() {
	$systemInfo = array();
	$systemInfo['系统'] = PHP_OS;
	$systemInfo['PHP版本'] = PHP_VERSION;
	$systemInfo['软件'] = $_SERVER['SERVER_SOFTWARE'];
	$systemInfo['ZEND版本'] = zend_version();
	if(function_exists('gd_info')) {
		$gdInfo = gd_info();
		$systemInfo['GD库是否支持'] = "是";
		$systemInfo['GD库版本'] = $gdInfo['GD Version'];
	} else {
		$systemInfo['GD库是否支持'] = "否";
		$systemInfo['GD库版本'] = '';
	}
	$systemInfo['安全模式'] = ini_get('safe_mode');
	$systemInfo['注册全局变量'] = ini_get('register_globals');
	$systemInfo['开启魔术引用'] = (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc());
	$systemInfo['最大上传文件大小'] = ini_get('upload_max_filesize');
	$systemInfo['脚本运行占用最大内存'] = get_cfg_var("memory_limit") ? get_cfg_var("memory_limit") : '-';
	return $systemInfo;
}
function Get_BKN($skey) {
	$len=strlen($skey);
	$hash=5381;
	for ($i=0;$i<$len;$i++) {
		$hash+=((($hash<<5) & 0x7fffffff)+ord($skey[$i])) & 0x7fffffff;
		$hash&=0x7fffffff;
	}
	return $hash & 0x7fffffff;
}
function GetBkn($skey) {
	$hash = 5381;
	for ($i = 0, $len = strlen($skey); $i < $len; ++$i) {
		$hash +=($hash << 5) + charCodeAt($skey, $i);
	}
	return $hash & 2147483647;
}
function charset($str,$charset='UTF-8') {
	$encode=mb_detect_encoding($str,["ASCII",'UTF-8',"GB2312","GBK",'BIG5']);
	if($encode!==strtoupper($charset))
	$str=mb_convert_encoding($str,$charset,$encode);
	return $str;
}
function GetGTK($skey) {
	$len = strlen($skey);
	$hash = 5381;
	for ($i = 0; $i < $len; $i++) {
		$hash += ($hash << 5 & 2147483647) + ord($skey[$i]) & 2147483647;
		$hash &= 2147483647;
	}
	return $hash & 2147483647;
}
function RanText($pat) {
	$file=file($pat);
	$arr=mt_rand(0,count($file)-1);
	$content=trim($file[$arr]);
	return $content;
}
function getip_user() {
	if(empty($_SERVER["HTTP_CLIENT_IP"]) == false) {
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	} else if(empty($_SERVER["HTTP_X_FORWARDED_FOR"]) == false) {
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else if(empty($_SERVER["REMOTE_ADDR"]) == false) {
		$cip = $_SERVER["REMOTE_ADDR"];
	} else {
		$cip = "";
	}
	preg_match("/[\d\.]{7,15}/", $cip, $cips);
	$cip = isset($cips[0]) ? $cips[0] : "";
	unset($cips);
	return $cip;
}
function text($array,$two=false) {
	if(!is_array($array)) {
		return $array;
	}
	if($two) {
		$array_data="[\n";
	} else {
		$array_data="/\n";
	}
	foreach($array as $k=>$v) {
		if(is_array($v)) {
			$array_data.="[".$k."]:".text($v,true)."\n";
		} else {
			if($two) {
				$array_data.="[".$k."]:".$v."\n";
			} else {
				$array_data.="[".$k."]:".$v."\n";
			}
		}
	}
	if($two) {
		$array_data.="]";
	} else {
		$array_data.="/";
	}
	return $array_data;
}
function xml($data, $root = true) {
	$str="";
	if($root)$str .= "<xml>";
	foreach($data as $key => $val) {
		if(is_array($val)) {
			$child = xml($val, false);
			$str .= "<$key>$child</$key>";
		} else {
			$str.= "<$key>$val</$key>";
		}
	}
	if($root)$str .= "</xml>";
	return $str;
}
function Back($array=array(),$types=false) {
	if($types=="print") {
		print_r($array);
	} else if($types=="die") {
		die($array);
	} else if($types=="echo") {
		echo($array);
	} else {
		$type=$_REQUEST["format"]?:"json";
		switch($type) {
			case "text":
			header('Content-Type: text/html; charset=utf-8');
			echo text($array);
			break;
			case "xml":
			header("Content-type: text/xml");
			$xml = new Array_to_Xml();
			//实例化类
			echo $xml->toXml($array);
			//转为数组
			break;
			default:
			header('Content-type: application/json');
			echo json_encode($array,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
			break;
		}
	}
}
function curl($url,$data=0,$header_array=0,$referer=0,$time=30,$code=0) {
	if($header_array==0) {
		$header=array("CLIENT-IP: ".getip_user(),"X-FORWARDED-FOR: ".getip_user(),'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.106 Safari/537.36');
	} else {
		$header=array("CLIENT-IP: ".getip_user(),"X-FORWARDED-FOR: ".getip_user());
		$header=array_merge($header_array,$header);
	}
	//print_r($header);
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
	if($data) {
		curl_setopt($curl,CURLOPT_POST,1);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
	}
	if($referer) {
		curl_setopt($curl,CURLOPT_REFERER,$referer);
	}
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
	//设置等待时间
	curl_setopt($curl,CURLOPT_TIMEOUT,$time);
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl,CURLOPT_ENCODING,'gzip,deflate');
	if($code) {
		curl_setopt($curl, CURLOPT_HEADER, 1);
		$return=curl_exec($curl);
		$code_code=curl_getinfo($curl);
		curl_close($curl);
		$code_int['exec']=substr($return,$code_code["header_size"]);
		$code_int['code']=$code_code["http_code"];
		$code_int['content_type']=$code_code["content_type"];
		$code_int['header']=substr($return,0,$code_code["header_size"]);
		return $code_int;
	} else {
		$return=curl_exec($curl);
		curl_close($curl);
		return $return;
	}
}
function str_Intercept($txt1,$q1,$h1) {
	$txt1=strstr($txt1,$q1);
	$cd=strlen($q1);
	$txt1=substr($txt1,$cd);
	$txt1=strstr($txt1,$h1,"TRUE");
	return $txt1;
}
class Array_to_Xml {
	private $version  = '1.0';
	private $encoding  = 'UTF-8';
	private $root    = 'xml';
	private $xml    = null;
	function __construct() {
		$this->xml = new XmlWriter();
	}
	function toXml($data, $eIsArray=FALSE) {
		if(!$eIsArray) {
			$this->xml->openMemory();
			$this->xml->startDocument($this->version, $this->encoding);
			$this->xml->startElement($this->root);
		}
		foreach($data as $key => $value) {
			if(is_array($value)) {
				$this->xml->startElement($key);
				$this->toXml($value, TRUE);
				$this->xml->endElement();
				continue;
			}
			$this->xml->writeElement($key, $value);
		}
		if(!$eIsArray) {
			$this->xml->endElement();
			return $this->xml->outputMemory(true);
		}
	}
}
function charCodeAt($str, $index) {
	$char = mb_substr($str, $index, 1, 'UTF-8');
	$value = null;
	if (mb_check_encoding($char, 'UTF-8')) {
		$ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
		$value = hexdec(bin2hex($ret));
	}
	return $value;
}
function cache_get_contents($list, $name, $type = "text") {
	clearstatcache();
	$fp_name = ApiRun."cache/". $list . ".txt";
	$fp = fopen($fp_name, "r");
	flock($fp, LOCK_EX);
	$fp_open = fread($fp, filesize($fp_name));
	if ($type != "text") {
		return $fp_open;
	} else {
		$encode = base64_encode($name);
		$json = json_decode($fp_open, true);
		return $json[$encode];
	}
	flock($fp, LOCK_UN);
	fclose($fp);
}
function cache_put_contents($list,$name,$msg) {
	clearstatcache();
	$encode = base64_encode($name);
	$fp_name = ApiRun."cache/". $list . ".txt";
	$dir = dirname($fp_name);
	if(!is_dir($dir)) {
		mkdir($dir, 0777, true);
	}
	$read = cache_get_contents($list,$name,"json");
	if(!$read) {
		$json = array();
	} else {
		$json = json_decode($read, true);
	}
	$now_array = array($encode => $msg);
	$new_array = array_merge($json, $now_array);
	$new_json = json_encode($new_array);
	$fp = fopen($fp_name, "w");
	flock($fp, LOCK_EX);
	fwrite($fp, $new_json);
	flock($fp, LOCK_UN);
	fclose($fp);
}
function GetCookie() {
	$skey=$_REQUEST["skey"]?:$_COOKIE["skey"];
	$pskey=$_REQUEST["pskey"]?:$_REQUEST["p_skey"]?:$_COOKIE["pskey"];
	$uin=$_REQUEST["uin"];
	if(!empty($_COOKIE["skey"])) {
		$cookie="";
		foreach($_COOKIE as $key=>$value) {
			$cookie.=$key."=".$value.";";
		}
	} else {
		if(!$skey|!$uin) {
			return false;
		}
		$cookie="skey=".$skey."; uin=o".$uin."; p_skey=".$pskey."; p_uin=o".$uin."";
	}
	return $cookie;
}