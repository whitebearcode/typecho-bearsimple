<?php
    /**
    * 我的追番
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<style>
    #imga{
        height:auto;
    }
     @media (max-width: 767px) {
       #imga{
        height:auto;
    } 
    }
</style>
<?php if($this->options->Scroll == '1'): ?>
<?php if(strpos($this->content,'h2') !== false): ?>
<div class="ax-scrollnav-v" id="article-nav" style="background-color: rgba(255,255,255,.9);border: 1px solid #ebebeb;float:left;"><a href="##" class="ax-close ax-iconfont ax-icon-arrow-right"></a></div>
<?php endif; ?>
<?php endif; ?>
<div id="bearsimple-images"></div>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
               <?php if($this->options->Diy == "1"): ?><div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="video icon"></i> <?php $this->title() ?></h2>
  
<div class="ui divided selection icon list">
  <a class="item">
    <div class="ui red horizontal label">Tips</div>
    右上角显示打勾标志=已完结
  </a>
</div>
<?php if(!empty($this->options->bilibili_note)): ?>     
    <div class="ui segment">
  <i class="red heart icon"></i>
  <?php $this->options->bilibili_note();?>
</div>
<?php endif; ?>
 <div id="loading"  class="ui icon message" style="display:none">
  <i class="video circle loading icon"></i>
  <div class="content">
    <div class="header">
      正在获取中.....
    </div>
    <p>请稍等一下哦～马上就出来了</p>
  </div>
</div>
                <div class="finish_content ui three doubling cards"></div>
<br>
            <!--分页链接-->
            <div class="pagelist">
            </div>
</div>
</div>
 <script>
$("#loading").show();
            $(function() {
                var page = 1;
                var n = 0;
                var max = 1;
                getData();
                function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getAcgFile(); ?>",
                        data: {
                            "page": page,
                            "type": 'acg'
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            n = json.total;
                            max = json.max;
                            if(json.total == null){
                             toastr.warning('啊哦，暂未获取到番剧~~请稍后再试');   
                             $("#loading").hide();
                            }
                            else{
                            content(json.list);
                            }
                        },
                        complete: function() {
                            pageList();
                        },
                        error: function() {
                            alert("番剧获取错误，请稍后再试~~");
                        }
                    });
                }
                function pageList() {
                    page = Math.min(page, max);
                    page = Math.max(page, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ page +">共" + n + "条</a><a class=\"ui label\" data-page="+ page +">第" + page + "/" + max + "页</a>";
                    html += '<a class=\"ui label\" href="#" data-page="1">首页</a>';
                    html += (page > 1) ? '<a class=\"ui label\" href="#" data-page="' + (page - 1) + '">上一页</a>' : '<a class=\"ui label\" href="#" data-page="1">上一页</a>';
                    html += (page < max) ? '<a class=\"ui label\" href="#" data-page="' + (page + 1) + '">下一页</a>' : '<a class=\"ui label\" href="#" data-page="' + max + '">下一页</a>';
                    html += '<a class=\"ui label\" href="#" data-page="' + max + '">尾页</a><div class=\"ui mini input\"><input id=\"dipage\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" href="#">跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        page = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipage").value;
                            if(dipage < 1){
                                page = 1;
                            }
                            else if(dipage > max){
                                page = max;
                            }
                            else{
                            page = dipage;
                            }
                        }
                        getData();
                    });
                    
                    
                    $(".pagelist").html($html);
                }
                function content(list) {
                    var str = " ";
                    for(var i in list) {
if(list[i]['is_finish'] == "1"){
                        str += '<div  class="ui fluid card" style="word-break:break-all;"><div class="blurring dimmable image"><a class="ui red right corner label"><i class="calendar check outline icon"></i></a><div class="ui dimmer"><div class="content"><div class="center"><a class="ui inverted button" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>我也要看</a></div></div></div><img class="lazyload" id="imga" data-src="' + list[i]['cover'].replace('http://','//') + '" referrerPolicy="no-referrer"></div><div class="content" style="text-align:center;"><a class="header" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>《' + list[i]['title'] + '》</a><div class="meta"><a>' + list[i]['subtitle_14'] + '</a></div></div></div>'
}
else{
str += '<div class="ui fluid card" style="word-break:break-all;"><div class="blurring dimmable image"><div class="ui dimmer"><div class="content"><div class="center"><a class="ui inverted button" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>我也要看</a></div></div></div><img class="lazyload" id="imga" data-src="'+ list[i]['cover'].replace('http://','//') +'" referrerPolicy="no-referrer"></div><div class="content" style="text-align:center;"><a class="header" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>《' + list[i]['title'] + '》</a><div class="meta"><a>' + list[i]['subtitle_14'] + '</a></div></div></div>'
}
}
$(".finish_content").html(str);
$("#loading").hide();


                }
            })
        </script>
         
  
<?php if($this->options->Diy == "1"): ?></div><?php endif; ?>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>