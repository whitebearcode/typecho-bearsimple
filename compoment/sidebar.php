<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if(Bsoptions('Scroll') == true && Bsoptions('Scroll_Sidebar') == true): ?>
<link href="<?php AssetsDir();?>assets/vendors/menutree/menutree.min.css" rel="stylesheet" />
<?php endif; ?>
<?php if(Bsoptions('Diy') == true) :?>

<?php $this->need('pages/diy-sidebar.php'); ?>

  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>

<?php $this->need('pages/sidebar.php'); ?>

  <?php endif; ?>
  <?php if(Bsoptions('Scroll') == true && Bsoptions('Scroll_Sidebar') == true): ?>
  <script src="<?php AssetsDir();?>assets/vendors/menutree/menutree.min.js"></script>
<script>
       (function(){
           if(!$('.bmenutree').length){
               $('.bsmenutree').hide();
           }
    const defaults = Menutree.DEFAULTS
    let menutree
    defaults.title =  false, 
    defaults.selector = "h1,h2,h3,h4,h5,h6",
    defaults.scrollElement = 'html,body',
    defaults.position = "sticky",
    defaults.showCode = false,
    defaults.stickyHeight = 86,
    defaults.hasToolbar = false,
    defaults.parentElement = "#menutree",
    defaults.articleElement = ".post-content",
    menutree = new Menutree(Menutree.DEFAULTS)
  })();
       
  </script>
  <?php endif; ?>