<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php $this->need('compoment/head.php');?>
<?php 
$category = array();
$category['title'] = $this->getArchiveTitle();
if(empty(CategoryEncrypt(categeid($this->getArchiveSlug()))['Cate_Encrypt_Password'])){
$category['md5_password'] = md5Encode('654321');//初始密码，即加密密码没填的情况下的默认密码，可改动    
}
else{
$category['md5_password'] = md5Encode(CategoryEncrypt(categeid($this->getArchiveSlug()))['Cate_Encrypt_Password']);
}
$category['type'] = "category";
$category['category'] = $this->getArchiveSlug();
$_POST['data'] = $category;
$password = Typecho_Cookie::get('category_'.$this->getArchiveSlug());
if ((!empty($password) && $password == $category['md5_password']) || $this->user->hasLogin()){
    $cookie = true;
}

?>
<?php if(Bsoptions('Cate_Encrypt_open') == true && !empty(CategoryEncrypt(categeid($this->getArchiveSlug()))) && !$cookie):?>
<?php $this->need('modules/lock.php'); ?>
<?php else:?>

<?php if(!empty(CategoryAlbum(categeid($this->getArchiveSlug())))):?>
<?php $this->need('pages/album.php'); ?>
<?php else:?>

<?php if(Bsoptions('Diy') == true) :?>
<?php $this->need('pages/diy-archive.php'); ?>

  <?php endif; ?>

<?php if(Bsoptions('Diy') == false || empty(Bsoptions('Diy'))) :?>

<?php $this->need('pages/archive.php'); ?>

  <?php endif; ?>
<?php endif; ?>

<?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>