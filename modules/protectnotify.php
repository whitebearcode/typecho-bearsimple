<script>
$(document).ready(function(){
    $("#form").submit(function(e) {
var surl=$("#form").attr("action");//表单地址

$.ajax({
                type: "POST",
                url:surl,
                data:$('#form').serialize(),// 你的form
                async:true,
                error: function(request) {
alert("密码提交失败，请刷新页面重试！");//ajax提交失败报错

                },
                success: function(data) {

if(data.indexOf("密码错误") >= 0 && data.indexOf("<title>Error</title>") >= 0) {
alert("密码错误，请重试！");
location.reload();
}else{
location.reload();
}
}
})
});
return false;
});     
     </script>
