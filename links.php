<?php
    /**
    * 友链
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
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                <h2><i class="jsfiddle icon"></i> <?php $this->title() ?></h2><br>    

<ul id="friendlinks">
<?php echo $this->content ?>

</ul>
<?php $this->need('comments.php'); ?>
<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<script>
(function(){
    let a =document.getElementById("friendlinks");
    if(a){
        let ns = a.querySelectorAll("bslink");
        let nsl = ns.length;
        let str ='<div class="ui four doubling cards" style="word-break:break-all;">';
        let bgid = 0;
        for(let i = 0;i<=nsl-4;i+=4){
           bgid = Math.floor(Math.random() * 6);
            str += (`<div class="card" hrefs="${ns[i+1].innerText}"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><div class="content"><div class="center aligned header">${ns[i].innerText}</div><div class="center aligned description"><p>${ns[i+3].innerText}</p></div></div><div class="extra content"><div class="center aligned author"><img class="ui avatar image" src="${ns[i+2].innerText}">${ns[i].innerText}</div></div></div>`);
        }
        str+='</div><style></style>';
        let n1 = document.createElement("div");
        n1.innerHTML = str;
        a.parentNode.insertBefore(n1,a);
        a.style="display: none;";
    }else{
        console.log('error');
    }
}());
 </script> 



<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>