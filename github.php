<?php
    /**
    * 我的Github仓库
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>
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

 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<?php if(Bsoptions('Animate') == "close" || Bsoptions('Animate') == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php echo Bsoptions('Animate') ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="github alternate icon"></i> <?php $this->title() ?></h2>

<?php if(!empty(Bsoptions('github_note'))): ?>     
    <div class="ui segment">
  <i class="red heart icon"></i>
  <?php echo Bsoptions('github_note');?>
</div>
<?php endif; ?>
 <div id="loading"  class="ui icon message" style="display:none">
  <i class="github alternate loading icon"></i>
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
                        url: "<?php getGhFile(); ?>",
                        data: {
                            "page": page,
                            "type": 'github'
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            n = json.total;
                            max = json.max;
                            if(json.total == null || json.total == 0){
                             toastr.warning('啊哦，暂未获取到数据~~请稍后再试');   
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
                            alert("数据获取错误，请稍后再试~~");
                        }
                    });
                };
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
                            switch(dipage){
                            case dipage < 1 :
                                page = 1;
                            break;
                            case dipage > max:
                                page = max;
                            break;
                            default:
                            page = dipage;
                        };
                        };
                        getData();
                    });
                    
                    
                    $(".pagelist").html($html);
                };
                function content(list) {
                    var str = " ";
                    for(var i in list) {

str += '<div class="ui card"><div class="content" style="word-break:break-all;"><div class="ui top left attached label">' + list[i]['language'] + '</div><a class="header" href="' + list[i]['url'] + '"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>>' + list[i]['name'] + '</a><div class="meta">更新于' + list[i]['push'] + '</div><div class="description"><p>' + list[i]['dec'] + '</p></div></div><div class="extra content"><i class="star yellow icon"></i>' + list[i]['stars'] + '<g style="float:right;"><i class="fork green icon" title="Forks"></i>' + list[i]['forks'] + '</g></div></div>'
}
$(".finish_content").html(str);
$("#loading").hide();


                }
            });
        </script>
  
<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>