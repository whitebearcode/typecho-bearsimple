<?php
    /**
    * 我的归档
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
               <?php if($this->options->Diy == "1"): ?><div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="list icon"></i> <?php $this->title() ?></h2>
                    <?php
  $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);   
    $year=0; $mon=0; $i=0; $j=0;   
    while($archives->next()):   
        $year_tmp = date('Y',$archives->created);   
        $mon_tmp = date('m',$archives->created);   
        $y=$year; $m=$mon;   
        if($year_tmp == date('Y') && $mon_tmp == date('m')){$now="active ";}else{$now="";}
        if ($mon != $mon_tmp && $mon > 0) $output .= '</div>';   
        if ($year != $year_tmp && $year > 0) $output .= '</div>';   
        if ($year != $year_tmp) {   
            $year = $year_tmp;   
            $output .= '<h3 class="al_year" style="margin-left:3px"><i class="star outline icon"></i>'. $year .' 年</h3><div class="ui accordion">'; //输出年份   
        }   
        if ($mon != $mon_tmp && $mon_tmp) {   
            $mon = $mon_tmp;   
            $output .= '<div class="'.$now.'title">
    <i class="dropdown icon"></i>'. $mon .' 月</div><div class="'.$now.'content"><p class="transition visible" style="display: block !important;margin-left:5px">'; //输出月份   
       }   
  
        $output .= '<span style="margin-left:15px">'.date('d日: ',$archives->created).'<a href="'.$archives->permalink .'">'. $archives->title .'</a>
  <em>(
    '. $archives->commentsNum.'条评论
  )</em></span><br>
'; //输出文章日期和标题   
    endwhile;   
    $output .= '</p></div></div>';
    echo $output;
?>


</div></div>

<?php if($this->options->Diy == "1"): ?></div><?php endif; ?>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>