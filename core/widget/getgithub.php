<?php
/**
 * 
 * Github数据获取
 * Template:Bearsimple
 * Date:2022/02/11
 * 
**/
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
function getData(){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    $optionss = Helper::options();
    //验证传值
if ($_GET['type'] !== 'github')
{
    $result = array('code'=> '-1','message'=>'The pass-through value is wrong.');
echo json_encode($result); 
exit;
} 
//验证传值
if (is_numeric($_GET['page']) == false)
{
$result = array('code'=> '-1','message'=>'The pass-through value is wrong.');
echo json_encode($result); 
exit;
} 
 $removeChar = ["https://", "http://", "/"]; 
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $optionss->siteUrl)) !== false) {   
$options = bsOptions::getInstance()::get_option( 'bearsimple' );
$str = $options['github_accountid'];
    $status = json_decode(curl_get('https://api.github.com/users/'.$options['github_accountid'].'/repos?per_page=99999'),true);
     //$arr=array_column($status,'fork');
     $tot = array(
    'list' => array()
);
foreach($status as $voo){
  $tot['list'][] = array((string)$voo);
}
$status = count($tot['list']);
$max = ceil($status / 6);
$total = $status;
$result = array(
    'total' => $total,
    'max' => $max,
    'list' => array()
);
if(empty($_GET['page'])){
    $i = 1;
}
else{
    $i = $_GET['page']; 
}
                $info = json_decode(curl_get('https://api.github.com/users/'.$options['github_accountid'].'/repos?per_page=6&page='.$i),true);
                foreach ($info as $data) {
                    if($data["language"] == null){
                       $data["language"] = 'Other'; 
                    }
                   	$result['list'][] = array(
	 'url' => $data["html_url"],
	 'name' => $data["name"],
	 'dec' => $data["description"],
	 'push' => date('Y-m-d H:m:s',strtotime($data['pushed_at'])),
     'forks' => $data["forks_count"],
     'stars' => $data["stargazers_count"],
     'language' => $data["language"]
	);
                    
}
}
else{
    $result = array('code'=> '-1','message'=>'Error');
}
echo json_encode($result);

}
getData();
?>
