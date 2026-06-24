<?php
ob_clean();
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    header('Content-type: application/json');
    $options = Helper::options();
    $removeChar = ["https://", "http://"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
   $db = \Typecho\Db::get();
   $data = json_decode(file_get_contents('php://input'),true);
  switch($data['action']){
      case 'getReact':
    $targetId = $data['targetId'];
    $result = $db->fetchAll($db->select()->from('table.bscore_emaction_data')->where('target_id = ?', $targetId));
    $newResult = [];
    foreach ($result as $row) {
        $newRow = ['reaction_name' => $row['reaction_name'], 'count' => $row['diff']];
        array_push($newResult, $newRow);
    }
    exit(json_encode([
        'code' => 200,
        'msg' => 'success',
        'data' => ['reactionsGot' => $newResult],
    ]));
  break;
      
      case 'updateReact':
                   $targetId = $data['targetId'];
    $reactionName = $data['reaction_name'];
    $diff = $data['diff'];
   if (!in_array($diff, [1, -1])) {
        $diff = $diff > 0 ? 1 : -1;
    }
    $reaction_data = $db->fetchRow($db->select()->from('table.bscore_emaction_data')->where('target_id = ?', $targetId)->where('reaction_name = ?', $reactionName));
    if(!$reaction_data){
        $datas = array(
                'target_id' => $targetId,
                'reaction_name' => $reactionName,
                'diff' => (int)$diff,
            );
            $db->query($db->insert('table.bscore_emaction_data')->rows($datas));
            
    }
    else{
        if($data['diff'] == '-1'){
            $diff = (int)$reaction_data['diff'] -1;
        }
        else{
            $diff = (int)$reaction_data['diff'] +1;
        }
        if($data['diff'] == '-1' && $reaction_data['diff'] == 0){
            $diff = 0;
        }
        $db->query($db->update('table.bscore_emaction_data')->rows(array('diff' => $diff))->where('target_id = ?', $targetId)->where('reaction_name = ?', $reactionName));
    }
    $reaction_sdata = $db->fetchAll($db->select()->from('table.bscore_emaction_data')->where('target_id = ?', $targetId)->where('reaction_name = ?', $reactionName));
    exit(json_encode([
      'code' => 200,
      'msg' => 'success',
      'data' => ['reactionsGot' => $reaction_sdata]
    ]));
 

          break;
}
}
  


   
   

    
    