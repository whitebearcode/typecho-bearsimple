$(function() {
  getwaitingdata();
  getapproveddata();
  getrejectdata();

});
  $("#linksearch").bind("input propertychange",function(event){
       getsearchdata($("#linksearch").val());
});
$("#usersearch").bind("input propertychange",function(event){
       getsearchuserdata($("#usersearch").val());
});
$(document).delegate(".ui.gray.icon.label.delete", "click", function() {
  $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfriendaction",
                        data: {
                            "type": 'delete',
                            "linkid":$(this).attr('data-id')
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('该友链已成功删除');
getwaitingdata();
  getapproveddata();
  getrejectdata();
  getsearchdata($("#linksearch").val());
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });

});
$(document).delegate("#createlink", "click", function() {
layer.open({
    type: 1 
    ,btn:["确定新增","取消新增"]
    ,title: '新增友链'
    ,skin: 'layui-layer-prompt'
    ,content: "<div style='margin:-10px 0 10px 0'>友链名称</div><div><input id='friendname' type='text' class='layui-layer-input' value='' placeholder='友链名称'></div><div style='margin:10px 0 10px 0'>友链网址</div><div><input style='margin-top:10px;' id='friendurl' type='text' class='layui-layer-input' value='' placeholder='友链网址'></div><div style='margin:10px 0 10px 0'>友链图标</div><div><input style='margin-top:10px;' id='friendpic' type='text' class='layui-layer-input' value='' placeholder='友链图标'></div><div style='margin:10px 0 10px 0'>友链描述</div><div><input style='margin-top:10px;' id='frienddec' type='text' class='layui-layer-input' value='' placeholder='友链描述'></div><div style='margin:10px 0 10px 0'>联系邮箱</div><div><input style='margin-top:10px;' id='contactmail' type='text' class='layui-layer-input' value='' placeholder='联系邮箱，可为空'></div><div style='margin:10px 0 10px 0'>友链添加至</div><div><select name='addtype' id='addtype'><option value='waiting' select=''>待审核</option><option value='approved'>已通过</option><option value='reject'>已驳回</option></select></div>"
    ,yes: function(index, callback){
        if(!$(callback).find("#friendname").val()){
            layer.msg('友链名称不能为空哦~');
            return false;
        }
        if(!$(callback).find("#friendurl").val()){
            layer.msg('友链网址不能为空哦~');
            return false;
        }
        if(!$(callback).find("#friendpic").val()){
            layer.msg('友链图标不能为空哦~');
            return false;
        }
        if(!$(callback).find("#frienddec").val()){
            layer.msg('友链描述不能为空哦~');
            return false;
        }
      $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfriendaction",
                        data: {
                            "type": 'add',
                            "addtype": $(callback).find("#addtype").val(),
                            "friendname":$(callback).find("#friendname").val(),
                            "friendurl":$(callback).find("#friendurl").val(),
                            "friendpic":$(callback).find("#friendpic").val(),
                            "frienddec":$(callback).find("#frienddec").val(),
                            "contactmail":$(callback).find("#contactmail").val()
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('友链已成功新增，友链列表已自动刷新。');
layer.closeAll();
getwaitingdata();
  getapproveddata();
  getrejectdata();
  getsearchdata($("#linksearch").val());
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                    
    }
});
});

$(document).delegate(".ui.yellow.icon.label.edit", "click", function() {
layer.open({
    type: 1 
    ,btn:["确定修改","取消修改"]
    ,title: '修改友链'
    ,skin: 'layui-layer-prompt'
    ,content: "<div style='margin:-10px 0 10px 0'>友链ID</div><div><input id='friendid' type='text' class='layui-layer-input' value="+$(this).attr('data-id')+" placeholder='友链ID' disabled></div><div style='margin:10px 0 10px 0'>友链网址</div><div><input style='margin-top:10px;' id='friendurl' type='text' class='layui-layer-input' value="+$(this).attr('data-friendurl')+" placeholder='友链网址'></div><div style='margin:10px 0 10px 0'>友链名称</div><div><input style='margin-top:10px;' id='friendname' type='text' class='layui-layer-input' value="+$(this).attr('data-friendname')+" placeholder='友链名称'></div><div style='margin:10px 0 10px 0'>友链图标</div><div><input style='margin-top:10px;' id='friendpic' type='text' class='layui-layer-input' value="+$(this).attr('data-friendpic')+" placeholder='友链图标'></div><div style='margin:10px 0 10px 0'>友链描述</div><div><input style='margin-top:10px;' id='frienddec' type='text' class='layui-layer-input' value="+$(this).attr('data-frienddec')+" placeholder='友链描述'></div><div style='margin:10px 0 10px 0'>联系邮箱</div><div><input style='margin-top:10px;' id='contactmail' type='text' class='layui-layer-input' value="+$(this).attr('data-mail')+" placeholder='联系邮箱' disabled></div>"
    ,yes: function(index, callback){
      $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfriendaction",
                        data: {
                            "type": 'edit',
                            "id":$(callback).find("#friendid").val(),
                            "friendname":$(callback).find("#friendname").val(),
                            "friendurl":$(callback).find("#friendurl").val(),
                            "friendpic":$(callback).find("#friendpic").val(),
                            "frienddec":$(callback).find("#frienddec").val(),
                            "contactmail":$(callback).find("#contactmail").val()
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('ID为'+$(callback).find("#friendid").val()+'的友链已修改成功。');
layer.closeAll();
getwaitingdata();
  getapproveddata();
  getrejectdata();
  getsearchdata($("#linksearch").val());
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                    
    }
});
});



$(document).delegate(".ui.blue.icon.label.approved", "click", function() {
    $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfriendaction",
                        data: {
                            "type": 'approved',
                            "linkid":$(this).attr('data-id'),
                            "linkmail":$(this).attr('data-mail')
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('该友链已批准，已将其加入友链列表。');
getwaitingdata();
  getapproveddata();
  getrejectdata();
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
    
});

$(document).delegate(".ui.blue.icon.label.approved2", "click", function() {
    $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfriendaction",
                        data: {
                            "type": 'approved',
                            "linkid":$(this).attr('data-id'),
                            //"linkmail":$(this).attr('data-mail')
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('该友链已重新获得批准，已将其加入友链列表。');
getwaitingdata();
  getapproveddata();
  getrejectdata();
                        },
                        complete: function() {
                            
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
    
});

$(document).delegate(".ui.red.icon.label.reject", "click", function() {
    $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfriendaction",
                        data: {
                            "type": 'reject',
                            "linkid":$(this).attr('data-id'),
                            "linkmail":$(this).attr('data-mail')
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('该友链已驳回，已将其加入已驳回列表，可在已驳回列表中重新审核。');
getwaitingdata();
  getapproveddata();
  getrejectdata();
                        },
                        complete: function() {
                            
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
});

$(document).delegate(".ui.red.icon.label.reject2", "click", function() {
    $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfriendaction",
                        data: {
                            "type": 'reject',
                            "linkid":$(this).attr('data-id'),
                           // "linkmail":$(this).attr('data-mail')
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('该友链已重新驳回，已将其加入已驳回列表，可在已驳回列表中重新审核。');
getwaitingdata();
  getapproveddata();
  getrejectdata();
                        },
                        complete: function() {
                            
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
});

//获取已经审批通过的友链数据
var approvedpage = 1;
                var approvedn = 0;
                var approvedmax = 1;
function getapproveddata(){
     $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfrienddata",
                        data: {
                            "type": 'approved',
                            "page": approvedpage
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
if(json.list == ''){
    approvedn = json.total;
                            approvedmax = json.max;
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#approvedfl").html(strs);
                            }
                            else{
                                approvedn = json.total;
                            approvedmax = json.max;
content2(json.list);
}

                        },
                        complete: function() {
                            pageList();
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                    function pageList() {
                    approvedpage = Math.min(approvedpage, approvedmax);
                    approvedpage = Math.max(approvedpage, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ approvedpage +">共" + approvedn + "条</a><a class=\"ui label\" data-page="+ approvedpage +">第" + approvedpage + "/" + approvedmax + "页</a>";
                    html += '<a class=\"ui label\"  data-page="1">首页</a>';
                    html += (approvedpage > 1) ? '<a class=\"ui label\"  data-page="' + (approvedpage - 1) + '">上一页</a>' : '<a class=\"ui label\"  data-page="1">上一页</a>';
                    html += (approvedpage < approvedmax) ? '<a class=\"ui label\"  data-page="' + (approvedpage + 1) + '">下一页</a>' : '<a class=\"ui label\"  data-page="' + approvedmax + '">下一页</a>';
                    html += '<a class=\"ui label\"  data-page="' + approvedmax + '">尾页</a><div class=\"ui mini input\"><input id=\"dipage\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" >跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        approvedpage = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipage").value;
                            switch(dipage){
                            case dipage < 1 :
                                approvedpage = 1;
                            break;
                            case dipage > approvedmax:
                                approvedpage = approvedmax;
                            break;
                            default:
                            approvedpage = dipage;
                        };
                        };
                        getapproveddata();
                    });
                    
                    
                    $(".approvedpagelist").html($html);
                }
                
                
     function content2(lists) {
                    var str2 = " ";
                    for(var i in lists) {
if(lists[i]['status'] == 'approved'){
    lists[i]['status'] = '已通过';
}
if(lists[i]['contactmail'] == null){
    lists[i]['contactmail'] = '无';
}
str2 += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['contactmail'] + '</font></font></td><td>' + lists[i]['status'] + '</td><td><div class="ui red icon label reject2"  data-mail="' + lists[i]['contactmail'] + '"data-id="' + lists[i]['id'] + '"><i class="ban icon"></i></div><div class="ui yellow icon label edit"  style="margin-top:5px" data-mail="' + lists[i]['contactmail'] + '" data-id="' + lists[i]['id'] + '" data-friendname="' + lists[i]['friendname'] + '" data-friendurl="' + lists[i]['friendurl'] + '" data-friendpic="' + lists[i]['friendpic'] + '" data-frienddec="' + lists[i]['frienddec'] + '"><i class="edit icon"></i></div><div class="ui gray icon label delete" style="margin-top:5px"  data-id="' + lists[i]['id'] + '"><i class="trash icon"></i></div></td></tr>'
$("#approvedfl").html(str2);
}
}
}

//获取审核中的友链数据
var waitingpage = 1;
                var waitingn = 0;
                var waitingmax = 1;
function getwaitingdata(){
    


    $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfrienddata",
                        data: {
                            "type": 'waiting',
                            "page":waitingpage
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
                            if(json.list == ''){
                                waitingn = json.total;
                            waitingmax = json.max;
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#waitingfl").html(strs);
                            }
                            else{
                                waitingn = json.total;
                            waitingmax = json.max;
content(json.list);
}
                        },
                        complete: function() {
                            pageList();
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    function pageList() {
                    waitingpage = Math.min(waitingpage, waitingmax);
                    waitingpage = Math.max(waitingpage, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ waitingpage +">共" + waitingn + "条</a><a class=\"ui label\" data-page="+ waitingpage +">第" + waitingpage + "/" + waitingmax + "页</a>";
                    html += '<a class=\"ui label\"  data-page="1">首页</a>';
                    html += (waitingpage > 1) ? '<a class=\"ui label\"  data-page="' + (waitingpage - 1) + '">上一页</a>' : '<a class=\"ui label\"  data-page="1">上一页</a>';
                    html += (waitingpage < waitingmax) ? '<a class=\"ui label\"  data-page="' + (waitingpage + 1) + '">下一页</a>' : '<a class=\"ui label\"  data-page="' + waitingmax + '">下一页</a>';
                    html += '<a class=\"ui label\"  data-page="' + waitingmax + '">尾页</a><div class=\"ui mini input\"><input id=\"dipage\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" >跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        waitingpage = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipage").value;
                            switch(dipage){
                            case dipage < 1 :
                                waitingpage = 1;
                            break;
                            case dipage > waitingmax:
                                waitingpage = waitingmax;
                            break;
                            default:
                            waitingpage = dipage;
                        };
                        };
                        getwaitingdata();
                    });
                    
                    
                    $(".waitingpagelist").html($html);
                }
     function content(list) {
                    var str = " ";
                    for(var i in list) {
if(list[i]['status'] == 'waiting'){
    list[i]['status'] = '待审核';
}
if(list[i]['contactmail'] == null){
    list[i]['contactmail'] = '无';
}

str += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['contactmail'] + '</font></font></td><td>' + list[i]['status'] + '</td><td><div class="ui labels"><div class="ui blue icon label approved"  data-mail="' + list[i]['contactmail'] + '" data-id="' + list[i]['id'] + '"><i class="check icon"></i></div><div class="ui red icon label reject"  data-mail="' + list[i]['contactmail'] + '" data-id="' + list[i]['id'] + '"><i class="ban icon"></i></div><div class="ui yellow icon label edit"  style="display:inline;" data-mail="' + list[i]['contactmail'] + '" data-id="' + list[i]['id'] + '" data-friendname="' + list[i]['friendname'] + '" data-friendurl="' + list[i]['friendurl'] + '" data-friendpic="' + list[i]['friendpic'] + '" data-frienddec="' + list[i]['frienddec'] + '"><i class="edit icon"></i></div><div class="ui gray icon label delete" style="margin-top:10px"  data-id="' + list[i]['id'] + '"><i class="trash icon"></i></div></div></td></tr>'
$("#waitingfl").html(str);

}
}
}

//获取已驳回的友链数据
var rejectpage = 1;
                var rejectn = 0;
                var rejectmax = 1;
function getrejectdata(){
     $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfrienddata",
                        data: {
                            "type": 'reject',
                            "page":rejectpage
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
if(json.list == ''){
    rejectn = json.total;
                            rejectmax = json.max;
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#rejectfl").html(strs);
                            }
                            else{
                                rejectn = json.total;
                            rejectmax = json.max;
content3(json.list);
}
                        },
                        complete: function() {
                            pageList();
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                     function pageList() {
                    rejectpage = Math.min(rejectpage, rejectmax);
                    rejectpage = Math.max(rejectpage, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ rejectpage +">共" + rejectn + "条</a><a class=\"ui label\" data-page="+ rejectpage +">第" + rejectpage + "/" + rejectmax + "页</a>";
                    html += '<a class=\"ui label\"  data-page="1">首页</a>';
                    html += (rejectpage > 1) ? '<a class=\"ui label\"  data-page="' + (rejectpage - 1) + '">上一页</a>' : '<a class=\"ui label\"  data-page="1">上一页</a>';
                    html += (rejectpage < rejectmax) ? '<a class=\"ui label\"  data-page="' + (rejectpage + 1) + '">下一页</a>' : '<a class=\"ui label\"  data-page="' + rejectmax + '">下一页</a>';
                    html += '<a class=\"ui label\"  data-page="' + rejectmax + '">尾页</a><div class=\"ui mini input\"><input id=\"dipage\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" >跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        rejectpage = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipage").value;
                            switch(dipage){
                            case dipage < 1 :
                                rejectpage = 1;
                            break;
                            case dipage > rejectmax:
                                rejectpage = rejectmax;
                            break;
                            default:
                            rejectpage = dipage;
                        };
                        };
                        getrejectdata();
                    });
                    
                    
                    $(".rejectpagelist").html($html);
                }
     function content3(listss) {
                    var str3 = " ";
                    for(var i in listss) {
if(listss[i]['status'] == 'reject'){
    listss[i]['status'] = '已驳回';
}
if(listss[i]['contactmail'] == null){
    listss[i]['contactmail'] = '无';
}
str3 += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['contactmail'] + '</font></font></td><td>' + listss[i]['status'] + '</td><td><div class="ui blue icon label approved2" data-mail="' + listss[i]['contactmail'] + '"data-id="' + listss[i]['id'] + '"><i class="check icon"></i></div><div class="ui yellow icon label edit"  style="margin-top:5px" data-mail="' + listss[i]['contactmail'] + '" data-id="' + listss[i]['id'] + '" data-friendname="' + listss[i]['friendname'] + '" data-friendurl="' + listss[i]['friendurl'] + '" data-friendpic="' + listss[i]['friendpic'] + '" data-frienddec="' + listss[i]['frienddec'] + '"><i class="edit icon"></i></div><div class="ui gray icon label delete" style="margin-top:5px" data-id="' + listss[i]['id'] + '"><i class="trash icon"></i></div></td></tr>'
$("#rejectfl").html(str3);
}
}
}

//搜索
var searchpage = 1;
                var searchn = 0;
                var searchmax = 1;
function getsearchdata(val){
          
     $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfrienddata",
                        data: {
                            "type": 'search',
                            'searchval':val,
                            "page": searchpage
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
if(json.list == ''){
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#search").html(strs);
                                searchn = json.total;
                            searchmax = json.max;
                            }
                            else{
                                searchn = json.total;
                            searchmax = json.max;
content4(json.list);
}
                        },
                        complete: function() {
                            searchpageList();
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
              
    function searchpageList() {
                    searchpage = Math.min(searchpage, searchmax);
                    searchpage = Math.max(searchpage, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ searchpage +">共" + searchn + "条</a><a class=\"ui label\" data-page="+ searchpage +">第" + searchpage + "/" + searchmax + "页</a>";
                    html += '<a class=\"ui label\"  data-page="1">首页</a>';
                    html += (searchpage > 1) ? '<a class=\"ui label\"  data-page="' + (searchpage - 1) + '">上一页</a>' : '<a class=\"ui label\"  data-page="1">上一页</a>';
                    html += (searchpage < searchmax) ? '<a class=\"ui label\"  data-page="' + (searchpage + 1) + '">下一页</a>' : '<a class=\"ui label\"  data-page="' + searchmax + '">下一页</a>';
                    html += '<a class=\"ui label\"  data-page="' + searchmax + '">尾页</a><div class=\"ui mini input\"><input id=\"dipage\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" >跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        searchpage = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipage").value;
                            switch(dipage){
                            case dipage < 1 :
                                searchpage = 1;
                            break;
                            case dipage > searchmax:
                                searchpage = searchmax;
                            break;
                            default:
                            searchpage = dipage;
                        };
                        };
                        getsearchdata($("#linksearch").val());
                    });
                    
                    
                    $(".searchpagelist").html($html);
                }
                
     function content4(listsss) {
                    var str4 = " ";
                    for(var i in listsss) {

if(listsss[i]['contactmail'] == null){
    listsss[i]['contactmail'] = '无';
}
if(listsss[i]['status'] == 'reject'){
    listsss[i]['status'] = '已驳回';
    str4 += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['contactmail'] + '</font></font></td><td>' + listsss[i]['status'] + '</td><td><div class="ui blue icon label approved2" data-mail="' + listsss[i]['contactmail'] + '"data-id="' + listsss[i]['id'] + '"><i class="check icon"></i></div><div class="ui yellow icon label edit"  style="margin-top:5px" data-mail="' + listsss[i]['contactmail'] + '" data-id="' + listsss[i]['id'] + '" data-friendname="' + listsss[i]['friendname'] + '" data-friendurl="' + listsss[i]['friendurl'] + '" data-friendpic="' + listsss[i]['friendpic'] + '" data-frienddec="' + listsss[i]['frienddec'] + '"><i class="edit icon"></i></div><div class="ui gray icon label delete" style="margin-top:5px" data-id="' + listsss[i]['id'] + '"><i class="trash icon"></i></div></td></tr>'
}
if(listsss[i]['status'] == 'waiting'){
    listsss[i]['status'] = '待审核';
    str4 += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['contactmail'] + '</font></font></td><td>' + listsss[i]['status'] + '</td><td><div class="ui labels"><div class="ui blue icon label approved"  data-mail="' + listsss[i]['contactmail'] + '" data-id="' + listsss[i]['id'] + '"><i class="check icon"></i></div><div class="ui red icon label reject"  data-mail="' + listsss[i]['contactmail'] + '" data-id="' + listsss[i]['id'] + '"><i class="ban icon"></i></div><div class="ui yellow icon label edit"  style="display:inline;" data-mail="' + listsss[i]['contactmail'] + '" data-id="' + listsss[i]['id'] + '" data-friendname="' + listsss[i]['friendname'] + '" data-friendurl="' + listsss[i]['friendurl'] + '" data-friendpic="' + listsss[i]['friendpic'] + '" data-frienddec="' + listsss[i]['frienddec'] + '"><i class="edit icon"></i></div><div class="ui gray icon label delete" style="margin-top:10px"  data-id="' + listsss[i]['id'] + '"><i class="trash icon"></i></div></div></td></tr>'
}
if(listsss[i]['status'] == 'approved'){
    listsss[i]['status'] = '已通过';
    str4 += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listsss[i]['contactmail'] + '</font></font></td><td>' + listsss[i]['status'] + '</td><td><div class="ui red icon label reject2"  data-mail="' + listsss[i]['contactmail'] + '"data-id="' + listsss[i]['id'] + '"><i class="ban icon"></i></div><div class="ui yellow icon label edit"  style="margin-top:5px" data-mail="' + listsss[i]['contactmail'] + '" data-id="' + listsss[i]['id'] + '" data-friendname="' + listsss[i]['friendname'] + '" data-friendurl="' + listsss[i]['friendurl'] + '" data-friendpic="' + listsss[i]['friendpic'] + '" data-frienddec="' + listsss[i]['frienddec'] + '"><i class="edit icon"></i></div><div class="ui gray icon label delete" style="margin-top:5px"  data-id="' + listsss[i]['id'] + '"><i class="trash icon"></i></div></td></tr>'
}

$("#search").html(str4);
}
}
}


//用户中心
$(document).delegate("#sendtongzhi", "click", function() {
layer.open({
    type: 1 
    ,btn:["确定发送","取消发送"]
    ,title: '发送通知'
    ,skin: 'layui-layer-prompt'
    ,content: "<div style='margin:-10px 0 10px 0' id='token-input-user'>搜索用户</div><div style='margin-left:-10px'><input id='searchUser' name='searchUser' type='text' class='layui-layer-input' ></div><div style='margin:10px 0 10px 0'>通知标题</div><div style='margin-left:-40px'><input style='margin-top:10px;' id='notifytitle' type='text' class='layui-layer-input' value='' placeholder='要发送的通知标题'></div><div style='margin:10px 0 10px 0'>通知内容</div><div><textarea style='margin-top:10px;' id='notifytext'  class='layui-layer-input'  placeholder='要发送的通知内容'></textarea></div><script>$(function(){var users=$('#searchUser'),usersPre=[];if(users.length>0){var items=users.val().split(','),result=[];for(var i=0;i<items.length;i++){var user=items[i];if(!user){continue;}usersPre.push({id:tag,name:tag});}users.tokenInput(document.location.protocol+'/index.php/getUsers',{propertyToSearch:'name',tokenValue:'id',searchDelay:0,preventDuplicates:true,animateDropdown:true,hintText:'请输入用户名',noResultsText:'啊哦~没有任何结果',searchingText:'熊宝正在搜寻中......',prePopulate:usersPre,onResult:function(result,query,val){if(!query){return result;}if(!result){result=[];}if(!result[0]||result[0]['id']!=query){result.unshift({id:val,name:val});}return result.slice(0,5);}});$('#token-input-user').focus(function(){var t=$('.token-input-dropdown'),offset=t.outerWidth()-t.width();t.width($('.token-input-list').outerWidth()-offset);});}});</script>"
    ,yes: function(index, callback){
        if(!$(callback).find("#searchUser").val()){
            layer.msg('要发送通知的用户不能为空哦~');
            return false;
        }
        if(!$(callback).find("#notifytitle").val()){
            layer.msg('要发送的通知标题不能为空哦~');
            return false;
        }
        if(!$(callback).find("#notifytext").val()){
            layer.msg('要发送的通知内容不能为空哦~');
            return false;
        }
      $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bs-usernotify",
                        data: {
                            "type": 'notify',
                            "searchUser": $(callback).find("#searchUser").val(),
                            "notifytitle":$(callback).find("#notifytitle").val(),
                            "notifytext":$(callback).find("#notifytext").val(),
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('通知发送成功');
layer.closeAll();
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                    
    }
});
});



//搜索用户
var searchuserpage = 1;
                var searchusern = 0;
                var searchusermax = 1;
function getsearchuserdata(val){
          
     $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bUserAction",
                        data: {
                            "type": 'searchuser',
                            'searchval':val,
                            "page": searchuserpage
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
if(json.list == ''){
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#searchuser").html(strs);
                                searchusern = json.total;
                            searchusermax = json.max;
                            }
                            else{
                                searchusern = json.total;
                            searchusermax = json.max;
content4(json.list);
}
                        },
                        complete: function() {
                            searchuserpageList();
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
              
    function searchuserpageList() {
                    searchuserpage = Math.min(searchuserpage, searchusermax);
                    searchuserpage = Math.max(searchuserpage, 1);
                    var html = "<center><div class=\"ui circular labels\"><a class=\"ui label\" data-page="+ searchuserpage +">共" + searchusern + "条</a><a class=\"ui label\" data-page="+ searchuserpage +">第" + searchuserpage + "/" + searchusermax + "页</a>";
                    html += '<a class=\"ui label\"  data-page="1">首页</a>';
                    html += (searchuserpage > 1) ? '<a class=\"ui label\"  data-page="' + (searchuserpage - 1) + '">上一页</a>' : '<a class=\"ui label\"  data-page="1">上一页</a>';
                    html += (searchuserpage < searchusermax) ? '<a class=\"ui label\"  data-page="' + (searchuserpage + 1) + '">下一页</a>' : '<a class=\"ui label\"  data-page="' + searchusermax + '">下一页</a>';
                    html += '<a class=\"ui label\"  data-page="' + searchusermax + '">尾页</a><div class=\"ui mini input\"><input id=\"dipage\" type=\"number\" placeholder=\"输入跳转的页码\"></div><a id=\"gopage\" class=\"ui label\" >跳转到指定页</a></div></center>';
                    var $html = $(html);
                    
                    $html.find("a").click(function() {
                        if($(this).attr("id")!=='gopage'){
                        searchuserpage = $(this).attr("data-page");
                        }
                        else{
                            var dipage = document.getElementById("dipage").value;
                            switch(dipage){
                            case dipage < 1 :
                                searchuserpage = 1;
                            break;
                            case dipage > searchusermax:
                                searchuserpage = searchusermax;
                            break;
                            default:
                            searchuserpage = dipage;
                        };
                        };
                        getsearchuserdata($("#usersearch").val());
                    });
                    
                    
                    $(".searchuserlist").html($html);
                }
                
     function content4(listsss) {
                    var str4 = " ";
                    for(var i in listsss) {
    str4 += '<tr><td>' + listsss[i]['uid'] + '</td><td>' + listsss[i]['name'] + '</td><td>' + listsss[i]['screenName'] + '</td><td>' + listsss[i]['mail'] + '</td><td>' + listsss[i]['post_num'] + '</td>><td>' + listsss[i]['group'] + '</td><td>' + listsss[i]['coins'] + '</td><td>' + listsss[i]['submission'] + '</td><td><div class="ui yellow icon label edituser"  style="margin-top:5px" data-mail="' + listsss[i]['mail'] + '" data-uid="' + listsss[i]['uid'] + '" data-screenName="' + listsss[i]['screenName'] + '" data-name="' + listsss[i]['name'] + '" data-post_num="' + listsss[i]['post_num'] + '" data-group="' + listsss[i]['group'] + '" data-coins="' + listsss[i]['coins'] + '"  data-submission="' + listsss[i]['submission'] + '" data-coin_name="' + listsss[i]['coin_name'] + '"><i class="edit icon"></i></div></td></tr>'

$("#searchuser").html(str4);
}
}
}


$(document).delegate(".ui.yellow.icon.label.edituser", "click", function() {
    var select = $(this).attr('data-submission');
    if(select == '开启'){
        select =  '<option value="open" selected="selected">开启</option><option value="close">关闭</option>';
    }
    else{
        select =  '<option value="open">开启</option><option value="close"  selected="selected">关闭</option>';
    }
layer.open({
    type: 1 
    ,btn:["确定修改","取消修改"]
    ,title: '修改用户'
    ,skin: 'layui-layer-prompt'
    ,content: "<div style='margin:-10px 0 10px 0'>UID</div><div><input id='uid' type='text' class='layui-layer-input' value="+$(this).attr('data-uid')+" placeholder='用户UID' disabled></div><div style='margin:10px 0 10px 0'>账号</div><div><input style='margin-top:10px;' id='name' type='text' class='layui-layer-input' value="+$(this).attr('data-name')+" placeholder='账号' disabled></div><div style='margin:10px 0 10px 0'>昵称</div><div><input style='margin-top:10px;' id='screenName' type='text' class='layui-layer-input' value="+$(this).attr('data-screenName')+" placeholder='昵称' disabled></div><div style='margin:10px 0 10px 0'>电邮</div><div><input style='margin-top:10px;' id='mail' type='text' class='layui-layer-input' value="+$(this).attr('data-mail')+" placeholder='邮箱' disabled></div><div style='margin:10px 0 10px 0'>"+$(this).attr('data-coin_name')+"</div><div><input style='margin-top:10px;' id='coins' type='text' class='layui-layer-input' value="+$(this).attr('data-coins')+" placeholder=''></div><div style='margin:10px 0 10px 0'>投稿权限</div><div><select name='submission_type' id='submission_type'>"+select+"</select></div>"
    ,yes: function(index, callback){
      $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bUserAction",
                        data: {
                            "type": 'edituser',
                            "uid":$(callback).find("#uid").val(),
                            "coins":$(callback).find("#coins").val(),
                            "submission_type":$(callback).find($("#submission_type")).find("option:selected").val()
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
toastr.success('UID为'+$(callback).find("#uid").val()+'的用户信息已修改成功。');
layer.closeAll();
  getsearchuserdata($("#usersearch").val());
                        },
                        complete: function() {
                        },
                        error: function() {
                            toastr.warning('数据获取错误，请稍后再试~~');
                        }
                    });
                    
                    
    }
});
});