
<link rel="stylesheet" href="<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/css/verify.min.css">
<script type="text/javascript" src="<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/js/verify.min.js"></script>
<script type="text/javascript">
document.getElementById("bearsimple_verify2").setAttribute("disabled", true);
	function Verify () {
		QVerify({
			name: "<?php if(empty($this->options->Verify22_Paneltitle)){echo '人机验证';}else{
			echo $this->options->Verify22_Paneltitle();}
			  ?>",
			desc: "<?php if(empty($this->options->Verify22_Paneldec)){echo '滑动滑块，使图片显示角度为正';}else{
			echo $this->options->Verify22_Paneldec();}?>",
			cloneTxt: "<?php if(empty($this->options->Verify22_Panelclose)){echo '点我关闭';}else{
			echo $this->options->Verify22_Panelclose();}?>",
			successTxt: "<?php if(empty($this->options->Verify22_Panelsuccess)){echo '验证成功，{0}秒后自动关闭';}else{
			echo $this->options->Verify22_Panelsuccess();}?>",
			errorTxt: "<?php if(empty($this->options->Verify22_Panelerror)){echo '验证失败，请重试';}else{
			echo $this->options->Verify22_Panelerror();}?>",
			images: [
			   <?php if(empty($this->options->Verify22_Panelimg)) :?>
			    "<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/img/t1.png",
				"<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/img/t2.png",
				"<?php AssetsDir();?>assets/verify/BearCaptcha/Captcha/img/t3.png"
				<?php else: ?>
				<?php $pic = explode(",", $this->options->Verify22_Panelimg);
				$pics = implode('","',$pic);
				$panelimg = '"'.$pics.'"';
				echo $panelimg;
				?>
				<?php endif; ?>
			
			],
			duration: <?php if(empty($this->options->Verify22_Paneltime)){echo '2';}else{
			echo $this->options->Verify22_Paneltime();}?>,
			mountDiv: "#QVerify",
			slideDifference: <?php if(empty($this->options->Verify22_PanelslideDifference)){echo '5';}else{
			echo $this->options->Verify22_PanelslideDifference();}?>,
			defaultDifference: <?php if(empty($this->options->Verify22_PaneldefaultDifference)){echo '5';}else{
			echo $this->options->Verify22_PaneldefaultDifference();}?>, 
			mousedown: function (e) {
				//预留事件
			},
			mousemove: function (e, moveWidth) {
               //预留事件
			},
			mouseup: function (e, moveWidth) { 
              //预留事件
			},
			success: function () {
			document.getElementById("bearsimple_verify2").removeAttribute("disabled");
			$('#qverify').attr('disabled',true);
			$('#qverify').css('pointer-events','none');
				toastr.success('人机验证成功:)');
			},
			fail: function () {
				toastr.warning('人机验证失败，请重试:(');
			},
			complete: function () {
				//预留事件
			},
			clone: function (status) {
				//预留事件
			}
		});
	};
	$(window).bind('popstate',function(event) { 
	    var button=document.getElementsByTagName("span");
for(var i=0;i<button.length;i++) {
if(typeof(button[i].id)!="undefined" && button[i].id == "qverify") {
	    			$('#qverify').attr('disabled',false);
			$('#qverify').css('pointer-events','auto');
}}
	});

</script>