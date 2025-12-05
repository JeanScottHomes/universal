document.addEventListener('DOMContentLoaded', function() {
    // Check if user has closed it previously (optional, but good UX)
    if (sessionStorage.getItem('jsh_cta_closed') === 'true') {
        return;
    }

    var ctaHTML = `
    <div id="ctaDesktopBodyBody" class="jsh-cta-popup">
        <button id="ctaDesktopClose" aria-label="Close">&times;</button>
        <div id="ctaDesktopBodyBodyHeading">
            <div id="ctaDesktopBodyBodyHeadingTop">Do you have questions?</div>
            <div id="ctaDesktopBodyBodyHeadingBottom">Call or text today, we are here to help!</div>
        </div>
        <div id="ctaDesktopBodyPhoneContainer">
            <svg id="ctaDesktopBodyPhoneIcon" preserveAspectRatio="xMidYMid" width="16" height="16" viewBox="0 0 16 16">
                <path fill-rule="evenodd" fill="currentColor" d="M11 10c-1 1-1 2-2 2s-2-1-3-2-2-2-2-3 1-1 2-2-2-4-3-4-3 3-3 3c0 2 2.055 6.055 4 8s6 4 8 4c0 0 3-2 3-3s-3-4-4-3z"></path>
            </svg>
            <a href="tel:407-564-2758" id="ctaDesktopBodyPhone">407-564-2758</a>
        </div>
        <div id="ctaDesktopTextingTerms">
            <span>I agree to be contacted by Jean Scott Homes via text, call & email. To opt-out, reply 'stop' or click unsubscribe.</span>
        </div>
    </div>
    `;

    var div = document.createElement('div');
    div.innerHTML = ctaHTML;
    document.body.appendChild(div.firstElementChild);

    // Close button logic
    document.getElementById('ctaDesktopClose').addEventListener('click', function() {
        document.getElementById('ctaDesktopBodyBody').style.display = 'none';
        sessionStorage.setItem('jsh_cta_closed', 'true');
    });
});
