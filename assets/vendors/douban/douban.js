// Author:熊猫小A
// Modified:Whitebear(whitebear@msn.com)

var curBooks_read = 0;
var curBooks_reading = 0;
var curBooks_wish = 0;
var curMovies_watched = 0;
var curMovies_watching = 0;
var curMovies_wish = 0;
var curMusic_listened = 0;
var curMusic_listening = 0;
var curMusic_wish = 0;
DoubanBoard = {
    initDoubanBoard: function () {
        
        $(`.douban-book-list[data-status="read"]`).after(`<div class="douban-loadmore" id="loadMoreBooks_read" onclick="DoubanBoard.loadBooks('read');">加载更多</div>`);
        $(`.douban-book-list[data-status="reading"]`).after(`<div class="douban-loadmore" id="loadMoreBooks_reading" onclick="DoubanBoard.loadBooks('reading');">加载更多</div>`);
        $(`.douban-book-list[data-status="wish"]`).after(`<div class="douban-loadmore" id="loadMoreBooks_wish" onclick="DoubanBoard.loadBooks('wish');">加载更多</div>`);
        $(`.douban-movie-list[data-status="watched"]`).after(`<div class="douban-loadmore" id="loadMoreMovies_watched" onclick="DoubanBoard.loadMovies('watched');">加载更多</div>`);
        $(`.douban-movie-list[data-status="watching"]`).after(`<div class="douban-loadmore" id="loadMoreMovies_watching" onclick="DoubanBoard.loadMovies('watching');">加载更多</div>`);
        $(`.douban-movie-list[data-status="wish"]`).after(`<div class="douban-loadmore" id="loadMoreMovies_wish" onclick="DoubanBoard.loadMovies('wish');">加载更多</div>`);
         $(`.douban-music-list[data-status="listened"]`).after(`<div class="douban-loadmore" id="loadMoreMusics_listened" onclick="DoubanBoard.loadMusics('listened');">加载更多</div>`);
        $(`.douban-music-list[data-status="listening"]`).after(`<div class="douban-loadmore" id="loadMoreMusics_listening" onclick="DoubanBoard.loadMusics('listening');">加载更多</div>`);
        $(`.douban-music-list[data-status="wish"]`).after(`<div class="douban-loadmore" id="loadMoreMusics_wish" onclick="DoubanBoard.loadMusics('wish');">加载更多</div>`);
        curBooks_read = 0;
        curBooks_reading = 0;
        curBooks_wish = 0;
        curMovies_watched = 0;
        curMovies_watching = 0;
        curMovies_wish = 0;
        curMusics_listened = 0;
        curMusics_listening = 0;
        curMusics_wish = 0;
        DoubanBoard.loadBooks('read');
        DoubanBoard.loadBooks('reading');
        DoubanBoard.loadBooks('wish');
        DoubanBoard.loadMovies('watched');
        DoubanBoard.loadMovies('watching');
        DoubanBoard.loadMovies('wish');
        DoubanBoard.loadMusics('listened');
        DoubanBoard.loadMusics('listening');
        DoubanBoard.loadMusics('wish');
    },

    loadBooks: function (status) {
        $("#honeyLoading").show();
        if ($(`.douban-book-list[data-status="` + status + `"]`).length < 1) return;
        $(`#loadMoreBooks_` + status).html("加载中...");
        var curBooks;
        if (status == 'read') curBooks = curBooks_read;
        else if (status == 'reading') curBooks = curBooks_reading;
        else curBooks = curBooks_wish;
        var api = window.DoubanAPI + "?type=book&from=" + String(curBooks) + "&status=" + status;
        $.getJSON(api, function (result) {
            $(`#loadMoreBooks_` + status).html("加载更多");
            if (result.length < DoubanPageSize) {
                $(`#loadMoreBooks_` + status).html("没有啦");
            }
            $.each(result, function (i, item) {
                var html = `<a href="` + item.url + `" target="_blank" id="doubanboard-book-item-` + String(curBooks) + `" class="doubanboard-item">
                            <div class="doubanboard-thumb" style="background-image:url(`+ item.img + `)"></div>
                            <div class="doubanboard-title">`+ item.name + `</div>
                        </a>`;
                $(`.douban-book-list[data-status="` + status + `"]`).append(html);
                if (status == 'read') curBooks_read++;
                else if (status == 'reading') curBooks_reading++;
                else curBooks_wish++;
            });
        });
    },

    loadMovies: function (status) {
        if ($(`.douban-movie-list[data-status="` + status + `"]`).length < 1) return;
        $("#loadMoreMovies_" + status).html("加载中...");

        var curMovies;
        if (status == 'watched') curMovies = curMovies_watched;
        else if (status == 'watching') curMovies = curMovies_watching;
        else curMovies = curMovies_wish;

        $.getJSON(window.DoubanAPI + "?type=movie&from=" + String(curMovies) + "&status=" + status, function (result) {
            $("#loadMoreMovies_" + status).html("加载更多");
            if (result.length < DoubanPageSize) {
                $("#loadMoreMovies_" + status).html("没有啦");
            }
            $.each(result, function (i, item) {
                var html = `<a href="` + item.url + `" target="_blank" id="doubanboard-movie-item-` + String(curMovies) + `" class="doubanboard-item">
                            <div class="doubanboard-thumb" style="background-image:url(`+ item.img + `)"></div>
                            <div class="doubanboard-title">`+ item.name + `</div>
                        </a>`;
                $(`.douban-movie-list[data-status="` + status + `"]`).append(html);
                if (status == 'watched') curMovies_watched++;
                else if (status == 'watching') curMovies_watching++;
                else curMovies_wish++;
            });
        });
    },

loadMusics: function (status) {
        if ($(`.douban-music-list[data-status="` + status + `"]`).length < 1) return;
        $("#loadMoreMusics_" + status).html("加载中...");

        var curMusics;
        if (status == 'listened') curMusics = curMusics_listened;
        else if (status == 'listening') curMusics = curMusics_listening;
        else curMusics = curMusics_wish;

        $.getJSON(window.DoubanAPI + "?type=music&from=" + String(curMusics) + "&status=" + status, function (result) {
            $("#loadMoreMusics_" + status).html("加载更多");
            if (result.length < DoubanPageSize) {
                $("#loadMoreMusics_" + status).html("没有啦");
            }
            $.each(result, function (i, item) {
                var html = `<a href="` + item.url + `" target="_blank" id="doubanboard-music-item-` + String(curMusics) + `" class="doubanboard-item">
                            <div class="doubanboard-thumb" style="background-image:url(`+ item.img + `)"></div>
                            <div class="doubanboard-title">`+ item.name + `</div>
                        </a>`;
                $(`.douban-music-list[data-status="` + status + `"]`).append(html);
                if (status == 'listened') curMusics_listened++;
                else if (status == 'listening') curMusics_listening++;
                else curMusics_wish++;
            });
        });
    }

}
$(document).ready(function () {
    DoubanBoard.initDoubanBoard();
})

$(document).click(function (e) {
    var target = e.target;
    $(".doubanboard-item").removeClass("doubanboard-info-show");
    $(".doubanboard-item").each(function () {
        if ($(target).parent()[0] == $(this)[0] || $(target) == $(this)[0]) {
            $(this).addClass("doubanboard-info-show");
        }
    })
})
