<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="pure-u-1-4 hidden_mid_and_down">
    <div id="sidebar" class="sidebar">
    
<?php if(Bsoptions('AdControl') == true) :?>
<?php if(Bsoptions('AdControl1') == true && !empty(Bsoptions('AdControl1Src'))) :?>
<div class="widget">
<!--右侧广告模块1-->
    <?php billboard(Bsoptions('AdControl1Src'),'sidebar'); ?></div>
    <?php endif; ?>
  <?php endif; ?>

          <?php if(Bsoptions('Authorz') == true) :?>
          <div class="widget">
<?php if(Bsoptions('AuthorzStyle') == '2') :?>
<div class="bs-new2authorcard-container">
        <div>
            <div class="bs-new2authorcard">
                <div class="bs-new2authorcard-header" style="background-image: url(<?php if(Bsoptions('AuthorBackground')):?><?php echo Bsoptions('AuthorBackground'); ?><?php else:?><?php AssetsDir();?>assets/images/default_background.webp<?php endif; ?>);">
                    <div class="bs-new2authorcard-photo">
                        <img class="got" src="<?php echo Bsoptions('AuthorAvatar') ?>" alt="">
                    </div>
                </div>
                <div class="bs-new2authorcard-body">
                    <?php if(Bsoptions('AuthorName') !== null) :?><h3 class="bs-new2authorcard-name"><?php echo Bsoptions('AuthorName') ?></h3><?php endif; ?>
                    
                    <?php if(Bsoptions('AuthorOneSay') == true) :?><p class="bs-new2authorcard-description"><?php echo get_hito(); ?></p><?php elseif(Bsoptions('AuthorQm') !== null): ?><p class="bs-new2authorcard-description"><?php echo Bsoptions('AuthorQm') ?></p><?php endif; ?>
                    
                    <?php if(Bsoptions('FourTotalHidden') == true) :?>
                    <div class="bs-new2authorcard-button">
                        
      <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?><br>
      <div class="ui small four statistics">
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
      <?php if($stat->publishedCommentsNum - crossnum() > '999'){echo '999+';}else{echo $stat->publishedCommentsNum - crossnum();} ?>
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
      
                    </div>
                <?php endif; ?>    
                <?php if(!empty(Bsoptions('Github_URL')) || !empty(Bsoptions('Wechat_QRCODE')) || !empty(Bsoptions('QQ_QRCODE')) || !empty(Bsoptions('Facebook_URL')) || !empty(Bsoptions('Twitter_URL')) ||!empty(Bsoptions('Telegram_URL')) ||!empty(Bsoptions('Weibo_URL'))) :?>
                    <ul class="bs-new2authorcard-social" style="margin:auto">
                         <?php if(!empty(Bsoptions('Github_URL'))) :?>
    <li><a href="<?php echo Bsoptions('Github_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><i class="fa fa-github"></i></a></li>
    <?php endif; ?>
                     <?php if(!empty(Bsoptions('Wechat_QRCODE'))) :?>
    <li><a><i class="fa fa-wechat" id="contactwechat"></i></a></li>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('QQ_QRCODE'))) :?>
    <li><a><i class="fa fa-qq" id="contactqq"></i></a></li>
    <?php endif; ?>

    <?php if(!empty(Bsoptions('Weibo_URL'))) :?>
    <li><a href="<?php echo Bsoptions('Weibo_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><i class="fa fa-weibo"></i></a></li>
    <?php endif; ?>
     <?php if(!empty(Bsoptions('Facebook_URL'))) :?>
    <li><a href="<?php echo Bsoptions('Facebook_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><i class="fa fa-facebook"></i></a></li>
    <?php endif; ?>
     <?php if(!empty(Bsoptions('Twitter_URL'))) :?>
    <li><a href="<?php echo Bsoptions('Twitter_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><i class="fa fa-twitter"></i></a></li>
    <?php endif; ?>
     <?php if(!empty(Bsoptions('Telegram_URL'))) :?>
    <li><a href="<?php echo Bsoptions('Telegram_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><i class="fa fa-telegram"></i></a></li>
    <?php endif; ?>
                    </ul> 
                     <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php elseif(Bsoptions('AuthorzStyle') == '3') :?>
             
              <div class="bs_newAuthor_card_body">
  <div class="bs_newAuthor_card">
 
      <div class="bs_newAuthor_card-header" style="background-image: url(<?php echo Bsoptions('AuthorAvatar') ?>)">
           
            <div class="bs_newAuthor_card-header-slanted-edge">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200"><path class="bs_newAuthor_card-polygon" d="M-20,200,1000,0V200Z" /></svg>
                
            </div>

      </div>

      <div class="bs_newAuthor_card-body">
          <?php if(Bsoptions('AuthorName') !== null) :?><h2 class="bs_newAuthor_card-name"><?php echo Bsoptions('AuthorName') ?></h2><?php endif; ?>
       <?php if(Bsoptions('AuthorOneSay') == true) :?><div class="bs_newAuthor_card-bio"><?php echo get_hito(); ?></div><?php elseif(Bsoptions('AuthorQm') !== null): ?><div class="bs_newAuthor_card-bio"><?php echo Bsoptions('AuthorQm') ?></div><?php endif; ?>
         
          
                <?php if(Bsoptions('FourTotalHidden') == true) :?>
