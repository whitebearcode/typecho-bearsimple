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
#echarts_pie{
     height:16rem;max-width:100%
 }
</style>

<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> divided items segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="list icon"></i> <?php $this->title() ?></h2>
                 
                   <div dominant-baseline="central" text-anchor="middle" style="font-size:18px;font-weight:bold;text-align:center;" y="9" transform="translate(386.5 7)" fill="#464646">分类统计</div>
                    <div id="echarts_pie"></div>
                    <div dominant-baseline="central" text-anchor="middle" style="font-size:18px;font-weight:bold;text-align:center;" y="9" transform="translate(386.5 7)" fill="#464646">文章归档[点击年份可展开收缩]</div>

                    
                   <div class="timeline">
    <ul>
                    <?php 
    
    $year=0; $mon=0; $i=0; $j=0;
    $sul = getArchived();
    if($sul){
    foreach($sul as $archives){
        $archives = Typecho_Widget::widget('Widget_Abstract_Contents')->push($archives);
        $year_tmp = date('Y',$archives['created']);
        $mon_tmp = date('n',$archives['created']);
        $day_tmp = date('j日',$archives['created']);
        $y=$year; $m=$mon;
        
        if ($mon != $mon_tmp && $mon > 0) $output .= '';
        if ($year != $year_tmp && $year > 0) $output .= '';
        if ($year != $year_tmp) {
            $year = $year_tmp;
            $output .= '<li class="yearli" data-year="'. $year .'">
        <div class="time">
          <h4>'. $year .'</h4>
        </div>
      </li>'; 
        }
        if ($mon != $mon_tmp) {
            $mon = $mon_tmp;
           
        }
        if(date('Y',time()) !== $year){
            $class = ' style="display:none"';
        }
        $output .= '<li class="'.$year.'" '.$class.'>
        <div class="content">
          <a href="'.$archives['permalink'] .'"><h3>'. $archives['title'] .'</h3></a>
         
        </div>
        <div class="time">
          <h4>'.$mon.'月'.$day_tmp.'</h4>
        </div>
      </li>';
    }
    }
    $output .= '';
    echo $output;
?>
           <div style="clear:both;"></div>
    </ul>


  </div>         

</div></div>

<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>

    
                  <script>
                  $(".yearli").on('click',function(){
                      $("."+$(this).attr('data-year')).toggle();
                  });
    function EchartsInit() {
        $.getScript('<?php AssetsDir();?>assets/js/echarts.min.js',function(){
        const pie = echarts.init(document.getElementById('echarts_pie'), null, {renderer: 'svg'});

        let pieOption = {
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
        pie.setOption(pieOption);
        })
    }

    window.onload = function(){
        EchartsInit();
    };
</script>
<?php $this->need('compoment/foot.php'); ?>