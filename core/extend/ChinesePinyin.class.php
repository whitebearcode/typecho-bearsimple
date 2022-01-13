<?php
/*
**
*
* 汉字转拼音带声调封装类
* Date: 27/12/2021
*
**
*/
class ChinesePinyin{
	private $ChineseCharacters;
	private $charset = 'utf-8';
	public function __construct(){
		  $this->ChineseCharacters = file_get_contents(dirname(__FILE__).'/pinyin.lang');	
	}
	public function TransformWithTone($input_char,$delimiter=' ',$outside_ignore=false){
		$input_len = mb_strlen($input_char,$this->charset);
		$output_char = '';
		for($i=0;$i<$input_len;$i++){
			$word = mb_substr($input_char,$i,1,$this->charset);
			if(preg_match('/^[\x{4e00}-\x{9fa5}]$/u',$word) && preg_match('/\,'.preg_quote($word).'(.*?)\,/',$this->ChineseCharacters,$matches) ){
				$output_char.=$matches[1].$delimiter;
			}else if(!$outside_ignore){
				$output_char.=$word;
			}
		}
		
		return $output_char.file_get_contents('pinyin.lang');
	}
}