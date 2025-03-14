<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);

require_once 'Dom.php';

function curl_file_get_contents($_url, $type='www')
{
    $ch = curl_init();

    $cookie = 'bid=Km3ZGpkEE00; ap_v=0,6.0; _pk_ses.100001.3ac3=*; __utma=30149280.1672442383.1554254872.1554254872.1554254872.1; __utmc=30149280; __utmz=30149280.1554254872.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmt_douban=1; __utma=81379588.1887771065.1554254872.1554254872.1554254872.1; __utmc=81379588; __utmz=81379588.1554254872.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmt=1; ll="108288"; _pk_id.100001.3ac3=88bbbc1a1f571a42.1554254872.1.1554254939.1554254872.; __utmb=30149280.7.10.1554254872; __utmb=81379588.7.10.1554254872';
    curl_setopt($ch, CURLOPT_URL, $_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_REFERER, 'https://'.$type.'.douban.com/');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

class DoubanAPI
{
    
   
    private static function __getMusicRawDataHelper($UserID, $Type='collect')
    {
        $api = 'https://music.douban.com/people/' . $UserID . '/' . $Type;
        $data = array();
        while ($api != null) {
            $raw = curl_file_get_contents($api, 'music');
            if ($raw == null || $raw == "") {
                break;
            }

            $doc = str_get_html($raw);
            
            $itemArray = $doc->find("div.item");
            foreach ($itemArray as $v) {
                $t = $v->find("li.title", 0);
                $movie_name = str_replace(array(" ", "　", "\t", "\n", "\r"),
                    array("", "", "", "", ""), $t->text());
                $movie_img = $v->find("div.pic a img", 0)->src;

                // 使用 wp 接口解决防盗链
                $movie_img = 'https://i0.wp.com/' . str_replace(array('http://', 'https://'), '', $movie_img);

                $movie_url = $t->find("a", 0)->href;
                $data[] = array("name" => $movie_name, "img" => $movie_img, "url" => $movie_url);
            }
            $url = $doc->find("span.next a", 0);
            if ($url) {
                $api = "https://music.douban.com" . $url->href;
            } else {
                $api = null;
            }
        }
        return $data;
    }
    
    
     private static function __getBookRawDataHelper($UserID, $Type='collect')
    {
        $api = 'https://book.douban.com/people/' . $UserID . '/' . $Type;
        $data = array();
        while ($api != null) {
            $raw = curl_file_get_contents($api, 'book');
            if ($raw == null || $raw == "") {
                break;
            }

            $doc = str_get_html($raw);
            
            $itemArray = $doc->find("li.subject-item");
            foreach ($itemArray as $v) {
                $t = $v->find("h2 a", 0);
                $movie_name = str_replace(array(" ", "　", "\t", "\n", "\r"),
                    array("", "", "", "", ""), $t->text());
                $movie_img = $v->find("div.pic a img", 0)->src;

                // 使用 wp 接口解决防盗链
                $movie_img = 'https://i0.wp.com/' . str_replace(array('http://', 'https://'), '', $movie_img);

                $movie_url = $v->find('a[href^="https://book.douban.com/subject/"]', 0)->href;
                $data[] = array("name" => $movie_name, "img" => $movie_img, "url" => $movie_url);
            }
            $url = $doc->find("span.next a", 0);
            if ($url) {
                $api = "https://book.douban.com" . $url->href;
            } else {
                $api = null;
            }
        }
        return $data;
    }

   
    private static function __getMovieRawDataHelper($UserID, $Type='collect')
    {
        $api = 'https://movie.douban.com/people/' . $UserID . '/' . $Type;
        $data = array();
        while ($api != null) {
            $raw = curl_file_get_contents($api, 'movie');
            if ($raw == null || $raw == "") {
                break;
            }

            $doc = str_get_html($raw);
            
            $itemArray = $doc->find("div.item");
            foreach ($itemArray as $v) {
                $t = $v->find("li.title", 0);
                $movie_name = str_replace(array(" ", "　", "\t", "\n", "\r"),
                    array("", "", "", "", ""), $t->text());
                $movie_img = $v->find("div.pic a img", 0)->src;

                // 使用 wp 接口解决防盗链
                $movie_img = 'https://i0.wp.com/' . str_replace(array('http://', 'https://'), '', $movie_img);

                $movie_url = $t->find("a", 0)->href;
                $data[] = array("name" => $movie_name, "img" => $movie_img, "url" => $movie_url);
            }
            $url = $doc->find("span.next a", 0);
            if ($url) {
                $api = "https://movie.douban.com" . $url->href;
            } else {
                $api = null;
            }
        }
        return $data;
    }
    
   
    private static function __getBookRawData($UserID)
    {
        $data = array();
        $data['reading'] = self::__getBookRawDataHelper($UserID, 'do');
        $data['wish'] = self::__getBookRawDataHelper($UserID, 'wish');
        $data['read'] = self::__getBookRawDataHelper($UserID, 'collect');
        return $data;
    }
    
   
    private static function __getMovieRawData($UserID)
    {
        $data = array();
        $data['watching'] = self::__getMovieRawDataHelper($UserID, 'do');
        $data['wish'] = self::__getMovieRawDataHelper($UserID, 'wish');
        $data['watched'] = self::__getMovieRawDataHelper($UserID, 'collect');
        return $data;
    }
    
    
    private static function __getMusicRawData($UserID)
    {
        $data = array();
        $data['listening'] = self::__getMusicRawDataHelper($UserID, 'do');
        $data['wish'] = self::__getMusicRawDataHelper($UserID, 'wish');
        $data['listened'] = self::__getMusicRawDataHelper($UserID, 'collect');
        return $data;
    }


    
    private static function __isCacheExpired($FilePath, $ValidTimeSpan)
    {
        if (!file_exists($FilePath)) {
            return -1;
        }

        $content = json_decode(file_get_contents($FilePath), true);
        if (!array_key_exists('time', $content) || $content['time'] < 1) {
            return -1;
        }

        if (time() - $content['time'] > $ValidTimeSpan) {
            return 1;
        }

        return $content;
    }

    
    public static function updateBookCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status='read')
    {
        if (!$UserID) {
            return json_encode(array());
        }

        $cache = self::__isCacheExpired(__DIR__ . '/cache/book.json', $ValidTimeSpan);

        if ($cache == -1 || $cache == 1) {
            // 缓存无效或者过期，重新请求，重新写入
            $raw = self::__getBookRawData($UserID);
            $cache = array('time' => time(), 'data' => $raw);
            file_put_contents(__DIR__ . '/cache/book.json', json_encode($cache));
        }

        $data = $cache['data'];

        // 没有数据，需要在下次刷新
        if (count($data['reading'])==0 && count($data['wish'])==0 && count($data['read'])==0) {
            $cache['time'] = 1;
            file_put_contents(__DIR__ . '/cache/book.json', json_encode($cache));
            return json_encode(array());
        }

        $data = $data[$status];
        $total = count($data);
        if ($From < 0) {
            echo json_encode(array());
        } else {
            $end = min($From + $PageSize, $total);
            $out = array();
            for ($index = $From; $index < $end; $index++) {
                array_push($out, $data[$index]);
            }
            return json_encode($out);
        }
    }

    
public static function updateMovieCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status='watched')
    {
        if (!$UserID) {
            return json_encode(array(1));
        }

        $cache = self::__isCacheExpired(__DIR__ . '/cache/movie.json', $ValidTimeSpan);

        if ($cache == -1 || $cache == 1) {
            // 缓存无效或者过期，重新请求，重新写入
            $raw = self::__getMovieRawData($UserID);
            $cache = array('time' => time(), 'data' => $raw);
            file_put_contents(__DIR__ . '/cache/movie.json', json_encode($cache));
        }

        $data = $cache['data'];

        // 没有数据，需要在下次刷新
        if (count($data['watching'])==0 && count($data['wish'])==0 && count($data['watched'])==0) {
            $cache['time'] = 1;
            file_put_contents(__DIR__ . '/cache/movie.json', json_encode($cache));
            return json_encode(array());
        }

        $data = $data[$status];
        $total = count($data);
        if ($From < 0) {
            echo json_encode(array(1));
        } else {
            $end = min($From + $PageSize, $total);
            $out = array();
            for ($index = $From; $index < $end; $index++) {
                array_push($out, $data[$index]);
            }
            return json_encode($out);
        }
    }
     
     
    
