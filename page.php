<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
?>
<?php $this->need('compoment/head.php');?>

<?php $this->need('pages/page.php'); ?>


<script>
articleCid=<?php echo $this->cid;?>;
articleType= 'page';
function addPostView(){if (typeof articleCid != 'undefined' && articleCid) $.post('/',{postview:articleCid,postType:articleType},function (res) {articleCid='';
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
