(function () {
  function inject(root) {
    if (!root) return;
    let s = root.querySelector('style[data-tjs="idx-pad"]');
    if (!s) {
      s = document.createElement('style');
      s.setAttribute('data-tjs', 'idx-pad');
      s.textContent = 'div.ui-grid.ui-grid-item{padding:0!important;}';
      root.appendChild(s);
    }
  }

  function touch(node) {
    if (node.shadowRoot) inject(node.shadowRoot);
    node.querySelectorAll('*').forEach(el => el.shadowRoot && inject(el.shadowRoot));
  }

  function hosts() {
    return document.querySelectorAll('#ihf-container, #ihf-main-container, .ihf-container');
  }

  function hasPopulatedShadow(node) {
    if (node.shadowRoot && node.shadowRoot.childNodes.length) return true;
    let ok = false;
    node.querySelectorAll('*').forEach(el => {
      if (!ok && el.shadowRoot && el.shadowRoot.childNodes.length) ok = true;
    });
    return ok;
  }

  function whenPopulated(root, cb) {
    const deadline = Date.now() + 5000; // 5s max wait
    (function check() {
      if (hasPopulatedShadow(root)) { cb(); return; }
      requestAnimationFrame(() => {
        if (Date.now() < deadline) check(); else cb();
      });
    })();
  }

  function hook(node) {
    whenPopulated(node, () => {
      touch(node);
      new MutationObserver(m => m.forEach(x => x.addedNodes.forEach(n => n.nodeType === 1 && touch(n))))
        .observe(node, { childList: true, subtree: true });
    });
  }

  function boot() {
    const hs = hosts();
    if (hs.length) { hs.forEach(hook); return; }
    new MutationObserver((m, obs) => {
      const hs2 = hosts();
      if (hs2.length) { hs2.forEach(hook); obs.disconnect(); }
    }).observe(document.documentElement || document.body, { childList: true, subtree: true });
  }

  if (document.readyState === 'complete') {
    boot();
  } else {
    window.addEventListener('load', boot, { once: true });
  }
})();