<link rel="stylesheet" href="<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/BsVerify.min.css">
<script type="text/javascript" src="<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/BsVerify.min.js"></script>
<script type="text/javascript">
function verify(){
    BsVerify.configure({
    tolerance: 10,
    duration: 500,
    mask: .5,
    maskClosable: true,
    title: '<?php if(empty(Bsoptions('Verify22_Paneltitle'))){echo '人机验证';}else{
			echo Bsoptions('Verify22_Paneltitle');}
			  ?>',
    text: '<?php if(empty(Bsoptions('Verify22_Paneldec'))){echo '滑动滑块，使图片显示角度为正';}else{
			echo Bsoptions('Verify22_Paneldec');}?>',
    album: [
			   <?php if(empty(Bsoptions('Verify22_Panelimg'))) :?>

			    "<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/img/t1.png",

				"<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/img/t2.png",
				"<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/img/t3.png"
				<?php else: ?>
				<?php $pic = explode(",", Bsoptions('Verify22_Panelimg'));
				$pics = implode('","',$pic);
				$panelimg = '"'.$pics.'"';
				echo $panelimg;
				?>
				<?php endif; ?>
    ]
  });

  BsVerify.action(function (code) {
    switch (code) {
      case 1:
        document.getElementById("commentsubmit").removeAttribute("disabled");
$("#bsverify").hide();  
        break;
    }
  });
}
		
	
	$(window).bind('popstate',function(event) { 
	    var button=document.getElementsByTagName("span");
for(var i=0;i<button.length;i++) {
if(typeof(button[i].id)!="undefined" && button[i].id == "bsverify") {
	    			$('#bsverify').show();
}};
});
</script>