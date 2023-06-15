<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php
$seo_description = '';
 if($this->fields->excerpt != ''){
            $seo_description = $this->fields->excerpt;
    }else{
        $seo_description = Helper::options()->description;
    }
if(empty(Bsoptions('IframeProtect')) || Bsoptions('IframeProtect') !== '1'){
switch(Bsoptions('IframeProtect')){
    case '2':
    header('X-Frame-Options:SAMEORIGIN');
    break;
    case '3':
    header('X-Frame-Options:DENY');  
    break;
}
}
?>
<?php if(Bsoptions('Compress') == true) :?>
<?php ob_start(); ?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="zh-CN" data-theme="light"<?php if (Bsoptions('Mournmode') == true): ?> class="gray"<?php endif; ?>>
    <head>
    <meta name="referrer" content="always" />
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <?php if(is_https()):?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php endif; ?>
    <meta name="renderer" content="webkit">
 <?php if (Bsoptions('DNSYJX') == true): ?>
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <?php foreach(Bsoptions('DNSYJX_AR') as $dnsyjx): ?>
    <?php if($dnsyjx['DNSADDRESS_Preconnect'] == true):?>
    <link rel="preconnect" href="<?php echo $dnsyjx['DNSADDRESS'] ?>" <?php if($dnsyjx['DNSADDRESS_Crossorign'] == true):?>crossorign<?php endif; ?>>
    <?php endif; ?>
<link rel="dns-prefetch" href="<?php echo $dnsyjx['DNSADDRESS'] ?>">
    <?php endforeach; ?>
<?php endif; ?>
<?php if (Bsoptions('DNSYJX') == '' || Bsoptions('DNSYJX') == false): ?>
<meta http-equiv="x-dns-prefetch-control" content="off">
<?php endif; ?>
 <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no, viewport-fit=cover" />
 <?php if(!empty(Bsoptions('favicon'))): ?>
 <link rel="shortcut icon" href="<?php echo Bsoptions('favicon') ?>" />
 <?php endif; ?>

 <title><?php getTitle($this); ?></title>
        <meta name="author" content="<?php $this->author(); ?>" />
    <meta name="description" content="<?php if($seo_description !== '') echo $seo_description; else getDescription($this); ?>" />
    <meta property="og:title" content="<?php getTitle($this); ?>" />
    <meta property="og:description" content="<?php if($seo_description !== '') echo $seo_description; else getDescription($this);  ?>" />
    <meta property="og:site_name" content="<?php $this->options->title(); ?>" />
    <meta property="og:type" content="<?php if($this->is('post') || $this->is('page')) echo 'article'; else echo 'website'; ?>" />
    <meta property="og:url" content="<?php $this->permalink(); ?>" />
    <meta property="article:published_time" content="<?php echo date('c', $this->created); ?>" />
    <meta property="article:modified_time" content="<?php echo date('c', $this->modified); ?>" />
    <?php $this->header('commentReply=1&description=&pingback=0&xmlrpc=0&wlw=0&generator=&template=&atom='); ?>
<script src="//lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/1.12.4/jquery.min.js" type="application/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php AssetsDir();?>assets/css/bearsimple.min.css?v=<?php echo themeVersion(); ?>">
<link href="//cdn.staticfile.org/fomantic-ui/2.9.2/semantic.min.css" rel="stylesheet">
<link rel="stylesheet" href="//lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.4/css/all.min.css?ver=5.15.4">
<link rel="stylesheet" href="//lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.4/css/v4-shims.min.css?ver=5.15.4">
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://npm.elemecdn.com/lxgw-wenkai-screen-webfont/style.css" media="print" onload="this.media='all'">
<script  src="//cdn.staticfile.org/toastr.js/2.1.4/toastr.min.js"></script>
<?php bs_style(); ?>
<?php echo Bsoptions('CustomizationCode'); ?>
<?php if(Bsoptions('Popup') == true) :?>
<link href="<?php AssetsDir();?>assets/vendors/bs-announcement/bs-announcement.css" rel="stylesheet" type="text/css">
<?php endif; ?>
<?php if(Bsoptions('Slidersss') == true) :?>
<link href="<?php AssetsDir();?>assets/vendors/slider/bearslider.min.css" rel="stylesheet" type="text/css">
<?php endif; ?>
<link href="<?php AssetsDir2();?>assets/vendors/bs-toc/bs-toc.min.css" rel="stylesheet" type="text/css">

  <?php if (Bsoptions('Translate') == "11"): ?>
  <script type="text/javascript" src="<?php AssetsDir();?>assets/js/translate.js"></script>
  <?php endif; ?>
<link href="//lf6-cdn-tos.bytecdntp.com/cdn/expire-0-ms/limonte-sweetalert2/11.4.4/sweetalert2.min.css" type="text/css" rel="stylesheet" />

