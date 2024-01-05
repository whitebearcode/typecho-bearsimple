<?php
    /**
    * 我的归档
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>
   <style>
 #echarts_line,#echarts_pie{
     height:16rem;max-width:100%
 }
</style>

<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> divided items segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="list icon"></i> <?php $this->title() ?></h2>
                 
                 
                    <div id="echarts_pie"></div>
               
                    <div id="echarts_line"></div>
              


                    <div dominant-baseline="central" text-anchor="middle" style="font-size:18px;font-weight:bold;text-align:center;" y="9" transform="translate(386.5 7)" fill="#464646">文章归档</div>
        
                    
                   <timeline class="bstimeline"><ul class="timeline">
                    <?php 
    
    $year=0; $mon=0; $i=0; $j=0;
    $sul = getArchived();
    if($sul){
    foreach($sul as $archives){
        $archives = Typecho_Widget::widget('Widget_Abstract_Contents')->push($archives);
        $year_tmp = date('Y',$archives['created']);
        $mon_tmp = date('m',$archives['created']);
        $day_tmp = date('d日',$archives['created']);
        $y=$year; $m=$mon;
        
        if ($mon != $mon_tmp && $mon > 0) $output .= '';
        if ($year != $year_tmp && $year > 0) $output .= '</div></li>';
        if ($year != $year_tmp) {
            $year = $year_tmp;
            $output .= '<li class="timeline-event"><label class="timeline-event-icon"></label><div class="timeline-event-copy"><p class="timeline-event-thumbnail">'. $year .' 年</p>'; 
        }
        if ($mon != $mon_tmp) {
            $mon = $mon_tmp;
            $output .= '<h3>'. $year .' 年'. $mon .' 月</h3>';
        }
        $output .= '<div class="timeline-info">
                            <span>'.$day_tmp.'</span>
                        </div><label class="timeline-event-icon2"></label><p><strong><a  href="'.$archives['permalink'] .'">'. $archives['title'] .'</a></strong></p>';
    }
    }
    $output .= '';
    echo $output;
?>
           </ul></timeline>         
         

</div></div>

<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>

    
                  <script>
    function EchartsInit() {
        $.getScript('<?php AssetsDir();?>assets/js/echarts.min.js',function(){
        const pie = echarts.init(document.getElementById('echarts_pie'), null, {renderer: 'svg'});
        const line = echarts.init(document.getElementById('echarts_line'), null, {renderer: 'svg'});
        let lineOption = {
            title: {text: '标签统计', top: 2, x: 'center'},
            grid: {position: 'center'},
            tooltip: {trigger: 'axis', axisPointer: {type: 'shadow'}},
            xAxis: [{type: 'category', data: <?php echo getTagAndNum('name')?>,}],
            yAxis: [{type: 'value', max: 13}],
            series: [
                {
                    type: 'bar', data: ["11","10","7","6","5","5","4","4","4","3"], itemStyle: {color: '#0E9BFF'},
                    markPoint: {
                        symbolSize: 45,
                        data: [{type: 'max', itemStyle: {color: '#3B6DF7'}, name: '最多'},
                            {type: 'min', itemStyle: {color: '#FF4444'}, name: '最少'}]
                    },
                    markLine: {itemStyle: {color: '#000000'}, data: [{type: 'average', name: '平均值'}]}
                }
            ]
        };
        let pieOption = {
            title: {text: '分类统计', top: 2, x: 'center'},
            grid: {position: 'center'},
            tooltip: {
                trigger: 'item'
            },
            series: [
                {
                    name: '来源',
                    type: 'pie',
                    radius: '50%',
                    data: <?php echo getPostAndNum(); ?>,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        line.setOption(lineOption);
        pie.setOption(pieOption);
        })
    }

    window.onload = function(){
        EchartsInit();
    };
</script>
<?php $this->need('compoment/foot.php'); ?>