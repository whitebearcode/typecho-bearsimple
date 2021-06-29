 <script>
//获取当前时间，格式YYYY-MM-DD
    function getNowFormatDate() {
        var date = new Date();
        var seperator1 = "-";
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var currentdate = year + seperator1 + month + seperator1 + strDate;
        return currentdate;
    }
//写cookies 
 
function setCookie(name,value) 
{ 
    var Days = 30; 
    var exp = new Date(); 
    exp.setTime(exp.getTime() + Days*24*60*60*1000); 
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString(); 
} 
 
//读取cookies 
function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
  
    if(arr=document.cookie.match(reg))
  
        return unescape(arr[2]); 
    else 
        return null; 
} 
$(".ui.red.button").on("click", function(){
    var date = getNowFormatDate();
    var num = getCookie(date) ? getCookie(date) : 0;
    if(num<=1){
        num++;
        setCookie(date,num);
    //处理点赞逻辑
     $(".ui.red.button").on("click", function(){
   var id = <?php $this->cid() ?>;
   sendBtn(id);
   })   
function sendBtn(id)
    {
        $.ajax({
            url: "<?php Helper::options()->index('/like'); ?>"
            ,data: {"cid":id}
            ,type: 'post'
            ,success: function(e){
                if(e == 'error')
                {
                    toastr.error('点赞失败!');
                    return false;
                }
                else{
                toastr.success('点赞成功!');
                location.reload();
                }
            }
        })
    }
    }else{
        toastr.error('您今日的点赞次数已用光,请明天再来!');
    }
})

  
    
</script>