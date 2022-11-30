$(function() {
  getwaitingdata();
  getapproveddata();
  getrejectdata();
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
                            alert("数据获取错误，请稍后再试~~");
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
                            alert("数据获取错误，请稍后再试~~");
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
                            alert("数据获取错误，请稍后再试~~");
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
                            alert("数据获取错误，请稍后再试~~");
                        }
                    });
});

//获取已经审批通过的友链数据
function getapproveddata(){
     $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfrienddata",
                        data: {
                            "type": 'approved'
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
if(json.list == ''){
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#approvedfl").html(strs);
                            }
                            else{
content2(json.list);
}

                        },
                        complete: function() {
                            
                        },
                        error: function() {
                            alert("数据获取错误，请稍后再试~~");
                        }
                    });
     function content2(lists) {
                    var str2 = " ";
                    for(var i in lists) {
if(lists[i]['status'] == 'approved'){
    lists[i]['status'] = '已通过';
}
if(lists[i]['contactmail'] == null){
    lists[i]['contactmail'] = '无';
}
str2 += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + lists[i]['contactmail'] + '</font></font></td><td>' + lists[i]['status'] + '</td><td><div class="ui red icon label reject2" data-mail="' + lists[i]['contactmail'] + '"data-id="' + lists[i]['id'] + '"><i class="ban icon"></div></td></tr>'
$("#approvedfl").html(str2);
}
}
}

//获取审核中的友链数据
function getwaitingdata(){

    $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfrienddata",
                        data: {
                            "type": 'waiting'
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
                            if(json.list == ''){
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#waitingfl").html(strs);
                            }
                            else{
content(json.list);
}
                        },
                        complete: function() {
                            
                        },
                        error: function() {
                            alert("数据获取错误，请稍后再试~~");
                        }
                    });
     function content(list) {
                    var str = " ";
                    for(var i in list) {
if(list[i]['status'] == 'waiting'){
    list[i]['status'] = '待审核';
}
if(list[i]['contactmail'] == null){
    list[i]['contactmail'] = '无';
}

str += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + list[i]['contactmail'] + '</font></font></td><td>' + list[i]['status'] + '</td><td><div class="ui labels"><div class="ui blue icon label approved" data-mail="' + list[i]['contactmail'] + '" data-id="' + list[i]['id'] + '"><i class="check icon"></i></div><div class="ui red icon label reject" data-mail="' + list[i]['contactmail'] + '" data-id="' + list[i]['id'] + '"><i class="ban icon"></div></div></td></tr>'
$("#waitingfl").html(str);

}
}
}

//获取已驳回的友链数据
function getrejectdata(){
     $.ajax({
                        type: "POST",
                        url: document.location.protocol+"/index.php/bsfrienddata",
                        data: {
                            "type": 'reject'
                        },
                        dateType: "json",
                        success: function(data) {
                            json = JSON.parse(data);
if(json.list == ''){
                                var strs = " ";
                                strs += '<tr></tr>'
                                $("#rejectfl").html(strs);
                            }
                            else{
content3(json.list);
}
                        },
                        complete: function() {
                            
                        },
                        error: function() {
                            alert("数据获取错误，请稍后再试~~");
                        }
                    });
     function content3(listss) {
                    var str3 = " ";
                    for(var i in listss) {
if(listss[i]['status'] == 'reject'){
    listss[i]['status'] = '已驳回';
}
if(listss[i]['contactmail'] == null){
    listss[i]['contactmail'] = '无';
}
str3 += '<tr><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['friendname'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['friendurl'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['friendpic'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['frienddec'] + '</font></font></td><td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">' + listss[i]['contactmail'] + '</font></font></td><td>' + listss[i]['status'] + '</td><td><div class="ui blue icon label approved2" data-mail="' + listss[i]['contactmail'] + '"data-id="' + listss[i]['id'] + '"><i class="check icon"></i></div></td></tr>'
$("#rejectfl").html(str3);
}
}
}