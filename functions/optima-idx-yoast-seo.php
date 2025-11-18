<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'optima_idx_yoast_is_virtual_request' ) ) {
	function optima_idx_yoast_is_virtual_request() {
		if ( get_query_var( 'ihf-type' ) ) {
			return true;
		}

		if ( isset( $_GET['ihf-type'] ) && $_GET['ihf-type'] !== '' ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'optima_idx_yoast_get_placeholder_page_id' ) ) {
	function optima_idx_yoast_get_placeholder_page_id() {
		static $placeholder_id = null;

		if ( null !== $placeholder_id ) {
			return $placeholder_id;
		}

		$stored_id = (int) get_option( 'optima_idx_placeholder_page_id', 0 );
		if ( $stored_id > 0 ) {
			$post = get_post( $stored_id );
			if ( $post instanceof WP_Post && $post->post_type === 'page' && 'trash' !== $post->post_status ) {
				$placeholder_id = $stored_id;
				return $placeholder_id;
			}
		}

		$existing = get_page_by_path( 'idx-virtual-page-placeholder', OBJECT, 'page' );
		if ( $existing instanceof WP_Post ) {
			$placeholder_id = (int) $existing->ID;
			update_option( 'optima_idx_placeholder_page_id', $placeholder_id );
			return $placeholder_id;
		}

		$page_id = wp_insert_post(
			[
				'post_title'     => 'IDX Virtual Page Placeholder',
				'post_name'      => 'idx-virtual-page-placeholder',
				'post_status'    => 'private',
				'post_type'      => 'page',
				'post_content'   => 'Automatically generated placeholder page for IDX virtual listings.',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			],
			true
		);

		if ( is_wp_error( $page_id ) ) {
			$placeholder_id = 0;
			return 0;
		}

		$placeholder_id = (int) $page_id;
		update_option( 'optima_idx_placeholder_page_id', $placeholder_id );

		return $placeholder_id;
	}
}

add_filter( 'wpseo_frontend_page_type_simple_page_id', function ( $page_id ) {
	if ( ! optima_idx_yoast_is_virtual_request() ) {
		return $page_id;
	}

	$placeholder_id = optima_idx_yoast_get_placeholder_page_id();
	if ( $placeholder_id > 0 ) {
		return $placeholder_id;
	}

	return $page_id;
}, 5 );

add_action( 'wp', function () {
	if ( ! optima_idx_yoast_is_virtual_request() ) {
		return;
	}

	if ( ! function_exists( 'YoastSEO' ) ) {
		return;
	}

	$yoast = YoastSEO();
	if ( ! $yoast || ! isset( $yoast->meta ) ) {
		return;
	}

	$context = $yoast->meta->for_current_page();
	if ( ! $context || ! isset( $context->indexable ) ) {
		return;
	}

	$indexable = $context->indexable;
	if ( ! $indexable ) {
		return;
	}

	$placeholder_id = optima_idx_yoast_get_placeholder_page_id();
	if ( $placeholder_id <= 0 ) {
		return;
	}

	$indexable->object_type       = 'post';
	$indexable->object_sub_type   = 'page';
	$indexable->object_id         = $placeholder_id;
	$indexable->permalink         = home_url( '/idx-virtual-page-placeholder/' );
	$indexable->is_robots_noindex = false;
}, 20 );

add_action( 'wp_enqueue_scripts', function () {
	if ( ! optima_idx_yoast_is_virtual_request() ) {
		return;
	}

	if ( ! wp_script_is( 'yoast-seo-premium-frontend-inspector', 'enqueued' ) ) {
		return;
	}

	$script = 'if ( window.wpseoScriptData && window.wpseoScriptData.frontendInspector ) { '
		. 'window.wpseoScriptData.frontendInspector.isIndexable = true; '
		. 'if ( window.wpseoScriptData.frontendInspector.indexable ) { '
		. 'window.wpseoScriptData.frontendInspector.indexable.is_robots_noindex = false; '
		. '} }';

	wp_add_inline_script( 'yoast-seo-premium-frontend-inspector', $script, 'after' );
}, 25 );
