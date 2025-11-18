// Lite YouTube embed: replace placeholder with iframe on click (youtube-lite-*)
(function() {
  function toEmbedUrl(url) {
    try {
      var u = new URL(url, document.baseURI);
      var host = u.hostname.replace(/^www\./, '');
      var id = '';
      if (host === 'youtube.com' || host === 'm.youtube.com' || host === 'music.youtube.com') {
        if (u.pathname === '/watch') {
          id = u.searchParams.get('v') || '';
        } else if (u.pathname.indexOf('/embed/') === 0) {
          id = u.pathname.split('/embed/')[1].split('/')[0];
        } else if (u.pathname.indexOf('/shorts/') === 0) {
          id = u.pathname.split('/shorts/')[1].split('/')[0];
        }
      } else if (host === 'youtu.be') {
        id = u.pathname.slice(1);
      }
      if (!id) return null;
      var params = new URLSearchParams('autoplay=1&rel=0&modestbranding=1&playsinline=1');
      var t = u.searchParams.get('t') || u.searchParams.get('start');
      if (t) params.set('start', parseInt(t, 10) || 0);
      return 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?' + params.toString();
    } catch (e) {
      return null;
    }
  }

  function activate(container) {
    if (!container || container.__ytLiteActive) return;
    container.__ytLiteActive = true;
    container.addEventListener('click', function() {
      var url = container.getAttribute('data-yturl') || '';
      var src = toEmbedUrl(url);
      if (!src) return;
      var iframe = document.createElement('iframe');
      iframe.src = src;
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
      iframe.allowFullscreen = true;
      iframe.setAttribute('allowfullscreen', 'allowfullscreen');
      iframe.loading = 'lazy';
      iframe.referrerPolicy = 'strict-origin-when-cross-origin';
      iframe.style.width = '100%';
      iframe.style.height = '100%';
      container.innerHTML = '';
      container.appendChild(iframe);
    }, { once: true });
  }

  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.youtube-lite-embed').forEach(activate);
  });
})();

