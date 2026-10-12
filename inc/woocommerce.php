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

/**
 * Add to cart button, once the product is in the cart
 * WooCommerce's own wording is "%s im Warenkorb" and offers no filter.
 */
function tanjandi_in_cart_button_text( $translation, $text, $domain ) {
    if ( 'woocommerce' === $domain && '%s in cart' === $text ) {
        return '%s Artikel im Warenkorb';
    }

    return $translation;
}
add_filter( 'gettext', 'tanjandi_in_cart_button_text', 10, 3 );

/**
 * Cart
 * Helpers for the cart templates in woocommerce/cart/.
 */

/**
 * Amount as plain text, e.g. "CHF 45".
 */
function tanjandi_price_text( $amount ) {
    return trim( html_entity_decode( wp_strip_all_tags( wc_price( $amount ) ), ENT_QUOTES, 'UTF-8' ), " \t\n\r\0\x0B\xC2\xA0" );
}

/**
 * Amount as plain text with a dash for whole amounts, e.g. "CHF 45.–".
 */
function tanjandi_price_dash( $amount ) {
    $amount = (float) $amount;
    $text   = str_replace( "\xC2\xA0", ' ', tanjandi_price_text( $amount ) );

    return floor( $amount ) === $amount ? $text . '.–' : $text;
}

/**
 * Line below the product name in the cart, e.g. "Vase · Desert Tan":
 * first part of the product subtitle plus the chosen variation values.
 */
function tanjandi_cart_item_meta( $cart_item ) {
    $parts    = array();
    $subtitle = function_exists( 'get_field' ) ? (string) get_field( 'product_subtitle', $cart_item['product_id'] ) : '';

    if ( '' !== $subtitle ) {
        $parts[] = trim( explode( '·', $subtitle )[0] );
    }

    if ( ! empty( $cart_item['variation'] ) && is_array( $cart_item['variation'] ) ) {
        foreach ( $cart_item['variation'] as $attribute => $value ) {
            $taxonomy = str_replace( 'attribute_', '', $attribute );
            $term     = taxonomy_exists( $taxonomy ) ? get_term_by( 'slug', $value, $taxonomy ) : false;
            $parts[]  = $term ? $term->name : $value;
        }
    }

    return implode( ' · ', array_filter( $parts ) );
}

/**
 * Minimum order amount of the free shipping method for the current
 * destination, with the amount still missing and the progress in percent.
 */
function tanjandi_free_shipping_goal() {
    if ( ! WC()->cart || ! WC()->cart->needs_shipping() ) {
        return null;
    }

    $packages = WC()->cart->get_shipping_packages();
    $zone     = $packages ? WC_Shipping_Zones::get_zone_matching_package( reset( $packages ) ) : null;

    if ( ! $zone ) {
        return null;
    }

    foreach ( $zone->get_shipping_methods( true ) as $method ) {
        if ( 'free_shipping' !== $method->id || empty( $method->min_amount ) ) {
            continue;
        }

        $minimum  = (float) $method->min_amount;
        $subtotal = (float) WC()->cart->get_displayed_subtotal();

        return array(
            'remaining' => max( 0, $minimum - $subtotal ),
            'percent'   => $minimum > 0 ? (int) min( 100, round( $subtotal / $minimum * 100 ) ) : 100,
        );
    }

    return null;
}

/**
 * Label and amount of the chosen shipping rate.
 */
function tanjandi_cart_shipping_row() {
    if ( ! WC()->cart || ! WC()->cart->needs_shipping() || ! WC()->cart->show_shipping() ) {
        return null;
    }

    $packages = WC()->shipping()->get_packages();
    $chosen   = (array) WC()->session->get( 'chosen_shipping_methods', array() );
    $rates    = $packages ? reset( $packages )['rates'] : array();
    $rate     = isset( $chosen[0], $rates[ $chosen[0] ] ) ? $rates[ $chosen[0] ] : ( $rates ? reset( $rates ) : null );

    if ( ! $rate ) {
        return array(
            'label' => __( 'Versand', 'tanjandi' ),
            'value' => __( 'wird an der Kasse berechnet', 'tanjandi' ),
        );
    }

    $cost = (float) WC()->cart->get_shipping_total() + ( WC()->cart->display_prices_including_tax() ? (float) WC()->cart->get_shipping_tax() : 0 );

    return array(
        'label' => $rate->get_label(),
        'value' => $cost > 0 ? tanjandi_price_dash( $cost ) : __( 'kostenlos', 'tanjandi' ),
    );
}

/**
 * Offer only free shipping once the order qualifies for it.
 */
function tanjandi_only_free_shipping( $rates ) {
    $free = array_filter(
        $rates,
        function ( $rate ) {
            return 'free_shipping' === $rate->get_method_id();
        }
    );

    return $free ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'tanjandi_only_free_shipping' );

/**
 * The cart sidebar holds the summary only.
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

/**
 * The quantity buttons update the cart on their own, so the confirmation
 * WooCommerce shows after every update is left out.
 */
function tanjandi_skip_cart_updated_notice( $message ) {
    return __( 'Cart updated.', 'woocommerce' ) === $message ? '' : $message;
}
add_filter( 'woocommerce_add_success', 'tanjandi_skip_cart_updated_notice' );
