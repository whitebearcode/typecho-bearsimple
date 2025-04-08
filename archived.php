<?php
    /**
    * 我的归档
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>


<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
              <div class="page-card">
                    <h2><i class="list icon"></i> <?php $this->title() ?></h2>
    <div class="chart-category-title">分类统计</div>
    <div class="chart-container">
        
        <canvas id="categoryChart"></canvas>
    </div>
<?php
$categories = $this->widget('Widget_Metas_Category_List');
$categoryData = [];
while ($categories->next()) {
    $categoryData[] = [
        'name' => $categories->name,
        'count' => $categories->count,
        'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF))
    ];
}
?>

<div class="archive-container">
    <div class="archive-category-title">文章归档</div>
    <?php
    $currentYear = date('Y');
    $years = [];
    $page = $this->request->get('page', 1);
    $pageSize = 5; 
    $archives = $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000');
    while ($archives->next()) {
        $year = date('Y', $archives->created);
        $years[$year][] = [
            'title' => $archives->title,
            'permalink' => $archives->permalink,
            'date' => date('Y-m-d', $archives->created)
        ];
    }

    krsort($years);
    $yearKeys = array_keys($years);
    $totalYears = count($yearKeys);
    $currentPageYears = array_slice($yearKeys, ($page-1)*$pageSize, $pageSize);
    
    foreach ($currentPageYears as $year):
        $isCurrentYear = $year == $currentYear;
    ?>
    <div class="year-group" data-year="<?php echo $year; ?>">
        <div class="year-title <?php echo $isCurrentYear ? '' : 'collapsed'; ?>" onclick="isCollapsed(this);">
            <span><?php echo $year; ?>年 <i class="pen icon"></i>共 <?php echo count($years[$year]);?> 篇文章</span>
        </div>
        <div class="post-list" style="<?php echo $isCurrentYear ? '' : 'display: none;' ?>">
            <?php foreach ($years[$year] as $post): ?>
            <a href="<?php echo $post['permalink']; ?>" class="post-item" >
                <span class="post-title"><?php echo $post['title']; ?></span>
                <span class="post-date"><?php echo $post['date']; ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
    
    <?php if ($page * $pageSize < $totalYears): ?>
    <div class="archived-load-more">
        <button class="archived-load-btn" onclick="loadMorePosts()">加载更多年份</button>
    </div>
    <?php endif; ?>
</div>

<script>
function isCollapsed(element){
    const isCollapsed = $(element).hasClass('collapsed');
    $(element).toggleClass('collapsed')
           .next('.post-list').slideToggle(100);
}

let currentPage = <?php echo $page; ?>;
const totalPages = Math.ceil(<?php echo $totalYears; ?> / <?php echo $pageSize; ?>);

function loadMorePosts() {
    const $btn = $('.archived-load-btn');
    $btn.prop('disabled', true).text('加载中...');

    $.get(window.location.href, { page: currentPage + 1 }, function(data) {
        const $newContent = $(data).find('.year-group');
        const $newButton = $(data).find('.archived-load-more');
        $('.archived-load-more').before($newContent);
        if ($newButton.length) {
            $('.archived-load-more').replaceWith($newButton);
        } else {
            $('.archived-load-more').remove();
        }
        
        currentPage++;
        $btn.prop('disabled', false);
    }).fail(function() {
        $btn.prop('disabled', false).text('加载失败，点击重试');
    });
}

function loadChart(){
  $.getScript("<?php AssetsDir();?>assets/js/chart.umd.min.js",function(){
        var ctxs = $('#categoryChart');
   if(ctxs){
       var ctx = ctxs.get(0).getContext('2d');
   }
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_column($categoryData, 'name')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($categoryData, 'count')) ?>,
                backgroundColor: <?= json_encode(array_column($categoryData, 'color')) ?>,
                borderWidth: 1,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 16,
                        padding: 12,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    displayColors: false,
                    bodyFont: { size: 14 }
                }
            },
            layout: {
                padding: {
                    top: 20,
                    bottom: 20
                }
            }
        }
    });
    });   
}
$(document).ready(function() {
   loadChart();

});
 if (typeof pjax !== 'undefined') {
    document.addEventListener('pjax:complete', function(){
        loadChart();
        });
  }
</script>


</div></div>

</div>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>