public static function updateMusicCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status='listened')
    {
        if (!$UserID) {
            return json_encode(array(1));
        }

        $cache = self::__isCacheExpired(__DIR__ . '/cache/music.json', $ValidTimeSpan);

        if ($cache == -1 || $cache == 1) {
            // 缓存无效或者过期，重新请求，重新写入
            $raw = self::__getMusicRawData($UserID);
            $cache = array('time' => time(), 'data' => $raw);
            file_put_contents(__DIR__ . '/cache/music.json', json_encode($cache));
        }

        $data = $cache['data'];

        // 没有数据，需要在下次刷新
        if (count($data['listening'])==0 && count($data['wish'])==0 && count($data['listened'])==0) {
            $cache['time'] = 1;
            file_put_contents(__DIR__ . '/cache/music.json', json_encode($cache));
            return json_encode(array());
        }

        $data = $data[$status];
        $total = count($data);
        if ($From < 0) {
            echo json_encode(array(1));
        } else {
            $end = min($From + $PageSize, $total);
            $out = array();
            for ($index = $From; $index < $end; $index++) {
                array_push($out, $data[$index]);
            }
            return json_encode($out);
        }
    }
    
  
}


        $options = get_option('bearsimple');
        $UserID = $options['douban_id'];
        $PageSize = 8;
        $ValidTimeSpan = 60 * 60 * 24 * 30;
        $From = 0;
        if (array_key_exists('from', $_GET)) {
            $From = $_GET['from'];
        }
        if ($_GET['type'] == 'book') {
            header("Content-type: application/json");
            $status = array_key_exists('status', $_GET) ? $_GET['status'] : 'read';
            echo DoubanAPI::updateBookCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status);
        } elseif ($_GET['type'] == 'movie') {
            header("Content-type: application/json");
            $status = array_key_exists('status', $_GET) ? $_GET['status'] : 'watched';
            echo DoubanAPI::updateMovieCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status);
        }elseif ($_GET['type'] == 'music') {
            header("Content-type: application/json");
            $status = array_key_exists('status', $_GET) ? $_GET['status'] : 'listened';
            echo DoubanAPI::updateMusicCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status);
        } elseif ($_GET['type'] == 'singlebook') {
            header("Content-type: application/json");
            echo DoubanAPI::updateSingleCacheAndReturn($_GET['id'], 'book', $ValidTimeSpan);
        } elseif ($_GET['type'] == 'singlemovie') {
            header("Content-type: application/json");
            echo DoubanAPI::updateSingleCacheAndReturn($_GET['id'], 'movie', $ValidTimeSpan);
        } else {
            echo json_encode(array());
        }
