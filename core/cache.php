<?php
if ($options->Cache == '1'){
Typecho_Plugin::factory('index.php')->begin = array('BearsimpleCache_Plugin', 'getCache');
        Typecho_Plugin::factory('index.php')->end = array('BearsimpleCache_Plugin', 'setCache');
        
class BearsimpleCache_Plugin
{
public static function getCache(){
        $req = Typecho_Request::getInstance();
        $url = $req->getRequestUri();


        if(!$req->isGet()){
            return;
        }
        if(strstr($url,'/action/') !== false || strstr($url,'/admin/') !== false){
            
            return;
        }

        $hash = md5($url);

        @$settings = Helper::options();
        if(!$settings) return;


        $cache_timeout = intval($settings->cache_timeout);

        $cache_root = $settings->cache_dir;
        if(strstr($cache_root, '/') !== 0 ){
            $cache_root = __TYPECHO_ROOT_DIR__.'/usr/'.$cache_root;
        }

        if($cache_timeout <= 0){
            $cache_timeout = 60; //1min
        }

        $file = self::hash2dir($hash,$cache_root).$hash.".gz";
        if(file_exists($file)){
            $filetime = filemtime($file);
            if($filetime !== false && time() - $filetime < $cache_timeout){
                $fh = fopen($file, "rb");
                $content = fread($fh,filesize ($file));
                fclose($fh);
                $html = gzuncompress($content);
                echo $html;
                exit(0);
            }
        }else{
        
        }
    }

    public static function setCache(){
        $req = Typecho_Request::getInstance();
        $url = $req->getRequestUri();
        
        if(!$req->isGet()){ #仅处理GET请求
            return;
        }
        if(strstr($url,'/action/') !== false || strstr($url,'/admin/') !== false){
            #排除action接口,这个一般是特殊接口,所以不需要缓存
            return;
        }

        @$settings = Helper::options();
        if(!$settings) return;
        $cache_root = $settings->cache_dir;
        if(strstr($cache_root, '/') !== 0 ){
            $cache_root = __TYPECHO_ROOT_DIR__.'/usr/'.$cache_root;
        }

        $hash = md5($url);
        $file = self::hash2dir($hash,$cache_root).$hash.".gz";
        $dir = dirname($file);

        if(!file_exists($dir)){
            $ret = mkdir($dir,0777,true);
            if(!$ret){
                return;
            }
        }

        $html = ob_get_contents();
        $html_gz = gzcompress($html);
        $fp = fopen($file, 'w');
        fwrite($fp, $html_gz);
        fclose($fp);
    }

    private static function hash2dir($hash,$base_dir=""){
        $dir="";
        for($i = 0; $i < strlen($hash) ; $i+=2){
            $dir = $dir."/".substr($hash, $i, 2);
        }
        return rtrim($base_dir,'/').$dir.'/';
    }
      
}
}
