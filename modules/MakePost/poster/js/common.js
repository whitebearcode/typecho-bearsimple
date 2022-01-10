var platform = navigator.platform;
var ua = navigator.userAgent;
var ios = /iPhone|iPad|iPod/.test(platform) && ua.indexOf( "AppleWebKit" ) > -1;
var andriod = ua.indexOf( "Android" ) > -1;
var bearstudio_scrollTop = 0;
var Bearstudio_Touch_on = 1;
var Bearstudio_Touch_openleftnav = 0;
var Bearstudio_Touch_endtime = 0;
var bearstudio_load_yes_on = 0;
var Bearstudio_MENU_on = 0;
var Bearstudio_MENUS_on = 0;
var Bearstudio_MENU_Data = new Object;
var bearstudio_group = 0;


var bearstudio_date_style = 0;
var POPMENU = new Object;
var popup = {
	init : function() {
		var $this = this;
		$('.popup').each(function(index, obj) {
			obj = $(obj);
			var pop = $(obj.attr('href'));
			if(pop && pop.attr('popup')) {
				pop.css({'display':'none'});
				obj.on('click', function(e) {
					$this.open(pop);
					return false;
				});
			}
		});
		this.maskinit();
	},
	maskinit : function() {
		var $this = this;
		$('#mask').off().on('tap', function() {
			$this.close();
		});
	},
	open : function(pop, type, url) {
		if(typeof pop == 'string' && pop.indexOf("messagetext") >= 0){
			var output = $(pop).find('#messagetext p').html();
			var output_no = output.indexOf("if(typeof");
			pop = (output_no > 0 ? output.substring(0, output_no) : output);
			converter = null;
			type = 'alert';
		}
		
		
		if(typeof pop == 'string') {
			if(!bearstudio_date_style){
				$('#ntcmsg').remove();
			}else{
				$('#bearstudio_date_style').remove();
			}
			if(type == 'alerts') {
				pop = '<div class="bearstudio_tip bg_f cl"><dt class="f_b"><p>'+ pop +'</p></dt><dd class="b_t cl"><a href="javascript:;" onclick="popup.close();" class="tip_btn tip_all bg_f f_b">确定</a></dd></div>'
			} else if(type == 'confirm') {			
			if(bearstudio_post_btnwz == 1){
				pop = '<div class="bearstudio_tip bg_f cl"><dt class="f_b"><p>'+ pop +'</p></dt><dd class="b_t cl"><a href="javascript:;" onclick="popup.close();" class="tip_btn bg_f f_b">取消</a><a href="'+ url +'" class="tip_btn bg_f f_0"><span class="tip_lx">确定</span></a></dd></div>'
			}else{
				pop = '<div class="bearstudio_tip bg_f cl"><dt class="f_b"><p>'+ pop +'</p></dt><dd class="b_t cl"><a href="'+ url +'" class="tip_btn bg_f f_0">确定</a><a href="javascript:;" onclick="popup.close();" class="tip_btn bg_f f_b"><span class="tip_lx">取消</span></a></dd></div>'
			}			
			}
			$('body').append('<div id="'+(bearstudio_date_style ? 'bearstudio_date_style' : 'ntcmsg')+'" style="display:none;">'+ pop +'</div>');
			pop = $((bearstudio_date_style ? '#bearstudio_date_style' : '#ntcmsg'));
		}
		
		var bearstudio_textarea = $('#' + pop.attr('id') + ' textarea').length > 0 ? 1 : 0;
		var html_box = pop.html().replace(/-bearstudio_htmlid-/gm, "newid_");
		
		if(POPMENU[pop.attr('id')]) {
			$('#' + pop.attr('id') + '_popmenu').html(html_box).css({'height':pop.height()+'px', 'width':bearstudio_textarea ? '90%' : pop.width()+'px'});
		} else {
			pop.parent().append('<div class="dialogbox" id="'+ pop.attr('id') +'_popmenu" style="height:'+ pop.height() +'px;width:'+ (bearstudio_textarea ? '90%' : pop.width()) +'px;">'+ html_box +'</div>');
		}
		var popupobj = $('#' + pop.attr('id') + '_popmenu');
		var left = bearstudio_textarea ? '5%' : (window.innerWidth - popupobj.width()) / 2;
		var top = bearstudio_textarea ? '70px' : (document.documentElement.clientHeight - popupobj.height()) / 2;
		var z_index = bearstudio_date_style ? '125' : '120'
		popupobj.css({'display':'block','position':'fixed','left':left,'top':top,'z-index':z_index,'opacity':1});
		
		bearstudio_textarea ? (popupobj.hasClass("bearstudio_textarea_box") ? '' : popupobj.addClass('bearstudio_textarea_box')) : popupobj.removeClass('bearstudio_textarea_box');
		
		if(bearstudio_date_style){
			$('#bearstudio_menu_bg').off().on('touchstart', function() {
				bearstudio_closedate();
				$(this).css('display','none');
				return false;
			}).css({
				'display':'block',
				'width':'100%',
				'height':'100%',
				'position':'fixed',
				'top':'0',
				'left':'0',
				'background':'transparent',
				'z-index':'121'
			});
		}else{
			$('#mask').css({'display':'block','width':'100%','height':'100%','position':'fixed','top':'0','left':'0','background':'black','opacity':'0.6','z-index':'100'});
		}
		POPMENU[pop.attr('id')] = pop;
		$('#ntcmsg').remove();
		
		Bearstudio_Touch_on = 0;
	},
	bearstudio_close : function() {
		Bearstudio_Touch_on = 1;
		Bearstudio_MENUS_on = 0;
		$('#bearstudio_bgbox').css('display', 'none');
		$('.bearstudio_popup').removeClass("bearstudio_share_box_show");
	},
	close : function() {
		Bearstudio_Touch_on = 1;
		$('#mask').css('display', 'none');
		$.each(POPMENU, function(index, obj) {
			$('#' + index + '_popmenu').css('display','none');
		});
		bearstudio_date_style = 0;
	}
};




