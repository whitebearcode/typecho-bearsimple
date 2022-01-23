<?php
if($options->Editors == '2'){
    Typecho_Plugin::factory('admin/write-post.php')->bottom = array('editor', 'button');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('editor', 'button');
class editor
{
    public static function button(){
		if (strpos( $_SERVER['REQUEST_URI'],'write-post.php') !== false)
{
    $url = 'post';
Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
}
if (strpos( $_SERVER['REQUEST_URI'],'write-page.php') !== false)
{
    $url = 'page';
Typecho_Widget::widget('Widget_Contents_Page_Edit')->to($page);
}
if (isset($post) || isset($page)) {
    $cid = isset($post) ? $post->cid : $page->cid;
    
    if ($cid) {
        Typecho_Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $cid)->to($attachment);
    } else {
        Typecho_Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
}
		?><style>.wmd-button-row {
    height: auto;
}</style>
<link rel="stylesheet" href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://lib.baomitu.com/limonte-sweetalert2/11.1.2/sweetalert2.min.css" />
<link href="https://deliver.application.pub/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
<link rel="stylesheet" href="https://lib.baomitu.com/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css" />
<script src="https://lib.baomitu.com/limonte-sweetalert2/11.1.2/sweetalert2.min.js"></script>
        <script type="text/javascript" src="https://lib.baomitu.com/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js"></script>
        <script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-loginkj-button" title="登录后可见"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-user-circle"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-loginkj-button').click(function(){
						var rs = "[bslogin]隐藏内容[/bslogin]";
						loginkj(rs);
					})
				}


				function loginkj(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}

				

			});
</script>
		<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-hfkj-button" title="回复或登录后可见"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-commenting"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-hfkj-button').click(function(){
						var rs = "[bshide]隐藏内容[/bshide]";
						hfkj(rs);
					})
				}


				function hfkj(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}

				

			});
</script>

