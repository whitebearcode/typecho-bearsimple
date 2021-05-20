<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php if ($this->options->CCFirewall == "1"): ?>
<?php include 'modules/cc-firewall.php'; ?>
<?php endif; ?>
<!DOCTYPE html>
<?php if ($this->options->Mournmode == "1"): ?>
<html lang="zh-CN" class="gray">
    <?php endif; ?>
    <head>
        <meta name="referrer" content="always">
 <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
 
 <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
 <meta name="keywords" content="<?php $this->options->keywords(); ?>">
 <meta name="description" content="<?php $this->options->description(); ?>">
 <?php $this->options->CustomizationCode() ?>
 <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类[ %s ]下的文章'),
            'search'    =>  _t('包含关键字[ %s ]的文章'),
            'tag'       =>  _t('标签[ %s ]下的文章'),
            'author'    =>  _t('[ %s ]发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
 <script src="/usr/themes/bearsimple/assets/js/jquery.min.js"></script>
<link href="https://cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">

 <link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/css/style.css">

<?php if($this->options->Lightbox == '1') :?>
<link rel="stylesheet" href="/usr/themes/bearsimple/assets/css/lightbox.min.css">
<?php endif; ?>

<link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/css/normalize.min.css">
<link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/css/pure-min.min.css">
<link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/css/grids-responsive-min.css">
<link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<script src="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdn.bootcdn.net/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<link href="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

<link href="/usr/themes/bearsimple/assets/css/nprogress.min.css" rel="stylesheet">

<?php if($this->options->Top == '1') :?>
<link href="/usr/themes/bearsimple/assets/css/top.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/usr/themes/bearsimple/assets/js/top.js"></script>
<?php endif; ?>
<?php if ($this->options->Mournmode == "1"): ?>
<style>

.gray {
  filter: grayscale(1);
}

.gray {
  -webkit-filter: grayscale(1); /* Old Chrome、Old Safari、Old Opera*/
  filter: grayscale(1); /* 现代浏览器标准 */
  filter: progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); /* IE */
}
</style>
<?php endif; ?>
<?php $this->header(); ?>
 </head>
 <body <?php if($this->options->CopyProtect == '1') :?>oncontextmenu='return false' ondragstart='return false' onselectstart ='return false' onselect='document.selection.empty()' oncopy='document.selection.empty()' onbeforecopy='return false'<?php endif; ?>>
     
     <?php if($this->options->Pjax == '1') :?>
     <div id="pjax">
         <?php endif; ?>
         
     <div class="body_container">
         <div id="header">
             <div class="site-name">
    <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
  
        	    <p class="description"><?php $this->options->description() ?></p>
        	    <?php if ($this->options->Translate == "1"): ?><a id="translateLink" class="ui mini button">繁体</a><?php endif; ?></div>
   
    <div id="nav-menu"><a<?php if($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
   <a>
  <div class="ui dropdown">
  分类 <i class="dropdown icon"></i>
  <div class="menu">
   
<?php $this->widget('Widget_Metas_Category_List')
                        ->parse('<div class="item" href="{permalink}">{name}</div>'); ?>
  </div>
</div></a>

                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                    <a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                    <?php endwhile; ?>
        </div></div>

