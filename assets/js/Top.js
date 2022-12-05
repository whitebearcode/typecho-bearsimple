/*
*
* 返回顶部 
* Update:22/10/2022
*
*/
(function($){
    //参数opt表示后期根据需求设置icon的css属性值
    jQuery.fn.gotoTop = function(opt){
        var ele = this;
        var win = $(window);
        var doc = $('html,body');
        var index = false;

        //默认icon的css属性值
        var defaultOpt = {
            offset : 420,
            speed : 500,
            iconSpeed : 200,
            animationShow : {'opacity' : '1'},
            animationHide : {'opacity' : '0'}
        };

        //将自定义icon的css属性值更新到options中
        var options = $.extend(defaultOpt,opt);

        

        //判断icon动画样式是不是transform
        $.each(options.animationShow,function(i){
            if(i == 'transform'){
                index = true;
            }
        });

        //icon动画样式显示时
        function animateShow(){
            if(index){
                ele.css(options.animationShow);
            }else{
                ele.stop().animate(options.animationShow,options.iconSpeed);
            }
        }

        //icon动画隐藏时
        function animateHide(){
            if(index){
                ele.css(options.animationHide);
            }else{
                ele.stop().animate(options.animationHide,options.iconSpeed);
            }
        }

    
        
        if(options.scrollTopNow >= options.offset){
            ele.css(options.animationShow);
        }else{
            ele.css(options.animationHide);
        }
    }
}(jQuery));