<?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
      <div class="bs_newAuthor_card-card-footer">
          <div class="bs_newAuthor_card-stats">
              <div class="bs_newAuthor_card-stat">
                <span class="bs_newAuthor_card-label">文章</span>
                <span class="bs_newAuthor_card-value"><div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
      <?php if($stat->publishedPostsNum > '999'){echo '999+';}else{echo $stat->publishedPostsNum();} ?>
    </a></div></span>
           </div>
              <div class="bs_newAuthor_card-stat">
                <span class="bs_newAuthor_card-label">评论</span>
                <span class="bs_newAuthor_card-value"><div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
      <?php if($stat->publishedCommentsNum - crossnum() > '999'){echo '999+';}else{echo $stat->publishedCommentsNum - crossnum();} ?>
    </a></div></span>
              </div>
              <div class="bs_newAuthor_card-stat">
                <span class="bs_newAuthor_card-label">分类</span>
                <span class="bs_newAuthor_card-value"><div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
      <?php if($stat->categoriesNum > '999'){echo '999+';}else{echo $stat->categoriesNum();} ?>
    </a></div></span>
              </div>
              <div class="bs_newAuthor_card-stat">
                <span class="bs_newAuthor_card-label">页面</span>
                <span class="bs_newAuthor_card-value"><div class="ui circular labels">
  <a class="ui label" style="margin-right:-2px">
      <?php if($stat->publishedPagesNum > '999'){echo '999+';}else{echo $stat->publishedPagesNum();} ?>
    </a></div></span>
              </div>
          </div>
      </div>
      <?php endif; ?>
  <?php if(!empty(Bsoptions('Github_URL')) || !empty(Bsoptions('Wechat_QRCODE')) || !empty(Bsoptions('QQ_QRCODE')) || !empty(Bsoptions('Facebook_URL')) || !empty(Bsoptions('Twitter_URL')) ||!empty(Bsoptions('Telegram_URL')) ||!empty(Bsoptions('Weibo_URL'))) :?>
          <div class="bs_newAuthor_card-social-accounts" style="margin-top:1500px">
              <a href="<?php echo Bsoptions('Github_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><i class="github icon circular link" style="margin-top:3px"></i></a>
              <?php if(!empty(Bsoptions('Wechat_QRCODE'))) :?>
    <a><i class="wechat icon circular link" style="margin-top:3px" id="contactwechat"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('QQ_QRCODE'))) :?>
    <a><i class="qq icon circular link" style="margin-top:3px" id="contactqq"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Weibo_URL'))) :?>
    <a href="<?php echo Bsoptions('Weibo_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
    <i class="weibo icon circular link" style="margin-top:3px"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Facebook_URL'))) :?>
    <a href="<?php echo Bsoptions('Facebook_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
    <i class="facebook icon circular link" style="margin-top:3px"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Twitter_URL'))) :?>
    <a href="<?php echo Bsoptions('Twitter_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
    <i class="twitter icon circular link" style="margin-top:3px"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Telegram_URL'))) :?>
    <a href="<?php echo Bsoptions('Telegram_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
        <i class="telegram icon circular link" style="margin-top:3px"></i></a>
        <?php endif; ?>
          </div>
          <br>
          <?php endif; ?>
     
      
      </div>
     
  </div>
 </div>
  <?php else:?>
