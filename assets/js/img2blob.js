/************************************************
 * #### jQuery img2blob.js ####
 * Coded by Ican Bachors 2017.
 * http://ibacor.com/labs/jquery-image-to-blob/
 * Updates will be posted to this site.
 ***********************************************/
$.fn.img2blob = function(a) {
    var b = {
        watermark: '',
		fontStyle: 'Microsoft YaHei',
		fontSize: '30',
		fontColor: 'black',
		fontX: 10,
		fontY: 50
    };
	if (typeof a === 'object') {
		a.watermark = (a.watermark == undefined ? b.watermark : a.watermark);
		a.fontStyle = (a.fontStyle == undefined ? b.fontStyle : a.fontStyle);
		a.fontSize  = (a.fontSize  == undefined ? b.fontSize  : a.fontSize);
		a.fontColor = (a.fontColor == undefined ? b.fontColor : a.fontColor);
		a.fontX 	= (a.fontX     == undefined ? b.fontX     : a.fontX);
		a.fontY     = (a.fontY     == undefined ? b.fontY     : a.fontY);
	} else {
		a = b;
	}
	
    $(this).each(function(i, c) {
        var d = $(this).data('img2blob'),
            e = '.' + $(this).attr('class'),
			f = new Image();
			
		f.onload = function() {
		    f.setAttribute("crossOrigin",'Anonymous');
            var g    = document.createElement('canvas');
            g.width  = f.naturalWidth;
            g.height = f.naturalHeight;
			var h    = g.getContext('2d');
            h.drawImage(f, 0, 0);
			if(a.watermark != ''){
				h.font 		= a.fontSize + 'px ' + a.fontStyle;
				h.fillStyle = a.fontColor;
				h.fillText(a.watermark, a.fontX, a.fontY);
			}
            var j = g.toDataURL('image/png'),
                k = DataUriToBinary(j),
                l = new Blob([k], {
                    type: 'image/png'
                }),
                m = window.URL.createObjectURL(l);
            $(e).eq(i).attr('src', m);
        };
        f.src = d;
    });

    function DataUriToBinary(n) {
        var o = ';base64,',
			p = n.indexOf(o) + o.length,
			q = n.substring(p),
			r = window.atob(q),
			s = r.length,
			t = new Uint8Array(new ArrayBuffer(s));
        for (i = 0; i < s; i++) {
            t[i] = r.charCodeAt(i);
        }
        return t;
    }
}
