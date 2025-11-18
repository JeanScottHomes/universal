document.addEventListener('DOMContentLoaded', function () {
	const container = document.querySelector('.infinite-container[data-scroll="yes"]');
	if (!container || typeof infinite_scroll_ajax_object === 'undefined') return;

	let loading = false;

	const loadMore = function () {
		if (loading) return;

		const containerBottom = container.getBoundingClientRect().bottom;
		const viewportHeight = window.innerHeight;

		if (containerBottom - viewportHeight < viewportHeight * 0.5) {
			loading = true;

			const post_tags = container.dataset.post_tags || '';
			const post_cats = container.dataset.post_cats || '';
			const sort = container.dataset.sort;
			const count = parseInt(container.dataset.count, 10);
			let page = parseInt(container.dataset.page, 10) + 1;

			const indicator = container.querySelector('.infinite-scroll-loading-indicator');
			if (indicator) indicator.style.display = 'block';

			fetch(infinite_scroll_ajax_object.ajax_url, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: new URLSearchParams({
					action: 'sitewide_grid_load_more',
					post_tags: post_tags,
					post_cats: post_cats,
					sort: sort,
					count: count,
					page: page,
				}),
			})
				.then((response) => response.text())
				.then((html) => {
					const temp = document.createElement('div');
					temp.innerHTML = html;
					const newContent = temp.querySelector('.sitewide-grid');
					if (newContent) {
						container.querySelector('.sitewide-grid').append(...newContent.children);
						container.dataset.page = page;
					}
				})
				.finally(() => {
					if (indicator) indicator.style.display = 'none';
					loading = false;
				});
		}
	};

	window.addEventListener('scroll', loadMore);
	window.addEventListener('resize', loadMore);
});