<div class="ui special cards">
  <div class="card">
    <div class="blurring dimmable image">
      <div class="ui inverted dimmer">
        <div class="content">
          <div class="center">
             
            <a href="<?php if(Bsoptions('AuthorAvatarClickLink')) :?><?php echo Bsoptions('AuthorAvatarClickLink') ?><?php else :?>#<?php endif; ?>"<?php if(Bsoptions('AuthorAvatarClickLink')){echo parselink(Bsoptions('AuthorAvatarClickLink'));} ?> class="ui primary button"><?php if(Bsoptions('AuthorAvatarClickText')) :?><?php echo Bsoptions('AuthorAvatarClickText') ?><?php else :?>暂时没有<?php endif; ?></a>
          </div>
        </div>
      </div>
      <img src="<?php echo Bsoptions('AuthorAvatar') ?>">
    </div>
    <div class="content center aligned">
        <?php if(Bsoptions('AuthorName') !== null) :?>
      <a class="header"><?php echo Bsoptions('AuthorName') ?></a>
       <?php endif; ?>
<?php if(Bsoptions('AuthorOneSay') == true) :?><div class="meta">
        <span class="date"><?php echo get_hito(); ?></span>
      </div><?php elseif(Bsoptions('AuthorQm') !== null): ?><div class="meta">
        <span class="date"><?php echo Bsoptions('AuthorQm') ?></span>
      </div><?php endif; ?>
   
      <?php if(Bsoptions('FourTotalHidden') == true) :?>
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
      <?php if($stat->publishedCommentsNum - crossnum() > '999'){echo '999+';}else{echo $stat->publishedCommentsNum - crossnum();} ?>
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

  <?php if(!empty(Bsoptions('Github_URL')) || !empty(Bsoptions('Wechat_QRCODE')) || !empty(Bsoptions('QQ_QRCODE')) || !empty(Bsoptions('Facebook_URL')) || !empty(Bsoptions('Twitter_URL')) ||!empty(Bsoptions('Telegram_URL')) ||!empty(Bsoptions('Weibo_URL'))) :?>
    <div class="extra content center aligned">
       <?php if(!empty(Bsoptions('Github_URL'))) :?>
       
     <a href="<?php echo Bsoptions('Github_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><i class="github icon circular link" style="margin-top:5px"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Wechat_QRCODE'))) :?>
    <a><i class="wechat icon circular link" style="margin-top:5px" id="contactwechat"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('QQ_QRCODE'))) :?>
    <a><i class="qq icon circular link" style="margin-top:5px" id="contactqq"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Weibo_URL'))) :?>
    <a href="<?php echo Bsoptions('Weibo_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
    <i class="weibo icon circular link" style="margin-top:5px"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Facebook_URL'))) :?>
    <a href="<?php echo Bsoptions('Facebook_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
    <i class="facebook icon circular link" style="margin-top:5px"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Twitter_URL'))) :?>
    <a href="<?php echo Bsoptions('Twitter_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
    <i class="twitter icon circular link" style="margin-top:5px"></i></a>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Telegram_URL'))) :?>
    <a href="<?php echo Bsoptions('Telegram_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>
        <i class="telegram icon circular link" style="margin-top:5px"></i></a>
        <?php endif; ?>
