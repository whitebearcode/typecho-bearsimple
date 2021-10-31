<?php if($this->is('post')):?>
var poster_open = 'on';
	var txt1 = '长按识别二维码查看详情';
	var txt2 = '<?php $this->options->title() ?>';
    var bearstudio_poster_start_wlat = 0;
	var bearstudio_rlmenu =  1;
	var bearstudio_nvscroll =  0;
    var bearstudio_poster_time_baxt;
    $(document).ready(function(){
        $(document).on('click', '.bearstudio_poster_a.ui.mini.gray.icon.button', function(e) {
            show_bearstudio_poster_ykzn();
        });
    });
    function bearstudio_poster_rrwz(){
        setTimeout(function(){
            html2canvas(document.querySelector(".bearstudio_poster_box_img"), {scale:2,useCORS:true}).then(canvas => {
                var img = canvas.toDataURL("image/jpeg", .9);
                document.getElementById('bearstudio_poster_images').src = img;
                $('.bearstudio_poster_load').hide();
                $('.bearstudio_poster_imgshow').show();
            });
        }, 100);
    }
    function show_bearstudio_poster_ykzn(){
        if(bearstudio_poster_start_wlat == 0){
            bearstudio_poster_start_wlat = 1;
            popup.open('<img src="<?php $this->options->themeUrl("/modules/MakePost/poster/img/imageloading.gif"); ?>" class="bearstudio_loading">');
			var url = window.location.href.split('#')[0];
			url = encodeURIComponent(url);
            var html = '<div id="bearstudio_poster_box" class="bearstudio_poster_nchxd">\n' +
                '<div class="bearstudio_poster_box">\n' +
                '<div class="bearstudio_poster_okimg">\n' +
                '<div style="padding:150px 0;" class="bearstudio_poster_load">\n' +
                '<div class="loading_color">\n' +
                '  <span class="loading_color1"></span>\n' +
                '  <span class="loading_color2"></span>\n' +
                '  <span class="loading_color3"></span>\n' +
                '  <span class="loading_color4"></span>\n' +
                '  <span class="loading_color5"></span>\n' +
                '  <span class="loading_color6"></span>\n' +
                '  <span class="loading_color7"></span>\n' +
                '</div>\n' +
                '<div class="bearstudio_poster_oktit">正在生成海报, 请稍候</div>\n' +
                '</div>\n' +
                '<div class="bearstudio_poster_imgshow" style="display:none">\n' +
                '<img src="" class="vm" id="bearstudio_poster_images">\n' +
                '<div class="bearstudio_poster_oktit">↑长按上图保存图片分享</div>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="bearstudio_poster_okclose"><a href="javascript:;" class="bearstudio_poster_closekey"><img src="<?php $this->options->themeUrl("modules/MakePost/poster/img/poster_okclose.png"); ?>" class="vm"></a></div>\n' +
                '</div>\n' +
                '<div class="bearstudio_poster_box_img">\n' +
                '<div class="bearstudio_poster_img"><div class="img_time"><?php $this->date('d'); ?><span><?php $this->date('Y'); ?>/<?php $this->date('m'); ?></span></div><img src="https://picapi.bear-studio.net/1000/700" class="vm" id="bearstudio_poster_image"></div>\n' +
                '<div class="bearstudio_poster_tita"><?php $this->title(); ?></div>\n' +
                '<div class="bearstudio_poster_txta"><?php $this->title(); ?></div><div class="bearstudio_poster_x guig"></div>\n' +
                '<div class="bearstudio_poster_foot">\n' +
                '<img src="<?php $this->options->themeUrl("/modules/MakePost/poster/api.php"); ?>?url='+url+'" class="kmewm fqpl vm">\n' +
                '<img src="<?php $this->options->themeUrl("/modules/MakePost/poster/img/poster_zw.png"); ?>" class="kmzw vm"><span class="kmzwtip">'+txt1+'<br>'+txt2+'</span>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>';
            if(html.indexOf("bearstudio_poster") >= 0){
                bearstudio_poster_time_baxt = setTimeout(function(){
                    bearstudio_poster_rrwz();
                }, 5000);
                $('body').append(html);
                $('#bearstudio_poster_image').load(function(){
                    clearTimeout(bearstudio_poster_time_baxt);
                    bearstudio_poster_rrwz();
                });
                popup.close();
                setTimeout(function() {
                    $('.bearstudio_poster_box').addClass("bearstudio_poster_box_show");
                    $('.bearstudio_poster_closekey').off().on('click', function(e) {
                        $('.bearstudio_poster_box').removeClass("bearstudio_poster_box_show").on('webkitTransitionEnd transitionend', function() {
                            $('#bearstudio_poster_box').remove();
                            bearstudio_poster_start_wlat = 0;
                        });
                        return false;
                    });
                }, 60);
            }
        }
    }

    var new_bearstudio_user_share, is_bearstudio_user_share = 0;
    var as = navigator.appVersion.toLowerCase(), isqws = 0;
    if (as.match(/MicroMessenger/i) == "micromessenger" || as.match(/qq\//i) == "qq/") {
        isqws = 1;
    }
    if(isqws == 1){
        if(typeof bearstudio_user_share === 'function'){
            new_bearstudio_user_share = bearstudio_user_share;
            is_bearstudio_user_share = 1;
        }
        var bearstudio_user_share = function(){
            if(is_bearstudio_user_share == 1){
                isusershare = 0;
                new_bearstudio_user_share();
                if(isusershare == 1){
                    return false;
                }
            }
            isusershare = 1;
            show_bearstudio_poster_ykzn();
            return false;
        }
    }
    <?php endif; ?>