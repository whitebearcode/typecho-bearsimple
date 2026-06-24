<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);

function curl_file_get_contents_a($_url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_REFERER, 'https://bangumi.tv/');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function curl_file_get_contents_b($_url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.bilibili.com/');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


class BangumiAPI
{
    
   
    private static function __getBangumiRawDataHelper($UserID, $Type='2')
    {
        $collOffset = 0;
$collDataArr = [];
 do {
                $collData = json_decode(curl_file_get_contents_a('https://api.bgm.tv/v0/users/'.$UserID.'/collections?subject_type=2&type='.$Type.'&limit=50&offset=' . $collOffset), true);
                $collDataArr = array_merge($collDataArr, $collData['data']);
                $collOffset += 50;
            } while ($collOffset < $collData['total']);
            
        $data = array();

            foreach ($collDataArr as $v) {
                $data[] = array("name" => $v['subject']['name'], "img" => $v['subject']['images']['medium'], "url" => 'https://bangumi.tv/subject/'.$v['subject_id']);
            }
    
        return $data;
    }
    
    
     
    private static function __getBangumiRawData($UserID)
    {
        $data = array();
        $data['watching'] = self::__getBangumiRawDataHelper($UserID, '3');
        $data['wish'] = self::__getBangumiRawDataHelper($UserID, '1');
        $data['watched'] = self::__getBangumiRawDataHelper($UserID, '2');
        $data['on_hold'] = self::__getBangumiRawDataHelper($UserID, '4');
        $data['dropped'] = self::__getBangumiRawDataHelper($UserID, '5');
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

    
    public static function updateBangumiCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status='watch')
    {
        if (!$UserID) {
            return json_encode(array());
        }

        $cache = self::__isCacheExpired(__DIR__ . '/cache/bangumi.json', $ValidTimeSpan);

        if ($cache == -1 || $cache == 1) {
            // 缓存无效或者过期，重新请求，重新写入
            $raw = self::__getBangumiRawData($UserID);
            $cache = array('time' => time(), 'data' => $raw);
            file_put_contents(__DIR__ . '/cache/bangumi.json', json_encode($cache));
        }

        $data = $cache['data'];

        // 没有数据，需要在下次刷新
        if (count($data['watching'])==0 && count($data['wish'])==0 && count($data['watch'])==0) {
            $cache['time'] = 1;
            file_put_contents(__DIR__ . '/cache/bangumi.json', json_encode($cache));
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

    

  
}


class BilibiliAPI
{
    
   
    private static function __getBilibiliRawDataHelper($UserID)
    {
       $collOffset = 1;
$collDataArr = [];
 do {
                $collData = json_decode(curl_file_get_contents_b('https://api.bilibili.com/x/space/bangumi/follow/list?vmid='.$UserID.'&type=1&ps=30&follow_status=0&pn=' . $collOffset), true);
                $collDataArr = array_merge($collDataArr, $collData['data']['list']);
                $collOffset += 1;
            } while ($collOffset < $collData['data']['total']);
            
        $data = array();

            foreach ($collDataArr as $v) {
                $data[] = array("name" => $v['title'], "img" => 'https://i0.wp.com/' . str_replace(array('http://', 'https://'), '', $v['cover']), "url" => $v['url']);
            }
    
        return $data;
    }
    
    
     
    private static function __getBilibiliRawData($UserID)
    {
        $data = array();
        $data['acg'] = self::__getBilibiliRawDataHelper($UserID);
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

    
    public static function updateBilibiliCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status='acg')
    {
        if (!$UserID) {
            return json_encode(array());
        }

        $cache = self::__isCacheExpired(__DIR__ . '/cache/bilibili.json', $ValidTimeSpan);

        if ($cache == -1 || $cache == 1) {
            // 缓存无效或者过期，重新请求，重新写入
            $raw = self::__getBilibiliRawData($UserID);
            $cache = array('time' => time(), 'data' => $raw);
            file_put_contents(__DIR__ . '/cache/bilibili.json', json_encode($cache));
        }

        $data = $cache['data'];

        // 没有数据，需要在下次刷新
        if (count($data['acg'])==0) {
            $cache['time'] = 1;
            file_put_contents(__DIR__ . '/cache/bilibili.json', json_encode($cache));
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

    

  
}


        $options = get_option('bearsimple');
        $UserID = $options['bangumi_accountid'];
        $UserID2 = $options['bilibili_accountid'];
        $PageSize = 8;
        $ValidTimeSpan = 60 * 60 * 24 * 7;
        $From = 0;
        if (array_key_exists('from', $_GET)) {
            $From = $_GET['from'];
        }
        if ($_GET['type'] == 'bangumi') {
            header("Content-type: application/json");
            $status = array_key_exists('status', $_GET) ? $_GET['status'] : 'watch';
            echo BangumiAPI::updateBangumiCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan, $status);
        }else if ($_GET['type'] == 'bilibili') {
            header("Content-type: application/json");
            $status = array_key_exists('status', $_GET) ? $_GET['status'] : 'acg';
            echo BilibiliAPI::updateBilibiliCacheAndReturn($UserID2, $PageSize, $From, $ValidTimeSpan, $status);
        } else {
            echo json_encode(array());
        }
