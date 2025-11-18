console.log("✅ Loaded: google-ads.js (HEAD)");

// Load Google Ads tag dynamically
(function() {
    var script = document.createElement('script');
    script.async = true;
    script.src = "https://www.googletagmanager.com/gtag/js?id=AW-1002016273";
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    window.gtag = gtag;

    gtag('js', new Date());

    // Main config
    gtag('config', 'AW-1002016273');

    // Call conversion config
    gtag('config', 'AW-1002016273/IYWfCOjt-ugaEJGc5t0D', {
        'phone_conversion_number': '407-564-2758'
    });

    // Optional: Trigger a custom conversion event on page view
    gtag('event', 'conversion_event_page_view');
})();
