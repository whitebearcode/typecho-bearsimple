<?php
    /**
    * 我的书架
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="bearsimple-images"></div>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
               <?php if($this->options->Diy == "1"): ?><div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="book icon"></i> 我的书架</h2>
  <?php if(!empty($this->options->douban_note)): ?>                  
                    <div class="center">
<h2 class="ui header" style="text-align:center">
  温馨提示
  <div class="sub header" style="text-align:center"><?php $this->options->douban_note();?></div>
</h2>
</div>
<?php endif; ?>
<div class="ui secondary pointing menu">
    <?php if(getBookTag()[0]):?>
  <a class="item active" data-tab="first"><?php echo getBookTag()[0]; ?></a>
  <?php endif; ?>
  <?php if(getBookTag()[1]):?>
  <a class="item" data-tab="second"><?php echo getBookTag()[1]; ?></a>
    <?php endif; ?>
  <?php if(getBookTag()[2]):?>
  <a class="item" data-tab="third"><?php echo getBookTag()[2]; ?></a>
  <?php endif; ?>
</div>
<?php if(getBookTag()[0] && $this->options->douban_book1):?>
<div class="ui bottom attached tab active" data-tab="first">
    <div class="ui three doubling cards">
        <?php foreach(getDoubanId($this->options->douban_book1) as $id):?>
      <?php $Getdata = douban_getdata($id); ?>
    <div class="ui fluid card">
        <div class="blurring dimmable image">
      <div class="ui dimmer">
        <div class="content">
          <div class="center">
            <a class="ui inverted button" href="<?php echo $Getdata['url']; ?>">我也要看</a>
          </div>
        </div>
      </div>
      <img class="lazyload" data-src="<?php echo $Getdata['cover']; ?>" referrerPolicy="no-referrer">
    </div>
      <div class="content" style="text-align:center;">
        <a class="header" href="<?php echo $Getdata['url']; ?>">《<?php echo $Getdata['bookname']; ?>》</a>
        <div class="meta">
      <a>作者：<?php echo $Getdata['author']; ?></a>
    </div>
      </div>
  </div>
  <?php endforeach; ?>
</div>
</div>
  <?php endif; ?>
  <?php if(getBookTag()[1] && $this->options->douban_book2):?>
<div class="ui tab" data-tab="second">
  <div class="ui three doubling cards">
        <?php foreach(getDoubanId($this->options->douban_book2) as $id):?>
      <?php $Getdata = douban_getdata($id); ?>
    <div class="ui fluid card">
        <div class="blurring dimmable image">
      <div class="ui dimmer">
        <div class="content">
          <div class="center">
            <a class="ui inverted button" href="<?php echo $Getdata['url']; ?>">我也要看</a>
          </div>
        </div>
      </div>
      <img class="lazyload" data-src="<?php echo $Getdata['cover']; ?>" referrerPolicy="no-referrer">
    </div>
      <div class="content" style="text-align:center;">
        <a class="header" href="<?php echo $Getdata['url']; ?>">《<?php echo $Getdata['bookname']; ?>》</a>
        <div class="meta">
      <a>作者：<?php echo $Getdata['author']; ?></a>
    </div>
      </div>
  </div>
  <?php endforeach; ?>
</div>
</div>
 <?php endif; ?>
  <?php if(getBookTag()[2] && $this->options->douban_book3):?>
<div class="ui tab" data-tab="third">
  <div class="ui three doubling cards">
        <?php foreach(getDoubanId($this->options->douban_book3) as $id):?>
      <?php $Getdata = douban_getdata($id); ?>
    <div class="ui fluid card">
        <div class="blurring dimmable image">
      <div class="ui dimmer">
        <div class="content">
          <div class="center">
            <a class="ui inverted button" href="<?php echo $Getdata['url']; ?>">我也要看</a>
          </div>
        </div>
      </div>
      <img class="lazyload" data-src="<?php echo $Getdata['cover']; ?>" referrerPolicy="no-referrer">
    </div>
      <div class="content" style="text-align:center;">
        <a class="header" href="<?php echo $Getdata['url']; ?>">《<?php echo $Getdata['bookname']; ?>》</a>
        <div class="meta">
      <a>作者：<?php echo $Getdata['author']; ?></a>
    </div>
      </div>
  </div>
  <?php endforeach; ?>
</div>
</div>
<?php endif; ?>
</div></div>

<?php if($this->options->Diy == "1"): ?></div><?php endif; ?>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>