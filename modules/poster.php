<div id="posterModal" class="poster-modal">
    <div class="poster-modal__content" onclick="event.stopPropagation()">
        <span class="poster-modal__close" onclick="closeModal()">&times;</span>
        <!-- 加载动画 -->
        <div id="posterLoading" class="poster-modal__loading">
            <div class="poster-modal__spinner"></div>
            <div class="poster-modal__loading-text">生成中，请稍候...</div>
        </div>
        <img id="posterImage" src="" alt="海报" style="display: none;">
        <!-- 下载海报按钮 -->
        <div class="poster-modal__button-container">
            <button class="poster-modal__button" onclick="downloadPoster()" style="display: none;">下载海报</button>
        </div>
    </div>
</div>

<!-- 引入库 -->
<script src="<?php AssetsDir();?>assets/js/qrcode.min.js"></script>
<script src="<?php AssetsDir();?>assets/js/html2canvas.min.js"></script>
<script>
    // 弹窗相关
    var posterModal = document.getElementById('posterModal');
    var posterImage = document.getElementById('posterImage');
    var posterLoading = document.getElementById('posterLoading');
    var downloadButton = document.querySelector('.poster-modal__button');

    // 打开弹窗
    function openModal() {
        posterModal.classList.add('poster-modal--active');
    }

    // 关闭弹窗
    function closeModal() {
        posterModal.classList.remove('poster-modal--active');
    }

    // 点击外部关闭弹窗
    posterModal.addEventListener('click', (event) => {
        if (event.target === posterModal) {
            closeModal();
        }
    });

    // 生成海报
    async function generatePoster() {
        // 显示加载动画
        posterLoading.style.display = 'flex';
        posterImage.style.display = 'none';
        downloadButton.style.display = 'none';

        // 打开弹窗
        openModal();

        // 使用 setTimeout 确保 UI 更新
        await new Promise((resolve) => setTimeout(resolve, 0));

        // 动态创建海报模板
        var posterTemplate = document.createElement('div');
        posterTemplate.className = 'poster-template';

        // 封面
        var cover = document.createElement('div');
        cover.className = 'poster-template__cover';
        cover.style.backgroundImage = `url('<?php echo posterPic($this->cid);?>')`;
        posterTemplate.appendChild(cover);

        // 内容
        var content = document.createElement('div');
        content.className = 'poster-template__content';

        // 标题
        var title = document.createElement('div');
        title.className = 'poster-template__title';
        title.innerText = '<?php echo $this->title;?>';
        content.appendChild(title);

        // 摘要
        var summary = document.createElement('div');
        summary.className = 'poster-template__summary';
        summary.innerText = `<?php if ($this->fields->excerpt == null): ?>
            <?php echo excerpt($this->excerpt, 80); ?>
        <?php else: ?>
            <?php $this->fields->excerpt(); ?>
        <?php endif; ?>`;
        content.appendChild(summary);

        // 信息
        var info = document.createElement('div');
        info.className = 'poster-template__info';
        info.innerHTML = `
            <span>作者：<?php $this->author(); ?></span>
            <span>时间：<?php $this->date(); ?></span>
        `;
        content.appendChild(info);

        // 底部区域
        var footer = document.createElement('div');
        footer.className = 'poster-template__footer';

        var blogName = document.createElement('div');
        blogName.className = 'poster-template__blog-name';
        
        <?php if(Bsoptions('Poster__LogoUrl') !== null && Bsoptions('Poster__LogoUrl') !== ''): ?>
        var blogNameImage = document.createElement('img');
        blogNameImage.src = '<?php echo Bsoptions('Poster__LogoUrl');?>';
        blogName.appendChild(blogNameImage);
        <?php else:?>
        var blogNameText = document.createElement('span');
        blogNameText.innerText = '<?php echo Bsoptions('textlogo_text') ?>';
        blogName.appendChild(blogNameText);
        <?php endif;?>
        footer.appendChild(blogName);

       // 二维码
    var qrcodeContainer = document.createElement('div');
    qrcodeContainer.className = 'poster-template__qrcode';
    var articleUrl = '<?php $this->permalink(); ?>';
    try {
        const qrcodeImg = document.createElement('canvas');
        QRCode.toCanvas(qrcodeImg, articleUrl, {
        width: 100,
        height: 100
    });
    const articleImageUrl = qrcodeImg.toDataURL('image/png');
        qrcodeImg.src = articleImageUrl;
        qrcodeContainer.appendChild(qrcodeImg);
    } catch (error) {
        console.error('生成二维码失败:', error);
        qrcodeContainer.innerText = '二维码生成失败';
    }

    // 扫一扫文字
    var scanText = document.createElement('div');
    scanText.className = 'poster-template__qrcode-text';
    scanText.innerText = '扫一扫二维码';
    qrcodeContainer.appendChild(scanText);

footer.appendChild(qrcodeContainer);
        posterTemplate.appendChild(content);
        posterTemplate.appendChild(footer);
        document.body.appendChild(posterTemplate);

        // 生成海报图片
        var canvas = await html2canvas(posterTemplate, {
            logging: false // 关闭日志输出
        });

        var img = canvas.toDataURL('image/png');
        posterImage.src = img;

        // 隐藏加载动画，显示海报和下载按钮
        posterLoading.style.display = 'none';
        posterImage.style.display = 'block';
        downloadButton.style.display = 'block';

        // 移除临时海报模板
        document.body.removeChild(posterTemplate);
    }

    // 下载海报
    function downloadPoster() {
        var link = document.createElement('a');
        link.href = posterImage.src;
        link.download = 'poster-<?php echo $this->cid;?>.png';
        link.click();
    }
</script>