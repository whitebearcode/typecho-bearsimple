<?php
if($options->Editors == '2'){
    Typecho_Plugin::factory('admin/write-post.php')->bottom = array('editor', 'button');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('editor', 'button');
class editor
{
    public static function button(){
		Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-colorpicker@3.4.0/dist/css/bootstrap-colorpicker.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-colorpicker@3.4.0/dist/js/bootstrap-colorpicker.min.js"></script>
		<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-hfkj-button" title="回复可见"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-commenting"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-hfkj-button').click(function(){
						var rs = "{bs-hide}隐藏内容{/bs-hide}";
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
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-fujian-button" title="插入所有附件"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-paperclip"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-fujian-button').click(function(){
                 function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getAttachFile(); ?>",
                        data: {
                            "cid": "<?php echo $cid; ?>",
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
                        filename += '![' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
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
        $cssUrl = 'https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css';
        $jsUrl = 'https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js';
Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
if (isset($post) || isset($page)) {
    $cid = isset($post) ? $post->cid : $page->cid;
    
    if ($cid) {
        Typecho_Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $cid)->to($attachment);
    } else {
        Typecho_Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
}

        ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css" />
        <script type="text/javascript" src="<?php echo $jsUrl; ?>"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-colorpicker@3.4.0/dist/css/bootstrap-colorpicker.min.css" />
  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap-colorpicker@3.4.0/dist/js/bootstrap-colorpicker.min.js"></script>

        <script>
            $(document).ready(function() {
      
                new EasyMDE({
        autoDownloadFontAwesome: false,
        showIcons: ['strikethrough', 'code', 'table', 'redo', 'heading', 'undo', 'heading-bigger', 'heading-smaller', 'heading-1', 'heading-2', 'heading-3', 'clean-block', 'horizontal-rule','side-by-side'],
        autosave: {
            enabled: true,
            delay: 1000,
            uniqueId: 'text',
            timeFormat:{locale:'zh-CN'},
            text:'自动保存时间：'
        },
        toolbar: [ { name: "bold", action:EasyMDE.toggleBold, className: "fa fa-bold",title: "加粗"}, { name: "italic", action:EasyMDE.toggleItalic, className: "fa fa-italic",title: "字体倾斜"}, { name: "strikethrough", action:EasyMDE.toggleStrikethrough, className: "fa fa-strikethrough",title: "删除线"},{ name: "heading-smaller", action:EasyMDE.toggleHeadingSmaller, className: "fa fa-header",title: "字体缩小"}, { name: "heading-bigger", action:EasyMDE.toggleHeadingBigger, className: "fa fa-header",title: "字体放大"},{ name: "heading-1", action:EasyMDE.toggleHeading1, className: "fa fa-header header-1",title: "H1字号"},{ name: "heading-2", action:EasyMDE.toggleHeading2, className: "fa fa-header header-2",title: "H2字号"},{ name: "heading-3", action:EasyMDE.toggleHeading3, className: "fa fa-header header-3",title: "H3字号"}, { name: "code", action:EasyMDE.toggleCodeBlock, className: "fa fa-code",title: "代码"}, { name: "quote", action:EasyMDE.toggleBlockquote, className: "fa fa-quote-left",title: "引用"}, { name: "unordered-list", action:EasyMDE.toggleUnorderedList, className: "fa fa-list-ul",title: "无序列表"}, { name: "ordered-list", action:EasyMDE.toggleOrderedList, className: "fa fa-list-ol",title: "有序列表"}, { name: "clean-block", action:EasyMDE.cleanBlock, className: "fa fa-eraser",title: "擦除代码块"}, { name: "link", action:EasyMDE.drawLink, className: "fa fa-link",title: "插入链接"}, { name: "image", action:EasyMDE.drawImage, className: "fa fa-picture-o",title: "插入图片"}, '|', { name: "table", action:EasyMDE.drawTable, className: "fa fa-table",title: "插入表格"}, { name: "color", className: "fa fa-font", action:colorpc,title: "字体颜色选择器"},{ name: "iframe", className: "fa fa-window-maximize", action:iframe,title: "插入iframe"},{ name: "hide", className: "fa fa-commenting", action:hide,title: "回复可见"},{ name: "inserts", className: "fa fa-paperclip", action:attachInsertEvent,title: "插入所有附件"},{ name: "insertper", className: "fa fa-paperclip", action:insertper,title: "插入单个附件"},{ name: "todolist1", className: "fa fa-check-square", action:todolist1,title: "已完成列表"},{ name: "todolist2", className: "fa fa-square", action:todolist2,title: "未完成列表"},{ name: "preview", action:EasyMDE.togglePreview, className: "fa fa-eye no-disable",title: "预览"}, { name: "side-by-side", action:EasyMDE.toggleSideBySide, className: "fa fa-columns no-disable no-mobile",title: "所见即所得"}, { name: "fullscreen", action:EasyMDE.toggleFullScreen, className: "fa fa-arrows-alt no-disable no-mobile",title: "全屏"}, '|', ],
        lineNumbers:false,
        promptURLs:true,
        promptTexts:{
            image:"请填写图片直链",
            link:"请填写网址链接",
        },
        element: document.getElementById('text'),
    });
            });
           
            setTimeout(function() {
                var button = $(".insertper");
                button.click();
            }, 2000);
        function insertper (editor) {
  $('#file-list').on('mousedown', '.insert', function(){
        var filenames="!["+$(this).parents("li").data('cid')+"]["+$(this).parents("li").data('cid')+"]\n";
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
                        filename += '![' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
editor.codemirror.doc.replaceSelection(filename + fileurl);
}
    }
    function iframe(editor){
    editor.codemirror.doc.replaceSelection('{bs-iframe}iframe地址，可为video等{/bs-iframe}'); 
            }
            function hide(editor){
    editor.codemirror.doc.replaceSelection('{bs-hide}隐藏内容{/bs-hide}'); 
            }
             function todolist1(editor){
    editor.codemirror.doc.replaceSelection('{bs-todo type=true}已完成的内容{/bs-todo}'); 
            }
             function todolist2(editor){
    editor.codemirror.doc.replaceSelection('{bs-todo type=false}未完成的内容{/bs-todo}'); 
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
       });
        </script>
   
      
        <?php
    }
}
}