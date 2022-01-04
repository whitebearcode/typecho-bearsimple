      document.body.oncopy = function() {
          toastr.success('复制成功,若要转载请务必保留原文链接！'); 
          };
$(document).ready(function(){
    localStorage.setItem("fontsize", "default");
  $("#fontsizechange").click(function(event){
    event.preventDefault();
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
});