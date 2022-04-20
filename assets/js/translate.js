//Google Translate Website Tools
function googleTranslateElementInit2() {console.log('load')
    new google.translate.TranslateElement({
        pageLanguage: 'auto',
        autoDisplay: false
    },
    'google_translate_element2');
}

//开始控制翻译层
var t;
//将setTimeout事件remove掉
function clearTime() {
    clearTimeout(t);
}

function openLogin() {
    document.getElementById("win").style.display = "";
}
function closeLogin() {
    t = setTimeout('document.getElementById("win").style.display="none"', 400);
}

function all_language() {
    document.getElementById("win").style.display = "none";
    document.getElementById("all_language").style.display = "";
    document.getElementById("back").style.display = "";
}
function close_all_language() {
    // t = setTimeout('document.getElementById("all_language").style.display="none";document.getElementById("back").style.display="none";document.getElementById("win").style.display="none";', 1000);
}
//关闭翻译
                        $(document).ready(function(){
                        	window.send = $("html").html();//alert(send);
                        })
                        function closeTranslate(){
						    delCookie("googtrans");
							//$("html").html(send);
							//document.write(send);
							//send = $("html").html();
						    window.location.reload();
						    //parent.document.location.reload();
						}
						
function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg)) return unescape(arr[2]);
    else return null;
}

function delCookie(name) {
    var host = document.domain;
    var ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
    var reg = host.match(ip);
    if (reg == null) {
        var domain = host.split(".");
        var domain_b = domain.length;
        domain_b--;
        var domain_a = domain_b - 1;
        var domain = "." + domain[domain_a] + "." + domain[domain_b];
        document.cookie = name + '=;domain=' + domain + ';expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
        
    } 
        document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
    //console.log(domain);
}

function GTranslateFireEvent(a, b) {
	try {
		if (document.createEvent) {
			var c = document.createEvent("HTMLEvents");
			c.initEvent(b, true, true);
			a.dispatchEvent(c)
		} else {
			var c = document.createEventObject();
			a.fireEvent('on' + b, c)
		}
	} catch (e) {}
}
function doGTranslate(a) {
	if (a.value) a = a.value;
	if (a == '') return;
	var b = a.split('|')[1];
	var c;
	var d = document.getElementsByTagName('select');
	for (var i = 0; i < d.length; i++) if (d[i].className == 'goog-te-combo') c = d[i];
	if (document.getElementById('google_translate_element2') == null || document.getElementById('google_translate_element2').innerHTML.length == 0 || c.length == 0 || c.innerHTML.length == 0) {
		setTimeout(function() {
			doGTranslate(a)
		}, 500)
	} else {
		c.value = b;
		GTranslateFireEvent(c, 'change');
		GTranslateFireEvent(c, 'change')
	}
}

String.prototype.escNone=function(){
    return this.toString()
};

var strHtml='<link rel="stylesheet" href="//deliver.application.pub/gh/whitebearcode/Translate/translate.css" type="text/css" /><script type="text/javascript" src="//deliver.application.pub/gh/whitebearcode/translate_bearsimple/element_latest.js?cb=googleTranslateElementInit2"></script>';
document.write(strHtml.escNone());
var Words ="";
function OutWord()
{
var NewWords;
NewWords = unescape(Words);
document.write(NewWords);
}
OutWord();

