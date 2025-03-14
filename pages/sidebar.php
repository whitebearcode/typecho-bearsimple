<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="<?php if(Bsoptions('site_style') == '2'):?>hidden <?php endif;?>pure-u-1-4 hidden_mid_and_down">
    <aside id="sidebar" class="sidebar">
        <?php if(Bsoptions('Scroll') == true && Bsoptions('Scroll_Sidebar') == true && $this->is('single')): ?>
   <div class="recent-menutree-card bsmenutree" style="display:none">
<div class="card-header">
  <i class="list alternate outline icon"></i>
 文章目录
</div>
<div class="card-body">
<span id="menutree"></span>
</div>
</div>
<?php endif; ?>

<?php if(Bsoptions('AdControl') == true && Bsoptions('AdControl1') == true) :?>
<div class="widget">
<!--右侧广告模块1-->
    <?php billboard(Bsoptions('AdControl1_style'),'sidebar1'); ?></div>
    <?php endif; ?>
    
<?php if(Bsoptions('Authorz') == true) :?>
<div class="blogger-card">
  <!-- 顶部背景 -->
  <div class="blogger-top-bg"<?php if(Bsoptions('AuthorBackground') !== null && Bsoptions('AuthorBackground') !== '') :?>style="background-image: url('<?php echo Bsoptions('AuthorBackground');?>');"<?php endif;?>></div>

  <!-- 博主头像和名字 -->
  <div class="blogger-header">
    <img src="<?php echo Bsoptions('AuthorAvatar') ?>" class="blogger-avatar">
    <div class="blogger-name"><?php echo Bsoptions('AuthorName') ?></div>
  </div>

  <!-- 博主个性简介 -->
  <div class="blogger-bio">
    <?php if(Bsoptions('AuthorOneSay') == true) :?><?php echo get_hito(); ?><?php elseif(Bsoptions('AuthorQm') !== null): ?><?php echo Bsoptions('AuthorQm') ?><?php endif; ?>
  </div>

  <?php if (array_filter([Bsoptions('Github_URL'), Bsoptions('Wechat_QRCODE'), Bsoptions('QQ_QRCODE'), Bsoptions('Facebook_URL'), Bsoptions('Twitter_URL'), Bsoptions('Telegram_URL'), Bsoptions('Weibo_URL')])) : ?>
    <!-- 社交平台图标 -->
    <div class="blogger-social">
      <?php if(!empty(Bsoptions('QQ_QRCODE'))) :?>
        <a class="social-icon" id="contactqq"><i class="fab fa-qq"></i></a>
      <?php endif;?>
      <?php if(!empty(Bsoptions('Wechat_QRCODE'))) :?>
        <a class="social-icon" id="contactwechat"><i class="fab fa-weixin"></i></a>
      <?php endif;?>
      <?php if(!empty(Bsoptions('Weibo_URL'))) :?>
        <a href="<?php echo Bsoptions('Weibo_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?> class="social-icon"><i class="fab fa-weibo"></i></a>
      <?php endif;?>
      <?php if(!empty(Bsoptions('Github_URL'))) :?>
        <a href="<?php echo Bsoptions('Github_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?> class="social-icon"><i class="fab fa-github"></i></a>
      <?php endif;?>
      <?php if(!empty(Bsoptions('Twitter_URL'))) :?>
        <a href="<?php echo Bsoptions('Twitter_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?> class="social-icon"><i class="fas fa-times"></i></a>
      <?php endif; ?>
      <?php if(!empty(Bsoptions('Telegram_URL'))) :?>
        <a href="<?php echo Bsoptions('Telegram_URL') ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?> class="social-icon"><i class="fab fa-telegram"></i></a>
      <?php endif; ?>
    </div>


  <?php endif;?>

  <?php if(Bsoptions('FourTotalHidden') == true) :?>
    <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
    <!-- 统计信息 -->
    <div class="blogger-stats">
      <div class="stat-item">
        <div class="stat-number"><?php if($stat->publishedPostsNum > '99'){echo '99+';}else{echo $stat->publishedPostsNum();} ?></div>
        <div class="stat-label">文章</div>
      </div>
      <div class="stat-item">
        <div class="stat-number"><?php if($stat->publishedCommentsNum - crossnum() > '99'){echo '99+';}else{echo $stat->publishedCommentsNum - crossnum();} ?></div>
        <div class="stat-label">评论</div>
      </div>
      <div class="stat-item">
        <div class="stat-number"><?php if($stat->categoriesNum > '99'){echo '99+';}else{echo $stat->categoriesNum();} ?></div>
        <div class="stat-label">分类</div>
      </div>
      <div class="stat-item">
        <div class="stat-number"><?php if($stat->publishedPagesNum > '99'){echo '99+';}else{echo $stat->publishedPagesNum();} ?></div>
        <div class="stat-label">页面</div>
      </div>
    </div>
  <?php endif;?>
