<?php

/*
 Shortcode to create a Timeline with items displayed vertically with items shown on the left and right.
 Example
 [iul_timeline]
    [iul_timeline_item title="Title goes here" position="right"]Enter your content here.[/iul_timeline_item]
    [iul_timeline_item title="Title goes here" position="left"]Enter your content here.[/iul_timeline_item]
[/iul_timeline]
*/

// Main Shortcode (Timeline Container)
// This shortcode acts as the wrapper for the entire timeline:
function ic_timeline_shortcode($atts, $content = null) {
	ob_start();
?>
<div class="iul_timeline1">
	<?php echo do_shortcode($content); ?>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('ic_timeline', 'ic_timeline_shortcode');


// Item Shortcode (Individual Timeline Entries)
// This shortcode will handle each timeline item, allowing the client to add unlimited items
function ic_timeline_item_shortcode($atts, $content = null) {
	$attributes = shortcode_atts(array(
		'title' => 'Default Title',
		'position' => 'right', // Default to 'right' if not defined
	), $atts);

	// Allow only 'left' or 'right' for the position attribute
	$position = strtolower($attributes['position']);
	if ($position !== 'left' && $position !== 'right') {
		$position = 'right'; // Default to 'right' if an invalid option is provided
	}

	// Automatically wrap content with <p> tags
	$wrapped_content = wpautop($content);

	ob_start();
?>
<div class="isc_wrap isc_<?php echo esc_attr($position); ?>">
	<div class="isc_content">
		<h2><?php echo esc_html($attributes['title']); ?></h2>
		<?php echo $wrapped_content; ?>
	</div>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('ic_timeline_item', 'ic_timeline_item_shortcode');
