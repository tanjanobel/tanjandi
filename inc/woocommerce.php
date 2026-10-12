<?php
/**
 * WooCommerce specific settings and configurations.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Header cart
 * WooCommerce auto-inserts its own account and mini-cart blocks after the
 * navigation. The header uses the tanjandi/cart-link block instead.
 */
function tanjandi_remove_hooked_header_blocks( $hooked_blocks, $position, $anchor_block ) {
    if ( 'core/navigation' !== $anchor_block ) {
        return $hooked_blocks;
    }

    return array_values( array_diff( $hooked_blocks, array( 'woocommerce/customer-account', 'woocommerce/mini-cart' ) ) );
}
add_filter( 'hooked_block_types', 'tanjandi_remove_hooked_header_blocks', 20, 3 );

/**
 * Cart count badge, hidden while the cart is empty.
 */
function tanjandi_cart_count_html() {
    $count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;

    return sprintf(
        '<span class="header__cart-count%s">%d</span>',
        $count > 0 ? '' : ' header__cart-count--empty',
        $count
    );
}

/**
 * Keep the cart count in sync when products are added via AJAX.
 */
function tanjandi_cart_count_fragment( $fragments ) {
    $fragments['.header__cart-count'] = tanjandi_cart_count_html();

    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'tanjandi_cart_count_fragment' );

/**
 * Prices
 * Show whole amounts without decimals (CHF 45 instead of CHF 45.00).
 */
add_filter( 'woocommerce_price_trim_zeros', '__return_true' );

/**
 * Product gallery
 * All images are shown at once in a grid, so the slider and the hover zoom
 * WooCommerce enables for block themes are switched off.
 */
function tanjandi_product_gallery_support() {
    remove_theme_support( 'wc-product-gallery-slider' );
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'tanjandi_product_gallery_support', 20 );

/**
 * Add to cart button
 * Shows the price next to the label on the product page.
 */
function tanjandi_single_add_to_cart_text( $text, $product ) {
    if ( ! $product instanceof WC_Product || '' === $product->get_price() ) {
        return $text;
    }

    return sprintf( '%s · %s', $text, wp_strip_all_tags( html_entity_decode( wc_price( $product->get_price() ) ) ) );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'tanjandi_single_add_to_cart_text', 10, 2 );

/**
 * Breadcrumbs
 * Start at the shop instead of the front page.
 */
function tanjandi_breadcrumb_defaults( $defaults ) {
    $defaults['home']      = __( 'Shop', 'tanjandi' );
    $defaults['delimiter'] = '<span class="product-detail__breadcrumb-separator">/</span>';

    return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'tanjandi_breadcrumb_defaults' );

function tanjandi_breadcrumb_home_url() {
    return wc_get_page_permalink( 'shop' );
}
add_filter( 'woocommerce_breadcrumb_home_url', 'tanjandi_breadcrumb_home_url' );
