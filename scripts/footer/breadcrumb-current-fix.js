/*
 * TJS 2025-09-02 — Band-aid: wrap the current breadcrumb text in Featured Listings
 * Some Featured Listings pages output the breadcrumb trail with the current item
 * as plain text (not a .breadcrumb-current span). This script finds the trailing
 * text node after the last link and wraps it in <span class="breadcrumb-current">…</span>
 * so existing CSS highlights it like on regular pages.
 */

document.addEventListener('DOMContentLoaded', function () {
  try {
    var blocks = document.querySelectorAll('.ao_listing_layout2 .isc_info_bar .breadcrumb');
    blocks.forEach(function (bc) {
      // Skip if already wrapped
      if (bc.querySelector('.breadcrumb-current')) return;
      // Find the last child node that is a non-empty text node
      var last = bc.lastChild;
      while (last && (last.nodeType !== Node.TEXT_NODE || !last.nodeValue.trim())) {
        last = last.previousSibling;
      }
      if (!last || last.nodeType !== Node.TEXT_NODE) return;
      var text = last.nodeValue.trim();
      if (!text) return;
      // Replace text node with span
      var span = document.createElement('span');
      span.className = 'breadcrumb-current';
      span.textContent = text;
      bc.replaceChild(span, last);
    });
  } catch (e) {
    // no-op
  }
});

