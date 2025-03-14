<?php
    /**
    * Memos
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>
<link rel="stylesheet" href="https://staticfile.typecho.co.uk/fancybox/fancybox.min.css">
<script>
window.Prism = window.Prism || {};
window.Prism.manual = true; // 禁用自动高亮
</script>
<?php if(Bsoptions('Emoji') == true) :?>
<link href="<?php AssetsDir();?>assets/vendors/bs-emoji/bs-emoji.css" rel="stylesheet" type="text/css">
<?php endif; ?>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
              <div class="page-card">
                    <h2><i class="lightbulb outline icon"></i> <?php $this->title() ?></h2>

    <script src="<?php AssetsDir();?>assets/vendors/marked.js/marked.min.js"></script>
    <script src="<?php AssetsDir();?>assets/vendors/purify/purify.min.js"></script>


    <div id="memo-container"></div>
    <button id="loadMore" class="load-more">加载更多</button>
    
<script>
        var nextPageToken = '';
var MEMO_DOMAIN = '<?php echo Bsoptions('memos_Url');?>';
var pageSize = 10;
var isLoading = false;
var userCache = {};
var pendingUserRequests = {};

async function fetchUserNickname(creator) {
  try {
    const response = await fetch(`${MEMO_DOMAIN}/api/v1/${creator}`);
    if (!response.ok) throw new Error('用户信息获取失败');
    const data = await response.json();
    return data.nickname || '未知用户';
  } catch (error) {
    console.error('获取用户信息失败:', error);
    return '用户加载失败';
  }
}

function updateUserDisplay(creator, nickname) {
  document.querySelectorAll(`.author-name[data-creator="${creator}"]`).forEach(el => {
    el.textContent = nickname;
  });
}

        function getResourceUrl(resource) {
            if (resource.externalLink) return resource.externalLink;
            return `${MEMO_DOMAIN}/file/${encodeURIComponent(resource.name)}/${encodeURIComponent(resource.filename)}`;
        }

        function renderResources(resources) {
            return resources.map(res => {
                const url = getResourceUrl(res);
                if (res.type.startsWith('image/')) {
                    return `<div class="resource-item">
                        <img src="${url}" alt="${res.filename}" loading="lazy">
                    </div>`;
                }
                return `<div class="resource-item">
                    <a href="${url}" target="_blank" rel="noopener"><i class="file alternate outline icon"></i>${res.filename}</a>
                </div>`;
            }).join('');
        }

function renderMemoCard(memo) {
  const container = document.createElement('div');
  container.className = 'memo-item';
  
  const creator = memo.creator;
  const memoId = memo.name;
  const cleanContent = DOMPurify.sanitize(marked.parse(memo.content));
  
  container.innerHTML = `
    <div class="avatar-container">
      <div class="avatar">
      <?php if(Bsoptions('memos_Autoavatar') == '' || Bsoptions('memos_Autoavatar') == true):?>
        <img src="https://api.dicebear.com/7.x/miniavs/svg?seed=${creator.split('/').pop()}">
    <?php else:?>
       <img src="<?php echo Bsoptions('memos_Avatar');?>">
       <?php endif;?>
      </div>
    </div>
    <div class="memo-card">
      <div class="memo-header">
        <span class="author-name" data-creator="${creator}">
          ${userCache[creator] || '加载中...'}
        </span>
        <span class="memo-time">${new Date(memo.displayTime).toLocaleString('zh-CN')}</span>
      </div>
      <div class="memo-body">
        ${cleanContent}
        ${memo.resources?.length ? `<div class="memo-resources">${renderResources(memo.resources)}</div>` : ''}
        ${renderLocation(memo.location)}
      </div>
      <?php if(Bsoptions('memos_Emaction') == true):?>
      <div class="emoji-reaction">
      <emoji-reaction theme="light" endpoint="<?php getEmactionAction();?>" reacttargetid="${memoId}" ></emoji-reaction>
      </div>
      <?php endif;?>
    </div>
  `;

  if (!userCache[creator] && !pendingUserRequests[creator]) {
    pendingUserRequests[creator] = true;
    
    fetchUserNickname(creator).then(nickname => {
      userCache[creator] = nickname;
      pendingUserRequests[creator] = false;
      updateUserDisplay(creator, nickname);
    });
  }

  return container;
}

function renderLocation(location) {
    if (!location || typeof location !== 'object') return '';

    const { placeholder, latitude, longitude } = location;

    if (typeof latitude === 'number' && typeof longitude === 'number') {
        return `
        <div class="memo-location">
            <div class="location-icon"></div>
            <div class="location-text">
                <span>${placeholder || '当前位置'}</span>
            </div>
        </div>
        `;
    }

    if (placeholder) {
        return `
        <div class="memo-location placeholder">
            <div class="location-icon">❔</div>
            <div class="location-text">
                ${placeholder}
            </div>
        </div>
        `;
    }

    return '';
}
  
        async function loadMemos() {
            if (isLoading || nextPageToken === null) return;

            const loadBtn = document.getElementById('loadMore');
            try {
                isLoading = true;
                loadBtn.disabled = true;
                loadBtn.textContent = '加载中...';

                const params = new URLSearchParams({ pageSize });
                if (nextPageToken) params.set('pageToken', nextPageToken);

                const response = await fetch(`${MEMO_DOMAIN}/api/v1/<?php if(Bsoptions('memos_Username') !== '' && Bsoptions('memos_Username') !== null):?>users/<?php echo Bsoptions('memos_Username');?>/<?php endif;?>memos?${params}`);
                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.message || `HTTP错误 ${response.status}`);
                }

                const data = await response.json();
                nextPageToken = data.nextPageToken || null;

                const container = document.getElementById('memo-container');
                data.memos.forEach(memo => container.appendChild(renderMemoCard(memo)));

                loadBtn.textContent = nextPageToken ? '加载更多' : '没有更多了';
            } catch (error) {
                console.error('加载失败:', error);
                loadBtn.textContent = `加载失败: ${error.message}`;
                nextPageToken = null;
            } finally {
                isLoading = false;
                loadBtn.disabled = !nextPageToken;
            }
        }
$(document).ready(function() {
        document.getElementById('loadMore').addEventListener('click', loadMemos);
        loadMemos();
});
    </script>

</div></div>




</div>

<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>