
<script>
$(function() {
  // 显示/隐藏下拉菜单
  var toggleMenu = document.getElementById('toggle-menu');
  var dropdownMenu = document.getElementById('dropdown-menu');

  toggleMenu.addEventListener('click', () => {
    dropdownMenu.classList.toggle('show');
  });

  // 点击其他地方隐藏下拉菜单
  window.addEventListener('click', (event) => {
    if (!event.target.closest('.article-actions')) {
      dropdownMenu.classList.remove('show');
    }
  });
  // 按 Esc 键关闭菜单
  window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      dropdownMenu.classList.remove('show');
    }
  });
<?php if(Bsoptions('Readmode') == true): ?>
 // 获取元素
var readingModeOverlay = document.getElementById('reading-mode-overlay');
var toggleReadingMode = document.getElementById('toggle-reading-mode');
var exitReadingMode = document.getElementById('exit-reading-mode');
var toggleSettingsPanel = document.getElementById('toggle-settings-panel');
var settingsPanel = document.getElementById('settings-panel');
var readingModeContent = document.getElementById('reading-mode');

// 进入阅读模式
toggleReadingMode.addEventListener('click', () => {
    <?php if($this->hidden): ?>
    $('body').toast({
        title: '抱歉~',
        class: 'warning',
        message: '<?php echo empty(Bsoptions('globalTips')['articlePwdAfterEnterReadMode_Tip']) ? '本文存在密码，验证文章密码后方可进入阅读模式' : Bsoptions('globalTips')['articlePwdAfterEnterReadMode_Tip']; ?>',
        showIcon: 'flushed outline',
        showProgress: 'top',
    });
    return false;
    <?php endif; ?>
     

    // 显示遮罩层
    readingModeOverlay.style.position = 'fixed';
    readingModeOverlay.style.top = '0'; // 显示在屏幕顶部
    readingModeOverlay.style.left = '0'; // 显示在屏幕左侧
    
    if ($('#darkmode').is(':checked')) {
        document.documentElement.setAttribute('data-theme', 'light');
    }
    $("#bs-theme-control").css('display', 'none');
    document.body.style.overflow = 'hidden';
readingModeOverlay.classList.add('show');

});