</div>
<?php endif;?>



<!--搜索模块-->
<?php if(!empty(Bsoptions('Search')[0]) && @in_array('sidebar',Bsoptions('Search'))) :?>

<!-- 搜索框 -->
<div class="search-box ui category search">
  <input class="prompt" type="text" id="sidebarsearch" name="s" placeholder="输入关键词实时搜索" />
<i class="fas fa-search"></i>
</div>


  <?php endif; ?>
<div class="sidebar-card">
  <div class="card-header"><i class="folder open outline icon"></i> 文章分类</div>
  <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
        <div class="card-body">
  <ul class="tree-view">
    
    <?php while($categorys->next()): ?>
<?php if ($categorys->levels === 0): ?>
<?php $children = $categorys->getAllChildren($categorys->mid); ?>
<?php if (empty($children)) { ?>
    <li>
      <div class="tree-node">
        <a href="<?php $categorys->permalink(); ?>" class="category-link"><?php $categorys->name(); ?> <span class="category-count">(<?php echo $categorys->count(); ?>)</span></a>
      </div>
    </li>
   <?php } else { ?>
  <li>
      <div class="tree-node">
        <span class="toggle-icon"></span>
        <a href="<?php $categorys->permalink(); ?>" class="category-link"><?php $categorys->name(); ?> <span class="category-count">(<?php echo $categorys->count(); ?>)</span></a>
      </div>
      <ul class="tree-view">
          <?php foreach ($children as $mid) { ?>
<?php $child = $categorys->getCategory($mid); ?>
        <li>
          <div class="tree-node">
            <a href="<?php echo $child['permalink'] ?>" class="category-link"><?php echo $child['name']; ?> <span class="category-count">(<?php echo $child['count']; ?>)</span></a>
          </div>
          
        </li>
      <?php } ?>
      </ul>
    </li> 
   <?php } ?><?php endif; ?><?php endwhile; ?>
  </ul>
</div>
</div>
<script>
 var toggleIcons = document.querySelectorAll('.toggle-icon');

toggleIcons.forEach(icon => {
  icon.addEventListener('click', function() {
    this.classList.toggle('open'); // 切换 open 类
    var subTree = this.parentElement.nextElementSibling;
    if (subTree) {
      subTree.classList.toggle('open');
    }
  });
});
</script>

<?php if(Bsoptions('LastArticle') == true) :?>
<?php $this->widget('Widget_Post_hot@hot', 'pageSize=5')->to($hot); ?>
<div class="recent-posts-card">
  <div class="card-header"><i class="newspaper icon"></i> 最近文章</div>
        <div class="card-body">
  <ul class="recent-posts-list">
      <?php while($hot->next()): ?>
    <li>
      <a href="<?php $hot->permalink() ?>"><?php $hot->title(); ?></a>
      <div class="recent-posts-meta"><?php echo date('Y/m/d',$hot->created); ?>  ·  <?php $hot->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></div>
    </li>
    <?php endwhile; ?>
  </ul>
  </div>
