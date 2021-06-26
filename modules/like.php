<?php
$cid=$this->request->filter('int')->cid;
        if($cid){
            try {
                $row = $this->db->fetchRow($this->db->select('likes')->from('table.contents')->where('cid = ?', $cid));
                $this->db->query($this->db->update('table.contents')->rows(array('likes' => (int)$row['likes']+1))->where('cid = ?', $cid));
                $this->response->throwJson("success");
            } catch (Exception $ex) {
               echo $ex->getCode();
            }
        }  else {
            echo "error";
        }