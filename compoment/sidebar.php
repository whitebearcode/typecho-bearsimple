<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if(Bsoptions('Scroll') == true && Bsoptions('Scroll_Sidebar') == true): ?>
<link href="<?php AssetsDir();?>assets/vendors/menutree/menutree.min.css?v=4" rel="stylesheet" />
<?php endif; ?>
<?php if(Bsoptions('Diy') == true) :?>

<?php $this->need('pages/diy-sidebar.php'); ?>

  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>

<?php $this->need('pages/sidebar.php'); ?>

  <?php endif; ?>
  <?php if(Bsoptions('Scroll') == true && Bsoptions('Scroll_Sidebar') == true && $this->is('single')): ?>
  <script src="<?php AssetsDir();?>assets/vendors/menutree/menutree.min.js?v=5"></script>
<script>
       (function(){
           if($('.post-content').length && $('.post-content').has('h1,h2,h3,h4,h5,h6').length){
               $('.bsmenutree').show();
    const defaults = Menutree.DEFAULTS;
    let menutree;
    defaults.title =  false, 
    defaults.selector = "h1,h2,h3,h4,h5,h6",
    defaults.position = "sticky",
    defaults.showCode = false,
    defaults.stickyHeight = 0,
    defaults.hasToolbar = false,
    defaults.parentElement = "#menutree",
    defaults.articleElement = "#bs_toc_body",
    
    menutree = new Menutree(Menutree.DEFAULTS);
  }}) ();
      
  </script>
  <?php endif; ?>