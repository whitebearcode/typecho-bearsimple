<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if(Bsoptions('Scroll') == true && Bsoptions('Scroll_Sidebar') == true): ?>
<link href="<?php AssetsDir();?>assets/vendor/menutree/menutree.min.css?v=4" rel="stylesheet" />
<?php endif; ?>

<?php $this->need('templates/layouts/sidebar-alt.php'); ?>

  <?php if(Bsoptions('Scroll') == true && Bsoptions('Scroll_Sidebar') == true && $this->is('single')): ?>
  <script src="<?php AssetsDir();?>assets/vendor/menutree/menutree.min.js?v=5"></script>
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