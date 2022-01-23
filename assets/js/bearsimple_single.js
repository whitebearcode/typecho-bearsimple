    //复制
      document.body.oncopy = function() {
          toastr.success('复制成功,若要转载请务必保留原文链接！'); 
          };
function bs_singlefunc(){
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


localStorage.setItem("fontsize", "default");
    $("#fontsizechanges").click(function(){
    switch(localStorage.getItem("fontsize"))
{
    case 'default':
      localStorage.setItem("fontsize", "18");
    $(".post-content").animate({"font-size":"18px"});
        break;
    case '18':
      localStorage.setItem("fontsize", "25");
    $(".post-content").animate({"font-size":"25px"});  
        break;
    case '25':
     localStorage.setItem("fontsize", "32");
    $(".post-content").animate({"font-size":"32px"});  
        break;
    default:
      localStorage.setItem("fontsize", "default");
        $(".post-content").animate({"font-size":"15px"});  
}
});         

}



bs_singlefunc();


