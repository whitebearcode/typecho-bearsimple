<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="pure-u-1-4 hidden_mid_and_down">
    <div id="sidebar">

<?php if($this->options->AdControl == '1') :?>
<!--右侧广告模块1-->
<div class="ui cards">
  <a class="gray card"  href="<?php $this->options->AdControl1Url() ?>">
    <div class="image">
      <img src="<?php if(empty($this->options->AdControl1Src)) :?>/usr/themes/bearsimple/assets/image/white-image.png<?php else: ?><?php $this->options->AdControl1Src() ?><?php endif; ?>">
    </div>
  </a>
  </div>
  <?php endif; ?>
  
<!--右侧博主信息栏-->  
  <?php if($this->options->Authorz == '1') :?>
  <div class="ui card">
  <a class="image">
    <img src="<?php $this->options->AuthorAvatar() ?>">
  </a>
  <div class="content center aligned">
      <?php if($this->options->AuthorName !== null) :?>
    <a class="header"><?php $this->options->AuthorName() ?></a>
    <?php endif; ?>
    <?php if($this->options->AuthorQm !== null) :?>
    <div class="meta">
      <a><?php $this->options->AuthorQm() ?></a>
      </div>
    <?php endif; ?>
  
 <br>
    <div class="ui center aligned">
    <?php if(!empty($this->options->Github_URL)) :?>
    <a href="<?php $this->options->Github_URL() ?>"><i class="github icon circular link"></i></a>
    <?php endif; ?>
    <?php if(!empty($this->options->Wechat_QRCODE)) :?>
    <i class="wechat icon circular link"></i>
    <?php endif; ?>
    <?php if(!empty($this->options->QQ_QRCODE)) :?>
    <i class="qq icon circular link"></i>
    <?php endif; ?>
    <?php if(!empty($this->options->Facebook_URL)) :?>
    <a href="<?php $this->options->Facebook_URL() ?>">
    <i class="facebook icon circular link"></i></a>
    <?php endif; ?>
    <?php if(!empty($this->options->Twitter_URL)) :?>
    <a href="<?php $this->options->Twitter_URL() ?>">
    <i class="twitter icon circular link"></i></a>
    <?php endif; ?>
    </div>
  </div></div>
<?php endif; ?>

<!--搜索模块-->
<?php if($this->options->Search == '1') :?>
   <div class="widget"><div class="widget-title"><i class="fa fa-search"> 搜索</i></div><ul class="category-list">
<form role="search" method="get"> 
<div class="ui input">
  <input type="text" name="s" placeholder="输入完毕后按回车键">
</div>
 </form>
 </ul></div>
<?php endif; ?>

<?php if($this->options->Cate == '1') :?>
<!--分类模块-->
<div class="widget"><div class="widget-title"><i class="fa fa-folder-o"> 分类</i></div><ul class="category-list"><?php $this->widget('Widget_Metas_Category_List')->listCategories('wrapClass=widget-list'); ?></ul></div>
<?php endif; ?>


<?php if($this->options->LastArticle == '1') :?>
<!--最近文章模块-->
<div class="widget"><div class="widget-title"><i class="fa fa-file-o"> 最近文章</i></div><ul class="post-list"><?php if($this->options->LastArticleNumber !== null) :?><?php $this->widget('Widget_Contents_Post_Recent',"pageSize=".$this->options->LastArticleNumber)
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}{id}</a></li>'); ?><?php endif; ?>
            <?php if($this->options->LastArticleNumber == null) :?>
         <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}{id}</a></li>'); ?>
            <?php endif; ?></ul></div>
<?php endif; ?>

<!--友链模块-->
<div class="widget"><div class="widget-title"><i class="fa fa-external-link"> 友情链接</i></div><ul></ul><?php if(empty($this->options->FriendLink)) :?> <center><div class="ui circular segment">
  <h2 class="ui header">
    <center><i class="bookmark outline icon"></i>
    <div class="sub header">暂无友情链接显示</div></center>
  </h2>
</div></center><?php else: ?> <?php echo BearSimpleFriendLinkBr($this->options->FriendLink )?><?php endif; ?></div>


<?php if($this->options->AdControl == '1') :?>
<!--右侧广告模块2-->
<div class="ui cards">
   <a class="gray card"  href="<?php $this->options->AdControl2Url() ?>">
    <div class="image">
      <img src="<?php if(empty($this->options->AdControl2Src)) :?>/usr/themes/bearsimple/assets/image/white-image.png<?php else: ?><?php $this->options->AdControl2Src() ?><?php endif; ?>">
    </div>
  </a>
  </div>
  <?php endif; ?>
</div></div>