exitReadingMode.addEventListener('click', () => {
    // 隐藏遮罩层
    readingModeOverlay.style.position = 'absolute';
    readingModeOverlay.style.top = '-9999px'; // 移动到屏幕外
    readingModeOverlay.style.left = '-9999px'; // 移动到屏幕外

    if ($('#darkmode').is(':checked') && setting.Mournmode !== 'true') {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
    $("#bs-theme-control").css('display', 'block');
    document.body.style.overflow = '';
});

  // 显示/隐藏设置面板
  toggleSettingsPanel.addEventListener('click', (event) => {
    event.stopPropagation(); // 阻止事件冒泡
    settingsPanel.style.display = settingsPanel.style.display === 'block' ? 'none' : 'block';
  });

  // 点击空白处隐藏设置面板
  document.addEventListener('click', (event) => {
    if (!event.target.closest('.reading-mode-panel') && !event.target.closest('#toggle-settings-panel')) {
      settingsPanel.style.display = 'none';
    }
  });

  // 切换背景颜色
  document.getElementById('bg-light').addEventListener('click', () => {
    readingModeOverlay.classList.remove('bg-sepia', 'bg-dark');
    readingModeOverlay.classList.add('bg-light');
    readingModeOverlay.style.color = '#333'; // 设置文字颜色
  });

  document.getElementById('bg-sepia').addEventListener('click', () => {
    readingModeOverlay.classList.remove('bg-light', 'bg-dark');
    readingModeOverlay.classList.add('bg-sepia');
    readingModeOverlay.style.color = '#5a4a42'; // 设置文字颜色
  });

  document.getElementById('bg-dark').addEventListener('click', () => {
    readingModeOverlay.classList.remove('bg-light', 'bg-sepia');
    readingModeOverlay.classList.add('bg-dark');
    readingModeOverlay.style.color = '#f5f5f5'; // 设置文字颜色
  });

  // 切换字体大小（阅读模式）
  document.getElementById('text-small').addEventListener('click', () => {
    readingModeContent.style.fontSize = '16.369px';
  });

  document.getElementById('text-medium').addEventListener('click', () => {
    readingModeContent.style.fontSize = '18.82px';
  });

  document.getElementById('text-large').addEventListener('click', () => {
    readingModeContent.style.fontSize = '21.28px';
  });
  <?php if(Bsoptions('Readmode_Auto') == true && !$this->hidden): ?>
  $("#toggle-reading-mode").click();
  <?php endif;?>
<?php endif;?>
 // 切换字体（普通模式）
var fontSwitch1 = document.getElementById('article_change_m');
var fontSwitch2 = document.getElementById('article_change_k');
var fontSwitch3 = document.getElementById('article_change_xlwk');
var bodyElement = document.getElementById('post-content');

var updateFontCheckmark = (selectedButton) => {
  // 移除所有字体按钮的打勾
  document.querySelectorAll('#article_change_m, #article_change_k, #article_change_xlwk').forEach(button => {
    button.classList.remove('active');
  });
  // 为选中的按钮添加打勾
  selectedButton.classList.add('active');
};

fontSwitch1.addEventListener('click', () => {
  $('.post-content').removeClass('article_font_xlwk');
  $('.post-content').removeClass('article_font');
  localStorage.setItem('article_font', 'm');
  updateFontCheckmark(fontSwitch1);
});

fontSwitch2.addEventListener('click', () => {
  $('.post-content').addClass('article_font');
  $('.post-content').removeClass('article_font_xlwk');
  localStorage.setItem('article_font', 'k');
  updateFontCheckmark(fontSwitch2);
});

fontSwitch3.addEventListener('click', () => {
  $('.post-content').removeClass('article_font');
  $('.post-content').addClass('article_font_xlwk');
  localStorage.setItem('article_font', 'xlwk');
  updateFontCheckmark(fontSwitch3);
});

// 初始化字体打勾状态
if (localStorage.getItem('article_font')) {
  switch (localStorage.getItem('article_font')) {
    case 'k':
      $('.post-content').addClass('article_font');
      updateFontCheckmark(fontSwitch2);
      break;
    case 'xlwk':
      $('.post-content').addClass('article_font_xlwk');
      updateFontCheckmark(fontSwitch3);
      break;
    case 'm':
      $('.post-content').removeClass('article_font');
      updateFontCheckmark(fontSwitch1);
      break;
  }
}

// 切换字体大小（普通模式）
var sizeSmall = document.getElementById('text-size-small');
var sizeMedium = document.getElementById('text-size-medium');
var sizeLarge = document.getElementById('text-size-large');

var updateSizeCheckmark = (selectedButton) => {
  // 移除所有字体大小按钮的打勾
  document.querySelectorAll('#text-size-small, #text-size-medium, #text-size-large').forEach(button => {
    button.classList.remove('active');
  });
  // 为选中的按钮添加打勾
  selectedButton.classList.add('active');
};

sizeSmall.addEventListener('click', () => {
  document.getElementById('post-content').style.fontSize = '16.369px';
  localStorage.setItem('text_size', 'small');
  updateSizeCheckmark(sizeSmall);
});

sizeMedium.addEventListener('click', () => {
  document.getElementById('post-content').style.fontSize = '18.82px';
  localStorage.setItem('text_size', 'medium');
  updateSizeCheckmark(sizeMedium);
});

sizeLarge.addEventListener('click', () => {
  document.getElementById('post-content').style.fontSize = '21.28px';
  localStorage.setItem('text_size', 'large');
  updateSizeCheckmark(sizeLarge);
});

// 初始化字体大小打勾状态
if (localStorage.getItem('text_size')) {
  var textSize = localStorage.getItem('text_size');
  var postContent = document.getElementById('post-content');

  switch (textSize) {
    case 'small':
      postContent.style.fontSize = '16.369px';
      updateSizeCheckmark(sizeSmall);
      break;
    case 'medium':
      postContent.style.fontSize = '18.82px';
      updateSizeCheckmark(sizeMedium);
      break;
    case 'large':
      postContent.style.fontSize = '21.28px';
      updateSizeCheckmark(sizeLarge);
      break;
  }
}

});
</script>