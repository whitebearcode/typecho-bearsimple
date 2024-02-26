<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once 'header.php';
require_once 'menu.php';

use \Typecho\Widget;
use \TypechoPlugin\BsCore\Plugin;

$current = $request->get('act', 'index');
$theme = $request->get('file', 'owner.html');
if($theme == 'owner.html'){
    $themeText = '博主所收到的评论邮件模板';
}
elseif($theme == 'guest.html'){
    $themeText = '访客所收到的评论邮件模板';
}
elseif($theme == 'friendlink_approved.html'){
    $themeText = '友链审核通过的邮件模板';
}
elseif($theme == 'friendlink_notify.html'){
    $themeText = '提醒博主审核友链的邮件模板';
}
elseif($theme == 'friendlink_reject.html'){
    $themeText = '友链审核不通过的邮件模板';
}
else{
    $themeText = '未知邮件模板';
}
$title = $current == 'index' ? $menu->title : '邮件发送模板 ' . $theme.'（'.$themeText.'）';
?>
<div class="main">
    <div class="body container">
        <div class="typecho-page-title">
            <h2><?= $title ?></h2>
        </div>
        <div class="row typecho-page-main" role="main">
            <!-- MENU -->
            <div class="col-mb-12">
                <ul class="typecho-option-tabs fix-tabs clearfix">

                    <li <?= ($current == 'editemailtemplates' || 'index' ? ' class="current"' : '') ?>>
                        <a href="<?php $options->adminUrl('extending.php?panel=' . Plugin::$_panel . '&act=editemailtemplates'); ?>">
                            <?php _e('邮件发送模板'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php $options->adminUrl('options-theme.php') ?>"><?php _e('主题控制中心'); ?></a>
                    </li>
                </ul>
            </div>
      
            <?php Widget::widget('TypechoPlugin\BsCore\Console')->to($files);?>
    
                <div class="typecho-edit-theme">
                           
                    
                    
                    <div class="col-mb-12 col-tb-8 col-9 content">
                        
                        <form method="post" name="theme" id="theme" action="<?php $options->index('/action/' . Plugin::$action); ?>">
                            <label for="content" class="sr-only"><?php _e('编辑模板'); ?></label>
                            <textarea name="content" id="content" class="w-100 mono" <?php if (!$files->currentIsWriteable()) echo 'readonly'; ?>><?php echo $files->currentContent(); ?></textarea>
                            <p class="submit">
                                <?php if ($files->currentIsWriteable()) : ?>
                                    <input type="hidden" name="do" value="editEmailTemplate" />
                                    <input type="hidden" name="edit" value="<?php echo $files->currentFile(); ?>" />
                                    <button type="submit" class="btn primary"><?php _e('保存模板'); ?></button>
                                <?php else : ?>
                                    <em><?php _e('文件无写入权限'); ?></em>
                                <?php endif; ?>
                            </p>
                        </form>
                    </div>
                      <ul class="col-mb-12 col-tb-4 col-3">
                        <li><strong>模板文件</strong></li>
                        <?php while ($files->next()) : ?>
                            <li <?php if ($files->current) echo "class='current'"; ?>>
                                <a href="<?php $options->adminUrl('extending.php?panel=' . Plugin::$_panel . '&act=theme' . '&file=' . $files->file); ?>">
                                    <?php $files->file(); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>   
                </div>
                
          
        </div>
    </div>
</div>

<?php
require_once 'copyright.php';
require_once 'common-js.php';
require_once 'footer.php';
?>