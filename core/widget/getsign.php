<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    $removeChar = ["https://", "http://"]; 
    
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
        $db= \Typecho\Db::get();
        if($this->user->uid == '' || $temoptions['UserCenter_sign'] == ''||  $temoptions['UserCenter_sign'] == false){
            $result = array(
    'code' => 0,
    'message' => 'error'
);
      exit(json_encode($result));  
        }
        $sign_data = array(
                'signuid' => $this->user->uid,
                'signtime' => date('Y-m-d',time()),
            );
            if(!is_numeric($temoptions['UserCenter_sign_min'])){
                $min_coin = '1';
            }
            elseif($temoptions['UserCenter_sign_min'] <= 0){
                $min_coin = '1';
            }
            else{
               $min_coin = $temoptions['UserCenter_sign_min']; 
            }
            
            
            if(!is_numeric($temoptions['UserCenter_sign_max'])){
                $max_coin = '5';
            }
            elseif($temoptions['UserCenter_sign_min'] <= 0){
                $max_coin = '5';
            }
            else{
               $max_coin = $temoptions['UserCenter_sign_max']; 
            }
            
            
            if($temoptions['UserCenter_sign_getCoin'] == true){
                $rand_coin = rand($min_coin,$max_coin);
               $sign_data['signcoin'] = $rand_coin;
            }
            else{
               $sign_data['signcoin'] = '0'; 
            }
            $db->query($db->insert('table.bscore_sign_data')->rows($sign_data));
            $oldcoin = $db->fetchRow($db->select('table.users.coins')->from('table.users')->where('uid = ?', $this->user->uid));
             $db->query($db->update('table.users')->rows(array('coins' => (int)$oldcoin['coins'] + $rand_coin))->where('uid = ?', $this->user->uid));
            $result = array(
    'code' => 1,
    'msg' => 'success',
);
if($temoptions['UserCenter_sign_getCoin'] == true){
   $result['signcoin'] = $rand_coin; 
}
      exit(json_encode($result));
    }
