<?php
if($options->Editors == '2'){
    Typecho_Plugin::factory('admin/write-post.php')->bottom = array('editor', 'button');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('editor', 'button');
class editor
{
    public static function button(){
		?><style>.wmd-button-row {
    height: auto;
}</style>

		<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-hfkj-button" title="回复可见"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><svg t="1631542611669" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4626" width="16" height="16"><path d="M850.858667 254.72c103.936 71.68 173.226667 168.362667 173.141333 257.109333 0 165.888-251.989333 365.909333-512 365.909334-80.213333 0-160.426667-19.541333-232.704-51.456l55.04-55.04c53.76 20.565333 113.578667 33.28 177.664 33.28 257.877333 0 438.869333-199.253333 438.869333-292.693334 0-54.357333-56.576-140.117333-152.405333-204.714666zM512 146.346667c69.973333 0 139.093333 13.909333 202.752 37.632l-56.746667 56.746666A509.269333 509.269333 0 0 0 512 219.392C261.461333 219.392 73.130667 415.146667 73.130667 511.829333c0 49.066667 48.213333 123.562667 128.512 185.173334l-52.309334 52.309333C59.221333 679.765333 0 592.042667 0 511.829333 0 345.6 256.085333 146.261333 512 146.261333z" p-id="4627"></path><path d="M675.498667 430.165333A182.869333 182.869333 0 0 1 430.08 675.584zM512 329.130667c17.493333 0 34.474667 2.474667 50.517333 7.082666L336.128 562.346667A183.04 183.04 0 0 1 512 329.130667zM840.192 101.546667a42.666667 42.666667 0 0 1 65.28 54.442666l-4.949333 5.973334-724.053334 724.053333a42.666667 42.666667 0 0 1-65.28-54.442667l4.949334-5.973333L840.192 101.546667z" p-id="4628"></path></svg></span></li>');
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
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-todocheck-button" title="打勾已完成"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><svg t="1631543018887" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5633" width="16" height="16"><path d="M128 85.333333h768a42.666667 42.666667 0 0 1 42.666667 42.666667v768a42.666667 42.666667 0 0 1-42.666667 42.666667H128a42.666667 42.666667 0 0 1-42.666667-42.666667V128a42.666667 42.666667 0 0 1 42.666667-42.666667z m42.666667 85.333334v682.666666h682.666666V170.666667H170.666667z m122.154666 262.869333a21.333333 21.333333 0 0 1 30.165334 0.106667l126.378666 127.296 251.050667-233.877334a21.333333 21.333333 0 0 1 30.165333 1.066667l29.077334 31.210667a21.333333 21.333333 0 0 1-1.066667 30.144L462.165333 665.642667a21.333333 21.333333 0 0 1-29.674666-0.576l-170.048-171.306667a21.333333 21.333333 0 0 1 0.106666-30.165333l30.293334-30.08z" p-id="5634"></path></svg></span></li>');
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
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-todonotcheck-button" title="打叉未完成"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><svg t="1631543115096" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="7147" width="16" height="16"><path d="M768 102.4H256C168.96 102.4 102.4 168.96 102.4 256v512c0 87.04 66.56 153.6 153.6 153.6h512c87.04 0 153.6-66.56 153.6-153.6V256c0-87.04-66.56-153.6-153.6-153.6z m51.2 665.6c0 30.72-20.48 51.2-51.2 51.2H256c-30.72 0-51.2-20.48-51.2-51.2V256c0-30.72 20.48-51.2 51.2-51.2h512c30.72 0 51.2 20.48 51.2 51.2v512z" p-id="7148"></path></svg></span></li>');
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
        $cssUrl = 'https://cdn.jsdelivr.net/gh/pandao/editor.md/css/editormd.min.css';
        $jsUrl = 'https://cdn.jsdelivr.net/gh/pandao/editor.md/editormd.min.js';
        ?>
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>" />
        <script>
            var emojiPath = '<?php echo $options->pluginUrl; ?>';
            var uploadURL = '<?php Helper::security()->index('/action/upload?cid=CID'); ?>';
        </script>
        <script type="text/javascript" src="<?php echo $jsUrl; ?>"></script>
        <script>
            $(document).ready(function() {

                var textarea = $('#text').parent("p");
                var isMarkdown = $('[name=markdown]').val()?1:0;
                if (!isMarkdown) {
                    var notice = $('<div class="message notice"><?php _e('本文Markdown解析已禁用！'); ?> '
                        + '<button class="btn btn-xs primary yes"><?php _e('启用'); ?></button> '
                        + '<button class="btn btn-xs no"><?php _e('保持禁用'); ?></button></div>')
                        .hide().insertBefore(textarea).slideDown();

                    $('.yes', notice).click(function () {
                        notice.remove();
                        $('<input type="hidden" name="markdown" value="1" />').appendTo('.submit');
                    });

                    $('.no', notice).click(function () {
                        notice.remove();
                    });
                }
                    $('#text').wrap("<div id='text-editormd'></div>");
                    postEditormd = editormd("text-editormd", {
                        width: "100%",
                        height: 640,
                        editorTheme: "default",
                        placeholder:'随心创作，简洁无极限~',
                        path: 'https://cdn.jsdelivr.net/gh/pandao/editor.md/lib/',
                        toolbarAutoFixed: true,
                        htmlDecode: true,
                        tex: true,
                        atLink: true,
                        emailLink: true,
                        saveHTMLToTextarea : true,
                        searchReplace : true,
                        autoHeight : false,
                        watch : false,
                        toc: true,
                        gotoLine: true, 
                        styleActiveLine: true, 
                        tocm: true,
                        codeFold : true,
                        taskList: true,
                        flowChart: true,
                        sequenceDiagram: true,
                        styleSelectedText: true,
                        toolbarIcons: function () {
                            return ["undo", "redo", "|", "bold", "del", "italic", "quote", "h1", "h2", "h3", "h4", "h5", "h6", "|", "list-ul", "list-ol", "hr", "|", "link", "reference-link", "image", "code", "preformatted-text", "code-block", "table", "datetime", "html-entities", "more", "|", "goto-line", "watch", "preview", "fullscreen", "clear",  "|", "isMarkdown"]
                        },
                        toolbarIconsClass: {
                            more: "fa-newspaper-o",
                            isMarkdown: "fa-power-off fun"
                        },
                        toolbarHandlers: {

                            more: function (cm, icon, cursor, selection) {
                                cm.replaceSelection("<!--more-->");
                            },
                            isMarkdown: function (cm, icon, cursor, selection) {
                                if(!$("div.message.notice").html()){
                                var isMarkdown = $('[name=markdown]').val()?$('[name=markdown]').val():0;
                                if (isMarkdown==1) {
                                    var notice = $('<div class="message notice"><?php _e('本文Markdown解析已启用！'); ?> '
                                        + '<button class="btn btn-xs no"><?php _e('禁用'); ?></button> '
                                        + '<button class="btn btn-xs primary yes"><?php _e('保持启用'); ?></button></div>')
                                        .hide().insertBefore(textarea).slideDown();

                                    $('.yes', notice).click(function () {
                                        notice.remove();
                                    });

                                    $('.no', notice).click(function () {
                                        notice.remove();
                                        $("[name=markdown]").val(0);
                                        postEditormd.unwatch();
                                    });
                                } else {
                                    var notice = $('<div class="message notice"><?php _e('本文Markdown解析已禁用！'); ?> '
                                        + '<button class="btn btn-xs primary yes"><?php _e('启用'); ?></button> '
                                        + '<button class="btn btn-xs no"><?php _e('保持禁用'); ?></button></div>')
                                        .hide().insertBefore(textarea).slideDown();

                                    $('.yes', notice).click(function () {
                                        notice.remove();
                                        postEditormd.watch();
                                        if(!$("[name=markdown]").val())
                                            $('<input type="hidden" name="markdown" value="1" />').appendTo('.submit');
                                        else
                                            $("[name=markdown]").val(1);
                                    });

                                    $('.no', notice).click(function () {
                                        notice.remove();
                                    });
                                }
                            }
                            }
                        },
                        lang: {
                            toolbar: {
                                more: "插入摘要分隔符",
                                isMarkdown: "非Markdown模式"
                            }
                        },
                    });
                    Typecho.insertFileToEditor = function (file, url, isImage) {
                        html = isImage ? '![' + file + '](' + url + ')'
                            : '[' + file + '](' + url + ')';
                        postEditormd.insertValue(html);
                    };
                    $(document).on('paste', function(event) {
                        event = event.originalEvent;
                        var cbd = event.clipboardData;
                        var ua = window.navigator.userAgent;
                        if (!(event.clipboardData && event.clipboardData.items)) {
                            return;
                        }

                        if (cbd.items && cbd.items.length === 2 && cbd.items[0].kind === "string" && cbd.items[1].kind === "file" &&
                            cbd.types && cbd.types.length === 2 && cbd.types[0] === "text/plain" && cbd.types[1] === "Files" &&
                            ua.match(/Macintosh/i) && Number(ua.match(/Chrome\/(\d{2})/i)[1]) < 49){
                            return;
                        }

                        var itemLength = cbd.items.length;

                        if (itemLength == 0) {
                            return;
                        }

                        if (itemLength == 1 && cbd.items[0].kind == 'string') {
                            return;
                        }

                        if ((itemLength == 1 && cbd.items[0].kind == 'file')
                                || itemLength > 1
                            ) {
                            for (var i = 0; i < cbd.items.length; i++) {
                                var item = cbd.items[i];

                                if(item.kind == "file") {
                                    var blob = item.getAsFile();
                                    if (blob.size === 0) {
                                        return;
                                    }
                                    var ext = 'jpg';
                                    switch(blob.type) {
                                        case 'image/jpeg':
                                        case 'image/pjpeg':
                                            ext = 'jpg';
                                            break;
                                        case 'image/png':
                                            ext = 'png';
                                            break;
                                        case 'image/gif':
                                            ext = 'gif';
                                            break;
                                    }
                                    var formData = new FormData();
                                    formData.append('blob', blob, Math.floor(new Date().getTime() / 1000) + '.' + ext);
                                    var uploadingText = '![图片上传中(' + i + ')...]';
                                    var uploadFailText = '![图片上传失败(' + i + ')]'
                                    postEditormd.insertValue(uploadingText);
                                    $.ajax({
                                        method: 'post',
                                        url: uploadURL.replace('CID', $('input[name="cid"]').val()),
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function(data) {
                                            if (data[0]) {
                                                postEditormd.setValue(postEditormd.getValue().replace(uploadingText, '![](' + data[0] + ')'));
                                            } else {
                                                postEditormd.setValue(postEditormd.getValue().replace(uploadingText, uploadFailText));
                                            }
                                        },
                                        error: function() {
                                            postEditormd.setValue(postEditormd.getValue().replace(uploadingText, uploadFailText));
                                        }
                                    });
                                }
                            }

                        }

                    });

            });
        </script>
        <?php
    }
}
}