function bearstudio_leftnv(){
	if($('.bearstudio_sidenv_box').length > 0){
		if(!$('.bearstudio_body').hasClass('bearstudio_showleftnv')){
			$('body').css({'height' : '100%','width' : '100%', 'overflow' : 'hidden'});
			$('.bearstudio_leftmenubg,.bearstudio_sidenv_box').css({'display' : 'block'});
			bearstudio_scrollTop = $(window).scrollTop();
			// $('.sidenv_li').height($(window).height() - 125);
			$('.bearstudio_body').css({'height' : '100%', 'overflow' : 'hidden'}).scrollTop(bearstudio_scrollTop).removeClass('bearstudio_hideleftnv').addClass("bearstudio_showleftnv");
			$('.bearstudio_sidenv_box').on('webkitTransitionEnd transitionend', function() {
				$(this).off('webkitTransitionEnd transitionend');
				$('.sidenv_li ul').css({'overflow-y' : 'scroll'});
				$('.bearstudio_leftmenubg').on("click", bearstudio_leftnv);
			});
		}else{
			$('.bearstudio_leftmenubg').off("click", bearstudio_leftnv);
			$('.sidenv_li ul').css({'overflow-y': ''});
			$('.bearstudio_body').removeClass("bearstudio_showleftnv").addClass('bearstudio_hideleftnv').on('webkitTransitionEnd transitionend', function() {
				$('.bearstudio_sidenv_box,.bearstudio_leftmenubg').css({'display' : 'none'});
				$(this).off('webkitTransitionEnd transitionend').removeClass('bearstudio_hideleftnv').css({'height' : '', 'overflow' : ''});
				$('body').css({'height' : '','width' : '', 'overflow' : ''});
				$(window).scrollTop(bearstudio_scrollTop);
			});
		}
	}
}
