//黑暗模式
function darkMode(){
    //黑暗模式
if(setting.darkmode == 'true'){
    const logo = $('#sitelogo').attr('src');
    if(setting.logo_type == 'image' && setting.darkmode_logo !== ''){
    if(localStorage.getItem('theme') == 'dark'){
      $('#sitelogo').attr("src",setting.darkmode_logo);  
    }
    else{
      $('#sitelogo').attr("src",logo);    
    }
    }
    if(setting.darkmodetype !== '' && setting.darkmodetype.indexOf("2") !== -1){
 //跟随系统逻辑判断
   const media = window.matchMedia('(prefers-color-scheme:dark)');
   media.addEventListener('change',(e) => {
       if (e.matches) {
   $('#darkmode').attr("checked", true);
  document.documentElement.setAttribute('data-theme', 'dark');
  localStorage.setItem('theme', 'dark');
  
  if(setting.logo_type == 'image' && setting.darkmode_logo !== ''){
   $('#sitelogo').attr("src",setting.darkmode_logo);   
  }
  
} else {
    $('#darkmode').attr("checked", false);
  document.documentElement.setAttribute('data-theme', 'light');
  localStorage.setItem('theme', 'light');
  
  if(setting.logo_type == 'image' && setting.darkmode_logo !== ''){
   $('#sitelogo').attr("src",logo);   
  }
}
});
}

if(setting.darkmodetype !== '' && setting.darkmodetype.indexOf("1") != -1){
//根据早晚时间自动设置
const nowtime = new Date().getHours();
if(localStorage.getItem('clickmode') !== 'true'){
if (nowtime >= 22 && nowtime <= 6 || nowtime === 22){
    $('#darkmode').attr("checked", true);
  document.documentElement.setAttribute('data-theme', 'dark');
  localStorage.setItem('theme', 'dark');
  localStorage.setItem('automode', 'true');
  if(setting.logo_type == 'image' && setting.darkmode_logo !== ''){
   $('#sitelogo').attr("src",setting.darkmode_logo);   
  }
}
else{
    if(localStorage.getItem("automode") == 'true'){
        localStorage.removeItem('automode');
        
        if(setting.logo_type == 'image' && setting.darkmode_logo !== ''){
   $('#sitelogo').attr("src",logo);   
  }
  
    }
}
}
}


const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
$('#darkmode').on('click',function(){
    if (setting.Mournmode == 'true') {
    $('body').toast({

							    title:'抱歉',
							    class: 'warning',
							    message: '当前处于哀悼模式，无法进入夜间模式哦~', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
				        return false;
}
if(localStorage.getItem("automode") == 'true'){
   localStorage.setItem('clickmode', 'true'); 
}
else{
    localStorage.removeItem('clickmode');
}

if($('#darkmode').is(':checked')){
    document.documentElement.setAttribute('data-theme', 'dark');
  localStorage.setItem('theme', 'dark');
  
  if(setting.logo_type == 'image' && setting.darkmode_logo !== ''){
   $('#sitelogo').attr("src",setting.darkmode_logo);   
  }
  
}
else{
    document.documentElement.setAttribute('data-theme', 'light');
  localStorage.setItem('theme', 'light');
  if(setting.logo_type == 'image' && setting.darkmode_logo !== ''){
   $('#sitelogo').attr("src",logo);   
  }
}
});



if (currentTheme && setting.Mournmode !== 'true') {
 document.documentElement.setAttribute('data-theme', currentTheme);
  if (currentTheme === 'light') {
       $('#darkmode').attr("checked", false);
  }
  else if (currentTheme === 'dark') {
    $('#darkmode').attr("checked", true);
  }
}



}
}


darkMode();