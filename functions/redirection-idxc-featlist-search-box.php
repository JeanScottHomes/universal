<?php
add_action('admin_footer', function () {
    $screen = get_current_screen();
    if (! $screen || $screen->id !== 'tools_page_redirection') return;
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let expanded = false;
            let collapseTimer;

            const container = document.createElement('div');
            container.id = 'idxc-helper-box';
            container.style = `
			position: fixed;
			bottom: 20px;
			right: 20px;
			width: 42.66vh;
			background: #f1f1f1;
			border: 1px solid #ccc;
			padding: 10px;
			z-index: 9999;
			max-height: 100px;
			overflow-y: hidden;
			overflow-x: hidden;
			font-size: 13px;
			transition: max-height 0.3s ease;
			color: #000000;
		`;
            container.innerHTML = `
			<div id="idxc-drag-handle" style="cursor: move;">
				<strong>Pages, Posts, & Listings</strong><br>
				<em>Click to copy target URL</em>
			</div>
			<input type="text" id="idxc-search" placeholder="Search..." style="width: 100%; margin-top: 6px; margin-bottom: 6px; padding: 2px 4px; height: 24px;" />
			<ul id="idxc-listings" style="margin: 10px 0; padding-left: 15px; display: none; max-height: 190px; overflow-y: auto;"><li>Loading...</li></ul>
		`;
            document.body.appendChild(container);

            // Drag only via handle
            const handle = document.getElementById('idxc-drag-handle');
            let isDragging = false;
            let dragOffset = [0, 0];

            handle.addEventListener('mousedown', function(e) {
                isDragging = true;
                dragOffset = [container.offsetLeft - e.clientX, container.offsetTop - e.clientY];
                handle.style.cursor = 'grabbing';
                e.preventDefault();
            });

            document.addEventListener('mouseup', function() {
                isDragging = false;
                handle.style.cursor = 'move';
            });

            document.addEventListener('mousemove', function(e) {
                if (isDragging) {
                    container.style.left = (e.clientX + dragOffset[0]) + 'px';
                    container.style.top = (e.clientY + dragOffset[1]) + 'px';
                    container.style.bottom = 'auto';
                    container.style.right = 'auto';
                }
            });

            // Expand/collapse
            function expandBox() {
                if (!expanded) {
                    container.style.maxHeight = '250px'; // expanded height
                    document.getElementById('idxc-listings').style.display = 'block';
                    expanded = true;
                }
                resetCollapseTimer();
            }

            function collapseBox() {
                container.style.maxHeight = '100px';
                document.getElementById('idxc-listings').style.display = 'none';
                expanded = false;
            }

            function resetCollapseTimer() {
                clearTimeout(collapseTimer);
                collapseTimer = setTimeout(() => collapseBox(), 60000);
            }

            document.addEventListener('focusin', function(e) {
                if (e.target.id === 'idxc-search') expandBox();
            });
            document.addEventListener('input', function(e) {
                if (e.target.id === 'idxc-search') expandBox();
            });

            // Fetch listings
            fetch('<?php echo admin_url('admin-ajax.php?action=idxc_featlist_urls'); ?>')
                .then(res => res.json())
                .then(data => {
                    const ul = document.getElementById('idxc-listings');
                    ul.innerHTML = '';
                    data.forEach(post => {
                        const li = document.createElement('li');
                        li.style = 'margin-bottom: 6px; cursor: pointer; color: #000000; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;';
                        li.textContent = post.title;
                        li.title = post.url; // Store the URL slug here
                        li.onclick = () => {
                            navigator.clipboard.writeText(post.url);
                            document.getElementById('idxc-search').value = '';

                            const confirm = document.createElement('div');
                            confirm.textContent = 'Copied!';
                            confirm.style = 'position: fixed; bottom: calc(250px + 30px); right: 40px; background: #000000; color: white; padding: 6px 12px; border-radius: 4px; font-size: 13px; z-index: 10000; box-shadow: 0 2px 5px rgba(0,0,0,0.2); opacity: 1; transition: opacity 0.4s ease;';
                            document.body.appendChild(confirm);
                            setTimeout(() => {
                                confirm.style.opacity = '0';
                                setTimeout(() => confirm.remove(), 400);
                            }, 800);
                        };
                        ul.appendChild(li);
                    });

                    // Search in title AND slug
                    document.getElementById('idxc-search').addEventListener('input', function(e) {
                        const term = e.target.value.toLowerCase();
                        document.querySelectorAll('#idxc-listings li').forEach(li => {
                            const titleMatch = li.textContent.toLowerCase().includes(term);
                            const slugMatch = li.title.toLowerCase().includes(term);
                            li.style.display = (titleMatch || slugMatch) ? 'list-item' : 'none';
                        });
                    });
                })
                .catch(() => {
                    document.getElementById('idxc-listings').innerHTML = '<li>Failed to load listings</li>';
                });
        });
    </script>
<?php
});

add_action('wp_ajax_idxc_featlist_urls', function () {
    $posts = get_posts([
        'post_type'      => ['idxc_featlist', 'page', 'post'],
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);

    $data = array_map(function ($post) {
        return [
            'title' => esc_html($post->post_title),
            'url'   => wp_make_link_relative(get_permalink($post)),
        ];
    }, $posts);

    wp_send_json($data);
});