<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-todocheck-button" title="打勾已完成"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-check-square"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-todocheck-button').click(function(){
						var rs = "{bs-todo type=true}Todolist已完成的内容{/bs-todo}";
						todocheck(rs);
					})
				}


				function todocheck(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-todonotcheck-button" title="打叉未完成"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-square"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-todonotcheck-button').click(function(){
						var rs = "{bs-todo type=false}Todolist待完成的内容{/bs-todo}";
						todonotcheck(rs);
					})
				}


				function todonotcheck(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-codes-button" title="代码高亮"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><svg t="1632126906909" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2425" width="16" height="16"><path d="M298.900577 778.338974c-7.070023 7.070023-17.974373 7.070023-25.043373 0L20.039405 524.521175c-7.070023-7.070023-7.070023-17.974373 0-25.043373l253.8178-253.8178c7.070023-7.070023 17.974373-7.070023 25.043373 0l27.242458 27.242458c7.070023 7.070023 7.070023 17.974373 0 25.043373L112.089891 512l214.053144 214.053144c7.070023 7.070023 7.070023 17.974373 0 25.043373L298.900577 778.338974zM444.87316 873.098151c-2.726088 9.269108-12.522198 14.702863-21.24486 11.995195l-33.767058-9.269108c-9.250688-2.726088-14.702863-12.522198-11.976776-21.790282l203.148793-703.132108c2.726088-9.269108 12.522198-14.702863 21.24486-11.995195l33.767058 9.269108c9.250688 2.726088 14.702863 12.522198 11.976776 21.790282L444.87316 873.098151zM752.049215 778.338974c-7.070023 7.070023-17.974373 7.070023-25.043373 0l-27.242458-27.242458c-7.070023-7.070023-7.070023-17.974373 0-25.043373l214.053144-214.053144L699.763384 297.946856c-7.070023-7.070023-7.070023-17.974373 0-25.043373l27.242458-27.242458c7.070023-7.070023 17.974373-7.070023 25.043373 0l253.8178 253.8178c7.070023 7.070023 7.070023 17.974373 0 25.043373L752.049215 778.338974z" p-id="2426" fill="#707070"></path></svg></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-codes-button').click(function(){
						var rs = "```编程语言\n这里是内容\n```";
						codes(rs);
					})
				}


				function codes(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-fontcolor-button" title="字体颜色"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-font"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-fontcolor-button').click(function(){
						Swal.fire({
  title: '字体颜色选择器面板',
  html: "<div id=\"color\"></div><br>选择完颜色后点击下面的直接插入按钮进行应用，本功能实现的效果仅在前台文章内页可见。",
  icon: 'info',
showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: "取消", 
  confirmButtonText: '直接插入'
}).then((result) => {
  if (result.isConfirmed) {
  var colorss = document.getElementById("colors").value;
  if(!colorss){
      alert('未选择颜色，不能直接插入!');
  }
  else{
    fontcolor('{bs-font color="'+ colorss + '"}内容{/bs-font}');
  }
  }
})
       $('#color').colorpicker({
        popover: false,
        inline: true,
        container: '#color',
template: '<div class="colorpicker">' +
          '<div class="colorpicker-saturation"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-hue"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-alpha">' +
          '   <div class="colorpicker-alpha-color"></div>' +
          '   <i class="colorpicker-guide"></i>' +
          '</div>' +
          '<div class="colorpicker-bar">' +
          '   <div class="input-group">' +
          '       <input id="colors" class="form-control input-block color-io" />' +
          '   </div>' +
          '</div>' +
          '</div>'
        })
        .on('colorpickerCreate', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          io.val(e.color.string());
          io.on('change keyup', function () {
            e.colorpicker.setValue(io.val());
          });
        })
        .on('colorpickerChange', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          if (e.value === io.val() || !e.color || !e.color.isValid()) {
            return;
          }
          io.val(e.color.string());
        });
						
					})
				}


				function fontcolor(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-iframe-button" title="插入iframe"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-window-maximize"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-iframe-button').click(function(){
						var rs = "{bs-iframe}iframe地址{/bs-iframe}";
						iframe(rs);
					})
				}


				function iframe(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-audio-button" title="插入音频"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-file-audio-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-audio-button').click(function(){
						var rs = "[bsaudio]音频地址[/bsaudio]";
						audio(rs);
					})
				}


				function audio(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-star-button" title="插入评星"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-star-half-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-star-button').click(function(){
						Swal.fire({
  title: '第一步 选择评星样式',
  input: 'select',
  inputOptions: {
      'star': '星星',
      'heart': '红心',
  },
  inputPlaceholder: '选择一款样式',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 输入评星数目',
  input: 'number',
inputLabel: '输入评星数目，最高五颗星',
inputAttributes:{
  min:1,
  max:5,
  
},
  inputPlaceholder: '输入评星数目',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
var text = '[bseva type="'+valueone+'"]'+valuetwo+'[/bseva]';
      star(text);
        
        resolve() 
      } 
      else{
         resolve('您必须输入评星数目~~') 
      }
    })
  }
})

        
    
        resolve() 
      } 
      else{
         resolve('您必须选择一款评星样式~~') 
      }
    })
  }
})
					})
				}


				function star(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-accord1-button" title="插入线性手风琴"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-plus-square"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-accord1-button').click(function(){
						var rs = "{bs-accord style=line title=线性手风琴标题}线性手风琴内容{/bs-accord}";
						accord1(rs);
					})
				}


				function accord1(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-accord2-button" title="插入普通手风琴"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-plus-square-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-accord2-button').click(function(){
						var rs = "{bs-accord style=common title=普通手风琴标题}普通手风琴内容{/bs-accord}";
						accord2(rs);
					})
				}


				function accord2(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-message-button" title="插入提示框"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-sticky-note-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-message-button').click(function(){
						Swal.fire({
  title: '第一步 选择提示框样式',
  input: 'select',
  inputOptions: {
      'common': '普通提示框',
      'basic': '阴影提示框',
      'commonclose': '普通可关闭提示框',
      'basicclose':'阴影可关闭提示框',
  },
  inputPlaceholder: '选择一款提示框',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择提示框颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'info':'淡青色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写提示框标题',
  input: 'text',
  inputLabel: '提示框标题',
  inputPlaceholder: '填写提示框标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写提示框内容',
  input: 'textarea',
  inputLabel: '提示框内容',
  inputPlaceholder: '请填写提示框内容',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写提示框内容'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写提示框图标名',
  input: 'text',
  inputLabel: '提示框图标名(若不需要图标可留空)',
  'html':'<a href="https://icon.bearlab.eu/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写提示框图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsmessage type="'+valueone+'" color="'+valuetwo+'" title="'+valuethree+'"'+icon+']'+valuefour+'[/bsmessage]';
      message(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写提示框标题~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款提示框~~') 
      }
    })
  }
})
					})
				}


				function message(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-button-button" title="插入按钮"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-circle-o-notch"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-button-button').click(function(){
						Swal.fire({
  title: '第一步 选择按钮样式',
  input: 'select',
  inputOptions: {
      'common': '普通按钮',
      'basic': '光圈按钮',
      'animated': '动画按钮',
  },
  inputPlaceholder: '选择一款按钮',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择按钮颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写按钮点击链接',
  input: 'url',
  inputLabel: '按钮点击跳转链接',
  inputPlaceholder: '填写按钮点击跳转链接，需带http(s)://',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写按钮名称',
  input: 'text',
  inputLabel: '按钮名称(若为动画按钮，两个名称请使用|隔开)',
  inputPlaceholder: '请填写按钮名称',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写按钮名称'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写按钮图标名',
  input: 'text',
  inputLabel: '按钮图标名(若不需要图标可留空)',
  'html':'<a href="https://icon.bearlab.eu/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写按钮图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsbtn type="'+valueone+'" color="'+valuetwo+'" url="'+valuethree+'"'+icon+']'+valuefour+'[/bsbtn]';
      button(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写跳转链接~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款按钮~~') 
      }
    })
  }
})
					})
				}


				function button(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
 <script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-progress-button" title="插入进度条"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-product-hunt"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
				    $('#wmd-progress-button').click(function(){
				    Swal.fire({
  title: '选择进度条颜色',
  input: 'select',
  inputOptions: {
      'normal':'蓝色',
      'success': '绿色',
      'info': '青色',
      'warning': '黄色',
      'danger': '红色',
      'light': '白色',
      'dark': '黑色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {
      
      Swal.fire({
      title: '第二步 填写进度条标题',
  input: 'text',
  inputLabel: '进度条标题[将显示在进度条上方]',
  inputPlaceholder: '填写进度条标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
             Swal.fire({
      title: '第三步 填写进度条数值',
  input: 'text',
  inputLabel: '进度条数值[如40%就填写40]',
  inputPlaceholder: '填写进度条数值',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
                var text = '[bsprog color="'+valueone+'" number="'+valuethree+'"]'+valuetwo+'[/bsprog]';
      progress(text);
    resolve()
      }
      else{
       resolve('您必须填写进度条数值~')    
      }
    })
  }
})
    resolve()
      }
      else{
       resolve('您必须填写进度条标题~')    
      }
    })
  }
})
      
      
      
      
      } 
      else{
         resolve('您必须选择一款颜色~') 
      }
    })
  }
})

				})
				}


				function progress(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-fujian-button" title="插入所有附件"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-paperclip"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-fujian-button').click(function(){
                 function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getAttachFile(); ?>",
                        data: {
                            "cid": "<?php echo $cid; ?>",
                             "url": "<?php echo $url; ?>",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            content(json.list);
                        },
                        complete: function() {
                        },
                        error: function() {
                            alert("数据获取错误");
                        }
                    });
                }
                getData();
                function content(list) {
                    var filename = " ";
                    var fileurl = " ";
                    for(var i in list) {
                        if(list[i]['type'] == 'img'){
                        filename += '![' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
                        if(list[i]['type'] == 'other'){
                        filename += '[' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
}
fujian(filename + fileurl);
}
					})
				}


				function fujian(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>

<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-bscardgithub-button" title="Github仓库"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-github"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-bscardgithub-button').click(function(){
						var rs = '[bsgit user="Github仓库拥有者，如whitebearcode"]Github项目名，如typecho-bearsimple[/bsgit]';
						githubcard(rs);
					})
				}


				function githubcard(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-gallery-button" title="相册"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-file-image-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-gallery-button').click(function(){
						var rs = '[bsgallery title="相册名"]\n[bsimg title="图片标题1" subtitle="图片子标题1"]图片地址1[/bsimg]\n[bsimg title="图片标题2" subtitle="图片子标题2"]图片地址2[/bsimg]\n[bsimg title="图片标题3" subtitle="图片子标题3"]图片地址3[/bsimg]\n[/bsgallery]';
						gallery(rs);
					})
				}


				function gallery(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-quotepost-button" title="引用文章"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-newspaper-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-quotepost-button').click(function(){
						var rs = '[bspost cid="文章CID"]';
						quotepost(rs);
					})
				}


				function quotepost(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-postmark-button" title="标注文字"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-bookmark-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-postmark-button').click(function(){
						var rs = '[bsmark]要标注的内容[/bsmark]';
						postmark(rs);
					})
				}


				function postmark(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-postruby-button" title="文字带拼音"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-file-word-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-postruby-button').click(function(){
						var rs = '[bsruby]要带拼音的汉字[/bsruby]';
						postruby(rs);
					})
				}


				function postruby(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<?php
}}
}
if($options->Editors == '1'){
 Typecho_Plugin::factory('admin/write-post.php')->richEditor = array('BearEditor_Plugin', 'Editor');
        Typecho_Plugin::factory('admin/write-page.php')->richEditor = array('BearEditor_Plugin', 'Editor');
class BearEditor_Plugin{
      /**
     * 插入编辑器
     */
     public static function Editor()
    {
        $cssUrl = 'https://deliver.application.pub/npm/easymde@2.15.0/dist/easymde.min.css';
        $jsUrl = 'https://deliver.application.pub/npm/easymde@2.15.0/dist/easymde.min.js';
        
	if (strpos( $_SERVER['REQUEST_URI'],'write-post.php') !== false)
{
    $url = 'post';
Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
}
if (strpos( $_SERVER['REQUEST_URI'],'write-page.php') !== false)
{
    $url = 'page';
Typecho_Widget::widget('Widget_Contents_Page_Edit')->to($page);
}

if (isset($post) || isset($page)) {
    $cid = isset($post) ? $post->cid : $page->cid;
    
    if ($cid) {
        Typecho_Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $cid)->to($attachment);
    } else {
        Typecho_Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
}

        ?>
<link rel="stylesheet" href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>" />
<link rel="stylesheet" href="https://lib.baomitu.com/limonte-sweetalert2/11.1.2/sweetalert2.min.css" />
        <script type="text/javascript" src="<?php echo $jsUrl; ?>"></script>
<link href="https://deliver.application.pub/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">

        <script src="https://lib.baomitu.com/limonte-sweetalert2/11.1.2/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://lib.baomitu.com/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css" />
<script type="text/javascript" src="https://lib.baomitu.com/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js"></script>
	<link href="https://cdn.staticfile.org/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
	<script src="https://cdn.staticfile.org/toastr.js/2.1.4/toastr.min.js"></script>


<style>
    .editor-statusbar .lines:before{content:'行数: '}
    .editor-statusbar .words:before{content:'字数: '}
</style>



        <script>
            $(document).ready(function() {
                new EasyMDE({
        autoDownloadFontAwesome: false,
        showIcons: ['strikethrough', 'code', 'table', 'redo', 'heading', 'undo', 'heading-bigger', 'heading-smaller', 'heading-1', 'heading-2', 'heading-3', 'clean-block', 'horizontal-rule','side-by-side'],
        <?php if(Helper::options()->EditorsAutosave[0] == '1'):?>
        autosave: {
            enabled: true,
            delay: 1000,
            uniqueId: 'text',
            timeFormat:{locale:'zh-CN'},
            text:'自动保存时间：'
        },
        <?php endif; ?>
        toolbar: [ { name: "bold", action:EasyMDE.toggleBold, className: "fa fa-bold",title: "加粗"}, { name: "italic", action:EasyMDE.toggleItalic, className: "fa fa-italic",title: "字体倾斜"}, { name: "strikethrough", action:EasyMDE.toggleStrikethrough, className: "fa fa-strikethrough",title: "删除线"},{ name: "heading-smaller", action:EasyMDE.toggleHeadingSmaller, className: "fa fa-header",title: "字体缩小"}, { name: "heading-bigger", action:EasyMDE.toggleHeadingBigger, className: "fa fa-header",title: "字体放大"},{ name: "heading-1", action:EasyMDE.toggleHeading1, className: "fa fa-header header-1",title: "H1字号"},{ name: "heading-2", action:EasyMDE.toggleHeading2, className: "fa fa-header header-2",title: "H2字号"},{ name: "heading-3", action:EasyMDE.toggleHeading3, className: "fa fa-header header-3",title: "H3字号"}, { name: "code", action:EasyMDE.toggleCodeBlock, className: "fa fa-code",title: "代码"}, { name: "quote", action:EasyMDE.toggleBlockquote, className: "fa fa-quote-left",title: "引用"}, { name: "unordered-list", action:EasyMDE.toggleUnorderedList, className: "fa fa-list-ul",title: "无序列表"}, { name: "ordered-list", action:EasyMDE.toggleOrderedList, className: "fa fa-list-ol",title: "有序列表"}, { name: "clean-block", action:EasyMDE.cleanBlock, className: "fa fa-eraser",title: "擦除代码块"}, { name: "link", action:EasyMDE.drawLink, className: "fa fa-link",title: "插入链接"}, { name: "image", action:EasyMDE.drawImage, className: "fa fa-picture-o",title: "插入图片"}, '|', { name: "table", action:EasyMDE.drawTable, className: "fa fa-table",title: "插入表格"}, { name: "color", className: "fa fa-font", action:colorpc,title: "字体颜色选择器"},{ name: "button", className: "fa fa-circle-o-notch", action:button,title: "按钮"},{ name: "message", className: "fa fa-sticky-note-o", action:message,title: "提示框"},{ name: "iframe", className: "fa fa-window-maximize", action:iframe,title: "插入iframe"},{ name: "audio", className: "fa fa-file-audio-o", action:audio,title: "插入音频"},{ name: "hide", className: "fa fa-commenting", action:hide,title: "回复或登录后可见"},{ name: "login", className: "fa fa-user-circle", action:login,title: "登录后可见"},{ name: "inserts", className: "fa fa-paperclip", action:attachInsertEvent,title: "插入所有附件"},{ name: "insertper", className: "fa fa-paperclip", action:insertper,title: "插入单个附件"},{ name: "todolist1", className: "fa fa-check-square", action:todolist1,title: "已完成列表"},{ name: "todolist2", className: "fa fa-square", action:todolist2,title: "未完成列表"},{ name: "star", className: "fa fa-star-half-o", action:star,title: "评星"},{ name: "accord1", className: "fa fa-plus-square", action:accord1,title: "线性手风琴"},{ name: "accord2", className: "fa fa-plus-square-o", action:accord2,title: "普通手风琴"},{ name: "quotepost", className: "fa fa-newspaper-o", action:quotepost,title: "引用文章"},{ name: "postmark", className: "fa fa-bookmark-o", action:postmark,title: "标注文字"},{ name: "postruby", className: "fa fa-file-word-o", action:postruby,title: "文字带拼音"},{ name: "gallery", className: "fa fa-file-image-o", action:gallery,title: "相册"},{ name: "githubcard", className: "fa fa-github", action:githubcard,title: "Github仓库"},{ name: "autosaves", className: "fa fa-grav", action:autosave,title: "自动保存"},{ name: "progress", className: "fa fa-product-hunt", action:progress,title: "进度条"},{ name: "preview", action:EasyMDE.togglePreview, className: "fa fa-eye no-disable",title: "预览"}, { name: "side-by-side", action:EasyMDE.toggleSideBySide, className: "fa fa-columns no-disable no-mobile",title: "所见即所得"}, { name: "fullscreen", action:EasyMDE.toggleFullScreen, className: "fa fa-arrows-alt no-disable no-mobile",title: "全屏"}, '|', ],
        lineNumbers:false,
        promptURLs:true,
        promptTexts:{
            image:"请填写图片直链",
            link:"请填写网址链接",
        },
        element: document.getElementById('text'),
    });
            });
            
            function star(editor){
               Swal.fire({
  title: '第一步 选择评星样式',
  input: 'select',
  inputOptions: {
      'star': '星星',
      'heart': '红心',
  },
  inputPlaceholder: '选择一款样式',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 输入评星数目',
  input: 'number',
inputLabel: '输入评星数目，最高五颗星',
inputAttributes:{
  min:1,
  max:5,
  
},
  inputPlaceholder: '输入评星数目',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
var text = '[bseva type="'+valueone+'"]'+valuetwo+'[/bseva]';
      editor.codemirror.doc.replaceSelection(text);
        
        resolve() 
      } 
      else{
         resolve('您必须输入评星数目~~') 
      }
    })
  }
})

        
    
        resolve() 
      } 
      else{
         resolve('您必须选择一款评星样式~~') 
      }
    })
  }
}) 
            }
            function autosave(editor){
          <?php if(Helper::options()->EditorsAutosave[0] == '11'||Helper::options()->EditorsAutosave[1] == '11'):?>
            //$("textarea:eq(1)").bind("input propertychange", autosaves); //废弃方法
        setInterval(function(){
         var submitted = false, form = $('form[name=write_post],form[name=write_page]').submit(function () {
        submitted = true;
    }), formAction = form.attr('action'),
        idInput = $('input[name=cid]'),
        cid = idInput.val(),
        draft = $('input[name=draft]'),
        draftId = draft.length > 0 ? draft.val() : 0,
        btnSave = $('#btn-save').removeAttr('name').removeAttr('value'),
        btnSubmit = $('#btn-submit').removeAttr('name').removeAttr('value'),
        btnPreview = $('#btn-preview'),
        doAction = $('<input type="hidden" name="do" value="publish" />').appendTo(form),
        locked = false,
        changed = false,
        autoSave = $('<span id="auto-save-message" class="left"></span>').prependTo('.submit'),
        lastSaveTime = null;
        var data = new FormData(form.get(0));
        data.set("text",editor.value());
        var localcid = "<?php echo $cid;?>";
if(localcid == '' && localStorage.getItem('autosavecid') && localStorage.getItem('autosavecid') !== ''){
data.set("cid",localStorage.getItem('autosavecid'));
}
else{
    data.set("cid",localcid);
}
     
        function callback(o) {
toastr.success('已自动保存<br>保存时间:'+o.time);   
localStorage.setItem('autosavecid',o.cid);

        }
                
            data.append('do', 'save');
            
  $.ajax({
                url: formAction,
                processData: false,
                contentType: false,
                type: 'POST',
                data: data,
                success: callback
            });    
   },15000); 
   <?php endif; ?>
}
            
                setTimeout(function() {
                var buttons = $(".autosaves");
                buttons.click();
            }, 2000);
            
           function confirmEnding(str, target) {
  var start = str.length-target.length;
  var arr = str.substr(start,target.length);
  if(arr == ".jpg" || arr == ".jpeg" || arr == ".png" || arr == ".gif"){
    return '1';
  }
 return '2';
}

            setTimeout(function() {
                var button = $(".insertper");
                button.click();
            }, 2000);
        function insertper (editor) {
  $('#file-list').on('mousedown', '.insert', function(){
      var s=$(this).parents("li").data('url');
var name = '.'+ s.substring(s.lastIndexOf(".")+1);
   var end = confirmEnding(s, name);
   if(end == '1'){
        var filenames="!["+$(this).parents("li").data('cid')+"]["+$(this).parents("li").data('cid')+"]\n";
   }
   else{
       var filenames="["+$(this).parents("li").data('cid')+"]["+$(this).parents("li").data('cid')+"]\n";
   }
	    var fileurls="\n  ["+$(this).parents("li").data('cid')+"]: "+$(this).parents("li").data('url');
                 editor.codemirror.doc.replaceSelection(filenames + fileurls); 
});
    }

             function attachInsertEvent (editor) {
                 function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getAttachFile(); ?>",
                        data: {
                            "cid": "<?php echo $cid; ?>",
                             "url": "<?php echo $url; ?>",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            content(json.list);
                        },
                        complete: function() {
                        },
                        error: function() {
                            alert("数据获取错误");
                        }
                    });
                }
                getData();
                function content(list) {
                    var filename = " ";
                    var fileurl = " ";
                    for(var i in list) {
                        if(list[i]['type'] == 'img'){
                        filename += '![' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
                        if(list[i]['type'] == 'other'){
                        filename += '[' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
}
editor.codemirror.doc.replaceSelection(filename + fileurl);
}
    }
    function iframe(editor){
    editor.codemirror.doc.replaceSelection('{bs-iframe}iframe地址，可为video等{/bs-iframe}'); 
            }
            function githubcard(editor){
    editor.codemirror.doc.replaceSelection('[bsgit user="Github仓库拥有者，如whitebearcode"]Github项目名，如typecho-bearsimple[/bsgit]'); 
            }
            function hide(editor){
    editor.codemirror.doc.replaceSelection('[bshide]隐藏内容[/bshide]'); 
            }
            function gallery(editor){
    editor.codemirror.doc.replaceSelection('[bsgallery title="相册名"]\n[bsimg title="图片标题1" subtitle="图片子标题1"]图片地址1[/bsimg]\n[bsimg title="图片标题2" subtitle="图片子标题2"]图片地址2[/bsimg]\n[bsimg title="图片标题3" subtitle="图片子标题3"]图片地址3[/bsimg]\n[/bsgallery]'); 
            }
            function login(editor){
    editor.codemirror.doc.replaceSelection('[bslogin]隐藏内容[/bslogin]'); 
            }
            function audio(editor){
    editor.codemirror.doc.replaceSelection('[bsaudio]音频地址[/bsaudio]'); 
            }
            function accord1(editor){
    editor.codemirror.doc.replaceSelection('{bs-accord style=line title=线性手风琴标题}线性手风琴内容{/bs-accord}'); 
            }
            function accord2(editor){
    editor.codemirror.doc.replaceSelection('{bs-accord style=common title=普通手风琴标题}普通手风琴内容{/bs-accord}'); 
            }
            function quotepost(editor){
    editor.codemirror.doc.replaceSelection('[bspost cid="文章CID"]'); 
            }
            function postmark(editor){
    editor.codemirror.doc.replaceSelection('[bsmark]要标注的内容[/bsmark]'); 
            }
            function postruby(editor){
    editor.codemirror.doc.replaceSelection('[bsruby]要带拼音的汉字[/bsruby]'); 
            }
             function todolist1(editor){
    editor.codemirror.doc.replaceSelection('{bs-todo type=true}已完成的内容{/bs-todo}'); 
            }
             function todolist2(editor){
    editor.codemirror.doc.replaceSelection('{bs-todo type=false}未完成的内容{/bs-todo}'); 
            }



function button(editor){
         Swal.fire({
  title: '第一步 选择按钮样式',
  input: 'select',
  inputOptions: {
      'common': '普通按钮',
      'basic': '光圈按钮',
      'animated': '动画按钮',
  },
  inputPlaceholder: '选择一款按钮',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择按钮颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写按钮点击链接',
  input: 'url',
  inputLabel: '按钮点击跳转链接',
  inputPlaceholder: '填写按钮点击跳转链接，需带http(s)://',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写按钮名称',
  input: 'text',
  inputLabel: '按钮名称(若为动画按钮，两个名称请使用|隔开)',
  inputPlaceholder: '请填写按钮名称',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写按钮名称'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写按钮图标名',
  input: 'text',
  inputLabel: '按钮图标名(若不需要图标可留空)',
  'html':'<a href="https://icon.bearlab.eu/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写按钮图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsbtn type="'+valueone+'" color="'+valuetwo+'" url="'+valuethree+'"'+icon+']'+valuefour+'[/bsbtn]';
      editor.codemirror.doc.replaceSelection(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写跳转链接~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款按钮~~') 
      }
    })
  }
})

      }
      
      function progress(editor){
         Swal.fire({
  title: '选择进度条颜色',
  input: 'select',
  inputOptions: {
       'normal':'蓝色',
      'success': '绿色',
      'info': '青色',
      'warning': '黄色',
      'danger': '红色',
      'light': '白色',
      'dark': '黑色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {
      
      Swal.fire({
      title: '第二步 填写进度条标题',
  input: 'text',
  inputLabel: '进度条标题[将显示在进度条上方]',
  inputPlaceholder: '填写进度条标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
             Swal.fire({
      title: '第三步 填写进度条数值',
  input: 'text',
  inputLabel: '进度条数值[如40%就填写40]',
  inputPlaceholder: '填写进度条数值',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
                var text = '[bsprog color="'+valueone+'" number="'+valuethree+'"]'+valuetwo+'[/bsprog]';
      editor.codemirror.doc.replaceSelection(text);
    resolve()
      }
      else{
       resolve('您必须填写进度条数值~')    
      }
    })
  }
})
    resolve()
      }
      else{
       resolve('您必须填写进度条标题~')    
      }
    })
  }
})
      
      
      
      
      } 
      else{
         resolve('您必须选择一款颜色~') 
      }
    })
  }
})

      }
      
      function message(editor){
         Swal.fire({
  title: '第一步 选择提示框样式',
  input: 'select',
  inputOptions: {
      'common': '普通提示框',
      'basic': '阴影提示框',
      'commonclose': '普通可关闭提示框',
      'basicclose':'阴影可关闭提示框',
  },
  inputPlaceholder: '选择一款提示框',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择提示框颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'info':'淡青色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写提示框标题',
  input: 'text',
  inputLabel: '提示框标题',
  inputPlaceholder: '填写提示框标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写提示框内容',
  input: 'textarea',
  inputLabel: '提示框内容',
  inputPlaceholder: '请填写提示框内容',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写提示框内容'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写提示框图标名',
  input: 'text',
  inputLabel: '提示框图标名(若不需要图标可留空)',
  'html':'<a href="https://icon.bearlab.eu/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写提示框图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsmessage type="'+valueone+'" color="'+valuetwo+'" title="'+valuethree+'"'+icon+']'+valuefour+'[/bsmessage]';
      editor.codemirror.doc.replaceSelection(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写提示框标题~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款提示框~~') 
      }
    })
  }
})

      }
      
       function colorpc(editor){
       Swal.fire({
  title: '字体颜色选择器面板',
  html: "<div id=\"color\"></div><br>选择完颜色后点击下面的直接插入按钮进行应用，本功能实现的效果仅在前台文章内页可见。",
  icon: 'info',
showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: "取消", 
  confirmButtonText: '直接插入'
}).then((result) => {
  if (result.isConfirmed) {
  var colorss = document.getElementById("colors").value;
  if(!colorss){
      alert('未选择颜色，不能直接插入!');
  }
  else{
    editor.codemirror.doc.replaceSelection('{bs-font color="'+ colorss + '"}内容{/bs-font}');
  }
  }
})
       $('#color').colorpicker({
        popover: false,
        inline: true,
        container: '#color',
template: '<div class="colorpicker">' +
          '<div class="colorpicker-saturation"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-hue"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-alpha">' +
          '   <div class="colorpicker-alpha-color"></div>' +
          '   <i class="colorpicker-guide"></i>' +
          '</div>' +
          '<div class="colorpicker-bar">' +
          '   <div class="input-group">' +
          '       <input id="colors" class="form-control input-block color-io" />' +
          '   </div>' +
          '</div>' +
          '</div>'
        })
        .on('colorpickerCreate', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          io.val(e.color.string());
          io.on('change keyup', function () {
            e.colorpicker.setValue(io.val());
          });
        })
        .on('colorpickerChange', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          if (e.value === io.val() || !e.color || !e.color.isValid()) {
            return;
          }
          io.val(e.color.string());
        });
       }
       $(document).ready(function() {
               $(".insertper").attr("style","display:none;");
               $(".autosaves").attr("style","display:none;");
               localStorage.setItem('autosavecid','');
        
       });
     

      
        </script>
   
      
        <?php
    }
}
}