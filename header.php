<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if($this->options->Compress == '1') :?>
<?php ob_start(); ?>
<?php endif; ?>
<?php if ($this->options->CCFirewall == "1"): ?>
<?php include 'modules/cc-firewall.php'; ?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="zh-CN"<?php if ($this->options->Mournmode == "1"): ?> class="gray"<?php endif; ?>>
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

 <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no, viewport-fit=cover" />
 <meta name="keywords" content="<?php $this->options->keywords(); ?>">
 <meta name="description" content="<?php $this->options->description(); ?>">
 <?php if(!empty($this->options->favicon)): ?>
 <link rel="shortcut icon" href="<?php $this->options->favicon() ?>" />
 <?php endif; ?>
 <?php $this->options->CustomizationCode() ?>
 <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类[ %s ]下的文章'),
            'search'    =>  _t('包含关键字[ %s ]的文章'),
            'tag'       =>  _t('标签[ %s ]下的文章'),
            'author'    =>  _t('[ %s ]发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
<style>

    .body_container{
     background-color:rgba(255,255,255,0.9);   
     border-radius:5px;
     <?php if($this->options->global_transparent == '1') :?>
     opacity: .9;
     transition: opacity .5s;
     <?php endif; ?>
      <?php if($this->options->global_shadow == '1') :?>
     box-shadow: 0 0 20px 6px rgba(0,0,0,.12),0 0 20px 6px rgba(0,0,0,.12)
    }
    <?php endif; ?>
</style>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.bootcdn.net/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
<link href="https://cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php AssetsDir();?>assets/css/style.css">
<style>
html,body{
    height:100vh;
}

</style>
<?php if($this->options->Lightbox == '1') :?>
<link href="https://cdn.bootcdn.net/ajax/libs/viewerjs/1.10.1/viewer.min.css" rel="stylesheet">
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php AssetsDir();?>assets/css/normalize.min.css">
<link rel="stylesheet" type="text/css" href="<?php AssetsDir();?>assets/css/pure-min.min.css">
<link rel="stylesheet" type="text/css" href="<?php AssetsDir();?>assets/css/grids-responsive-min.css">
<link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<link href="<?php AssetsDir();?>assets/css/nprogress.min.css" rel="stylesheet">
<?php if ($this->options->Mournmode == "1"): ?>
<style>
.gray {
  filter: grayscale(1);
}
.gray {
  -webkit-filter: grayscale(1);
  filter: grayscale(1);
  filter: progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);
}
</style>
<?php endif; ?>
<?php if(!empty($this->options->picradius)): ?>
<style>
    img{
 border-radius:<?php $this->options->picradius() ?>px;   
}
</style>
<?php endif; ?>
<link rel="stylesheet" href="<?php AssetsDir();?>assets/css/style-pic.css">
<?php if($this->options->Slidersss == '1' && $this->options->SliderIndexs == '1' || $this->options->SliderOthers == '1') :?>
<link href="<?php AssetsDir();?>assets/slider/css/swiper.min.css" rel="stylesheet" >
<style>
.swiper-container{
    height:220px;
    width:auto;
    border-radius:10px;
}
.swiper-slide{
    width:100%;
    height:100%;
    background-color: #f5f5f5;
    border-radius:10px;
}
}
</style>
<?php endif; ?>
<?php if($this->options->Top == '1') :?>
<style type="text/css">
        .goTop >img{
            width: 50px;
            height: 50px;
            cursor: pointer;
        }
        .goTop{
            position: fixed;
            right : 20px;
            bottom : 20px;
        }
    </style>
    <?php endif; ?>
<link href="https://at.alicdn.com/t/font_1551254_rxrrzgz2kjc.css" rel="stylesheet" type="text/css" />
<?php if($this->options->Scroll == '1'): ?>
<link href="<?php AssetsDir();?>assets/scroll/scroll.min.css" rel="stylesheet" >
<?php endif; ?>
<?php $this->header(); ?>
  <style>
        <?php if(!empty($this->options->BackGround)): ?>
        body{
            background-image: url('<?php $this->options->BackGround(); ?>')!important;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment:fixed;
            
background-size:100% 100%;
            -webkit-background-size: cover;
            -o-background-size: cover;
        }
        <?php endif; ?>
        <?php if(!empty($this->options->Diyfont)): ?>
@font-face {
          font-family: CustomFont;
          src: url(<?php $this->options->Diyfont(); ?>);
        }
        body ,p, a, h1, h2, h3, h4, h5, h6,textarea,div,span,input,.ui{
          font-family: CustomFont !important;
        }
<?php endif; ?>
<?php if(!empty($this->options->Diyfontsize)): ?>
 body,.ui,div{
font-size:<?php $this->options->Diyfontsize(); ?>px !important;
}
<?php endif; ?>

.break{
      word-break:break-all;
  }
  li{
	word-wrap: break-all;
  }
