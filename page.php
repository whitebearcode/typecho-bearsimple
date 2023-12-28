<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
?>
<?php $this->need('compoment/head.php');?>
<?php if(Bsoptions('Diy') == true) :?>

<?php $this->need('pages/diy-page.php'); ?>

  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>

<?php $this->need('pages/page.php'); ?>
  <?php endif; ?>
  
<?php if(Bsoptions('Readmode') == true): ?>
<?php $this->need('modules/readmode.php'); ?>
  <?php endif; ?>
<script>articleCid=<?php $this->is('post') || $this->is('page')?_e($this->cid):_e('');?>;
function addPostView(){if (typeof articleCid != 'undefined' && articleCid) $.post('/',{postview:articleCid},function (res) {articleCid='';
       $('#ahot').html(res.data);
   })}
function addPostEditBtn(){
    $.post('<?php getIsLogin(); ?>',{action:'find'},function (res) {
        res = JSON.parse(res);
        switch(res.code){
    case 1 :
       $('#editbtn').show();
    break;
        }
    })
}
   $(function(){addPostView();addPostEditBtn();})
</script>
 <?php if(Bsoptions('AIService') == true && Bsoptions('AIService_Key') !== ''): ?> 
<script src="<?php AssetsDir();?>assets/vendors/aiTool/ai.min.js"></script>
<?php endif;?>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>
