document.body.oncopy = function() {toastr.success('复制成功,若要转载请务必保留原文链接！');   };
$(document).ready(function(){
    localStorage.setItem("fontsize", "default");
  $("#fontsizechange").click(function(event){
    event.preventDefault();
    if(localStorage.getItem("fontsize") == '' || localStorage.getItem("fontsize") == 'default'){
    localStorage.setItem("fontsize", "18");
    $(".post-content").animate({"font-size":"18px"});
    }
    else if(localStorage.getItem("fontsize") == '18'){
      localStorage.setItem("fontsize", "25");
    $(".post-content").animate({"font-size":"25px"});  
    }
    else if(localStorage.getItem("fontsize") == '25'){
      localStorage.setItem("fontsize", "32");
    $(".post-content").animate({"font-size":"32px"});  
    }
    else{
        localStorage.setItem("fontsize", "default");
        $(".post-content").animate({"font-size":"15px"});  
    }
  });
});