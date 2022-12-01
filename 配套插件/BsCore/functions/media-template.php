<?php

/**
 * Prints the templates used in the media manager.
 *
 * @since 3.5.0
 */


if (!defined('MEDIA_TRASH')) {
    define('MEDIA_TRASH', false);
}
if (class_exists('Widget\Base\Contents')){
    require_once 'Attachments.php';
}

if (!function_exists('wp_print_media_templates')) {
    function wp_print_media_templates()
    {

        ?>

        <?php // Template for the media frame: used both in the media grid and in the media modal.
        $attachments = Attachments::alloc();

        ?>
        <div id="__wp-uploader" style="position: relative; display: none;"
             class="supports-drag-drop media-modal wp-core-ui">
            <div tabindex="0" class="media-modal wp-core-ui" role="dialog" aria-labelledby="media-frame-title">
                <button type="button" class="media-modal-close"><span class="media-modal-icon"><span
                            class="screen-reader-text">关闭</span></span></button>
                <div class="media-modal-content" role="document">
                    <div class="media-frame mode-select wp-core-ui hide-menu" id="__wp-uploader-id-1">
                        <div class="media-frame-title" id="media-frame-title"><h1>媒体</h1></div>
                        <h2 class="media-frame-menu-heading">Actions</h2>
                        <button type="button" class="button button-link media-frame-menu-toggle" aria-expanded="false">
                            Menu <span class="dashicons dashicons-arrow-down" aria-hidden="true"></span>
                        </button>
                        <div class="media-frame-menu">
                            <div role="tablist" aria-orientation="vertical" class="media-menu">
                                <button type="button" role="tab" class="media-menu-item active" id="menu-item-library"
                                        aria-selected="true">媒体
                                </button>
                            </div>
                        </div>
                        <div class="media-frame-tab-panel">
                            <div class="media-frame-router">
                                <div role="tablist" aria-orientation="horizontal" class="media-router">
                                    <button type="button" role="tab" class="media-menu-item active"
                                            id="menu-item-upload"
                                            aria-selected="false" tabindex="-1">上传
                                    </button>
                                    <button type="button" role="tab" class="media-menu-item" id="menu-item-browse"
                                            aria-selected="true">媒体库
                                    </button>
                                </div>
                            </div>
                            <div id="menu-item-upload-tab" class="media-frame-content" data-columns="10" role="tabpanel"
                                 aria-labelledby="menu-item-upload" tabindex="0">
                                <div class="uploader-inline">
                                    <div class="uploader-inline-content no-upload-message">
                                        <?php
                                        $options = Helper::options();
                                        $security = Helper::security();
                                        ?>

                                        <div class="upload-ui">
                                            <h2 class="upload-instructions drop-instructions">拖拽文件上传</h2>
                                            <p class="upload-instructions drop-instructions">或</p>
                                            <button type="button" class="browser button button-hero upload-file"
                                                    style="position: relative; z-index: 1;"
                                                    aria-labelledby="__wp-uploader-id-1 post-upload-info">选择文件
                                            </button>
                                        </div>

                                        <div class="upload-inline-status">
                                            <div class="media-uploader-status" style="display: none;">
                                                <h2>上传中</h2>
                                                <div class="media-progress-bar"></div>
                                                <div class="upload-details">
                                                <span class="upload-count">
                                                    <span class="upload-index"></span> / <span
                                                        class="upload-total"></span>
                                                </span>
                                                    <span class="upload-detail-separator">–</span>
                                                    <span class="upload-filename"></span>
                                                </div>
                                                <div class="upload-errors"></div>
                                                <button type="button" class="button upload-dismiss-errors">忽略错误
                                                </button>
                                            </div>
                                            <ul id="file-list"></ul>
                                        </div>
                                        <div class="post-upload-ui" id="post-upload-info">
                                            <p class="max-upload-size">
                                                最大文件上传大小: <?php
                                                $max_upload_size = wp_max_upload_size();
                                                if (!$max_upload_size) {
                                                    $max_upload_size = 0;
                                                }
                                                echo size_format($max_upload_size);
                                                ?>. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menu-item-browse-tab" style="display: none" class="media-frame-content"
                                 data-columns="10" role="tabpanel"
                                 aria-labelledby="menu-item-browse" tabindex="0">
                                <div class="attachments-browser has-load-more">
                                    <div class="media-toolbar">
                                        <!--                                    <div class="media-toolbar-secondary"><h2 class="media-attachments-filter-heading">-->
                                        <!--                                            Filter media</h2><label for="media-attachment-date-filters"-->
                                        <!--                                                                    class="screen-reader-text">Filter by-->
                                        <!--                                            date</label><select id="media-attachment-date-filters"-->
                                        <!--                                                                class="attachment-filters">-->
                                        <!--                                            <option value="all">All dates</option>-->
                                        <!--                                            <option value="0">January 2022</option>-->
                                        <!--                                        </select><span class="spinner"></span></div>-->
                                        <div class="media-toolbar-primary search-form"><label for="media-search-input"
                                                                                              class="media-search-input-label">搜索</label><input
                                                type="search" id="media-search-input" class="search"></div>
                                    </div>
                                    <h2 class="media-views-heading screen-reader-text">Media list</h2>
                                    <div class="attachments-wrapper">
                                        <?php if ($attachments->have()): ?>
                                            <ul tabindex="-1" class="attachments ui-sortable ui-sortable-disabled">
                                                <?php $img_index = 0;
                                                while ($attachments->next()): ?>
                                                    <li tabindex="0" role="checkbox"
                                                        data-date="<?php $attachments->dateWord(); ?>"
                                                        aria-label="photo-<?php _e($img_index); ?>"
                                                        data-name="<?php $attachments->attachment->name(); ?>"
                                                        aria-checked="false"
                                                        data-id="<?php $attachments->theId(); ?>"
                                                        data-edit="<?php $options->adminUrl('media.php?cid=' . $attachments->cid); ?>"
                                                        class="attachment save-ready">
                                                        <div
                                                            class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img src="<?php $attachments->attachment->url(); ?>"
                                                                         draggable="false"
                                                                         alt="<?php $attachments->attachment->name(); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="check" tabindex="0"><span
                                                                class="media-modal-icon"></span><span
                                                                class="screen-reader-text">Deselect</span></button>
                                                    </li>
                                                    <?php $img_index++;endwhile; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>没有项目。</p>
                                        <?php endif; ?>

                                        <div class="load-more-wrapper"><span class="spinner"></span>
                                            <?php
                                            $currentPage = $attachments->getCurrentPage();
                                            $perPage = $attachments->getPageSize();
                                            if ($attachments->have()): ?>
                                                <p class="load-more-count">显示 <?php echo($attachments->getTotal()); ?>中的
                                                    <?php _e(min($currentPage * $perPage, $attachments->getTotal())); ?>
                                                    个媒体项目</p>
                                            <?php endif; ?>
                                            <button type="button" class="button load-more hidden button-primary"
                                                    data-page="<?php _e($currentPage); ?>"
                                                    data-totalpage="<?php _e($attachments->getTotalPage()); ?>">加载更多
                                            </button>
                                            <button type="button" class="button load-more-jump hidden">跳至首个加载的项目
                                            </button>
                                        </div>
                                        <script>window.ty_media = {
                                                keywords: '',
                                                curpage:<?php _e($currentPage); ?>,
                                                pagesize:<?php _e($perPage); ?>,
                                                total:<?php _e($attachments->getTotal());?>,
                                                totalpage:<?php _e($attachments->getTotalPage());?>}</script>
                                    </div>
                                    <div class="media-sidebar">
                                        <div class="media-uploader-status" style="display: none;">
                                            <h2>Uploading</h2>
                                            <div class="media-progress-bar">
                                                <div></div>
                                            </div>
                                            <div class="upload-details">
                                            <span class="upload-count">
                                                <span class="upload-index"></span> / <span class="upload-total"></span>
                                            </span>
                                                <span class="upload-detail-separator">–</span>
                                                <span class="upload-filename"></span>
                                            </div>
                                            <div class="upload-errors"></div>
                                            <button type="button" class="button upload-dismiss-errors">Dismiss errors
                                            </button>
                                        </div>
                                        <div class="attachment-details save-ready">
                                            <h2>附件信息<span class="settings-save-status" role="status"><span
                                                        class="spinner"></span><span class="saved">Saved.</span></span>
                                            </h2>
                                            <div class="attachment-info">
                                                <div class="thumbnail thumbnail-image">
                                                    <img src="" draggable="false" alt="">
                                                </div>
                                                <div class="details">
                                                    <div class="filename">photo-01.jpg</div>
                                                    <div class="uploaded">January 3, 2022</div>
                                                    <a class="edit-attachment" href="" target="_blank">编辑图片</a>
                                                    <div class="compat-meta"></div>
                                                </div>
                                            </div>
                                            <span class="setting" data-setting="url">
                                            <label for="attachment-details-copy-link" class="name">文件 URL:</label>
                                            <input type="text" class="attachment-details-copy-link"
                                                   id="attachment-details-copy-link" value="" readonly="">
                                            <div class="copy-to-clipboard-container">
                                                <button type="button" class="button button-small copy-attachment-url"
                                                        data-clipboard-target="#attachment-details-copy-link">复制到剪切板</button>
                                                <span class="success hidden" aria-hidden="true">已复制!</span>
                                            </div>
                                        </span>
                                        </div>
                                        <form class="compat-item"></form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="media-frame-actions-heading screen-reader-text">选择媒体动作</h2>
                        <div class="media-frame-toolbar">
                            <div class="media-toolbar">
                                <div class="media-toolbar-secondary"></div>
                                <div class="media-toolbar-primary search-form">
                                    <button type="button"
                                            class="button media-button button-primary button-large media-button-select">
                                        选择
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media-modal-backdrop"></div>
        </div>
        <script src="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/clipboard.js/2.0.10/clipboard.min.js"
                type="application/javascript"></script>
        <script src="<?php $options->adminStaticUrl('js', 'moxie.js'); ?>"></script>
        <script src="<?php $options->adminStaticUrl('js', 'plupload.js'); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#menu-item-upload-tab').bind({
                    dragenter: function () {
                        $(this).parent().addClass('drag');
                    },
                    dragover: function (e) {
                        $(this).parent().addClass('drag');
                    },
                    drop: function () {
                        $(this).parent().removeClass('drag');
                    },
                    dragend: function () {
                        $(this).parent().removeClass('drag');
                    },
                    dragleave: function () {
                        $(this).parent().removeClass('drag');
                    }
                });

                function fileUploadStart(file) {
                    $('<ul id="file-list"></ul>').appendTo('.upload-inline-status');
                    $('<li id="' + file.id + '" class="loading">'
                        + file.name + '</li>').prependTo('#file-list');
                }

                function fileUploadError(error) {
                    var file = error.file, code = error.code, word;

                    switch (code) {
                        case plupload.FILE_SIZE_ERROR:
                            word = '<?php _e('文件大小超过限制'); ?>';
                            break;
                        case plupload.FILE_EXTENSION_ERROR:
                            word = '<?php _e('文件扩展名不被支持'); ?>';
                            break;
                        case plupload.FILE_DUPLICATE_ERROR:
                            word = '<?php _e('文件已经上传过'); ?>';
                            break;
                        case plupload.HTTP_ERROR:
                        default:
                            word = '<?php _e('上传出现错误'); ?>';
                            break;
                    }

                    var fileError = '<?php _e('%s 上传失败'); ?>'.replace('%s', file.name),
                        li, exist = $('#' + file.id);

                    if (exist.length > 0) {
                        li = exist.removeClass('loading').html(fileError);
                    } else {
                        $('<ul id="file-list"></ul>').appendTo('.upload-inline-status');
                        li = $('<li>' + fileError + '<br />' + word + '</li>').prependTo('#file-list');
                    }

                    li.effect('highlight', {color: '#FBC2C4'}, 2000, function () {
                        $(this).remove();
                    });
                }

                function imageToggleFunc($this, e) {
                    e.preventDefault();
                    var instance = $this;
                    instance.attr('aria-checked', function (index, attr) {
                        return attr !== true;
                    });
                    instance.siblings().attr('aria-checked', false);
                    instance.siblings().removeClass('selected details');
                    instance.toggleClass('selected details');
                    // 附件信息
                    var info = $('.attachment-info')
                    info.find('.thumbnail img').attr('src', instance.find('img').attr('src'))
                    info.find('.details .filename').text(instance.data('name'))
                    info.find('.details .uploaded').text(instance.data('date'))
                    info.find('.details .edit-attachment').attr('href', instance.data('edit'))
                    $('#attachment-details-copy-link').val(instance.find('img').attr('src'))
                    window.cur_media_select_instance = instance
                }

                function fileUploadComplete(id, url, data) {

                    $('#' + id).html('<?php _e('文件 %s 已经上传'); ?>'.replace('%s', data.title))
                        .effect('highlight', 2000, function () {
                            $(this).remove();
                            $('#file-list').remove();
                        });
                    $('#menu-item-browse').click();
                    var eachImg = $(".attachments-wrapper .attachments li")
                    eachImg.attr('aria-checked', false);
                    eachImg.removeClass('selected details');
                    var html = `<li tabindex="0" role="checkbox" aria-label="photo-09" aria-checked="true" data-id="${id}" class="attachment save-ready selected details"><div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape"><div class="thumbnail"><div class="centered"><img src="${url}" draggable="false" alt=""></div></div></div><button type="button" class="check" tabindex="-1"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button></li>`
                    $('.attachments-wrapper .attachments').prepend(html);
                    // rebind
                    rebind_imgs_click()
                    window.cur_media_select_instance = $('.attachments-wrapper ul li').eq(1) //默认选择第一个
                }

                var uploader = new plupload.Uploader({
                    browse_button: $('.upload-file').get(0),
                    url: '<?php $security->index('/action/upload'); ?>',
                    runtimes: 'html5,flash,html4',
                    flash_swf_url: '<?php $options->adminStaticUrl('js', 'Moxie.swf'); ?>',
                    drop_element: $('#menu-item-upload-tab').get(0),
                    filters: {
                        max_file_size: '<?php echo size_format($max_upload_size); ?>',
                        mime_types: [{
                            'title': '<?php _e('允许上传的文件'); ?>',
                            'extensions': '<?php echo(implode(',', getAttachmentTypes())); ?>'
                        }],
                        prevent_duplicates: true
                    },
                    multi_selection: false,

                    init: {
                        FilesAdded: function (up, files) {
                            plupload.each(files, function (file) {
                                fileUploadStart(file);
                            });

                            uploader.start();
                        },

                        FileUploaded: function (up, file, result) {
                            if (200 == result.status) {
                                var data = $.parseJSON(result.response);
                                if (data) {
                                    fileUploadComplete(file.id, data[0], data[1]);
                                    return;
                                }
                            }

                            fileUploadError({
                                code: plupload.HTTP_ERROR,
                                file: file
                            });
                        },

                        Error: function (up, error) {
                            fileUploadError(error);
                        }
                    }
                });
                uploader.init();

                //
                function rebind_imgs_click() {
                    $(".attachments-wrapper .attachments li").unbind('click').bind('click', function (e) {
                        imageToggleFunc($(this), e)
                    })
                }

                var ty_loadmore = $('.button.load-more');
                var ty_loadmore_jump = $('.button.load-more-jump');
                var ty_media_search = $('#media-search-input');

                function check_ty_loadmore_show() {
                    if (window.ty_media.curpage * window.ty_media.pagesize < window.ty_media.total) {
                        ty_loadmore.text('加载更多')
                        ty_loadmore.show();
                    } else {
                        ty_loadmore.text('加载完成')
                    }
                    if (window.ty_media.curpage > 1) {
                        ty_loadmore_jump.show();
                    }
                }

                function ty_loadmore_event_init() {
                    ty_loadmore.on('click', function (e) {
                        if (window.ty_media.curpage >= window.ty_media.totalpage) {
                            return
                        }
                        var query;
                        if (window.ty_media.keywords) {
                            query = $.query.set('page', window.ty_media.curpage + 1).set('keywords', window.ty_media.keywords).toString();
                        } else {
                            query = $.query.set('page', window.ty_media.curpage + 1).toString()
                        }

                        var url = location.origin + location.pathname + query;
                        $.get(url, function (res) {
                            var imgs = $('.attachments-wrapper ul', $(res)).html()
                            if (imgs) {
                                $('.attachments-wrapper ul').append(imgs)
                                rebind_imgs_click()
                                window.ty_media.curpage = window.ty_media.curpage + 1
                                check_ty_loadmore_show()
                                $('.load-more-count').html($('.load-more-count', $(res)).html())
                            }

                        })
                    })
                    ty_loadmore_jump.on('click', function (e) {
                        $('.attachments-wrapper ul li').eq(1).focus()
                    })
                    ty_media_search.on('keypress', function (e) {
                        if (e.key === "Enter") {
                            var keywords = ty_media_search.val()
                            var url = location.origin + location.pathname + $.query.set('page', 1).set('keywords', keywords);
                            $.get(url, function (res) {
                                var imgs = $('.attachments-wrapper ul', $(res)).html()
                                if (imgs) {
                                    $('.attachments-wrapper ul').html(imgs)
                                    rebind_imgs_click()
                                    window.ty_media.curpage = 1
                                    window.ty_media.keywords = keywords
                                    check_ty_loadmore_show()
                                    $('.load-more-count').html($('.load-more-count', $(res)).html())
                                    window.ty_media.curpage = $('.load-more-wrapper .button.load-more', $(res)).data('page')
                                    window.ty_media.totalpage = $('.load-more-wrapper .button.load-more', $(res)).data('totalpage')
                                } else {
                                    window.ty_media.keywords = ''
                                }
                                check_ty_loadmore_show()
                            })
                        }
                    })
                }

                function clipboardInit() {
                    var clipboard = new ClipboardJS('.copy-attachment-url'),
                        successTimeout;

                    clipboard.on('success', function (event) {
                        var triggerElement = $(event.trigger),
                            successElement = $('.success', triggerElement.closest('.copy-to-clipboard-container'));

                        // Clear the selection and move focus back to the trigger.
                        event.clearSelection();
                        // Handle ClipboardJS focus bug, see https://github.com/zenorocha/clipboard.js/issues/680
                        triggerElement.trigger('focus');

                        // Show success visual feedback.
                        clearTimeout(successTimeout);
                        successElement.removeClass('hidden');

                        // Hide success visual feedback after 3 seconds since last success.
                        successTimeout = setTimeout(function () {
                            successElement.addClass('hidden');
                        }, 3000);

                    });
                }

                function select_func_init() {
                    $('.media-toolbar .media-button-select').on('click', function (e) {
                        if (window.cur_media_click_instance && window.cur_media_select_instance) { // in main.js
                            var input_ele = window.cur_media_click_instance.siblings('input')
                            var parent = window.cur_media_click_instance.parent()
                            var img_url = window.cur_media_select_instance.find('img').attr('src')
                            input_ele.val(img_url)
                            $('#__wp-uploader').toggle()
                            var preview = parent.prev()
                            if (preview.hasClass('csf--preview')) {
                                preview.find('img').attr('src', img_url)
                                preview.removeClass('hidden')
                            }
                        }
                    })
                }

                rebind_imgs_click()
                check_ty_loadmore_show()
                ty_loadmore_event_init()
                select_func_init()
                clipboardInit()

            });
        </script>
        <?php


    }
}
