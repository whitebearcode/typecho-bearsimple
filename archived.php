<?php
    /**
    * 我的归档
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>

 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> divided items segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="list icon"></i> <?php $this->title() ?></h2>
                   <timeline class="bstimeline"><ul class="timeline">
                    <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);
    $year=0; $mon=0; $i=0; $j=0;
    
    while($archives->next()):
        $year_tmp = date('Y',$archives->created);
        $mon_tmp = date('m',$archives->created);
        $day_tmp = date('d日',$archives->created);
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
                        </div><label class="timeline-event-icon2"></label><p><strong><a  href="'.$archives->permalink .'">'. $archives->title .'</a></strong></p>';
    endwhile;
    $output .= '';
    echo $output;
?>
           </ul></timeline>         
         

</div></div>

<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>