</div><?php endif; ?>
  </div></div><?php endif; ?>
  </div>
  <?php endif; ?>
<!--搜索模块-->
<?php if(!empty(Bsoptions('Search')[0]) && @in_array('sidebar',Bsoptions('Search'))) :?>
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
     
<?php if(Bsoptions('Cate') == true) :?>
<!--分类模块-->
<div class="widget">
<div class="widget-title"><i class="fa fa-folder-o"></i> 分类</div><ul class="category-list">

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

<?php if(Bsoptions('LastArticle') == true) :?>
<!--最近文章模块-->

<div class="widget"><div class="widget-title"><i class="fa fa-file-o"></i> 最近文章</div><ul class="post-list">
 <?php if(!empty(Bsoptions('LastArticleNumber'))) :?><?php $this->widget('Widget_Contents_Post_Recent',"pageSize=".Bsoptions('LastArticleNumber'))
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}</a></li>',''); ?>
            <?php else: ?>
         <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}</a></li>'); ?>
            <?php endif; ?></ul></div>
<?php endif; ?>
 
<?php if(Bsoptions('lastcomment') == true) :?>
<div class="widget">
     <div class="widget-title"><i class="fa fa-reply"></i> 最新评论</div>
     <div class="ui small feed">
    
 <?php lastComments(); ?>



</div>
   
</div>
<?php endif; ?>

<?php if(Bsoptions('FriendLinkChoose') == true) :?>
<?php if(Bsoptions('FriendLink_place') == '2' && !$this->is('index')) :?>
<?php else:?>
<!--友链模块-->
<div class="widget"><div class="widget-title"><i class="fa fa-external-link"></i>  友情链接</div><ul></ul><?php if(empty(Bsoptions('FriendLink'))) :?> <center><div class="ui compact segment">
  <h2 class="ui header">
    <center><i class="bookmark outline icon"></i>
    <div class="sub header">暂无友情链接显示</div></center>
  </h2></div>
</center><?php else: ?> <?php foreach (getFriendLink() as $FriendLinks): ?>
<a href="<?php echo $FriendLinks[2]; ?>" title="<?php echo $FriendLinks[1]; ?>"<?php echo parselink($FriendLinks[2]); ?>><?php echo $FriendLinks[0]; ?>
</a><ul></ul> 
<?php endforeach; ?><?php endif; ?></div>
<?php endif; ?><?php endif; ?>

<?php if(Bsoptions('tagcloud') == true) :?>
<div class="widget">
<div class="widget-title"><i class="fa fa-tag"></i> 标签云</div><ul class="category-list">
<?php Typecho_Widget::widget('Widget_Metas_Tag_Cloud','ignoreZeroCount=true&limit='.tagcloudnum())->to($tags); ?>
          <?php if($tags->have()): ?>
    <?php while ($tags->next()): ?>
      <a class="ui mini basic label" style="margin-top:3px;margin-left:-3px" href="<?php $tags->permalink();?>"><?php $tags->name(); ?></a>
      <?php endwhile; ?>
      <?php else: ?>
     <a class="ui mini basic label" style="margin-top:3px;margin-left:-3px;" href="#">暂无标签</a>
      <?php endif; ?>
   </ul>
    </div>
    <?php endif; ?>
    
<?php if(Bsoptions('AdControl') == true) :?>
<?php if(Bsoptions('AdControl2') == true && !empty(Bsoptions('AdControl2Src'))) :?>
<div class="widget">
<!--右侧广告模块2-->
<?php billboard(Bsoptions('AdControl2Src'),'sidebar'); ?> </div>
  <?php endif; ?>
  <?php endif; ?>
</div></div> 