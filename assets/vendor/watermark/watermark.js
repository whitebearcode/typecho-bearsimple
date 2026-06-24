class Watermark {
  // 默认配置
  static DEFAULTS = {
    type: 'text',          // text/image
    container: 'body',     // 作用区域选择器
    content: 'Watermark',  // 文字内容或图片URL
    width: 160,            // 水印宽度
    fontSize: 14,          // 文字尺寸
    color: '#000000',      // 文字颜色
    bgColor: '#FFFFFF80',  // 文字背景色
    position: 'center',    // 位置: top-left, top-center...
    opacity: 0.5,          // 透明度 0-1
    margin: 20,            // 边距(px)
    format: 'original',    // jpg/png/webp/original
    quality: 0.92,         // 图片质量 0-1
    observeDOM: true,      // 自动检测DOM变化
    pjax: false,           // Pjax兼容模式
    onSuccess: null,       // 成功回调
    onError: null          // 错误回调
  };

  constructor(options = {}) {
    this.config = { ...Watermark.DEFAULTS, ...options };
    this.observer = null;
    this.init();
  }

  // 初始化
  init() {
    this.processExistingImages();
    if (this.config.observeDOM) this.setupObserver();
    if (this.config.pjax) this.setupPjax();
  }

  // 处理现有图片
  processExistingImages() {
    document.querySelectorAll(`${this.config.container} img:not([data-watermarked])`)
      .forEach(img => {
        if (this.isLazyImage(img)) return;
        this.applyWatermark(img);
      });
  }

  // 创建观察者
  setupObserver() {
    this.observer = new MutationObserver(mutations => {
      mutations.forEach(mutation => {
        if (mutation.type === 'childList') {
          this.processExistingImages();
        }
      });
    });

    this.observer.observe(document.querySelector(this.config.container), {
      childList: true,
      subtree: true
    });
  }

  // Pjax支持
  setupPjax() {
    document.addEventListener('pjax:complete', () => {
      this.processExistingImages();
    });
  }

  // 应用水印
  async applyWatermark(img) {
    try {
      // 跳过已处理图片
      if (img.dataset.watermarked) return;
      img.dataset.watermarked = 'processing';

      // 创建画布
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');
      
      // 等待图片加载
      await this.loadImage(img);
      
      // 设置画布尺寸
      [canvas.width, canvas.height] = [img.naturalWidth, img.naturalHeight];
      
      // 绘制原图
      ctx.drawImage(img, 0, 0);
      
      // 应用水印
      if (this.config.type === 'text') {
        this.applyTextWatermark(ctx);
      } else {
        await this.applyImageWatermark(ctx);
      }

      // 转换格式
      const mimeType = this.getMimeType(img.src);
      const newSrc = canvas.toDataURL(mimeType, this.config.quality);
      
      // 更新图片
      img.src = newSrc;
      img.dataset.watermarked = 'true';
      
      // 回调
      this.config.onSuccess?.(img);
    } catch (error) {
      this.handleError(error, img);
    }
  }

  // 应用文字水印
  applyTextWatermark(ctx) {
    ctx.save();
    ctx.globalAlpha = this.config.opacity;
    
    // 计算位置
    const { x, y } = this.calculatePosition(ctx);
    
    // 绘制背景
    ctx.fillStyle = this.config.bgColor;
    const textMetrics = ctx.measureText(this.config.content);
    ctx.fillRect(
      x - 5, 
      y - parseInt(this.config.fontSize) - 2,
      textMetrics.width + 10,
      parseInt(this.config.fontSize) + 4
    );
    
    // 绘制文字
    ctx.fillStyle = this.config.color;
    ctx.font = `${this.config.fontSize}px Arial`;
    ctx.fillText(this.config.content, x, y);
    ctx.restore();
  }

  // 应用图片水印
  async applyImageWatermark(ctx) {
    const watermarkImg = await this.loadImage(this.config.content);
    
    // 计算缩放比例
    const scale = Math.min(
      this.config.width / watermarkImg.width,
      this.config.width / watermarkImg.height
    );
    
    // 计算位置
    const { x, y } = this.calculatePosition(ctx, 
      watermarkImg.width * scale,
      watermarkImg.height * scale
    );
    
    // 绘制水印
    ctx.save();
    ctx.globalAlpha = this.config.opacity;
    ctx.drawImage(
      watermarkImg,
      x, y,
      watermarkImg.width * scale,
      watermarkImg.height * scale
    );
    ctx.restore();
  }

  // 计算水印位置
  calculatePosition(ctx, wmWidth = 0, wmHeight = 0) {
    const { width: imgWidth, height: imgHeight } = ctx.canvas;
    const margin = this.config.margin;
    
    const positions = {
      'top-left': [margin, margin],
      'top-center': [(imgWidth - wmWidth)/2, margin],
      'top-right': [imgWidth - wmWidth - margin, margin],
      'center-left': [margin, (imgHeight - wmHeight)/2],
      'center': [(imgWidth - wmWidth)/2, (imgHeight - wmHeight)/2],
      'center-right': [imgWidth - wmWidth - margin, (imgHeight - wmHeight)/2],
      'bottom-left': [margin, imgHeight - wmHeight - margin],
      'bottom-center': [(imgWidth - wmWidth)/2, imgHeight - wmHeight - margin],
      'bottom-right': [imgWidth - wmWidth - margin, imgHeight - wmHeight - margin]
    };

    return {
      x: positions[this.config.position][0],
      y: positions[this.config.position][1] + (this.config.type === 'text' ? 0 : wmHeight)
    };
  }

  // 辅助方法
  getMimeType(originalSrc) {
    if (this.config.format !== 'original') {
      return `image/${this.config.format}`;
    }
    return originalSrc.match(/data:([^;]+);/)?.[1] || 'image/png';
  }

  loadImage(img) {
    return new Promise((resolve, reject) => {
      if (img.complete && img.naturalWidth !== 0) {
        resolve(img);
        return;
      }

      img.onload = () => resolve(img);
      img.onerror = (e) => reject(new Error('图片加载失败'));
    });
  }

  isLazyImage(img) {
    return img.loading === 'lazy' || 
           img.getAttribute('loading') === 'lazy' ||
           img.dataset.lazy;
  }

  handleError(error, img) {
    console.error('水印处理失败:', error);
    img.dataset.watermarked = 'error';
    this.config.onError?.(error, img);
  }

  // 销毁实例
  destroy() {
    this.observer?.disconnect();
    document.removeEventListener('pjax:complete', this.processExistingImages);
  }
}