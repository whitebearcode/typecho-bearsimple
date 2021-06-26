<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="pure-u-1-4 hidden_mid_and_down">
    <div id="sidebar">

<?php if($this->options->AdControl == '1') :?>
<?php if($this->options->AdControl1 == '1') :?>
<div class="widget">
<!--右侧广告模块1-->
<div class="ui cards">
  <a class="gray card"  href="<?php $this->options->AdControl1Url() ?>">
    
    <div class="image">
      <img src="<?php if(empty($this->options->AdControl1Src)) :?>/usr/themes/bearsimple/assets/image/white-image.png<?php else: ?><?php $this->options->AdControl1Src() ?><?php endif; ?>">
       
    </div>
  </a>
  </div> </div>
  <?php endif; ?>
  <?php endif; ?>
          <?php if($this->options->Authorz == '1') :?>
          <div class="widget">
<div class="ui special cards">
  <div class="card">
    <div class="blurring dimmable image">
      <div class="ui dimmer">
        <div class="content">
          <div class="center">
             
            <a href="<?php if($this->options->AuthorAvatarClickLink) :?><?php $this->options->AuthorAvatarClickLink() ?><?php else :?>#<?php endif; ?>" class="ui inverted button"><?php if($this->options->AuthorAvatarClickText) :?><?php $this->options->AuthorAvatarClickText() ?><?php else :?>暂时没有<?php endif; ?></a>
          </div>
        </div>
      </div>
      <img src="<?php $this->options->AuthorAvatar() ?>">
    </div>
    <div class="content center aligned">
        <?php if($this->options->AuthorName !== null) :?>
      <a class="header"><?php $this->options->AuthorName() ?></a>
       <?php endif; ?>
    <?php if($this->options->AuthorQm !== null) :?>
      <div class="meta">
        <span class="date"><?php $this->options->AuthorQm() ?></span>
      </div>
      <?php endif; ?>
    </div>
    <div class="extra content center aligned">
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
  </div></div></div>
  <?php endif; ?>
<!--搜索模块-->
<?php if($this->options->Search == '1') :?>

   <div class="widget">
   
       <?php if($this->options->rightType !== "0"): ?><div class="ui <?php if($this->options->rightType == "1"): ?>raised<?php endif; ?><?php if($this->options->rightType == "2"): ?>stacked<?php endif; ?><?php if($this->options->rightType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->rightType == "4"): ?>piled<?php endif; ?> segments" <?php if($this->options->rightradius): ?>style="border-radius:<? $this->options->rightradius(); ?>px"<?php endif; ?>>
 <div class="ui segment"><?php endif; ?>
<div class="widget-title"><i class="fa fa-search"> 搜索</i></div><ul class="category-list">
<form class="ui form" role="search" method="get">

<div class="ui large icon input">
  <input type="text"  name="s"  placeholder="输入完毕后按回车键">
  <i class="search icon"></i>
</div>
 </form>
  
 </ul>
</div>
<?php if($this->options->rightType !== "0"): ?></div></div><?php endif; ?><?php endif; ?>


<?php if($this->options->Cate == '1') :?>
<!--分类模块-->
<div class="widget"> <?php if($this->options->rightType !== "0"): ?><div class="ui <?php if($this->options->rightType == "1"): ?>raised<?php endif; ?><?php if($this->options->rightType == "2"): ?>stacked<?php endif; ?><?php if($this->options->rightType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->rightType == "4"): ?>piled<?php endif; ?> segments" <?php if($this->options->rightradius): ?>style="border-radius:<? $this->options->rightradius(); ?>px"<?php endif; ?>>
 <div class="ui segment"><?php endif; ?><div class="widget-title"><i class="fa fa-folder-o"> 分类</i></div><ul class="category-list"><?php $this->widget('Widget_Metas_Category_List')->listCategories('wrapClass=widget-list'); ?></ul></div><?php if($this->options->rightType !== "0"): ?></div></div><?php endif; ?>
<?php endif; ?>


<?php if($this->options->LastArticle == '1') :?>
<!--最近文章模块-->

<div class="widget"><?php if($this->options->rightType !== "0"): ?><div class="ui <?php if($this->options->rightType == "1"): ?>raised<?php endif; ?><?php if($this->options->rightType == "2"): ?>stacked<?php endif; ?><?php if($this->options->rightType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->rightType == "4"): ?>piled<?php endif; ?> segments">
 <div class="ui segment"><?php endif; ?><div class="widget-title"><i class="fa fa-file-o"> 最近文章</i></div><ul class="post-list"><?php if($this->options->LastArticleNumber !== null) :?><?php $this->widget('Widget_Contents_Post_Recent',"pageSize=".$this->options->LastArticleNumber)
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}{id}</a></li>'); ?><?php endif; ?>
            <?php if($this->options->LastArticleNumber == null) :?>
         <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li class="post-list-item"><a class="post-list-link" href="{permalink}">{title}{id}</a></li>'); ?>
            <?php endif; ?></ul></div><?php if($this->options->rightType !== "0"): ?></div></div><?php endif; ?>
<?php endif; ?>

<?php if($this->options->FriendLinkChoose == '1') :?>
<!--友链模块-->
<div class="widget"><?php if($this->options->rightType !== "0"): ?><div class="ui <?php if($this->options->rightType == "1"): ?>raised<?php endif; ?><?php if($this->options->rightType == "2"): ?>stacked<?php endif; ?><?php if($this->options->rightType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->rightType == "4"): ?>piled<?php endif; ?> segments" <?php if($this->options->rightradius): ?>style="border-radius:<? $this->options->rightradius(); ?>px"<?php endif; ?>>
 <div class="ui segment"><?php endif; ?><div class="widget-title"><i class="fa fa-external-link"> 友情链接</i></div><ul></ul><?php if(empty($this->options->FriendLink)) :?> <center><div class="ui compact segment">
  <h2 class="ui header">
    <center><i class="bookmark outline icon"></i>
    <div class="sub header">暂无友情链接显示</div></center>
  </h2></div>
</center><?php else: ?> <?php echo BearSimpleFriendLinkBr($this->options->FriendLink )?><?php endif; ?></div><?php if($this->options->rightType !== "0"): ?></div></div><?php endif; ?>
  <?php endif; ?>

<?php if($this->options->AdControl == '1') :?>
<?php if($this->options->AdControl2 == '1') :?>
<!--右侧广告模块2-->
<div class="ui cards">
   <a class="gray card"  href="<?php $this->options->AdControl2Url() ?>">
    <div class="image">
      <img src="<?php if(empty($this->options->AdControl2Src)) :?>/usr/themes/bearsimple/assets/image/white-image.png<?php else: ?><?php $this->options->AdControl2Src() ?><?php endif; ?>">
    </div>
  </a>
  </div>
  <?php endif; ?>
  <?php endif; ?>

</div></div>