<?php if (Bsoptions('Poster') == true): ?>
<link href="<?php AssetsDir();?>assets/vendors/bs-poster/bearui/assets/bearui.css" rel="stylesheet" />
<link href="<?php AssetsDir();?>assets/vendors/bs-poster/bposter.css" rel='stylesheet' />
<?php endif; ?>
<link rel="stylesheet" href="<?php AssetsDir();?>assets/vendors/bs-audio/audio.css">
<?php if(Bsoptions('more_posts') == true): ?>
<link rel="stylesheet" href="<?php AssetsDir();?>assets/css/modules/carousel/carousel.min.css">
<?php endif; ?>
<!--数学公式判断-->
<script>
<?php if(Bsoptions('MathJax') == true):?>
    window.Mathjax = "open";
    <?php else:?>
    window.Mathjax = "close";
    <?php endif; ?>
    <?php if(Bsoptions('Cache') == true && (Bsoptions('Cache_choose') == 'memcached' || Bsoptions('Cache_choose') == 'redis') && Bsoptions('enable_gcache') == true):?>
    window.GlobalCache = "on";
    <?php endif; ?>
    window.Defaultfont = "<?php echo Bsoptions('articleFontDefault') ?>";
</script>
 </head>
 <body id="translatethis"  class="translatethis" <?php if(Bsoptions('CopyProtect') == true) :?>oncontextmenu='return false' ondragstart='return false' onselectstart ='return false' onselect='document.selection.empty()' oncopy='document.selection.empty()' onbeforecopy='return false'<?php endif; ?>  >
     <?php if(Bsoptions('Read_Process') == true) :?>
<div class="read_progress">
    <div class="read_progress_inner"></div>
</div>

<?php endif; ?>

<div id="nopjax">
     <div id="pjax">
<?php if(Bsoptions('Pjax') == true) :?>
<?php $this->header('commentReply=1&description=0&keywords=0&generator=0&template=0&pingback=0&xmlrpc=0&wlw=0&rss2=0&rss1=0&antiSpam=0&atom'); ?>
     <?php endif; ?>
     <div class="body_container" id="body_container">
         
         <div id="header">
             <div class="site-name">
<?php if(!empty(Bsoptions('Search')[0]) && @in_array('header',Bsoptions('Search'))) :?>   
        <form name="pcsearch" role="search" method="get" id="searchform1">
 <div class="bearmargin" style="float:right;"><div class="ui search"><div class="ui large icon input pc">
      <input class="prompt" id="pcsearch" type="text" name="s" placeholder="输入关键词进行搜索">
      <i hrefx="?s=" class="search link icon"></i>
</div></div></div>
</form> 
<?php endif; ?>
                 <?php if(Bsoptions('header_choose') == 'image') :?>
    <a id="logo" href="<?php $this->options->siteUrl(); ?>"><img width="250" height="70" src="<?php echo Bsoptions('imagelogo') ?>"></a>
        	    <p class="description"></p>
        	    <?php else :?>
        	     <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php echo Bsoptions('textlogo_text') ?>	     </a>
        	     <?php if(!empty(Bsoptions('textlogo_dec'))) :?>
        	    <p class="description"><?php echo Bsoptions('textlogo_dec'); ?></p>
        	     <?php endif; ?>
        	     
      <?php endif; ?>
        
        	     
        	    </div>
        	    <?php if(!empty(Bsoptions('Search')[0]) && @in_array('phone',Bsoptions('Search'))) :?> 
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

<?php if(Bsoptions('menu_style') == "2" || Bsoptions('menu_style') == "1" || Bsoptions('menu_style') == ""): ?>
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
        <?php if(Bsoptions('CategoryMenu') == null || Bsoptions('CategoryMenu') == true): ?>
        <li class="bnm"><a <?php if($this->is('category')): ?> class="current"<?php endif; ?>>分类</a>
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
        <?php endif; ?>
<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
<?php if($pages->have()): ?>
<?php if(Bsoptions('PageMenu') == null || Bsoptions('PageMenu') == "1"): ?>
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
        <li><a href="<?php echo $MenuLinks[0]; ?>" title="<?php echo $MenuLinks[1]; ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><?php echo $MenuLinks[1]; ?> </a></li>
        <?php endforeach; ?>
        
<?php if(Bsoptions('Login_hidden') == true): ?>
<li id="bs-login" style="display:none"><a><?php _e('登录'); ?></a></li>
<li id="bs-islogin" style="display:none"><a href="<?php $this->options->adminUrl(); ?>" pjax="no"><?php _e('进入管理中心'); ?></a></li>
<li id="bs-islogin2" style="display:none"></li>
<?php endif; ?>

      </ul>
</div>

        <?php endif; ?>

<div class="sticky" id="sticky">