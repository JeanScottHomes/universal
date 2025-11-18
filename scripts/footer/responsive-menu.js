// responsive-menu.js
(() => {
	console.log('✅ responsive-menu.js is running');

	// — Force top of page on reload —
	if (history.scrollRestoration) {
		history.scrollRestoration = 'manual';
	} else {
		window.onbeforeunload = function () {
			window.scrollTo(0, 0);
		};
	}

	// — macOS detection —
	if (navigator.userAgent.indexOf('Mac') > 0) {
		jQuery('body').addClass('mac_os');
	}

	// — Hamburger click toggles menu open —
	document.addEventListener('DOMContentLoaded', function () {
		const hamburger = document.querySelector('#primary-nav-hamburger');
		const navMenu = document.querySelector('#genesis-nav-primary');

		if (!hamburger || !navMenu) return;

		hamburger.addEventListener('click', function () {
			navMenu.classList.toggle('open');
			document.body.classList.toggle('nav-open');
			const expanded = hamburger.getAttribute('aria-expanded') === 'true';
			hamburger.setAttribute('aria-expanded', !expanded);
		});

		document.addEventListener('click', function (event) {
			if (!navMenu.contains(event.target) && !hamburger.contains(event.target)) {
				navMenu.classList.remove('open');
				document.body.classList.remove('nav-open');
				hamburger.setAttribute('aria-expanded', 'false');
			}
		});
	});

	// — Sticky header scroll behavior —
	let didScroll;
	let lastScrollTop = 0;
	let deltaDown = 8;
	let deltaUp = 256;
	let headerHeight = 0;

	function hasScrolled() {
		const st = window.scrollY;
		if (st > lastScrollTop && st - lastScrollTop <= deltaDown) return;
		if (st < lastScrollTop && lastScrollTop - st <= deltaUp) return;

		const header = document.querySelector('header.site-header');
		if (st > lastScrollTop && st > headerHeight) {
			header.classList.remove('nav-down');
			header.classList.add('nav-up');
			header.style.top = `-${headerHeight}px`;
		} else {
			if (st + window.innerHeight < document.body.scrollHeight) {
				header.classList.remove('nav-up');
				header.classList.add('nav-down');
				header.style.top = '0px';
			}
		}

		lastScrollTop = st;
	}

	jQuery(function ($) {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 10) {
				$('header.site-header').addClass('scrolled');
			}

			if ($(this).scrollTop() < 5) {
				$('header.site-header').removeClass('scrolled');
			}
		});
	});

	window.addEventListener('scroll', () => {
		didScroll = true;
	});

	setInterval(() => {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}, 250);

	// — Adjust site-container padding to match header height —
	function adjustHeaderPadding() {
		const header = document.querySelector('header.site-header');
		const container = document.querySelector('.site-container');
		if (header && container) {
			headerHeight = header.offsetHeight;
			container.style.paddingTop = `${headerHeight}px`;
		}
	}

	window.addEventListener('load', adjustHeaderPadding);
	window.addEventListener('resize', adjustHeaderPadding);

	// — Responsive menu logic (vanilla JS) —
	function checkNavFit() {
		const nav = document.querySelector('.primary_nav_container');
		const navMenu = document.querySelector('#genesis-nav-primary');
		const hamburger = document.querySelector('#primary-nav-hamburger');

		if (!nav || !navMenu || !hamburger) return;

		const navWidth = nav.offsetWidth;
		const menuWidth = navMenu.scrollWidth;

		if (menuWidth > navWidth) {
			document.body.classList.add('nav-overflow');
		} else {
			document.body.classList.remove('nav-overflow');
			navMenu.classList.remove('open');
			document.body.classList.remove('nav-open');
			hamburger.setAttribute('aria-expanded', 'false');
		}
	}

	window.addEventListener('load', checkNavFit);
	window.addEventListener('resize', checkNavFit);

	function checkNavOverflow() {
		const nav = document.getElementById('genesis-nav-primary');
		if (!nav) return;

		const navRight = nav.getBoundingClientRect().right;
		const wrapRight = nav.parentElement.getBoundingClientRect().right;

		if (navRight > wrapRight) {
			document.body.classList.add('nav-overflow');
		} else {
			document.body.classList.remove('nav-overflow');
		}
	}

	window.addEventListener('load', checkNavOverflow);
	window.addEventListener('resize', checkNavOverflow);
})();
