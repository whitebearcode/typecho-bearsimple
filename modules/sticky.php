<?php
/** 文章置顶模块 */
$sticky = $this->options->sticky_cids;

if($sticky && $this->is('index') || $this->is('front')){
    $sticky_cids = explode(',', strtr($sticky, ' ', ','));
    $sticky_html = $this->options->sticky_html; 
    $db = Typecho_Db::get();
    $pageSize = $this->options->pageSize;
    $select1 = $this->select()->where('type = ?', 'post');
    $select2 = $this->select()->where('type = ? && status = ? && created < ?', 'post','publish',time());
    $this->row = [];
    $this->stack = [];
    $this->length = 0;
    $order = '';
    foreach($sticky_cids as $i => $cid) {
        if($i == 0) $select1->where('cid = ?', $cid);
        else $select1->orWhere('cid = ?', $cid);
        $order .= " when $cid then $i";
        $select2->where('table.contents.cid != ?', $cid); 
    }
    if ($order) $select1->order(null,"(case cid$order end)");
    if ($this->_currentPage == 1) foreach($db->fetchAll($select1) as $sticky_post){
        $sticky_post['sticky'] = $sticky_html;
        $this->push($sticky_post);
    }
$uid = $this->user->uid;
    if($uid) $select2->orWhere('authorId = ? && status = ?',$uid,'private');
    $sticky_posts = $db->fetchAll($select2->order('table.contents.created', Typecho_Db::SORT_DESC)->page($this->_currentPage, $this->parameter->pageSize));
    foreach($sticky_posts as $sticky_post) $this->push($sticky_post);
    $this->setTotal($this->getTotal()-count($sticky_cids));
}