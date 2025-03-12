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
    <style>
     .memo-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .avatar-container {
            flex: 0 0 50px;
            height: 50px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e5e7eb;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .memo-card {
            flex: 1;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 15px;
            position: relative;
            min-width: 0;
        }

        /* 添加对话气泡小箭头 */
        .memo-card::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 15px;
            width: 0;
            height: 0;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-right: 8px solid #fff;
            filter: drop-shadow(-2px 0 2px rgba(0,0,0,0.1));
        }

        .memo-header {
            display: flex;
            align-items: baseline;
            margin-bottom: 8px;
        }

        .author-name {
            font-weight: 600;
            color: #1a1a1a;
            margin-right: 10px;
            font-size: 16px;
        }

        .memo-time {
            color: #999;
            font-size: 0.85em;
        }

        .memo-body {
            color: #333;
            line-height: 1.6;
            word-break: break-word;
        }

        .memo-body img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 10px;
        }

        .memo-resources {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .resource-item {
            margin-top: 10px;
        }

        .load-more {
            display: block;
            width: fit-content;
            padding: 12px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin:20px auto 0 auto;
        }

        .load-more:hover {
            background: #f8f8f8;
        }
.memo-body {
  color: #374151;
  line-height: 1.75;
  font-size: 16px;
}

.memo-body h1 {
  font-size: 2em;
  margin: 1.2em 0 0.8em;
  padding-bottom: 0.3em;
  border-bottom: 1px solid #e5e7eb;
  color: #1f2937;
}

.memo-body h2 {
  font-size: 1.5em;
  margin: 1.5em 0 0.8em;
  color: #1f2937;
}

.memo-body p {
  margin: 1em 0;
}

.memo-body strong {
  color: #1f2937;
  font-weight: 600;
}

.memo-body em {
  color: #4b5563;
  font-style: italic;
}

.memo-body ul,
.memo-body ol {
  padding-left: 1.5em;
  margin: 1em 0;
}


.memo-body ul {
  list-style: none;
}

.memo-body ol {
  list-style: decimal;
}

.memo-body pre {
  background: #f3f4f6;
  border-radius: 8px;
  padding: 1.25em;
  margin: 1.5em 0;
  overflow-x: auto;
  font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
  border: 1px solid #e5e7eb;
}

.memo-body code {
  font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
  background: rgba(156,163,175,0.15);
  padding: 0.2em 0.4em;
  border-radius: 4px;
  color: #3b82f6;
  font-size: 0.9em;
}

.memo-body pre code {
  background: transparent;
  padding: 0;
  color: #1f2937;
  font-size: 0.95em;
  line-height: 1.5;
}

.memo-body a {
  color: #3b82f6;
  text-decoration: none;
  border-bottom: 1px solid #bfdbfe;
}

.memo-body a:hover {
  color: #2563eb;
  border-bottom-color: currentColor;
}

.memo-body img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin: 1em 0;
  background: #fff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.memo-body blockquote {
  border-left: 4px solid #e5e7eb;
  margin: 1.5em 0;
  padding: 0.5em 1em;
  color: #4b5563;
  background: #f8fafc;
  border-radius: 0 6px 6px 0;
}

.memo-body table {
  width: 100%;
  border-collapse: collapse;
  margin: 1.5em 0;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.memo-body th,
.memo-body td {
  padding: 0.75em;
  border: 1px solid #e5e7eb;
  text-align: left;
}

.memo-body th {
  background: #f3f4f6;
  font-weight: 600;
}

.memo-body tr:nth-child(even) {
  background: #f8fafc;
}

.memo-body hr {
  border: none;
  border-top: 1px solid #e5e7eb;
  margin: 2em 0;
}
.memo-body .code-toolbar,
.memo-body .code-toolbar:before{
    all: unset!important;
}


.memo-location {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 14px;
}

.location-icon {
    width: 18px;
    height: 18px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%23666" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>');
}

.location-text {
    display: flex;
    gap: 6px;
    align-items: baseline;
}

.emoji-reaction{
    margin-top:8px;
}
</style>

    <div id="memo-container"></div>
    <button id="loadMore" class="load-more">加载更多</button>
    
<script>
        let nextPageToken = '';
const MEMO_DOMAIN = '<?php echo Bsoptions('memos_Url');?>';
const pageSize = 10;
let isLoading = false;
let userCache = {};
let pendingUserRequests = {};

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

        document.getElementById('loadMore').addEventListener('click', loadMemos);
        loadMemos();
    </script>

</div></div>




</div>

<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>