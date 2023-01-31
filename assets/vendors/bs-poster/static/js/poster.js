	"use strict";
	var poster = function (){
		var DEBUG = false;
		var WIDTH = 720;
		var HEIGHT = 1280;
		function init(config){
			var $container = document.querySelector(config.selector);
			var $wrapper = createDom('div', 'id', 'wrapper');
			var $canvas = createDom('canvas', 'id', 'canvas', 'block');
			var $day = createDom('canvas', 'id', 'day');
			var $date = createDom('canvas', 'id', 'date');
			var $title = createDom('canvas', 'id', 'title');
			var $content = createDom('canvas', 'id', 'content');
			var $postmeta = createDom('canvas', 'id', 'postmeta');
			var $posttimeym = createDom('canvas', 'id', 'posttimeym');
			var $posttimed = createDom('canvas', 'id', 'posttimed');
			var $description = createDom('canvas', 'id', 'description');
			appendChilds($wrapper, $canvas, $day, $date, $title, $content, $postmeta, $posttimeym, $posttimed, $description);
			$container ? $container.appendChild($wrapper) : "";
			
			var date = new Date(); 
			// 日
			var dayStyle = {
				font: 'bold 70px Arial',
				color: 'rgba(255, 255, 255, 1)',
				position: 'left'
			};
			drawOneline($day, dayStyle, date.getDate()); 
			// 年月
			var dateStyle = {
				font: 'normal 30px Arial',
				color: 'rgba(88, 88, 88, 1)',
				position: 'left'
			};
			drawOneline($date, dateStyle, date.getFullYear() + ' / ' + (date.getMonth() + 1)+ ' / '); 
			// 文章标题
			var titleStyle = {
				font: 'bold normal 29px Arial',
				color: 'rgba(66, 66, 66, 1)',
				position: 'left',
				lineHeight: 1.4,
				maxHeight: 70

			};
			titleStyle.font = config.titleStyle && config.titleStyle.font || titleStyle.font;
			titleStyle.color = config.titleStyle && config.titleStyle.color || titleStyle.color;
			titleStyle.position = config.titleStyle && config.titleStyle.position || titleStyle.position;
			drawMoreLines($title, titleStyle, config.title); 
			// 文章摘要
			var contentStyle = {
				font: '24px Arial',
				color: 'rgba(88, 88, 88, 1)',
				position: 'left',
				lineHeight: 1.5,
				maxHeight: 210
			};
			contentStyle.font = config.contentStyle && config.contentStyle.font || contentStyle.font;
			contentStyle.color = config.contentStyle && config.contentStyle.color || contentStyle.color;
			contentStyle.position = config.contentStyle && config.contentStyle.position || contentStyle.position;
			contentStyle.lineHeight = config.contentStyle && config.contentStyle.lineHeight || contentStyle.lineHeight;
			contentStyle.maxHeight = config.contentStyle && config.contentStyle.maxHeight || contentStyle.maxHeight;
			drawMoreLines($content, contentStyle, config.content); 
			// 文章Meta
			var postmetaStyle = {
				font: 'normal 24px Arial',
				color: 'rgb(255, 167, 0)',
				position: 'left',
				lineHeight: 1.5,
				maxHeight: 72
			};
			postmetaStyle.font = config.postmetaStyle && config.postmetaStyle.font || postmetaStyle.font;
			postmetaStyle.color = config.postmetaStyle && config.postmetaStyle.color || postmetaStyle.color;
			postmetaStyle.position = config.postmetaStyle && config.postmetaStyle.position || postmetaStyle.position;
			postmetaStyle.lineHeight = config.postmetaStyle && config.postmetaStyle.lineHeight || postmetaStyle.lineHeight;
			postmetaStyle.maxHeight = config.postmetaStyle && config.postmetaStyle.maxHeight || postmetaStyle.maxHeight;
			drawMoreLines($postmeta, postmetaStyle, config.postmeta);

			// 文章发布时间 / 年-月
			var posttimeymStyle = {
				font: 'normal 30px Arial',
				color: 'rgba(255, 255, 255, 1)',
				position: 'left'
			};
			posttimeymStyle.font = config.posttimeymStyle && config.posttimeymStyle.font || posttimeymStyle.font;
			posttimeymStyle.color = config.posttimeymStyle && config.posttimeymStyle.color || posttimeymStyle.color;
			posttimeymStyle.position = config.posttimeymStyle && config.posttimeymStyle.position || posttimeymStyle.position;
			drawMoreLines($posttimeym, posttimeymStyle, config.posttimeym);

			// 文章发布时间 / 日
			var posttimedStyle = {
				font: 'bold 70px Arial',
				color: 'rgba(255, 255, 255, 1)',
				position: 'left'
			};
			posttimedStyle.font = config.posttimedStyle && config.posttimedStyle.font || posttimedStyle.font;
			posttimedStyle.color = config.posttimedStyle && config.posttimedStyle.color || posttimedStyle.color;
			posttimedStyle.position = config.posttimedStyle && config.posttimedStyle.position || posttimedStyle.position;
			drawMoreLines($posttimed, posttimedStyle, config.posttimed);

			// 宣传标语
			var descriptionStyle = {
				font: 'normal 24px Arial',
				color: 'rgba(88, 88, 88, 1)',
				position: 'left',
				lineHeight: 1.3,
				maxHeight: 72
			};
			descriptionStyle.font = config.descriptionStyle && config.descriptionStyle.font || descriptionStyle.font;
			descriptionStyle.color = config.descriptionStyle && config.descriptionStyle.color || descriptionStyle.color;
			descriptionStyle.position = config.descriptionStyle && config.descriptionStyle.position || descriptionStyle.position;
			drawMoreLines($description, descriptionStyle, config.description); 
			
			// Logo 图标
			var logo = new Image();
			logo.setAttribute("crossOrigin",'anonymous');
			logo.src = config.logo;
			// 特色图像
			var banner = new Image();
			banner.setAttribute("crossOrigin",'anonymous');
			banner.src = config.banner;
			//二维码图片
			var qrcode = new Image();
			qrcode.setAttribute("crossOrigin",'anonymous');
			qrcode.src = config.qrcode;
			//背景图片
			var bgimg = new Image();
			bgimg.setAttribute("crossOrigin",'anonymous');
			bgimg.src = "/usr/themes/bearsimple/assets/vendors/bs-poster/static/images/xuxian.png";





			// 生成海报图片
			var onload = function onload(){
				$canvas.width = WIDTH;
				$canvas.height = HEIGHT;
				
				banner.onload = function (){
					var ctx = $canvas.getContext('2d');

					// 绘制背景图片
					var pat = ctx.createPattern(bgimg,"repeat");
					ctx.fillStyle = pat;

					ctx.fillRect(0, 0, $canvas.width, $canvas.height);

					// 绘制 Banner 图片
					ctx.drawImage(banner, 0, $canvas.height / 3 - 427, 720 ,500);

					// 绘制灰色遮罩
					ctx.fillStyle="#00000052";	
					ctx.globalCompositeOperation="source-over";
					ctx.fillRect(0, $canvas.height / 3 - 427, 720 ,500);

					// 绘制文章发布时间
					ctx.drawImage($posttimed, 175, $canvas.height / 3 - 60);
					ctx.drawImage($posttimeym, 10, $canvas.height / 3 - 40);

					ctx.lineWidth = 3;
					ctx.strokeStyle = '#fff';
					ctx.moveTo(30, $canvas.height / 3 + 1);
					ctx.lineTo(185, $canvas.height / 3 +1);
					ctx.stroke(); 
					ctx.beginPath();
					ctx.lineWidth = 5;
					ctx.strokeStyle = '#fff';
					ctx.moveTo(30, $canvas.height / 3 + 10);
					ctx.lineTo(265, $canvas.height / 3 +10);
					ctx.stroke();

					// 绘制文章内容
					ctx.drawImage($title, 10, $canvas.height / 3 + 120);
					ctx.drawImage($content, 10, $canvas.height / 3 + 220);
					ctx.drawImage($postmeta, 10, $canvas.height / 3 + 430);

					// 绘制 Logo 图片
					ctx.drawImage(logo, 30, $canvas.height / 3 + 650, 244 , 80);

					// 绘制二维码图片
					ctx.drawImage(qrcode, 510, $canvas.height / 3 + 620, 185 , 185);

					// logo标语
					ctx.drawImage($description, 10, $canvas.height - 100,);

					var img = new Image();
					img.src = $canvas.toDataURL('image/png');
					var radio = config.radio || 0.7;
					img.width = WIDTH * radio;
					img.height = HEIGHT * radio;
					ctx.clearRect(0, 0, $canvas.width, $canvas.height);
					$canvas.style.display = 'none';
					$container ? $container.appendChild(img) : "";
					$container ? $container.removeChild($wrapper) : "";
					if (config.callback) {
						config.callback($container);
					}
				};
			};
			onload();
		}
		function createDom(name, key, value) {
			var display = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 'none';
			var $dom = document.createElement(name);
			$dom.setAttribute(key, value);
			$dom.style.display = display;
			$dom.width = WIDTH;
			return $dom;
		}
		function appendChilds(parent) {
			for (var _len = arguments.length, doms = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
				doms[_key - 1] = arguments[_key];
			}

			doms.forEach(function (dom) {
				parent.appendChild(dom);
			});
		}
		function drawOneline(canvas, style, content) {
			var ctx = canvas.getContext('2d');
			canvas.height = parseInt(style.font.match(/\d+/), 10) + 20;
			ctx.font = style.font;
			ctx.fillStyle = style.color;
			ctx.textBaseline = 'top';
			var lineWidth = 0;
			var idx = 0;
			var truncated = false;
			for (var i = 0; i < content.length; i++) {
				lineWidth += ctx.measureText(content[i]).width;
				if (lineWidth > canvas.width - 60) {
					truncated = true;
					idx = i;
					break;
				}
			}
			var padding = 30;
			if (truncated) {
				content = content.substring(0, idx);
				padding = canvas.width / 2 - lineWidth / 2;
			}
			if (DEBUG) {
				ctx.strokeStyle = "#6fda92";
				ctx.strokeRect(0, 0, canvas.width, canvas.height);
			}
			if (style.position === 'center') {
				ctx.textAlign = 'center';
				ctx.fillText(content, canvas.width / 2, 0);
			} else if (style.position === 'left') {
				ctx.fillText(content, padding, 0);
			} else {
				ctx.textAlign = 'right';
				ctx.fillText(content, canvas.width - padding, 0);
			}
		}

		function drawMoreLines(canvas, style, content) {
			var ctx = canvas.getContext('2d');
			var fontHeight = parseInt(style.font.match(/\d+/), 10);
			canvas.height = style.maxHeight ? style.maxHeight : 200;
			if (DEBUG) {
				ctx.strokeStyle = "#6fda92";
				ctx.strokeRect(0, 0, canvas.width, canvas.height);
			}
			ctx.font = style.font;
			ctx.fillStyle = style.color;
			ctx.textBaseline = 'top';
			ctx.textAlign = 'center';
			var alignX = 0;
			if (style.position === 'center') {
				alignX = canvas.width / 2;
			} else if (style.position === 'left') {
				ctx.textAlign = 'left';
				alignX = 20;
			} else {
				ctx.textAlign = 'right';
				alignX = canvas.width - 60;
			}
			var lineWidth = 0;
			var lastSubStrIndex = 0;
			var offsetY = 0;
			for (var i = 0; i < content.length; i++) {
				// 累加字体长度（px）
				lineWidth += ctx.measureText(content[i]).width;
				// 字体长度满一行后绘制
				if (lineWidth > canvas.width - 80) {
					ctx.fillText(content.substring(lastSubStrIndex, i), alignX, offsetY);
					offsetY += fontHeight * style.lineHeight;
					lineWidth = 0;
					lastSubStrIndex = i;
				}
				// 字体长度不足一行时绘制
				if (i === content.length - 1) {
					ctx.fillText(content.substring(lastSubStrIndex, i + 1), alignX, offsetY);
				}
			}
		}
		return {
			init: init
		};
	}();