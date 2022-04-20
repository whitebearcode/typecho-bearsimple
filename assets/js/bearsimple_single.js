    //复制
      document.body.oncopy = function() {
          toastr.success('复制成功,若要转载请务必保留原文链接！'); 
          };
$.getScript("//cdn.staticfile.org/mathjax/2.7.9/MathJax.js?config=TeX-MML-AM_CHTML",function(){MathJax.Hub.Config({linebreaks: { automatic: true },showMathMenu: false,messageStyle:'none',tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});});
        //相册
var instance = $(".bsgallery__wrapper");
$.each(instance, function (key, value) {

  var arrows = $(instance[key]).find(".arrow"),
  prevArrow = arrows.filter('.arrow-prev'),
  nextArrow = arrows.filter('.arrow-next'),
  box = $(instance[key]).find(".bsgallery"),
  x = 0,
  mx = 0,
  maxScrollWidth = box[0].scrollWidth - box[0].clientWidth / 2 - box.width() / 2;
    $(arrows).click(function(){
    if ($(this).hasClass("arrow-next")) {
      x = box.width() / 2 + box.scrollLeft() - 10;
      box.animate({
        scrollLeft: x });

    } else {
      x = box.width() / 2 - box.scrollLeft() - 10;
      box.animate({
        scrollLeft: -x });

    }

  });

  $(box).on({
    mousemove: function (e) {
      var mx2 = e.pageX - this.offsetLeft;
      if (mx) this.scrollLeft = this.sx + mx - mx2;
    },
    mousedown: function (e) {
      this.sx = this.scrollLeft;
      mx = e.pageX - this.offsetLeft;
    },
    scroll: function () {
      toggleArrows();
    } });


  $(document).on("mouseup", function () {
    mx = 0;
  });

  function toggleArrows() {
    if (box.scrollLeft() > maxScrollWidth - 10) {
      nextArrow.addClass('disabled');
    } else if (box.scrollLeft() < 10) {
      prevArrow.addClass('disabled');
    } else {
      nextArrow.removeClass('disabled');
      prevArrow.removeClass('disabled');
    }
  }
});


