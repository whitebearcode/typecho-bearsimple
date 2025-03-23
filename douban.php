<?php
    /**
    * 豆瓣
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php $this->need('compoment/head.php');?>
<link rel="stylesheet" href="<?php AssetsDir();?>assets/vendors/douban/douban.css?v=<?php echo themeVersion(); ?>">
<script>
    window.DoubanAPI = "<?php echo Helper::options()->siteUrl.'index.php/getDouban';?>";
    window.DoubanPageSize = 8;
</script>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
              <div class="page-card">
                <h2><i class="puzzle piece icon"></i><?php $this->title() ?></h2>   

 <?php if(!empty(Bsoptions('douban_note'))): ?>     
    <div class="ui segment">
  <i class="red heart icon"></i>
  <?php echo Bsoptions('douban_note');?>
</div>
<?php endif; ?>

<?php if(is_array(Bsoptions('douban_show')) && in_array('movie',Bsoptions('douban_show'))):?>
<section>
      <h3><i class="film icon"></i> 影视</h3>
  <div class="tab">

	<uls class="tabs">
		<li><a>在看</a></li>
		<li><a>想看</a></li>
		<li><a>看过</a></li>
	</uls>

	<div class="tab_content">

		<div class="tabs_item">
		<div data-status="watching" class="douban-movie-list doubanboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="wish" class="douban-movie-list doubanboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="watched" class="douban-movie-list doubanboard-list"></div>  
		</div>
		
	</div>
</div>

</section>
 <?php endif;?>

<?php if(is_array(Bsoptions('douban_show')) && in_array('book',Bsoptions('douban_show'))):?>
<section>
        <h3><i class="book icon"></i> 读书</h3>
  <div class="tab">

	<uls class="tabs">
		<li><a>在读</a></li>
		<li><a>想读</a></li>
		<li><a>读过</a></li>
	</uls>

	<div class="tab_content">

		<div class="tabs_item">
		<div data-status="reading" class="douban-book-list doubanboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="wish" class="douban-book-list doubanboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="read" class="douban-book-list doubanboard-list"></div>  
		</div>
		
	</div>
</div>

     
</section>
<?php endif;?>


<?php if(is_array(Bsoptions('douban_show')) && in_array('music',Bsoptions('douban_show'))):?>
<section>
    <h3><i class="music icon"></i> 音乐</h3>
   <div class="tab">

	<uls class="tabs">
		<li><a>在听</a></li>
		<li><a>想听</a></li>
		<li><a>听过</a></li>
	</uls>

	<div class="tab_content">

		<div class="tabs_item">
		<div data-status="listening" class="douban-music-list doubanboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="wish" class="douban-music-list doubanboard-list"></div>  
		</div>

		<div class="tabs_item">
			<div data-status="listened" class="douban-music-list doubanboard-list"></div>  
		</div>
		
	</div>
</div>

</section>

<?php endif;?>
</div> 

       </div> 
<script src="<?php AssetsDir();?>assets/vendors/douban/douban.js?v=<?php echo themeVersion(); ?>"></script>
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