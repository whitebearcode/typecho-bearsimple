<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="pure-u-1-4 hidden_mid_and_down">
    <div id="sidebar" class="sidebar">

<?php if($this->options->AdControl == '1') :?>
<?php if($this->options->AdControl1 == '1' && !empty($this->options->AdControl1Src)) :?>
<div class="widget">
<!--右侧广告模块1-->
    <?php billboard($this->options->AdControl1Src,'sidebar'); ?></div>
    <?php endif; ?>
  <?php endif; ?>

          <?php if($this->options->Authorz == '1') :?>
          <div class="widget">
<div class="ui special cards">
  <div class="card">
    <div class="blurring dimmable image">
      <div class="ui inverted dimmer">
        <div class="content">
          <div class="center">
             
            <a href="<?php if($this->options->AuthorAvatarClickLink) :?><?php $this->options->AuthorAvatarClickLink() ?><?php else :?>#<?php endif; ?>"<?php if($this->options->AuthorAvatarClickLink){echo parselink($this->options->AuthorAvatarClickLink);} ?> class="ui primary button"><?php if($this->options->AuthorAvatarClickText) :?><?php $this->options->AuthorAvatarClickText() ?><?php else :?>暂时没有<?php endif; ?></a>
          </div>
        </div>
      </div>
      <img src="<?php $this->options->AuthorAvatar() ?>">
    </div>
    <div class="content center aligned">
        <?php if($this->options->AuthorName !== null) :?>
      <a class="header"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>><?php $this->options->AuthorName() ?></a>
       <?php endif; ?>

    <?php if($this->options->AuthorQm !== null) :?>
      <div class="meta">
        <span class="date"><?php $this->options->AuthorQm() ?></span>
      </div>
      <?php endif; ?>
      
      <?php if($this->options->FourTotalHidden == '1') :?>
      <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?><br>
      <div class="ui mini four statistics">
  <div class="statistic">
    <div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
<?php if($stat->publishedPostsNum > '999'){echo '999+';}else{echo $stat->publishedPostsNum();} ?>
    </a></div>
    <div class="label">
      文章
    </div>
  </div>
   <div class="statistic">
            <div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
      <?php if($stat->publishedCommentsNum > '999'){echo '999+';}else{echo $stat->publishedCommentsNum();} ?>
     </a></div>
    <div class="label">
      评论 
    </div>
   </div>
  <div class="statistic">
       <div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
      <?php if($stat->categoriesNum > '999'){echo '999+';}else{echo $stat->categoriesNum();} ?>
   </a>
    </div>
    <div class="label">
      分类
    </div>
  </div>
  <div class="statistic">
    <div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
      <?php if($stat->publishedPagesNum > '999'){echo '999+';}else{echo $stat->publishedPagesNum();} ?>
    </a></div>
    <div class="label">
      页面
    </div>
  </div></div>
      <?php endif; ?>
    </div> 

  <?php if(!empty($this->options->Github_URL) || !empty($this->options->Wechat_QRCODE) || !empty($this->options->QQ_QRCODE) || !empty($this->options->Facebook_URL) || !empty($this->options->Twitter_URL) ||!empty($this->options->Telegram_URL)) :?>
    <div class="extra content center aligned">
       <?php if(!empty($this->options->Github_URL)) :?>
       
    <a href="<?php $this->options->Github_URL() ?>"<?php echo parselink($this->options->Github_URL); ?>><i class="github icon circular link" style="margin-top:5px"></i></a>
    <?php endif; ?>
    <?php if(!empty($this->options->Wechat_QRCODE)) :?>
    <i class="wechat icon circular link" style="margin-top:5px"></i>
    <?php endif; ?>
    <?php if(!empty($this->options->QQ_QRCODE)) :?>
    <i class="qq icon circular link" style="margin-top:5px"></i>
    <?php endif; ?>
    <?php if(!empty($this->options->Facebook_URL)) :?>
    <a href="<?php $this->options->Facebook_URL() ?>"<?php echo parselink($this->options->Facebook_URL); ?>>
    <i class="facebook icon circular link" style="margin-top:5px"></i></a>
    <?php endif; ?>
    <?php if(!empty($this->options->Twitter_URL)) :?>
    <a href="<?php $this->options->Twitter_URL() ?>"<?php echo parselink($this->options->Twitter_URL); ?>>
    <i class="twitter icon circular link" style="margin-top:5px"></i></a>
    <?php endif; ?>
    <?php if(!empty($this->options->Telegram_URL)) :?>
    <a href="<?php $this->options->Telegram_URL() ?>"<?php echo parselink($this->options->Telegram_URL); ?>>
        <i class="telegram icon circular link" style="margin-top:5px"></i></a>
        <?php endif; ?>
</div><?php endif; ?>
  </div></div></div>
  <?php endif; ?>
