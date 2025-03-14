<?php
    /**
    * 全部标签
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>

<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
            <div class="page-card">
                    <h2><i class="tags icon"></i> <?php $this->title() ?></h2><br>
<div class="tag-page">
    <div class="tag-cloud" id="tagCloud"></div>
    <div class="load-control">
        <button class="load-btn" id="loadMore">显示更多</button>
    </div>
</div>

<script>
$(document).ready(function() {
    const tagCloud = document.getElementById('tagCloud');
    const loadBtn = document.getElementById('loadMore');
    let currentPage = 1;
    let totalPages = 1;

    const renderTags = (tags) => {
        const fragment = document.createDocumentFragment();
        
        tags.forEach(tag => {
            const card = document.createElement('a');
            card.className = 'tag-card';
            card.href = tag.url;
            card.style = `--hue: ${Math.floor(Math.random()*360)}`;
            card.innerHTML = `
                <span class="tag-name">${tag.name}</span>
                <span class="tag-count">${tag.count}</span>
            `;
            fragment.appendChild(card);
        });

        tagCloud.appendChild(fragment);
    };

    const loadTags = async () => {
        loadBtn.disabled = true;
        loadBtn.textContent = '加载中...';
        
        try {
            const response = await fetch('<?php echo getTagsApi();?>?page='+currentPage);
            const { tags, total } = await response.json();
            if(tags.length > 0) {
                renderTags(tags);
                totalPages = Math.ceil(total / 50);
                currentPage++;
                if(currentPage > totalPages) {
                    loadBtn.remove();
                } else {
                    loadBtn.disabled = false;
                    loadBtn.textContent = '显示更多';
                }
            } else {
                loadBtn.remove();
            }
        } catch (error) {
            loadBtn.textContent = '加载失败，点击重试';
            loadBtn.disabled = false;
        }
    };
    loadTags();
    loadBtn.addEventListener('click', loadTags);
});
</script>
</div></div>

</div>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>