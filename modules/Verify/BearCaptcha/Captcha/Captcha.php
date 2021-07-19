<link rel="stylesheet" href="/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/css/verify.min.css">
<script type="text/javascript" src="/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/js/verify.min.js"></script>
<script type="text/javascript">
document.getElementById("bearsimple_verify2").setAttribute("disabled", true);
	function Verify () {
		QVerify({
			name: "<?php if(empty($this->options->Verify22_Paneltitle)){echo '人机验证';}else{
			echo $this->options->Verify22_Paneltitle();}
			  ?>",  // 验证面板标题
			desc: "<?php if(empty($this->options->Verify22_Paneldec)){echo '滑动滑块，使图片显示角度为正';}else{
			echo $this->options->Verify22_Paneldec();}?>",  // 验证操作提示文字
			cloneTxt: "<?php if(empty($this->options->Verify22_Panelclose)){echo '点我关闭';}else{
			echo $this->options->Verify22_Panelclose();}?>",  // 关闭验证面板文字
			successTxt: "<?php if(empty($this->options->Verify22_Panelsuccess)){echo '验证成功，{0}秒后自动关闭';}else{
			echo $this->options->Verify22_Panelsuccess();}?>",  // {0}必须有，延迟关闭时间显示
			errorTxt: "<?php if(empty($this->options->Verify22_Panelerror)){echo '验证失败，请重试';}else{
			echo $this->options->Verify22_Panelerror();}?>",
			images: [
			   <?php if(empty($this->options->Verify22_Panelimg)) :?>
			    "/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t1.png",
				"/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t2.png",
				"/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t3.png"
				<?php else: ?>
				<?php $pic = explode(",", $this->options->Verify22_Panelimg);
				$pics = implode('","',$pic);
				$panelimg = '"'.$pics.'"';
				echo $panelimg;
				?>
				<?php endif; ?>
			
			],  // 图片数组 将会随机从里面选取一张
			duration: <?php if(empty($this->options->Verify22_Paneltime)){echo '2';}else{
			echo $this->options->Verify22_Paneltime();}?>,  //定时关闭时间 默认 2
			mountDiv: "#QVerify",  // 装载div 默认 #QVerify
			slideDifference: <?php if(empty($this->options->Verify22_PanelslideDifference)){echo '5';}else{
			echo $this->options->Verify22_PanelslideDifference();}?>,  // 滑动误差值 默认 5
			defaultDifference: <?php if(empty($this->options->Verify22_PaneldefaultDifference)){echo '5';}else{
			echo $this->options->Verify22_PaneldefaultDifference();}?>,  // 默认图片角度最小差值 默认 50
			mousedown: function (e) {  // 按下鼠标事件
				// e: 元素本身
				console.log('按下了鼠标');
			},
			mousemove: function (e, moveWidth) {  // 移动鼠标事件
				// e: 元素本身
				// moveWidth: 移动距离
				console.log("移动了鼠标");
				console.log(moveWidth);
			},
			mouseup: function (e, moveWidth) {  // 抬起鼠标事件
				// e: 元素本身
				// moveWidth: 移动距离
				console.log("抬起了鼠标");
				console.log(moveWidth);
			},
			success: function () {  // 验证成功事件
			document.getElementById("bearsimple_verify2").removeAttribute("disabled");
				console.log("验证成功");
			},
			fail: function () {  // 验证失败事件
				console.log("验证失败");
			},
			complete: function () {  // 验证完成事件 成功失败都会执行(执行顺序: complete->success 或 complete->fail)
				console.log("触发验证");
			},
			clone: function (status) {  // 关闭验证面板事件
				// status 返回的状态
				// false: 失败状态下关闭; true: 成功状态下关闭;
				console.log(status);
			}
		});
	};
</script>