<!--搜索模块-->
<?php if(@in_array('sidebar',$this->options->Search)) :?> 
   <div class="widget">
<div class="widget-title"><i class="fa fa-search"> 搜索</i></div><ul class="category-list">
<form name="search" class="ui form" role="search" method="get" id="searchform">
    <div class="ui search">
<div class="ui large transparent icon input">
  <input class="prompt" id="sidebarsearch" type="text" name="s" placeholder="输入完毕后按回车键">
  <i hrefx="?s=" class="search link icon"></i>
</div>
</div>
 </form>
 </ul>
</div>
  <?php endif; ?>
<?php if($this->options->Cate == '1') :?>
<!--分类模块-->
<div class="widget">
<div class="widget-title"><i class="fa fa-folder-o"> 分类</i></div><ul class="category-list">

<?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
<?php while($categorys->next()): ?>
<?php if ($categorys->levels === 0): ?>
<?php $children = $categorys->getAllChildren($categorys->mid); ?>
<?php if (empty($children)) { ?>
<li <?php if($this->is('category', $categorys->slug)): ?> class="active"<?php endif; ?>>
<a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?>  <div class="ui mini label" style="float:right">
    <?php $categorys->count(); ?></a>
</li>
<?php } else { ?>
<li>
<div class="ui dropdown"><a style="color:gray" href="<?php $categorys->permalink(); ?>"><?php $categorys->name(); ?></a><i class="dropdown icon"></i>
<div class="menu">
<?php foreach ($children as $mid) { ?>
<?php $child = $categorys->getCategory($mid); ?>
<div class="item" hrefs="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?>  <div class="ui mini label">
    <?php echo $child['count']; ?>
</div>
</div>
<?php } ?>
</div></div></li>
<?php } ?><?php endif; ?><?php endwhile; ?>

</ul>

</div>
<?php endif; ?>

<?php if($this->options->LastArticle == '1') :?>
<!--最近文章模块-->

<div class="widget"><div class="widget-title"><i class="fa fa-file-o"> 最近文章</i></div><ul class="post-list">
<?php if(!empty($this->options->LastArticleNumber)) :?><?php $this->widget('Widget_Contents_Post_Recent',"pageSize=".$this->options->LastArticleNumber)
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}</a></li>',''); ?>
            <?php else: ?>
         <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}</a></li>'); ?>
            <?php endif; ?>
            </ul></div>
<?php endif; ?>

<?php if($this->options->lastcomment == '1') :?>
<div class="widget">
     <div class="widget-title"><i class="fa fa-reply"> 最新回复</i></div>
    <div class="ui feed">
   <?php
    $obj = $this->widget('Widget_Comments_Recent');
    ?>
<?php if($obj->have()) :?>
  <?php $i = 0;
$num = 5;
while($obj->next()) :?>
<?php
if($i == $num){ 
   break;
} 
?>
     <div class="event" style="margin-top:5px">
    <div class="content">
    <div class="date" style="margin-top:3px">
          <?php $obj->date('Y-m-d H:i'); ?>
        </div>
      <div class="summary">
        <?php echo $obj->author; ?> 在《<a href="<?php echo get_article_link($obj->cid); ?>"><?php echo get_article_title($obj->cid); ?></a>》发表了评论:
      </div>
      <div class="extra text" style="margin-top:-3px">
<?php echo reEmo($obj->text,'reply'); ?>
      </div>
    </div>
  </div>
      <?php  
$i++;
?>
<?php endwhile; ?>
<?php endif; ?>
</div>
</div>
<?php endif; ?>

<?php if($this->options->FriendLinkChoose == '1') :?>
<!--友链模块-->
<div class="widget"><div class="widget-title"><i class="fa fa-external-link"> 友情链接</i></div><ul></ul><?php if(empty($this->options->FriendLink)) :?> <center><div class="ui compact segment">
  <h2 class="ui header">
    <center><i class="bookmark outline icon"></i>
    <div class="sub header">暂无友情链接显示</div></center>
  </h2></div>
</center><?php else: ?> <?php foreach (getFriendLink() as $FriendLinks): ?>
<a href="<?php echo $FriendLinks[2]; ?>" title="<?php echo $FriendLinks[1]; ?>"<?php echo parselink($FriendLinks[2]); ?>><?php echo $FriendLinks[0]; ?>
</a><ul></ul> 
<?php endforeach; ?><?php endif; ?></div>
<?php endif; ?>


<?php if($this->options->AdControl == '1') :?>
<?php if($this->options->AdControl2 == '1' && !empty($this->options->AdControl2Src)) :?>
<div class="widget">
<!--右侧广告模块2-->
<?php billboard($this->options->AdControl2Src,'sidebar'); ?> </div>
  <?php endif; ?>
  <?php endif; ?>
</div></div>