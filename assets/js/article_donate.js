window.__DONATE_INSTANCE = null;

function destroyDonateModal() {
  if (window.__DONATE_INSTANCE) {
    window.__DONATE_INSTANCE.destroy();
    window.__DONATE_INSTANCE = null;
  }
}

(function() {
  class DonateModal {
    constructor() {
      this.modal = document.querySelector('.donate-modal__mask');
      this.closeBtn = document.querySelector('.donate-modal__close');
      this.tabs = document.querySelectorAll('.donate-tab');
      this.panes = document.querySelectorAll('.donate-pane');

      this._closeHandler = null;
      this._maskHandler = null;
      this._tabHandlers = new Map();
      
      this.init();
    }

    init() {
      this.destroy();

      this._closeHandler = () => this.hide();
      this._maskHandler = (e) => {
        if (e.target === this.modal) this.hide();
      };

      this.closeBtn.addEventListener('click', this._closeHandler);
      this.modal.addEventListener('click', this._maskHandler);

      this.tabs.forEach(tab => {
        const handler = () => this.switchTab(tab);
        this._tabHandlers.set(tab, handler);
        tab.addEventListener('click', handler);
      });

      this.panes.forEach(pane => {
        if (!pane.children.length) {
          const tab = document.querySelector(`[data-target="${pane.id}"]`);
          if (tab) tab.style.display = 'none';
        }
      });
    }

    switchTab(selectedTab) {
      this.tabs.forEach(tab => tab.classList.remove('active'));
      selectedTab.classList.add('active');
      
      const target = selectedTab.dataset.target;
      this.panes.forEach(pane => {
        pane.classList.remove('active');
        if (pane.id === target) pane.classList.add('active');
      });
    }

    show() {
      this.modal.style.display = 'flex';
    }

    hide() {
      this.modal.style.display = 'none';
    }

    destroy() {
      if (this.closeBtn && this._closeHandler) {
        this.closeBtn.removeEventListener('click', this._closeHandler);
      }
      if (this.modal && this._maskHandler) {
        this.modal.removeEventListener('click', this._maskHandler);
      }

      this.tabs.forEach(tab => {
        const handler = this._tabHandlers.get(tab);
        if (handler) {
          tab.removeEventListener('click', handler);
        }
      });
      this._tabHandlers.clear();
    }
  }

  function initDonateModal() {
    destroyDonateModal();
    window.__DONATE_INSTANCE = new DonateModal();
  }

  if (document.readyState !== 'loading') {
    initDonateModal();
  } else {
    document.addEventListener('DOMContentLoaded', initDonateModal);
  }

  if (typeof pjax !== 'undefined') {
    document.addEventListener('pjax:complete', initDonateModal);
  }
})();