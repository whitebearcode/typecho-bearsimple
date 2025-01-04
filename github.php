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
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="github alternate icon"></i> <?php $this->title() ?></h2>

<?php if(!empty(Bsoptions('github_note'))): ?>     
    <div class="ui segment">
  <i class="red heart icon"></i>
  <?php echo Bsoptions('github_note');?>
</div>
<?php endif; ?>




<style>
/* 容器样式 */
.github-projects {
  column-count: 3; /* 分为 3 列 */
  column-gap: 20px; /* 列之间的间距 */
}

/* 项目卡片样式 */
.project-card {
  background-color: #fff;
  border: 1px solid #e1e4e8;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  display: inline-block; /* 必须设置为 inline-block */
  width: 100%; /* 宽度占满列 */
  margin-bottom: 20px; /* 卡片之间的间距 */
  break-inside: avoid; /* 防止卡片被分割到两列 */
}

.project-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* 项目名称 */
.project-name {
  font-size: 1.5rem;
  margin: 0 0 10px;
  word-break: break-word; /* 长名称换行 */
}

/* 项目描述 */
.project-description {
  font-size: 1rem;
  color: #586069;
  margin: 0 0 15px;
  flex-grow: 1; /* 描述部分撑开剩余空间 */
  word-break: break-word; /* 长描述换行 */
}

/* 项目元数据 */
.project-meta {
  display: flex;
   flex-direction: column;
  gap: 15px;
  margin-bottom: 15px;
  font-size: 0.9rem;
  color: #586069;
}

.project-lan {
  display: flex;
   flex-direction: column;
  gap: 15px;
  margin-bottom: 10px;
  font-size: 0.9rem;
  color: #586069;
}

.project-language {
  display: flex;
  align-items: center;
}
/* 语言图标样式 */
.project-language i {
  margin-right: 5px;
  vertical-align: middle;
}


.project-stats {
  display: flex;
  align-items: center;
  gap: 15px; /* Star 和 Fork 之间的间距 */
  font-size: 0.9rem;
  color: #586069;
}

.project-stars,
.project-forks {
  display: flex;
  align-items: center;
  gap: 5px;
}

/* 项目链接 */
.project-link {
  display: inline-block;
  padding: 8px 16px;
  background-color: #eee;
  color: #000;
  text-decoration: none;
  border-radius: 4px;
  font-size: 0.9rem;
  transition: background-color 0.2s ease;
  text-align: center;
}

.project-link:hover {
  background-color: #000;
  color:#fff;
}

/* 小屏幕（手机） */
@media (max-width: 600px) {
  .github-projects {
    column-count: 1; /* 1 列 */
  }
}

/* 中等屏幕（平板） */
@media (min-width: 601px) and (max-width: 900px) {
  .github-projects {
    column-count: 2; /* 2 列 */
  }
}

/* 大屏幕（桌面） */
@media (min-width: 901px) {
  .github-projects {
    column-count: 3; /* 3 列 */
  }
}
</style>



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
  
<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>