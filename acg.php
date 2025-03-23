<?php
    /**
    * 我的追番
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php $this->need('compoment/head.php');?>
<link rel="stylesheet" href="<?php AssetsDir();?>assets/vendors/bangumi/bangumi.css?v=<?php echo themeVersion(); ?>">
<script>
    window.BangumiAPI = "<?php echo Helper::options()->siteUrl.'index.php/getBangumi';?>";
    window.BangumiPageSize = 8;
</script>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
              <div class="page-card">
                <h2><i class="tv icon"></i> <?php $this->title() ?></h2>   


 <?php if(!empty(Bsoptions('bangumi_note'))): ?>     
    <div class="ui segment">
  <i class="red heart icon"></i>
  <?php echo Bsoptions('bangumi_note');?>
</div>
<?php endif; ?>

<section>
    <?php if(Bsoptions('acg_choose') == '1'):?>
    <div data-status="acg" class="bangumi-movie-list bangumiboard-list"></div>  
    <?php endif;?>
    <?php if(Bsoptions('acg_choose') == '2'):?>
  <div class="tab">

	<uls class="tabs">
		<li><a>在看</a></li>
		<li><a>想看</a></li>
		<li><a>看过</a></li>
		<li><a>搁置</a></li>
		<li><a>抛弃</a></li>
	</uls>

	<div class="tab_content">

		<div class="tabs_item">
		<div data-status="watching" class="bangumi-movie-list bangumiboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="wish" class="bangumi-movie-list bangumiboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="watched" class="bangumi-movie-list bangumiboard-list"></div>  
		</div>
		
		<div class="tabs_item">
			<div data-status="on_hold" class="bangumi-movie-list bangumiboard-list"></div>  
		</div>
		
		<div class="tabs_item">
			<div data-status="dropped" class="bangumi-movie-list bangumiboard-list"></div>  
		</div>
		
	</div>
</div>
<?php endif;?>
</section>
</div> 

       </div> 
<script src="<?php AssetsDir();?>assets/vendors/bangumi/bangumi.js?v=<?php echo themeVersion(); ?>"></script>
</div>
 <script>
$(document).ready(function () {
  (function ($) {
    $('.tab uls.tabs').addClass('active').find('> li:eq(0)').addClass('current');

    $('.tab uls.tabs li a').click(function (g) {
      var tab = $(this).closest('.tab'),
      index = $(this).closest('li').index();

      tab.find('uls.tabs > li').removeClass('current');
      $(this).closest('li').addClass('current');

      tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
      tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();

      g.preventDefault();
    });
  })(jQuery);

});
    </script>

<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>