</div>
<?php endif;?>

<?php if(Bsoptions('lastcomment') == true) :?>
<div class="recent-comments-card">
  <div class="card-header"><i class="comment dots outline icon"></i> 最新评论</div>
  <?php lastComments(); ?>
 
</div>
<?php endif;?>
<?php if(Bsoptions('tagcloud') == true) :?>
<?php Typecho_Widget::widget('Widget_Metas_Tag_Cloud','ignoreZeroCount=0&limit='.tagcloudnum())->to($tags); ?>
<div class="tag-cloud-card">
       <div class="card-header"><i class="tags icon"></i> 文章标签</div>
             <div class="card-body">
  <?php if($tags->have()): ?>
  <ul class="tag-cloud-list">
      <?php while ($tags->next()): ?>
    <li><a href="<?php $tags->permalink();?>"><?php $tags->name(); ?></a></li>
    <?php endwhile; ?>
  </ul>
  <?php endif; ?>
</div>
</div>
 <?php endif; ?>

<?php if(Bsoptions('ClockModule') == true) :?>
<div class="countdown-card">
        <div class="card-header"><i class="hourglass half icon"></i> 时光沙漏</div>
              <div class="card-body">
  <div class="countdown-item">
    <div class="countdown-label">今年剩余时间</div>
    <div class="countdown-progress">
      <div class="countdown-progress-bar" id="year-progress"></div>
    </div>
    <div class="countdown-time" id="year-time"></div>
  </div>
  <div class="countdown-item">
    <div class="countdown-label">本月剩余时间</div>
    <div class="countdown-progress">
      <div class="countdown-progress-bar" id="month-progress"></div>
    </div>
    <div class="countdown-time" id="month-time"></div>
  </div>
  <div class="countdown-item">
    <div class="countdown-label">今天剩余时间</div>
    <div class="countdown-progress">
      <div class="countdown-progress-bar" id="day-progress"></div>
    </div>
    <div class="countdown-time" id="day-time"></div>
  </div>
</div>
</div>

<script>
    function updateCountdown() {
  const now = new Date();

  // 今年剩余时间
  const yearEnd = new Date(now.getFullYear(), 11, 31, 23, 59, 59);
  const yearTotal = yearEnd - new Date(now.getFullYear(), 0, 1);
  const yearRemaining = yearEnd - now;
  const yearProgress = ((yearTotal - yearRemaining) / yearTotal) * 100;
  $('#year-progress').css('width', `${yearProgress}%`);
  $('#year-time').text(`${Math.floor(yearRemaining / (1000 * 60 * 60 * 24))} 天`);

  // 本月剩余时间
  const monthEnd = new Date(now.getFullYear(), now.getMonth() + 1, 0, 23, 59, 59);
  const monthTotal = monthEnd - new Date(now.getFullYear(), now.getMonth(), 1);
  const monthRemaining = monthEnd - now;
  const monthProgress = ((monthTotal - monthRemaining) / monthTotal) * 100;
  $('#month-progress').css('width', `${monthProgress}%`);
  $('#month-time').text(`${Math.floor(monthRemaining / (1000 * 60 * 60 * 24))} 天`);

  // 今天剩余时间
  const dayEnd = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
  const dayTotal = 24 * 60 * 60 * 1000; // 一天的总毫秒数
  const dayRemaining = dayEnd - now;
  const dayProgress = ((dayTotal - dayRemaining) / dayTotal) * 100;
  $('#day-progress').css('width', `${dayProgress}%`);
  const hoursRemaining = Math.floor(dayRemaining / (1000 * 60 * 60));
  const minutesRemaining = Math.floor((dayRemaining % (1000 * 60 * 60)) / (1000 * 60));
  $('#day-time').text(`${hoursRemaining} 小时 ${minutesRemaining} 分钟`);
}

