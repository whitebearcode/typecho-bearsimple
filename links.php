<?php
    /**
    * 友链
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
                    
                    <h2><i class="jsfiddle icon"></i> 友链</h2><br>

<ul id="friendlinks">

<?php echo $this->content ?>

</ul>
<script>
(function(){
    let a =document.getElementById("friendlinks");
    if(a){
        let ns = a.querySelectorAll("li");
        let nsl = ns.length;
        let str ='<div class="ui four doubling cards">';
        let bgid = 0;
        for(let i = 0;i<=nsl-4;i+=4){
           bgid = Math.floor(Math.random() * 6);
            str += (`<div class="card" href="${ns[i+1].innerText}"><div class="content"><div class="center aligned header">${ns[i].innerText}</div><div class="center aligned description"><p>${ns[i+3].innerText}</p></div></div><div class="extra content"><div class="center aligned author"><img class="ui avatar image" src="${ns[i+2].innerText}">${ns[i].innerText}</div></div></div>`);
        }
        str+='</div><style></style>';
        let n1 = document.createElement("div");
        n1.innerHTML = str;
        a.parentNode.insertBefore(n1,a);
        a.style="display: none;";
    }else{
        console.log('error');
    }
}())
 </script> 

</div>

</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>