.post .post-content pre code{
padding: 0 3em;
overflow-x:auto;
width:100%
}
        pre{
            max-height: auto;
            padding: 0;
            margin: 0;
        }
        pre code {
            display:block;
            overflow-x:auto;
            position:relative;
            margin:0;
            padding-left:50px;
            
        }
        pre code {
            position:relative;
            display:block;
            overflow-x:auto;
            margin:4.4px 0.px .4px 1px;
            padding:0;
            max-height:500px;
            padding-left:3.5em
        }
        .line-numbers .line-numbers-rows {
            position: absolute;
            pointer-events: none;
            top: 0;
        }
        
        .post .post-content pre code {
            padding: 0 3em;
        }
        pre.line-numbers{
            padding-left: 0;
            padding-bottom: 0;
        }
        pre[class*="language-"]{
            padding: 0;
        }
        
        .qrcode{
          display: block;
      }
.ui.icon.input.phone{
    display: none;
  }
 .ui.large.icon.input.pc{
    display: inline;
  }
@media (max-width: 767px) {
  .ui.icon.input.phone{
    display: inline;
  }
 .ui.large.icon.input.pc{
    display: none;
  }
}

<?php if($this->options->hcsticky == "1"): ?>
.sidebar {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
}

.sticky:before,
.sticky:after {
    content: '';
    display: table;
}
<?php endif; ?>
 

</style>

  <?php if ($this->options->Translate == "11"): ?>
  <script type="text/javascript" src="<?php AssetsDir();?>assets/js/translate.js"></script>
  <?php endif; ?>
 </head>
 <body id="translatethis"  class="translatethis" <?php if($this->options->CopyProtect == '1') :?>oncontextmenu='return false' ondragstart='return false' onselectstart ='return false' onselect='document.selection.empty()' oncopy='document.selection.empty()' onbeforecopy='return false'<?php endif; ?>>


     <?php if($this->options->Pjax == '1') :?>
     <div id="pjax">
         <?php $this->header('commentReply=1&description=0&keywords=0&generator=0&template=0&pingback=0&xmlrpc=0&wlw=0&rss2=0&rss1=0&antiSpam=0&atom'); ?>
     <?php endif; ?>
     <div class="body_container">

         <div id="header">

     <?php if(in_array('header',$this->options->Search)) :?>   
        <form name="pcsearch" role="search" method="get">
 <div style="float:right;margin-top:-0.7em"><div class="ui large icon input pc">
      <input type="text" name="s" placeholder="输入关键词后按回车键">
      <i  onclick="javascript:pcsearch.submit();"  class="search link icon"></i>
</div></div>
</form> 
<?php endif; ?>
             <div class="site-name">
                 <?php if(!empty($this->options->logo)) :?>
    <a id="logo" href="<?php $this->options->siteUrl(); ?>"><img src="<?php $this->options->logo() ?>"></a>
        	    <p class="description"></p>
        	    <?php else :?>
        	     <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
        	     <?php if($this->options->webdec_hidden == '1') :?>
        	    <p class="description"><?php $this->options->description() ?></p>
        	     <?php endif; ?>
      <?php endif; ?>
        	    <?php if ($this->options->Translate == "1"): ?><p><a id="translateLink" class="ui mini button">繁体</a></p><?php endif; ?>
        	     <?php if ($this->options->Translate == "11"): ?><p><?php $this->need('modules/translate.php'); ?></p><?php endif; ?>

        	    </div>
        	    <?php if(in_array('phone',$this->options->Search)) :?> 
<form name="phonesearch" role="search" method="get">
 <div style="text-align:center"><div class="ui icon input phone">
      <input type="text" name="s" placeholder="输入关键词后按回车键">
      <i onclick="javascript:phonesearch.submit();" class="search link icon"></i>
</div></div>
</form>
<?php endif; ?>

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

<div class="item" href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?>  </div>

<?php }  else { ?>
<div class="item">
        <i class="dropdown icon"></i>
        <span class="text" href="<?php $categorys->permalink(); ?>"><?php $categorys->name(); ?></span>
        <div class="menu">
<?php foreach ($children as $mid) { ?>
<?php $child = $categorys->getCategory($mid); ?>
<div class="item" href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?> 
</div>
<?php } ?></div></div><?php } ?>
<?php endif; ?><?php endwhile; ?>


  </div>
</div></a>
<?php if(empty($this->options->PageMenu) || $this->options->PageMenu == "1"): ?>
<a>
<div class="ui dropdown">
  页面 <i class="dropdown icon"></i>
  <div class="menu">

                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                    <div class="item" href="<?php $pages->permalink(); ?>" title="<?php $pages->name(); ?>"><?php $pages->title(); ?>  </div>
                  
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

<?php foreach (getMenu() as $MenuLinks): ?>
<a href="<?php echo $MenuLinks[0]; ?>" title="<?php echo $MenuLinks[1]; ?>"><?php echo $MenuLinks[1]; ?> 
</a>
<?php endforeach; ?>

  </div>
        </div>
       
<div class="sticky">