// 初始化并每秒更新一次
updateCountdown();
setInterval(updateCountdown, 1000);
</script>
<?php endif;?>

    
<?php if(Bsoptions('FriendLinkChoose') == true && Bsoptions('FriendLinkFoot') == false) :?>
  <?php if((Bsoptions('FriendLink_place') == '1') || (Bsoptions('FriendLink_place') == '2' && $this->is('index'))) :?>
    <!-- 友情链接卡片 -->
    <div class="friend-link-card">
      <div class="card-header">
        <i class="linkify icon"></i>
        <span>友情链接</span>
      </div>
      <div class="friend-link-card-body">
        <?php if(empty(Bsoptions('FriendLink'))) :?>
          <!-- 无友情链接时的提示 -->
          <div class="empty-state">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="148" height="148" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="1.128" y1="0.988" x2="0.364" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="c" x1="1" y1="0.5" x2="0.112" y2="1.125" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#747f95"/></linearGradient><linearGradient id="d" x1="-0.392" y1="1.114" x2="0.5" y2="0.396" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#ebedf5"/></linearGradient><linearGradient id="e" x1="-0.906" y1="1.646" x2="0.636" y2="0.061" xlink:href="#d"/><linearGradient id="f" x1="-0.109" y1="1.931" x2="0.736" y2="0.141" xlink:href="#d"/></defs><g transform="translate(-135 -375)"><circle cx="184" cy="184" r="184" transform="translate(191 443)" fill="#f3f3fa"/><path d="M2925,350h0c-8.837,0-16-32.235-16-72s7.163-72,16-72c.038,0,11.813.471,18.75-7.529s9-14.486,9-24.469c0-34.257,14.681-58.6,28.25-63.313,3.909-.688,10,.818,16-4.354s8-9.372,8-16.333c0-37.555,12.536-68,28-68s28,30.445,28,68c0,6.961-.667,10.328,5.333,15.5s14.76,4.5,18.667,5.187c13.569,4.714,24,33.055,24,67.312a101.212,101.212,0,0,0,2.333,20s4.485,11.842,11,5.5,9.13-14.885,10.25-22.871C3135.767,157.923,3142.61,142,3149,142c6.519,0,12.127,16.566,14.645,40.566.741,7.066,2.2,11.743,6.521,17.6A14.3,14.3,0,0,0,3180.92,206H3181c6.488,0,12.073,16.409,14.617,40.308.5,4.725.982,7.6,5.3,11.527S3212.884,262,3212.884,262l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573C3227.336,294.758,3229,311.835,3229,330c0,6.817-.237,13.546-.7,20H2925Zm303.3,0h0Z" transform="translate(-2718 397)" fill="url(#a)"/><path d="M117,208H.7c-.466-6.453-.7-13.181-.7-20,0-18.163,1.664-35.24,4.686-48.083a58.6,58.6,0,0,1,5.086-14.573C11.745,121.8,13.84,120,16,120l.116,0s7.651-.242,11.967-4.166,4.8-6.8,5.3-11.527C35.927,80.408,41.513,64,48,64a16.6,16.6,0,0,0,3.3-1.014A6.153,6.153,0,0,0,53.365,61.5c6.515-6.342,9.13-14.884,10.25-22.871C66.8,15.924,73.642,0,80.032,0,86.55,0,92.158,16.566,94.676,40.567c.742,7.065,2.2,11.742,6.521,17.6A14.3,14.3,0,0,0,111.951,64h.081c6.487,0,12.073,16.409,14.617,40.307.5,4.725.983,7.6,5.3,11.527S143.915,120,143.915,120l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573c3.022,12.844,4.686,29.921,4.686,48.083,0,6.818-.237,13.546-.7,20H117Zm42.328,0h0ZM.7,208h0Z" transform="translate(350.969 539)" fill="url(#a)"/><path d="M2989,62c-10.838-4.087-16.3,0-32,0-26.51,0-48-8.954-48-20s21.49-20,48-20h256a16,16,0,1,1,0,32s-15.5,0-27.5,3S3165,68.714,3165,68.714,3127.392,110,3081,110c-38.041,0-70.176-13.246-80.647-31.653C2998.219,74.6,2999.838,66.087,2989,62Z" transform="translate(-2702 701)" fill="#d1d6e2"/><path d="M-2493,98s-56.355,45.651-64,16,74.25-17.75-16,72" transform="translate(3044 409)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2" stroke-dasharray="10"/><path d="M4,2.2C7.15-.75,16,0,16,0s-1.5,4-2.6,8-.232,5.942-1.8,8C7.6,21.25,0,21,0,21s.75-3.4,2-8S.85,5.15,4,2.2Z" transform="translate(447 603.085)" fill="#909aa9"/><ellipse cx="10" cy="4" rx="10" ry="4" transform="translate(294 787)" fill="url(#c)"/><path d="M8.44,24s8.115-6,6.94-10S11.51,9.625,9.775,6.125A11.222,11.222,0,0,1,8.44,0S1.767,2.625,1.5,9.375C1.38,12.419,4.436,14.344,6.171,18A32.451,32.451,0,0,1,8.44,24Z" transform="translate(287 794.497) rotate(-90)" fill="#909aa9"/><path d="M0,0,57,4.5,136,0l31.5,12,17,10-37,8.5-24.5-5-58,5L4,23Z" transform="translate(191 699)" fill="#fff"/><path d="M-1.4,1.2,60,9l58.75-5.25L143,9l36-9V24.5L144.4,29l-16.2-7.25L95.6,23l-5.1,1.5L67.2,21.75,5,23.25S2.8,16.713,1.2,11.2-1.4,1.2-1.4,1.2Z" transform="translate(196 720)" fill="#eceff5"/><ellipse cx="43" cy="9.5" rx="43" ry="9.5" transform="translate(253 701)" fill="#ebedf5"/><g transform="translate(63 354)"><g transform="translate(258.49 305.55)"><path d="M525.021,66.584a31.23,31.23,0,0,1,7.085,10.425c2.772,6.6,5.877,13.459,8.386,14.78s3.695,10.033-8.053,8.185S525.021,66.584,525.021,66.584Z" transform="translate(-524.241 -66.584)" fill="#fff"/><path d="M525.494,68.3a32.341,32.341,0,0,1,6.953,16.851c.847,8.628,2.933,13.332,5.151,13.016a12.659,12.659,0,0,1-5.991-.025C528.092,97.37,524.074,68.412,525.494,68.3Z" transform="translate(-523.763 -65.64)" fill="url(#d)"/></g><path d="M537.949,131.675a34.415,34.415,0,0,0,14.137,1.09c6.9-.975,8.727-13.747-.647-15.059-7.267-1.02-6.026-12.167-7.366-22.433s-6.56-18.848-7.364-23.026,4.251-9.233,3.614-18.062c-.652-9.065-6.3-10.479-8.307-10.074s-3.609,2.392-6.154,3.47-6.292-.673-11.112,1.619-9.377,7.547-9.377,7.547c-2.009,2.561.4,10.648-.938,14.691s-6.694,39.223-6.56,49.062,6.426,16.715,19.952,18.467,19.419-.606,19.856-4.448c.279-2.443,1.905-11.053-7.8-12.535-4.83-.74-7.363-1.347-7.363-1.347" transform="translate(-279.872 225.445)" fill="#fff"/><path d="M519.206,44.961s.961-1.578,1.726-1.594c1.313-.026,2.7,1.631,2.7,1.631S519.249,46.731,519.206,44.961Z" transform="translate(-268.363 226.187)" fill="#757f95"/><path d="M522.077,37.922c-2.054-.536-2.278,2.085-2.278,2.085s-2.89-.313-2.6,1.743c.357,2.566,5.831,2.443,5.831,2.443S524.583,38.578,522.077,37.922Z" transform="translate(-269.464 223.151)" fill="#757f95"/><path d="M505.743,52.715s-6.088-1.338-6.755,3.318,4.181,7.509,7.656.6" transform="translate(-279.292 231.235)" fill="#fff"/><path d="M503.084,74.624s-1.45,17.9,1.1,22.385c2.3,4.044,10.662,5.138,16.755,4.63a25.038,25.038,0,0,0,6.013-1.246c6.068-2.157,2.831-6.2,0-8.893s-3.738-10.346-8.593-14.5" transform="translate(-276.501 243.626)" fill="url(#e)"/><path d="M514.078,48.635a.6.6,0,0,0-.522.31v0l-.009.014a4.814,4.814,0,0,1-3.228,2.322l-.019,0,0,0a.6.6,0,0,0-.509.5l-.011,0-.406,1.078s.341-.014.842-.088l.057-.307.11-.584v.865c.188-.031.389-.073.6-.121v-.747l.064.454.037.268a5.609,5.609,0,0,0,2.386-1.138,4.083,4.083,0,0,0,1.152-1.977c.04-.155.054-.248.054-.248A.6.6,0,0,0,514.078,48.635Z" transform="translate(-273.668 229.087)" fill="#757f95"/><path d="M531.516,76.393c-3.6-3.507-6.766.555-6.766.555s-6.2-4.888-8.5.26C513.373,83.63,528.051,94,528.051,94S535.2,79.982,531.516,76.393Z" transform="translate(-270.216 243.516)" fill="url(#f)"/><path d="M504.118,75.051s5.02,15.274,7.571,19.76c3.236,5.688,9.468,8.51,15.533,6.355s2.831-5.527,0-8.223S523.148,81.155,518.293,77" transform="translate(-277.496 242.564)" fill="#fff"/></g><path d="M0,9.833l18-9.5,2.667,4v8.2L13,18,8.167,12.532,0,13.671Z" transform="translate(377 777)" fill="#eceff5"/><path d="M4,3.167,18,0V10l-5,3.167-4.833-4L0,10Z" transform="translate(377 777)" fill="#fff"/><path d="M-.211,18.893,16,12l.246,14.107-2.084,4.646L0,31Z" transform="matrix(1, 0.017, -0.017, 1, 400.376, 734.864)" fill="#eceff5"/><path d="M9.75,12H16l-3.75,7H0Z" transform="translate(400 735)" fill="#fff"/><g transform="translate(447 690)"><path d="M97,0,63.923,4.5,24.316,0,8.523,12,0,22l18.55,8.5,12.283-5,29.079,5,23.488-5,6.467-12.126Z" transform="translate(-1 12)" fill="#fff"/><path d="M81.149.607l-28.1,3.945L26.17,1.9l-11.1,2.655L-2.651-1.333V12.391l17.083,2.276L21.846,11l14.917.632,2.334.759L49.759,11l28.991,1.391s-1.4-1.778,0-4.724A43.992,43.992,0,0,0,81.149.607Z" transform="translate(1.651 35.333)" fill="#eceff5"/></g></g></svg>
            <p>暂无友情链接显示</p>
          </div>
        <?php else: ?>
          <!-- 友情链接列表 -->
          <ul class="friend-link-list">
            <?php foreach (getFriendLink() as $FriendLinks): ?>
              <li>
                <a href="<?php echo $FriendLinks[2]; ?>" title="<?php echo $FriendLinks[1]; ?>"<?php echo parselink($FriendLinks[2]); ?>>
                  <?php echo $FriendLinks[0]; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>


<?php if(Bsoptions('AdControl') == true && Bsoptions('AdControl2') == true) :?>
<div class="widget">
<!--右侧广告模块2-->
<?php billboard(Bsoptions('AdControl2_style'),'sidebar2'); ?> </div>
  <?php endif; ?>
</aside></div> 