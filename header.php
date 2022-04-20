<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php define('__TYPECHO_DEBUG__', false); 
if(empty($this->options->IframeProtect) || $this->options->IframeProtect !== '1'){
switch($this->options->IframeProtect){
    case '2':
    header('X-Frame-Options:SAMEORIGIN');
    break;
    case '3':
    header('X-Frame-Options:DENY');  
    break;
}
}
?>
<?php if($this->options->Compress == '1') :?>
<?php ob_start(); ?>
<?php endif; ?>
<?php if ($this->options->CCFirewalls == "2"): ?>
<?php include 'modules/cc-firewall.php'; ?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="zh-CN"<?php if ($this->options->Mournmode == "1"): ?> class="gray"<?php endif; ?>>
    <head>
        <meta name="referrer" content="always" />
        
<meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
 <?php if ($this->options->DNSYJX == "1"): ?>
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <?php if ($this->options->DNSADDRESS1): ?>
<link rel="dns-prefetch" href="<?php $this->options->DNSADDRESS1() ?>">
<?php endif; ?>
<?php if ($this->options->DNSADDRESS2): ?>
<link rel="dns-prefetch" href="<?php $this->options->DNSADDRESS2() ?>">
<?php endif; ?>
<?php if ($this->options->DNSADDRESS3): ?>
<link rel="dns-prefetch" href="<?php $this->options->DNSADDRESS3() ?>">
<?php endif; ?>
<?php endif; ?>
<?php if ($this->options->DNSYJX == "2"): ?>
<meta http-equiv="x-dns-prefetch-control" content="off">
<?php endif; ?>

 <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no, viewport-fit=cover" />
 <meta name="keywords" content="<?php $this->options->keywords(); ?>">
 <meta name="description" content="<?php $this->options->description(); ?>">
 <?php if(!empty($this->options->favicon)): ?>
 <link rel="shortcut icon" href="<?php $this->options->favicon() ?>" />
 <?php endif; ?>
 <?php $this->options->CustomizationCode() ?>
 <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类「%s」下的文章'),
            'search'    =>  _t('包含关键字「%s」的文章'),
            'tag'       =>  _t('标签「%s」下的文章'),
            'author'    =>  _t('「%s」发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>

<script src="//cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
<link  href="//cdn.staticfile.org/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php AssetsDir();?>assets/css/bearsimple.min.css?v=<?php echo themeVersion(); ?>">
<link href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script  src="//cdn.staticfile.org/toastr.js/2.1.4/toastr.min.js"></script>
<script  src="//cdn.staticfile.org/clipboard.js/2.0.8/clipboard.min.js"></script>
<link href="//at.alicdn.com/t/font_1551254_rxrrzgz2kjc.css" rel="stylesheet" type="text/css" />
<?php bs_style(); ?>
<?php $this->header(); ?>
  <?php if ($this->options->Translate == "11"): ?>
  <script type="text/javascript" src="<?php AssetsDir();?>assets/js/translate.js"></script>
  <?php endif; ?>
 </head>
 <body id="translatethis"  class="translatethis" <?php if($this->options->CopyProtect == '1') :?>oncontextmenu='return false' ondragstart='return false' onselectstart ='return false' onselect='document.selection.empty()' oncopy='document.selection.empty()' onbeforecopy='return false'<?php endif; ?>>
     <?php if($this->options->Read_Process == '1') :?>
<progress id="read_progress" value="0"></progress>
<?php endif; ?>
<div id="nopjax">
     <div id="pjax">
            <?php if($this->options->Pjax == '1') :?>
         <?php $this->header('commentReply=1&description=0&keywords=0&generator=0&template=0&pingback=0&xmlrpc=0&wlw=0&rss2=0&rss1=0&antiSpam=0&atom'); ?>
     <?php endif; ?>
     <div class="body_container" id="body_container">
         <div id="header">
             <div class="site-name">
<?php if(!empty($this->options->Search[0]) && @in_array('header',$this->options->Search)) :?>   
        <form name="pcsearch" role="search" method="get" id="searchform1">
 <div style="float:right;display:inline;<?php if($this->options->webdec_hidden !== '1' && $this->options->Translate !== "1" && $this->options->Translate !== "11") :?>margin-top:-20px<?php endif; ?>"><div class="ui search"><div class="ui large icon input pc">
      <input class="prompt" id="pcsearch" type="text" name="s" placeholder="输入关键词进行搜索">
      <i hrefx="?s=" class="search link icon"></i>
</div></div></div>
</form> 
<?php endif; ?>
                 <?php if(!empty($this->options->logo)) :?>
    <a id="logo" href="<?php $this->options->siteUrl(); ?>"><img width="250" height="70" src="<?php $this->options->logo() ?>"></a>
        	    <p class="description"></p>
        	    <?php else :?>
        	     <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?>	     </a>

        	     <?php if($this->options->webdec_hidden == '1') :?>
        	    <p class="description"><?php $this->options->description() ?></p>
        	     <?php endif; ?>
        	     
      <?php endif; ?>

        	    <?php if ($this->options->Translate == "1"): ?><p><a id="translateLink" class="ui mini button">繁体</a></p><?php endif; ?>
        	     <?php if ($this->options->Translate == "11"): ?><p><?php $this->need('modules/translate.php'); ?></p><?php endif; ?>



        	    </div>
        	    <?php if(!empty($this->options->Search[0]) && @in_array('phone',$this->options->Search)) :?> 
<form name="phonesearch" role="search" method="get" id="searchformbyphone">
 <div style="text-align:center">
<div class="ui search">
<div class="ui icon input phone">
      <input class="prompt" id="phonesearch" type="text" name="s" placeholder="输入关键词进行搜索">
      <i hrefx="?s=" class="search link icon"></i>
</div>
</div></div>
</form>
<?php endif; ?>


  

<?php if($this->options->menu_style == "2"): ?>
<input id="main-menu-state" type="checkbox" />
<center>
<div style="margin-top:15px">
<label class="main-menu-btn" for="main-menu-state">
  <span class="main-menu-btn-icon"></span>
</label>
</div>
</center>

      <ul id="main-menu" class="sm sm-clean">
        <li><a href="<?php $this->options->siteUrl(); ?>"<?php if($this->is('index')): ?> class="current"<?php endif; ?>>首页</a></li>
        <li><a <?php if($this->is('category')): ?> class="current"<?php endif; ?>>分类</a>
          <ul>
              <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
<?php while($categorys->next()): ?>
<?php if ($categorys->levels === 0): ?>
<?php $children = $categorys->getAllChildren($categorys->mid); ?>
<?php if (empty($children)) { ?>
            <li><a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>" <?php if($this->is('category',$categorys->slug)): ?> class="current"<?php endif; ?>> <?php $categorys->name(); ?></a></li>
<?php }  else { ?>
            <li><a href="<?php $categorys->permalink(); ?>" <?php if($this->is('category',$categorys->slug)): ?> class="current"<?php endif; ?>><?php $categorys->name(); ?></a>
              <ul>
                  <?php foreach ($children as $mid) { ?>
<?php $child = $categorys->getCategory($mid); ?>
                <li><a href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>" <?php if($this->is('category',$child['slug'])): ?> class="current"<?php endif; ?>><?php echo $child['name']; ?></a></li>
                <?php } ?>
              </ul>
          
            </li>
                <?php } ?>
                <?php endif; ?><?php endwhile; ?>
          </ul>
        </li>
<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
<?php if($pages->have()): ?>
<?php if(empty($this->options->PageMenu) || $this->options->PageMenu == "1"): ?>
        <li><a<?php if($this->is('page')): ?> class="current"<?php endif; ?>>页面</a>
          <ul>
                    <?php while($pages->next()): ?>
            <li><a href="<?php $pages->permalink(); ?>" <?php if($this->is('page',$pages->slug)): ?> class="current"<?php endif; ?> title="<?php $pages->name(); ?>"><?php $pages->title(); ?></a></li>
            <?php endwhile; ?>
            </ul>
        </li>
        <?php else : ?>
                    <?php while($pages->next()): ?>
            <li><a href="<?php $pages->permalink(); ?>"<?php if($this->is('page',$pages->slug)): ?> class="current"<?php endif; ?> title="<?php $pages->name(); ?>"><?php $pages->title(); ?></a></li>
         <?php endwhile; ?>
         <?php endif; ?>
<?php endif; ?>

         <?php foreach (getMenu() as $MenuLinks): ?>
        <li><a href="<?php echo $MenuLinks[0]; ?>" title="<?php echo $MenuLinks[1]; ?>"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>><?php echo $MenuLinks[1]; ?> </a></li>
        <?php endforeach; ?>
        <?php if($this->options->Login_hidden == "2"): ?>
<?php if(!$this->user->hasLogin()):?>
  <li><a id="bs-login">登录</a></li>
  <?php else: ?>
<li><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入管理中心'); ?></a></li>
<?php endif; ?>
<?php endif; ?>
      </ul>
</div>
<?php else: ?>
 <div id="nav-menu">

        <a<?php if($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
   <a>
  <div class="ui dropdown">
  分类 <i class="dropdown icon"></i>
  <div class="menu">
   
   <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
<?php while($categorys->next()): ?>
<?php if ($categorys->levels === 0): ?>
<?php $children = $categorys->getAllChildren($categorys->mid); ?>
<?php if (empty($children)) { ?>

<div class="item" hrefs="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?>  </div>

<?php }  else { ?>
<div class="item">
        <i class="dropdown icon"></i>
        <div class="text" hrefs="<?php $categorys->permalink(); ?>"><?php $categorys->name(); ?></div>
        <div class="menu">
<?php foreach ($children as $mid) { ?>
<?php $child = $categorys->getCategory($mid); ?>
<div class="item" hrefs="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?> 
</div>
<?php } ?></div></div><?php } ?>
<?php endif; ?><?php endwhile; ?>


  </div>
</div></a>
<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
<?php if($pages->have()): ?>
<?php if(empty($this->options->PageMenu) || $this->options->PageMenu == "1"): ?>
<a>
<div class="ui dropdown">
  页面 <i class="dropdown icon"></i>
  <div class="menu">

              
                    <?php while($pages->next()): ?>
                    <div class="item" hrefs="<?php $pages->permalink(); ?>" title="<?php $pages->name(); ?>"><?php $pages->title(); ?>  </div>
                  
                    <?php endwhile; ?>

</div>
</div></a>

<?php else : ?>
<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
<a <?php if($this->is('page',$pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->name(); ?>"><?php $pages->title(); ?> 
</a>
<?php endwhile; ?>
<?php endif; ?>
<?php endif; ?>

<?php foreach (getMenu() as $MenuLinks): ?>
<a href="<?php echo $MenuLinks[0]; ?>" title="<?php echo $MenuLinks[1]; ?>"<?php echo parselink($MenuLinks[0]); ?>><?php echo $MenuLinks[1]; ?> 
</a>
<?php endforeach; ?>
<?php if($this->options->Login_hidden == "2"): ?>
<?php if(!$this->user->hasLogin()):?>
<a id="bs-login"><?php _e('登录'); ?></a>
<?php else: ?>
<a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入管理中心'); ?></a>
<?php endif; ?>
<?php endif; ?>
  </div>
        </div>
        <?php endif; ?>
<?php if($this->options->Login_hidden == "2"): ?>       
<div class="ui mini modal login">
  <div class="header">
    登录
  </div>
  <div class="content">
<form id="loginform" class="ui form" action="<?php $this->options->loginAction(); ?>"  method="post" name="login" role="form" target="_blank">
  <div class="ui fluid labeled input">
  <div class="ui label">
    账号
  </div>
  <input type="text" id="name" name="name" value="" placeholder="请输入您的登录账号" autofocus>
</div><br>
<div class="ui fluid labeled input">
  <div class="ui label">
    密码
  </div>
  <input type="password" id="password" name="password" placeholder="请输入您的登录密码">
  <input type="hidden" name="referer" value="<?php $this->options->adminUrl(); ?>" />
</div>
</div>
  <div class="actions">
<button id="loginbtn" type="submit" class="ui button">提交</button>

  </div>
  </form>
</div>
<?php endif; ?>
<div class="sticky">