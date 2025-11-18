// Update YouTube iframe title attribute for accessibility/SEO
// If the title is the default "YouTube video player", replace it with the
// page H1 text when available; otherwise fall back to document.title.

document.addEventListener('DOMContentLoaded', function () {
  try {
    var h1 = document.querySelector('h1');
    var h1Text = h1 ? (h1.textContent || '').trim() : '';
    var docTitle = (document.title || '').trim();

    // Optional: strip common site suffix after separators like " | "
    docTitle = docTitle.replace(/\s*[\|–-]\s*.*$/, '').trim();

    var replacement = h1Text || docTitle || 'Video';

    function applyTitle(el) {
      var current = (el.getAttribute('title') || '').trim();
      if (current === '' || /^YouTube video player$/i.test(current)) {
        el.setAttribute('title', replacement);
      }
    }

    // Initial pass for iframes present on load
    var iframes = document.querySelectorAll('iframe[src*="youtube.com"], iframe[src*="youtu.be"]');
    iframes.forEach(applyTitle);

    // Observe dynamically added YouTube iframes (e.g., FooBox lightbox)
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (m) {
        m.addedNodes && Array.prototype.forEach.call(m.addedNodes, function (node) {
          if (node && node.nodeType === 1) {
            if (node.matches && (node.matches('iframe[src*="youtube.com"], iframe[src*="youtu.be"]'))) {
              applyTitle(node);
            }
            var nested = node.querySelectorAll ? node.querySelectorAll('iframe[src*="youtube.com"], iframe[src*="youtu.be"]') : [];
            nested && nested.forEach && nested.forEach(applyTitle);
          }
        });
      });
    });
    observer.observe(document.body, { childList: true, subtree: true });
  } catch (e) {
    // Fail silently; do not interfere with page rendering
  }
});
