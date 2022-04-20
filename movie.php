<?php
    /**
    * 我的追剧
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
 <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
               <?php if($this->options->Diy == "1"): ?><div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="video icon"></i> <?php $this->title() ?></h2>
  <?php if(!empty($this->options->douban_movie_note)): ?> 
    <div class="ui segment">
  <i class="red heart icon"></i>
  <?php $this->options->douban_movie_note();?>
</div>
<?php endif; ?>

<div class="ui secondary pointing menu">
    <?php if(getMovieTag()[0]):?>
  <a id="first" class="item active" data-tab="first"><?php echo getMovieTag()[0]; ?></a>
  <?php endif; ?>
  <?php if(getMovieTag()[1]):?>
  <a id="second" class="item" data-tab="second"><?php echo getMovieTag()[1]; ?></a>
    <?php endif; ?>
  <?php if(getMovieTag()[2]):?>
  <a id="third" class="item" data-tab="third"><?php echo getMovieTag()[2]; ?></a>
  <?php endif; ?>
</div>
<?php if(getMovieTag()[0]):?>
<div class="ui bottom attached tab active" data-tab="first">
    <div id="loading"  class="ui icon message" style="display:none">
  <i class="video loading icon"></i>
  <div class="content">
    <div class="header">
      正在获取中.....
    </div>
    <p>请稍等一下哦～马上就出来了</p>
  </div>
</div>
<div id="error1" style="display:none">
    <article class="post">
        <center><svg t="1617683554811" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2629" width="200" height="200"><path d="M817.152 346.112c0-12.8-10.752-23.552-23.552-23.552h-28.672v281.6l-181.76 182.272H361.472v15.36c0 12.8 10.752 23.552 23.552 23.552l254.976-2.56 180.224-184.32-3.072-292.352z" fill="#E3EAED" p-id="2630"></path><path d="M332.8 705.536H258.56c-18.432 0-32.768-14.336-32.768-32.768V223.232c0-18.432 14.336-32.768 32.768-32.768H604.16c4.608 0 9.216 4.096 9.216 9.216 0 4.608-4.096 9.216-9.216 9.216H258.56c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336H332.8M686.08 299.52v-51.2c0-4.608 4.096-9.216 9.216-9.216 4.608 0 9.216 4.096 9.216 9.216v51.2" fill="#D3DBDE" p-id="2631"></path><path d="M608.768 797.184H350.208c-18.432 0-32.768-14.336-32.768-32.768V315.392c0-18.432 14.336-32.768 32.768-32.768h413.184c18.432 0 32.768 14.336 32.768 32.768v294.912l-187.392 186.88z m-258.56-496.64c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336h251.392l176.128-176.128v-286.72c0-7.68-6.656-14.336-14.336-14.336H350.208z" fill="#D3DBDE" p-id="2632"></path><path d="M601.088 778.752l177.152-176.128V322.56H394.752c-12.8 0-23.552 11.264-23.552 24.576v431.616h229.888z" fill="#F2F5F7" p-id="2633"></path><path d="M613.888 788.992h-18.432v-110.08c0-44.032 36.352-80.384 80.384-80.384h103.936v17.92H675.84c-34.304 0-62.464 27.648-62.464 62.464l0.512 110.08z m45.056-350.72H453.12c-6.656 0-12.288-5.632-12.288-12.288 0-6.656 5.632-12.288 12.288-12.288h205.824c6.656 0 12.288 5.632 12.288 12.288 0 7.168-5.632 12.288-12.288 12.288z m0-11.776v6.144-6.144z m1.536 71.168H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m0 71.68H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m-10.752-451.072c-5.12 0-9.216 4.096-9.216 9.216v61.44c0 5.12 4.096 9.216 9.216 9.216 4.608 0 9.216-4.096 9.216-9.216v-61.44c0-4.608-4.096-9.216-9.216-9.216z m114.688 17.408c-4.096-3.072-9.728-2.048-12.8 2.048l-35.84 49.664c-3.072 4.096-2.048 9.728 2.048 12.8 2.048 1.024 3.584 2.048 5.632 2.048 3.072 0 5.632-1.024 7.168-3.584l35.84-49.664c2.56-4.608 2.048-10.24-2.048-13.312z m58.88 71.168c-2.048-5.12-7.168-6.656-12.288-4.096l-55.296 25.6c-5.12 2.048-6.656 7.168-4.096 12.288 2.048 3.584 5.12 5.632 8.704 5.632 1.024 0 2.56 0 3.584-0.512l55.296-25.6c4.096-3.584 6.144-8.704 4.096-13.312z" fill="#D3DBDE" p-id="2634"></path></svg></center>
                <center><h2>暂无数据</h2></center>
            </article>
</div>
                <div class="finish_content1 ui three doubling cards"></div>
                  <!--分页链接-->
           <br>
            <div class="pagelist" id="page1">
            </div>         
</div>
  <?php endif; ?>
  <?php if(getMovieTag()[1]):?>
<div class="ui tab" data-tab="second">

  <div id="loading2"  class="ui icon message" style="display:none">
  <i class="video loading icon"></i>
  <div class="content">
    <div class="header">
      正在获取中.....
    </div>
    <p>请稍等一下哦～马上就出来了</p>
  </div>
</div>

<div id="error2" style="display:none">
    <article class="post">
        <center><svg t="1617683554811" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2629" width="200" height="200"><path d="M817.152 346.112c0-12.8-10.752-23.552-23.552-23.552h-28.672v281.6l-181.76 182.272H361.472v15.36c0 12.8 10.752 23.552 23.552 23.552l254.976-2.56 180.224-184.32-3.072-292.352z" fill="#E3EAED" p-id="2630"></path><path d="M332.8 705.536H258.56c-18.432 0-32.768-14.336-32.768-32.768V223.232c0-18.432 14.336-32.768 32.768-32.768H604.16c4.608 0 9.216 4.096 9.216 9.216 0 4.608-4.096 9.216-9.216 9.216H258.56c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336H332.8M686.08 299.52v-51.2c0-4.608 4.096-9.216 9.216-9.216 4.608 0 9.216 4.096 9.216 9.216v51.2" fill="#D3DBDE" p-id="2631"></path><path d="M608.768 797.184H350.208c-18.432 0-32.768-14.336-32.768-32.768V315.392c0-18.432 14.336-32.768 32.768-32.768h413.184c18.432 0 32.768 14.336 32.768 32.768v294.912l-187.392 186.88z m-258.56-496.64c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336h251.392l176.128-176.128v-286.72c0-7.68-6.656-14.336-14.336-14.336H350.208z" fill="#D3DBDE" p-id="2632"></path><path d="M601.088 778.752l177.152-176.128V322.56H394.752c-12.8 0-23.552 11.264-23.552 24.576v431.616h229.888z" fill="#F2F5F7" p-id="2633"></path><path d="M613.888 788.992h-18.432v-110.08c0-44.032 36.352-80.384 80.384-80.384h103.936v17.92H675.84c-34.304 0-62.464 27.648-62.464 62.464l0.512 110.08z m45.056-350.72H453.12c-6.656 0-12.288-5.632-12.288-12.288 0-6.656 5.632-12.288 12.288-12.288h205.824c6.656 0 12.288 5.632 12.288 12.288 0 7.168-5.632 12.288-12.288 12.288z m0-11.776v6.144-6.144z m1.536 71.168H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m0 71.68H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m-10.752-451.072c-5.12 0-9.216 4.096-9.216 9.216v61.44c0 5.12 4.096 9.216 9.216 9.216 4.608 0 9.216-4.096 9.216-9.216v-61.44c0-4.608-4.096-9.216-9.216-9.216z m114.688 17.408c-4.096-3.072-9.728-2.048-12.8 2.048l-35.84 49.664c-3.072 4.096-2.048 9.728 2.048 12.8 2.048 1.024 3.584 2.048 5.632 2.048 3.072 0 5.632-1.024 7.168-3.584l35.84-49.664c2.56-4.608 2.048-10.24-2.048-13.312z m58.88 71.168c-2.048-5.12-7.168-6.656-12.288-4.096l-55.296 25.6c-5.12 2.048-6.656 7.168-4.096 12.288 2.048 3.584 5.12 5.632 8.704 5.632 1.024 0 2.56 0 3.584-0.512l55.296-25.6c4.096-3.584 6.144-8.704 4.096-13.312z" fill="#D3DBDE" p-id="2634"></path></svg></center>
                <center><h2>暂无数据</h2></center>
            </article>
</div>

                <div class="finish_content2 ui three doubling cards"></div>
           <!--分页链接-->
           <br>
            <div class="pagelist" id="page2">
            </div>
</div>
 <?php endif; ?>
  <?php if(getMovieTag()[2]):?>
<div class="ui tab" data-tab="third">
 <div id="loading3"  class="ui icon message" style="display:none">
  <i class="video loading icon"></i>
  <div class="content">
    <div class="header">
      正在获取中.....
    </div>
    <p>请稍等一下哦～马上就出来了</p>
  </div>
</div>

<div id="error3" style="display:none">
    <article class="post">
        <center><svg t="1617683554811" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2629" width="200" height="200"><path d="M817.152 346.112c0-12.8-10.752-23.552-23.552-23.552h-28.672v281.6l-181.76 182.272H361.472v15.36c0 12.8 10.752 23.552 23.552 23.552l254.976-2.56 180.224-184.32-3.072-292.352z" fill="#E3EAED" p-id="2630"></path><path d="M332.8 705.536H258.56c-18.432 0-32.768-14.336-32.768-32.768V223.232c0-18.432 14.336-32.768 32.768-32.768H604.16c4.608 0 9.216 4.096 9.216 9.216 0 4.608-4.096 9.216-9.216 9.216H258.56c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336H332.8M686.08 299.52v-51.2c0-4.608 4.096-9.216 9.216-9.216 4.608 0 9.216 4.096 9.216 9.216v51.2" fill="#D3DBDE" p-id="2631"></path><path d="M608.768 797.184H350.208c-18.432 0-32.768-14.336-32.768-32.768V315.392c0-18.432 14.336-32.768 32.768-32.768h413.184c18.432 0 32.768 14.336 32.768 32.768v294.912l-187.392 186.88z m-258.56-496.64c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336h251.392l176.128-176.128v-286.72c0-7.68-6.656-14.336-14.336-14.336H350.208z" fill="#D3DBDE" p-id="2632"></path><path d="M601.088 778.752l177.152-176.128V322.56H394.752c-12.8 0-23.552 11.264-23.552 24.576v431.616h229.888z" fill="#F2F5F7" p-id="2633"></path><path d="M613.888 788.992h-18.432v-110.08c0-44.032 36.352-80.384 80.384-80.384h103.936v17.92H675.84c-34.304 0-62.464 27.648-62.464 62.464l0.512 110.08z m45.056-350.72H453.12c-6.656 0-12.288-5.632-12.288-12.288 0-6.656 5.632-12.288 12.288-12.288h205.824c6.656 0 12.288 5.632 12.288 12.288 0 7.168-5.632 12.288-12.288 12.288z m0-11.776v6.144-6.144z m1.536 71.168H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m0 71.68H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m-10.752-451.072c-5.12 0-9.216 4.096-9.216 9.216v61.44c0 5.12 4.096 9.216 9.216 9.216 4.608 0 9.216-4.096 9.216-9.216v-61.44c0-4.608-4.096-9.216-9.216-9.216z m114.688 17.408c-4.096-3.072-9.728-2.048-12.8 2.048l-35.84 49.664c-3.072 4.096-2.048 9.728 2.048 12.8 2.048 1.024 3.584 2.048 5.632 2.048 3.072 0 5.632-1.024 7.168-3.584l35.84-49.664c2.56-4.608 2.048-10.24-2.048-13.312z m58.88 71.168c-2.048-5.12-7.168-6.656-12.288-4.096l-55.296 25.6c-5.12 2.048-6.656 7.168-4.096 12.288 2.048 3.584 5.12 5.632 8.704 5.632 1.024 0 2.56 0 3.584-0.512l55.296-25.6c4.096-3.584 6.144-8.704 4.096-13.312z" fill="#D3DBDE" p-id="2634"></path></svg></center>
                <center><h2>暂无数据</h2></center>
            </article>
</div>

                <div class="finish_content3 ui three doubling cards"></div>
           <!--分页链接-->
           <br>
            <div class="pagelist" id="page3">
            </div>
</div>
<?php endif; ?>

 
</div></div>
<?php if($this->options->Diy == "1"): ?></div><?php endif; ?>
<script>
$(document).ready(function(){
$("#loading").show();
                var page = 1;
                var n = 0;
                var max = 1;
                getData();
                function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getDoubanFile(); ?>",
                        data: {
                            "type": '1',
                            "page": page,
                            "dbtype":'movie'
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            n = json.total;
                            max = json.max;
                            if(n == '0' || json.list[0].url == ''){
                             toastr.warning('啊哦，暂未获取到数据~~请稍后再试');   
                             $("#loading").hide();
                             $("#page1").hide();
                             $("#error1").fadeIn();
                            }
                            else{
                            $("#page1").show();
                            content(json.list,json.rating_status);
                            }
                        },
                        complete: function() {
                               pageList();
                            $('.ui.dimmer').click();
                        },
                        error: function() {
                            toastr.warning("数据获取错误，请稍后再试~~");
                            $("#loading").hide();
                            $("#page1").hide();
                            $("#error1").fadeIn();
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
                    
                    
                    $("#page1").html($html);
                }
                function content(list,rating) {
                    var str = " ";
                    for(var i in list) {
if(rating == '1'){
                    style = 'display:none';
                 }
                 else{
                     style = 'display:block';
                 }
str += '<div class="ui fluid card" style="word-break:break-all;"><div class="blurring dimmable image"><div class="ui dimmer"><div class="content"><div class="center"><a class="ui inverted button" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>我也要看</a></div></div></div><img class="lazyload" id="imga" data-src="'+ list[i]['cover'].replace('http://','//') +'" referrerPolicy="no-referrer"></div><div class="content" style="text-align:center;"><a class="header" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>《' + list[i]['title'] + '》</a><div class="meta"><a>' + list[i]['summary'] + '</a></div><div class="ui star rating" data-rating="' + list[i]['rating'] + '" data-max-rating="5" style="pointer-events: none;' + style + '"></div></div></div>'
}
$('.finish_content1').html(str);
$("#loading").hide();
                }
           
});

$("#second").one('click',function(){
$("#loading2").show();
                var page = 1;
                var n = 0;
                var max = 1;
                getData();
                function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getDoubanFile(); ?>",
                        data: {
                            "type": '2',
                            "page": page,
                            "dbtype":'movie'
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            n = json.total;
                            max = json.max;
                            if(n == '0' || json.list[0].url == ''){
                             toastr.warning('啊哦，暂未获取到数据~~请稍后再试');   
                             $("#loading2").hide();
                             $("#page2").hide();
                             $("#error2").fadeIn();
                            }
                            else{
                            $("#page2").show();
                            content(json.list,json.rating_status);
                            }
                        },
                        complete: function() {
                            pageList();
                            $('.ui.dimmer').click();
                        },
                        error: function() {
                            toastr.warning("数据获取错误，请稍后再试~~");
                            $("#loading2").hide();
                            $("#page2").hide();
                            $("#error2").fadeIn();
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
                    
                    
                    $("#page2").html($html);
                }
                function content(list,rating) {
                    var str = " ";
                    for(var i in list) {
if(rating == '1'){
                    style = 'display:none';
                 }
                 else{
                     style = 'display:block';
                 }
str += '<div class="ui fluid card" style="word-break:break-all;"><div class="blurring dimmable image"><div class="ui dimmer"><div class="content"><div class="center"><a class="ui inverted button" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>我也要看</a></div></div></div><img class="lazyload" id="imga" data-src="'+ list[i]['cover'].replace('http://','//') +'" referrerPolicy="no-referrer"></div><div class="content" style="text-align:center;"><a class="header" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>《' + list[i]['title'] + '》</a><div class="meta"><a>' + list[i]['summary'] + '</a></div><div class="ui star rating" data-rating="' + list[i]['rating'] + '" data-max-rating="5" style="pointer-events: none;' + style + '"></div></div></div>'
}
$('.finish_content2').html(str);
$("#loading2").hide();
                }

});
$("#third").one('click',function(){
$("#loading3").show();
                var page = 1;
                var n = 0;
                var max = 1;
                getData();
                function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getDoubanFile(); ?>",
                        data: {
                            "type": '3',
                            "page": page,
                            "dbtype":'movie'
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            n = json.total;
                            max = json.max;
                            if(n == '0' || json.list[0].url == ''){
                             toastr.warning('啊哦，暂未获取到数据~~请稍后再试');   
                             $("#loading3").hide();
                             $("#page3").hide();
                             $("#error3").fadeIn();
                            }
                            else{
                             $("#page3").show();
                            content(json.list,json.rating_status);
                            }
                        },
                        complete: function() {
                            pageList();
                            $('.ui.dimmer').click();
                        },
                        error: function() {
                            toastr.warning("数据获取错误，请稍后再试~~");
                            $("#loading3").hide();
                            $("#page3").hide();
                            $("#error3").fadeIn();
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
                    
                    
                    $("#page3").html($html);
                }
                function content(list,rating) {
                    var str = " ";
                    for(var i in list) {
if(rating == '1'){
                    style = 'display:none';
                 }
                 else{
                     style = 'display:block';
                 }
str += '<div class="ui fluid card" style="word-break:break-all;"><div class="blurring dimmable image"><div class="ui dimmer"><div class="content"><div class="center"><a class="ui inverted button" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>我也要看</a></div></div></div><img class="lazyload" id="imga" data-src="'+ list[i]['cover'].replace('http://','//') +'" referrerPolicy="no-referrer"></div><div class="content" style="text-align:center;"><a class="header" href="' + list[i]['url'] + '"<?php if($this->options->Link_blank == '2'):?> target="_blank"<?php endif; ?>>《' + list[i]['title'] + '》</a><div class="meta"><a>' + list[i]['summary'] + '</a></div><div class="ui star rating" data-rating="' + list[i]['rating'] + '" data-max-rating="5" style="pointer-events: none;' + style + '"></div></div></div>'
}
$('.finish_content3').html(str);
$("#loading3").hide();
                }


});
</script>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>