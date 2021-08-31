/**
 * layAway.js弹窗插件
 * @author Mr.Liu
 * Email:547720744@qq.com
 * Version:  pro 1.0x
 */
;(function($){
    lay = function (list) {
        var options = {
            title: '',// 标题
            content: ' ',// 内容
            icon: '',// 图标
            type: 'msg',// 弹窗类型 msg,load,obj
            delayTime: 2000,// 自动关闭时间
            autoClose: true,// 自动关闭
            closeOther: false,// 是否关闭其他弹层,对图片弹层无效
            swiper: true,// 图片的上下翻页，只对图片层生效
            pagination: true,// 分页器
            loop: true,// 是否开启环路
            onMouse: true,// 鼠标滚轮控制
            before: function () {// 回调
                console.log('before')
            },
            close: function (obj, layType) {// 关闭弹窗
                if (obj.parents(".lay-wrap").hasClass("lay-image-main")) {
                    obj.parents(".lay-wrap").remove();
                } else {
                    $(".lay-msg-main").remove();
                    $(".lay-load-main").remove();
                }
                return false;
            }
        }
        for (var i in options) {
            if (list[i] == undefined) {
                list[i] = options[i]
            }
        }
        list.before && list.before()// 点击回调
        var layHtml = '';
        if (list.type == 'image') {
            // 图片层
            layHtml = '';
            layHtml += "<div class=\"lay-wrap lay-image-main\">";
            layHtml += "<div class=\"lay-load-shadow\"></div>";
            layHtml += "<div class=\"lay-load-body\">";
            layHtml += "<a class=\"lay-close\"><i class=\"fa fa-remove\"></i></a>";
            layHtml += "<img src=\"" + list.content + "\">";
            if (list.swiper === true) {
                layHtml += "<div class='lay-image-btn-item'>";
                layHtml += "<div class='lay-image-btn-info'>";
                layHtml += "<a class='lay-prev'><i class='fa fa-angle-left'></i></a>";
                layHtml += "<a class='lay-next'><i class='fa fa-angle-right'></i></a>";
                layHtml += "</div>";
                layHtml += "</div>";
                if (list.pagination === true) {
                    layHtml += "<div class='lay-image-pagination'>";
                    for (var pagelist = 0; pagelist <= imglist.length - 1; pagelist++) {
                        if (imgIndex == pagelist) {
                            layHtml += "<li class='active'></li>";
                        } else {
                            layHtml += "<li></li>";
                        }
                    }
                    layHtml += "</div>";
                }
            }
            layHtml += "</div>";
            layHtml += "</div>";
        } else if (list.type == 'msg') {
            // 提示信息
            layHtml = '';
            layHtml += "<div class=\"lay-wrap lay-msg-main\">";
            layHtml += "<div class=\"lay-load-body\">";
            layHtml += "<p><i class=\"fa fa-" + list.icon + "\"></i>" + list.content + "</p>";
            // layHtml += // "<a class=\"lay-close\"><i class=\"fa fa-remove\"></i></a>";// 关闭按钮，暂不支持
            layHtml += "</div>";
            layHtml += "</div>";
        } else {
            // 加载层
            list.icon = list.icon == '' ? 'spinner' : list.icon;
            layHtml = '';
            layHtml += "<div class=\"lay-wrap lay-load-main\">";
            layHtml += "<div class=\"lay-load-body\">";
            layHtml += "<a class=\"lay-load\"><i class=\"fa fa-" + list.icon + "\"></i></a>";
            layHtml += "</div>";
            layHtml += "</div>";
        }
        // 删除旧弹窗
        if (list.closeOther === true) $(".lay-msg-main,.lay-load-main").remove();
        // 插入到body中
        if (layHtml.length >= 0) $('body').append(layHtml);
        // 图片翻页
        $(".lay-prev,.lay-next").on("click", function () {
            if ($(this).hasClass("lay-prev")) {
                // 上一页
                if (imgIndex > 0) {
                    var imgsrc = $(imglist[parseInt(imgIndex) - 1]).attr('src');
                    $(this).parents(".lay-load-body").find('img').attr('src', imgsrc);
                    imgIndex = parseInt(imgIndex) - 1;
                } else {
                    looper(1);
                }
            } else {
                if (imgIndex < imglist.length - 1) {
                    var imgsrc = $(imglist[parseInt(imgIndex) + 1]).attr('src');
                    $(this).parents(".lay-load-body").find('img').attr('src', imgsrc);
                    imgIndex = parseInt(imgIndex) + 1;
                } else {
                    looper(0);
                }
            }
            run_pagination();
        })
        // 分页器保持运动方法
        function run_pagination(){
            // 开启分页器
            if (list.pagination === true) {
                $(".lay-image-pagination li").siblings('li').removeClass("active");
                $('.lay-image-pagination li').eq(imgIndex).addClass('active');
            }
        }
        // 图片循环展示方法
        function looper(loopType){
            if (list.loop === true) {
                imgIndex = loopType == 1 ? imglist.length - 1 : 0;
                $(".lay-load-body").find('img').attr('src', $(imglist[imgIndex]).attr('src'));
            }
        }
        // 分页器翻页
        $('.lay-image-pagination li').on('click', function () {
            $(this).addClass('active').siblings('li').removeClass('active');
            $(this).parents(".lay-load-body").find('img').attr('src', $(imglist[$(this).index()]).attr('src'));
            imgIndex = $(this).index();
        })
        // 弹出层关闭事件
        var close = $(".lay-close");
        close.on("click", function () {
            list.close && list.close($(this))// 关闭回调
        })
        // 自动关闭
        if (list.type != 'image') {// 图片弹层不自动关闭
            if (list.autoClose === true) {
                var removeLay = setTimeout(function () {
                    list.close && list.close($(this), list.type);
                    clearTimeout(removeLay);
                }, list.delayTime)
            }
        }
        // 开启滚轮
        if (list.onMouse === true) {
            $('.lay-image-main .lay-load-body').on("mousewheel DOMMouseScroll", function (e) {
                var delta = (e.originalEvent.wheelDelta && (e.originalEvent.wheelDelta > 0 ? 1 : -1)) || (e.originalEvent.detail && (e.originalEvent.detail > 0 ? -1 : 1));
                if (delta > 0) {// 向上滚动
                    if (imgIndex > 0) {
                        var imgsrc = $(imglist[parseInt(imgIndex) - 1]).attr('src');
                        $(".lay-load-body").find('img').attr('src', imgsrc);
                        imgIndex = parseInt(imgIndex) - 1;
                    } else {
                        looper(1)
                    }
                } else if (delta < 0) {// 向下滚动
                    if (imgIndex < imglist.length - 1) {
                        var imgsrc = $(imglist[parseInt(imgIndex) + 1]).attr('src');
                        $(".lay-load-body").find('img').attr('src', imgsrc);
                        imgIndex = parseInt(imgIndex) + 1;
                    } else {
                        looper(0);
                    }
                }
                run_pagination();
            });
        }
        // 底层方法，不允许有多个图片弹层
        if ($('.lay-image-main').length > 1) {
            console.log('只允许存在一个图片弹层');
            $('.lay-image-main').remove();
            return false;
        }
    }
    // 初始化图片方法
    var imglist = document.getElementsByClassName('layimg'),imgIndex = null;
    // 在一个完整的网页中可能会存在很多并不需要展示的图片，因此推荐使用指定类名进行初始化 或者你也可以指定容器 此处请自行更改
    $('.layimg').on('click',function(){
        for(var i in imglist){
            if(imglist[i] == this){
                imgIndex =  i;
                break;
            }
        }
    })
})(jQuery)