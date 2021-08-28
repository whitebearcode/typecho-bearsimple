<?php
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
                        placeholder:'随心创作，简洁无极限~',
                        path: 'https://cdn.jsdelivr.net/gh/pandao/editor.md/lib/',
                        toolbarAutoFixed: false,
                        htmlDecode: true,
                        tex: true,
                        saveHTMLToTextarea : true,
                        searchReplace : true,
                        watch : false,
                        toc: true,
                        tocm: true,
                        codeFold : true,
                        taskList: true,
                        flowChart: true,
                        sequenceDiagram: true,
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