<?php
/**
 * Gutenberg specific settings and configurations.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Includes
 * Load Gutenberg feature modules early (so they can attach hooks in time).
 */
require_once get_template_directory() . '/inc/gutenberg-button-compact.php';

/**
 * Gutenberg setup
 * Keep this for Gutenberg-wide settings if needed.
 */
function wp_starter_gutenberg_settings() {
    // Add custom font sizes, colors, etc. here if needed.
    $block_path = get_template_directory() . '/blocks/project-card';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/employee-card';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/subheader';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/project-services';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/icon-link';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/image-box';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/cart-link';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/product-filter';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/product-card-actions';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/product-teaser';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

}
add_action( 'init', 'wp_starter_gutenberg_settings' );

/**
 * Marks the navigation link of the current section as active. The links in
 * the header are custom links, which WordPress does not mark by itself.
 * A link is active on its own URL and everything below it; the shop link
 * also on product categories and products.
 */
function tanjandi_navigation_link_current( $block_content, $block ) {
    $url = isset( $block['attrs']['url'] ) ? (string) $block['attrs']['url'] : '';

    if ( '' === $url || is_admin() ) {
        return $block_content;
    }

    $link_path    = trailingslashit( (string) wp_parse_url( $url, PHP_URL_PATH ) );
    $request_path = trailingslashit( (string) wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH ) );
    $shop_path    = function_exists( 'wc_get_page_permalink' ) ? trailingslashit( (string) wp_parse_url( wc_get_page_permalink( 'shop' ), PHP_URL_PATH ) ) : '';
    $is_current   = '/' !== $link_path && 0 === strpos( $request_path, $link_path );

    if ( ! $is_current && $shop_path === $link_path && function_exists( 'is_woocommerce' ) ) {
        $is_current = is_shop() || is_product_taxonomy() || is_product();
    }

    if ( ! $is_current ) {
        return $block_content;
    }

    $tags = new WP_HTML_Tag_Processor( $block_content );

    if ( $tags->next_tag( 'li' ) ) {
        $tags->add_class( 'current-menu-item' );
    }

    if ( $tags->next_tag( 'a' ) ) {
        $tags->set_attribute( 'aria-current', $request_path === $link_path ? 'page' : 'true' );
    }

    return $tags->get_updated_html();
}
add_filter( 'render_block_core/navigation-link', 'tanjandi_navigation_link_current', 10, 2 );
