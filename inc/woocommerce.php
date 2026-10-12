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
