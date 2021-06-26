<?php
    /**
    * 全部标签
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
                    <div class="ui piled segment">
                    <h2><i class="tags icon"></i> 所有标签</h2><br>
<?php if($this->slug=="tags"): ?>
<?php Typecho_Widget::widget('Widget_Metas_Tag_Cloud')->to($tags); ?>
<?php if($tags->have()): ?>
    <?php while ($tags->next()): ?>


<a>
<div class="ui left labeled button" tabindex="0">
  <a class="ui basic label" href="<?php $tags->permalink();?>">
    <?php $tags->name(); ?>
  </a>
  <div class="ui icon button" onclick="window.open('<?php $tags->permalink();?>','_self')">
    <i class="tag icon"></i>
  </div>
</div>
</a>
    <?php endwhile; ?>
<?php endif; ?>
<?php else: ?>
<?php $this->content(); ?>
<?php endif; ?>

</div></div>

</div>
<?php $this->need('sidebar.php'); ?>

<?php $this->need('footer.php'); ?>