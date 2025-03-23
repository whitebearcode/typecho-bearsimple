// Author:熊猫小A
// Modified:Whitebear(whitebear@msn.com)

var curMovies_watched = 0;
var curMovies_acg= 0;
var curMovies_watching = 0;
var curMovies_wish = 0;
var curMovies_on_hold = 0;
var curMovies_dropped = 0;
BangumiBoard = {
    initBangumiBoard: function () {
        $(`.bangumi-movie-list[data-status="acg"]`).after(`<div class="bangumi-loadmore" id="loadMoreMovies_acg" onclick="BangumiBoard.loadBangumi('acg');">加载更多</div>`);
        $(`.bangumi-movie-list[data-status="watched"]`).after(`<div class="bangumi-loadmore" id="loadMoreMovies_watched" onclick="BangumiBoard.loadBangumi('watched');">加载更多</div>`);
        $(`.bangumi-movie-list[data-status="watching"]`).after(`<div class="bangumi-loadmore" id="loadMoreMovies_watching" onclick="BangumiBoard.loadBangumi('watching');">加载更多</div>`);
        $(`.bangumi-movie-list[data-status="wish"]`).after(`<div class="bangumi-loadmore" id="loadMoreMovies_wish" onclick="BangumiBoard.loadBangumi('wish');">加载更多</div>`);
        $(`.bangumi-movie-list[data-status="on_hold"]`).after(`<div class="bangumi-loadmore" id="loadMoreMovies_on_hold" onclick="BangumiBoard.loadBangumi('on_hold');">加载更多</div>`);
        $(`.bangumi-movie-list[data-status="dropped"]`).after(`<div class="bangumi-loadmore" id="loadMoreMovies_dropped" onclick="BangumiBoard.loadBangumi('dropped');">加载更多</div>`);
        curMovies_watched = 0;
        curMovies_watching = 0;
        curMovies_wish = 0;
        curMovies_on_hold = 0;
        curMovies_dropped = 0;
        curMovies_acg = 0;
        BangumiBoard.loadBangumi('watched');
        BangumiBoard.loadBangumi('watching');
        BangumiBoard.loadBangumi('wish');
        BangumiBoard.loadBangumi('on_hold');
        BangumiBoard.loadBangumi('dropped');
        BangumiBoard.loadBangumi('acg');
    },
    
    loadBangumi: function (status) {
        if ($(`.bangumi-movie-list[data-status="` + status + `"]`).length < 1) return;
        $("#loadMoreMovies_" + status).html("加载中...");

        var curMovies;
        if (status == 'watched') curMovies = curMovies_watched;
        else if (status == 'watching') curMovies = curMovies_watching;
        else if (status == 'on_hold') curMovies = curMovies_on_hold;
        else if (status == 'dropped') curMovies = curMovies_dropped;
        else if (status == 'acg') curMovies = curMovies_acg;
        else curMovies = curMovies_wish;
        if(status == 'acg'){
         $.getJSON(window.BangumiAPI + "?type=bilibili&from=" + String(curMovies) + "&status=" + status, function (result) {
            $("#loadMoreMovies_" + status).html("加载更多");
            if (result.length < BangumiPageSize) {
                $("#loadMoreMovies_" + status).html("没有啦");
            }
            $.each(result, function (i, item) {
                var html = `<a href="` + item.url + `" target="_blank" id="bangumiboard-movie-item-` + String(curMovies) + `" class="bangumiboard-item" title="`+ item.name + `">
                            <div class="bangumiboard-thumb" id="bangumiboard-movie-bg-item-` + String(curMovies) + `" style="background-image:url(`+ item.img + `)"></div>
                            <div class="bangumiboard-title">`+ item.name + `</div>
                        </a>`;
                $(`.bangumi-movie-list[data-status="` + status + `"]`).append(html);
               curMovies_acg++;
              
            });
            
        });    
        }
        else{
        $.getJSON(window.BangumiAPI + "?type=bangumi&from=" + String(curMovies) + "&status=" + status, function (result) {
            $("#loadMoreMovies_" + status).html("加载更多");
            if (result.length < BangumiPageSize) {
                $("#loadMoreMovies_" + status).html("没有啦");
            }
            $.each(result, function (i, item) {
                var html = `<a href="` + item.url + `" target="_blank" id="bangumiboard-movie-item-` + String(curMovies) + `" class="bangumiboard-item" title="`+ item.name + `">
                            <div class="bangumiboard-thumb" style="background-image:url(`+ item.img + `)"></div>
                            <div class="bangumiboard-title">`+ item.name + `</div>
                        </a>`;
                $(`.bangumi-movie-list[data-status="` + status + `"]`).append(html);
                if (status == 'watched') curMovies_watched++;
                else if (status == 'watching') curMovies_watching++;
                else if (status == 'on_hold') curMovies = curMovies_on_hold++;
                else if (status == 'dropped') curMovies = curMovies_dropped++;
                else curMovies_wish++;
            });
        });
        }
    },

}
$(document).ready(function () {
    BangumiBoard.initBangumiBoard();
})



$(document).click(function (e) {
    var target = e.target;
    $(".bangumiboard-item").removeClass("bangumiboard-info-show");
    $(".bangumiboard-item").each(function () {
        if ($(target).parent()[0] == $(this)[0] || $(target) == $(this)[0]) {
            $(this).addClass("bangumiboard-info-show");
        }
    })
})
