<?php
if($options->music == "1"){
Typecho_Plugin::factory('Widget_Archive')->header = array('Music', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Music', 'footer');
class Music 
{ 
 
    public static function header(){
        $cssUrl = Helper::options()->themeUrl . '/assets/music/css/player.css';
        echo '<link rel="stylesheet" href="' . $cssUrl . '">';
if(Typecho_Widget::widget('Widget_Options')->music_sxj=='0'){	
			echo '<style>@media only screen and (max-width:766px){.ymusic{display:none}}</style>'. "\n";
}
    }

    public static function footer(){
        $options = Typecho_Widget::widget('Widget_Options');
  $musicList = $options->music_musicList;
 if(empty($musicList)){
       $musicList = "761323";
      }
      
      if(strpos($musicList,'//')===false){
        $musicList = str_replace(PHP_EOL, '&br=128000&raw=ture"},{mp3:"//api.imjad.cn/cloudmusic/?type=song&id=', $musicList);  
  $musicList = '{mp3:"//api.imjad.cn/cloudmusic/?type=song&id='.$musicList.'&br=128000&raw=ture"}';
   $musicList = str_replace(array("\r\n", "\r", "\n", " "), "", $musicList);    
         }else{
              $musicList = str_replace(PHP_EOL, '"},{mp3:"', $musicList);  
  $musicList = '{mp3:"'.$musicList.'"}';
   $musicList = str_replace(array("\r\n", "\r", "\n", " "), "", $musicList);   
      
      }
if(strpos($musicList,',')===false){
    
		echo '
<bgm>			
<a class="ymusic" onclick="playbtu();" target="_blank"><i id="ydmc"></i></a>
</bgm>
             ';
}else{
      
		echo '
<bgm>			
<a class="ymusic" onclick="playbtu();" target="_blank"><i id="ydmc"></i></a><a class="ymusic" onclick="next();" id="ydnext" target="_blank"><i class="iconfont icon-you"></i></a>
</bgm>
             ';

}
      



        echo '<script data-no-instant>
var yaudio = new Audio();
yaudio.controls = true;
var musicArr=[
             '.$musicList.'
              ];
 
/*首次随机播放*/
var a=parseInt(Math.random()*musicArr.length);
var sj=musicArr[a];
yaudio.src=sj.mp3;
 ';
if(Typecho_Widget::widget('Widget_Options')->music_bof=='1'){	
			echo 'yaudio.play();</script>'. "\n";
		}else{	echo '</script>'. "\n";
}
        echo '<script  src="'.Helper::options()->pluginUrl . '/assets/music/js/player.js" data-no-instant></script><script  src="'.Helper::options()->themeUrl . '/assets/music/js/prbug.js"></script>' . "\n";        
    }

}
}