jQuery(function($){
	$('[data-event="poster-popover"]').on('click', function(){
		$('.poster-popover-mask, .poster-popover-box').fadeIn()
	});
	$('[data-event="poster-close"]').on('click', function(){
		$('.poster-popover-mask, .poster-popover-box').fadeOut()
	});
	if( $('.post-poster').length ){
			$('.poster-qrcode').qrcode({
				width: 200,
				height: 200,
				text: window.location.href
			});
			var qrcanvas = $('.poster-qrcode canvas')[0];
			var qrcode_img = convertCanvasToImage(qrcanvas)
			function convertCanvasToImage(canvas) {
				var image = new Image();
				canvas ? image.src = canvas.toDataURL("image/png"): "" ;
				return image;
			}
			post_title = poster_info.post_title;
			post_desc = poster_info.excerpt ? poster_info.excerpt : '暂时没有文章摘要！';
			post_meta = '由 @'+poster_info.author+' 发布在《'+poster_info.cat_name+'》栏目';
			post_time_ym = poster_info.time_y_m;
			post_time_d = poster_info.time_d;
			site_desc = poster_info.site_motto ? poster_info.site_motto : '太懒了没有描述可言~';
			poster.init({
				selector: '.poster-popover-box',
				bgimg: '/usr/themes/bearsimple/assets/vendors/bs-poster/static/images/xuxian.png',
				banner: poster_info.att_img,
				logo: poster_info.logo_pure,
				qrcode: qrcode_img['src'],
				title: post_title,
				titleStyle:{
					font: 'bold normal 29px Arial',
					color: 'rgba(66, 66, 66, 1)',
					position: 'left',
					lineHeight: 1.4,
					maxHeight: 70,
				},
				content: post_desc,
				contentStyle:{
					font: 'normal 24px Arial',
					color: 'rgba(88, 88, 88, 1)',
					position: 'left',
					lineHeight: 1.5,
					maxHeight: 174,
				},
				postmeta: post_meta,
				postmetaStyle:{
					font: 'normal 24px Arial',
					color: 'rgb(255, 167, 0)',
					position: 'left',
					lineHeight: 1.5,
					maxHeight: 72,
				},
				posttimeym: post_time_ym,
				posttimeymStyle:{
					font: 'normal 30px Arial',
					color: 'rgba(255, 255, 255, 1)',
					position: 'left',
				},
				posttimed: post_time_d,
				posttimedStyle:{
					font: 'bold 70px Arial',
					color: 'rgba(255, 255, 255, 1)',
					position: 'left',
				},
				description: site_desc,
				descriptionStyle:{
					font: 'normal 24px Arial',
					color: 'rgba(88, 88, 88, 1)',
					position: 'left',
					lineHeight: 1.3,
					maxHeight: 72,
				},
				callback: posterDownload
			});
			function posterDownload(container){
				if(container == null) {return;}
				const $btn = container.querySelector('.poster-download');
				const $img = container.querySelector('img');
				$btn.setAttribute('href', $img.getAttribute('src'));
			}
	}
});