<?php
    /**
    * 我的Github仓库
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
    <div class="page-card">
                    <h2><i class="github alternate icon"></i> <?php $this->title() ?></h2>

<?php if(!empty(Bsoptions('github_note'))): ?>     
    <div class="ui segment">
  <i class="red heart icon"></i>
  <?php echo Bsoptions('github_note');?>
</div>
<?php endif; ?>




<div class="ui active inverted dimmer" id="commonLoad" style="display:none">
    <div class="ui active black elastic loader"></div>
  </div>
 <div id="loading"  class="ui icon message" style="display:none">
  <i class="github alternate loading icon"></i>
  <div class="content">
    <div class="header">
      正在获取中.....
    </div>
    <p>请稍等一下哦～马上就出来了</p>
  </div>
</div>
                <div class="github-projects">
                    </div>
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
                        async:true,
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
                            $("#commonLoad").fadeOut();
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
                        $("#commonLoad").fadeIn();
                        getData();
                    });
                    
                    
                    $(".pagelist").html($html);
                };
                function abbreviateNumber(number) {
  if (number >= 1000) {
    return (number / 1000).toFixed(1) + 'k';
  }
  return number.toString();
}
                function content(list) {
                    var str = " ";
                    for(var i in list) {

str += '<div class="project-card"><h2 class="project-name">' + list[i]['name'] + '</h2><div class="project-lan"><span class="project-language"><i class="fas fa-code"></i>' + list[i]['language'] + '</span></div><p class="project-description">' + list[i]['dec'] + '</p><div class="project-meta"><div class="project-stats"><span class="project-stars"><i class="fas fa-star"></i> ' + abbreviateNumber(list[i]['stars']) + '</span><span class="project-forks"><i class="fas fa-code-branch"></i> ' + abbreviateNumber(list[i]['forks']) + '</span></div></div><a href="' + list[i]['url'] + '" class="project-link" target="_blank">访问项目仓库</a></div>'
}
$(".github-projects").html(str);
$("#loading").hide();


                }
            });
        </script>
  
</div>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>