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
 * Line below the product name in the cart, e.g. "Vase · Suna":
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

        // Same rule as the free shipping method: coupons count against the
        // minimum unless the method is set to ignore them.
        if ( 'yes' !== $method->ignore_discounts ) {
            $subtotal -= (float) WC()->cart->get_discount_total();
        }

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

    $country   = WC()->customer ? WC()->customer->get_shipping_country() : '';
    $countries = WC()->countries->get_countries();

    return array(
        /* translators: %s: destination country. */
        'label' => isset( $countries[ $country ] ) ? sprintf( __( 'Versand %s', 'tanjandi' ), $countries[ $country ] ) : __( 'Versand', 'tanjandi' ),
        'value' => $cost > 0 ? tanjandi_price_dash( $cost ) : __( 'kostenlos', 'tanjandi' ),
    );
}

/**
 * Once the order qualifies for free shipping, the free rate takes the place
 * of the cheapest paid one; faster paid options stay available.
 */
function tanjandi_free_shipping_replaces_cheapest( $rates ) {
    $free = array();
    $paid = array();

    foreach ( $rates as $id => $rate ) {
        if ( 'free_shipping' === $rate->get_method_id() ) {
            $free[ $id ] = $rate;
        } else {
            $paid[ $id ] = $rate;
        }
    }

    if ( ! $free || ! $paid ) {
        return $rates;
    }

    $cheapest = null;
    foreach ( $paid as $id => $rate ) {
        if ( null === $cheapest || (float) $rate->get_cost() < (float) $paid[ $cheapest ]->get_cost() ) {
            $cheapest = $id;
        }
    }
    unset( $paid[ $cheapest ] );

    return $free + $paid;
}
add_filter( 'woocommerce_package_rates', 'tanjandi_free_shipping_replaces_cheapest' );

/**
 * Delivery time shown below a shipping method, e.g. "2–3 Werktage nach dem
 * Druck". Entered per method in the WooCommerce shipping zone.
 */
function tanjandi_shipping_delivery_note_field( $fields ) {
    $fields['delivery_note'] = array(
        'title'       => __( 'Lieferzeit-Hinweis', 'tanjandi' ),
        'type'        => 'text',
        'description' => __( 'Erscheint in der Kasse unter dem Namen der Versandart.', 'tanjandi' ),
        'default'     => '',
        'desc_tip'    => true,
    );

    return $fields;
}
add_filter( 'woocommerce_shipping_instance_form_fields_flat_rate', 'tanjandi_shipping_delivery_note_field' );
add_filter( 'woocommerce_shipping_instance_form_fields_free_shipping', 'tanjandi_shipping_delivery_note_field' );

function tanjandi_shipping_delivery_note( $rate ) {
    $method = WC_Shipping_Zones::get_shipping_method( $rate->get_instance_id() );

    return $method ? (string) $method->get_option( 'delivery_note', '' ) : '';
}

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

/**
 * Checkout
 * Helpers and settings for the checkout templates in woocommerce/checkout/.
 */

/**
 * Checkout fields: e-mail plus one address, with our own labels, widths
 * and classes.
 */
function tanjandi_checkout_fields( $fields ) {
    $billing = isset( $fields['billing'] ) ? $fields['billing'] : array();
    $layout  = array(
        'billing_email'      => array( __( 'E-Mail', 'tanjandi' ), 'full' ),
        'billing_first_name' => array( __( 'Vorname', 'tanjandi' ), 'half' ),
        'billing_last_name'  => array( __( 'Nachname', 'tanjandi' ), 'half' ),
        'billing_address_1'  => array( __( 'Strasse und Hausnummer', 'tanjandi' ), 'full' ),
        'billing_postcode'   => array( __( 'PLZ', 'tanjandi' ), 'third' ),
        'billing_city'       => array( __( 'Ort', 'tanjandi' ), 'two-thirds' ),
        'billing_country'    => array( __( 'Land', 'tanjandi' ), 'full' ),
    );
    $sorted  = array();
    $order   = 10;

    foreach ( $layout as $key => $settings ) {
        if ( ! isset( $billing[ $key ] ) ) {
            continue;
        }

        $field                = $billing[ $key ];
        $field['label']       = $settings[0];
        $field['placeholder'] = '';
        $field['priority']    = $order;
        $field['class']       = array( 'checkout-field', 'checkout-field--' . $settings[1] );
        $field['label_class'] = array( 'checkout-field__label' );
        $field['input_class'] = array( 'checkout-field__input' );

        if ( 'billing_country' === $key ) {
            $countries = WC()->countries->get_allowed_countries();

            if ( 1 === count( $countries ) ) {
                // Only one country to sell to: nothing to choose, the
                // country travels along as a hidden field.
                $field['type']        = 'hidden';
                $field['class']       = array( 'checkout-field', 'checkout-field--hidden' );
                $field['input_class'] = array();
            } else {
                // A plain select instead of WooCommerce's enhanced country field.
                $field['type']    = 'select';
                $field['options'] = $countries;
                $field['class'][] = 'address-field';
                $field['class'][] = 'update_totals_on_change';
            }
        } elseif ( 'billing_email' !== $key ) {
            $field['class'][] = 'address-field';
        }

        $sorted[ $key ] = $field;
        $order         += 10;
    }

    $fields['billing'] = $sorted;

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'tanjandi_checkout_fields', 20 );

/**
 * With a single country to sell to, that country is always the one used,
 * whatever an account has stored from earlier.
 */
function tanjandi_checkout_single_country( $value, $input ) {
    if ( 'billing_country' !== $input ) {
        return $value;
    }

    $countries = array_keys( WC()->countries->get_allowed_countries() );

    return 1 === count( $countries ) ? $countries[0] : $value;
}
add_filter( 'woocommerce_checkout_get_value', 'tanjandi_checkout_single_country', 10, 2 );

// No order notes; the coupon is redeemed in the cart; no login prompt.
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );

/**
 * Shipping methods for the shipping step.
 */
function tanjandi_checkout_shipping() {
    echo '<div class="checkout-shipping">';

    if ( WC()->cart && WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) {
        wc_cart_totals_shipping_html();
    } else {
        echo '<p class="checkout-shipping__message">' . esc_html__( 'Für diese Bestellung ist kein Versand nötig.', 'tanjandi' ) . '</p>';
    }

    echo '</div>';
}

/**
 * Refresh the shipping step whenever WooCommerce recalculates the checkout.
 */
function tanjandi_checkout_shipping_fragment( $fragments ) {
    ob_start();
    tanjandi_checkout_shipping();
    $fragments['.checkout-shipping'] = ob_get_clean();

    return $fragments;
}
add_filter( 'woocommerce_update_order_review_fragments', 'tanjandi_checkout_shipping_fragment' );

/**
 * Place order button in the shared button markup.
 */
function tanjandi_order_button_text() {
    $text = __( 'Zahlungspflichtig bestellen', 'tanjandi' );

    if ( ! WC()->cart ) {
        return $text;
    }

    return sprintf( '%s · %s', $text, tanjandi_price_dash( WC()->cart->get_total( 'edit' ) ) );
}
add_filter( 'woocommerce_order_button_text', 'tanjandi_order_button_text' );

function tanjandi_order_button_html() {
    $text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );

    return sprintf(
        '<div class="checkout-page__submit wp-block-button"><button type="submit" class="wp-block-button__link wp-element-button" name="woocommerce_checkout_place_order" id="place_order" value="%1$s" data-value="%1$s">%2$s</button></div>',
        esc_attr( $text ),
        esc_html( $text )
    );
}
add_filter( 'woocommerce_order_button_html', 'tanjandi_order_button_html' );

/**
 * There is one address only, so the "Rechnung:" prefix WooCommerce puts in
 * front of field names in error messages is left out.
 */
function tanjandi_checkout_validation_prefix( $translation, $text, $context, $domain ) {
    if ( 'woocommerce' === $domain && 'checkout-validation' === $context && 'Billing %s' === $text ) {
        return '%s';
    }

    return $translation;
}
add_filter( 'gettext_with_context', 'tanjandi_checkout_validation_prefix', 10, 4 );

/**
 * Order numbers carry the shop's prefix, e.g. TJ-71.
 */
function tanjandi_order_number( $number ) {
    return 'TJ-' . $number;
}
add_filter( 'woocommerce_order_number', 'tanjandi_order_number' );

/**
 * Account
 * Menu of the account page: own labels, no downloads.
 */
function tanjandi_account_menu_items( $items ) {
    unset( $items['downloads'] );

    if ( isset( $items['dashboard'] ) ) {
        $items['dashboard'] = __( 'Übersicht', 'tanjandi' );
    }

    if ( isset( $items['edit-address'] ) ) {
        $items['edit-address'] = __( 'Adressen', 'tanjandi' );
    }

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'tanjandi_account_menu_items' );

/**
 * The address consists of name, street, postcode, city and country only,
 * in the checkout as well as in the account.
 */
function tanjandi_billing_fields( $fields ) {
    unset( $fields['billing_company'], $fields['billing_address_2'], $fields['billing_state'], $fields['billing_phone'] );

    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'tanjandi_billing_fields' );

/**
 * Address form in the account: same labels, widths and classes as in the
 * checkout.
 */
function tanjandi_account_address_fields( $address, $load_address ) {
    $prefix = $load_address . '_';
    $layout = array(
        'email'      => array( __( 'E-Mail', 'tanjandi' ), 'full' ),
        'first_name' => array( __( 'Vorname', 'tanjandi' ), 'half' ),
        'last_name'  => array( __( 'Nachname', 'tanjandi' ), 'half' ),
        'address_1'  => array( __( 'Strasse und Hausnummer', 'tanjandi' ), 'full' ),
        'postcode'   => array( __( 'PLZ', 'tanjandi' ), 'third' ),
        'city'       => array( __( 'Ort', 'tanjandi' ), 'two-thirds' ),
        'country'    => array( __( 'Land', 'tanjandi' ), 'full' ),
    );
    $sorted = array();

    foreach ( $layout as $name => $settings ) {
        $key = $prefix . $name;

        if ( ! isset( $address[ $key ] ) ) {
            continue;
        }

        $field                = $address[ $key ];
        $field['label']       = $settings[0];
        $field['placeholder'] = '';
        $field['class']       = array( 'checkout-field', 'checkout-field--' . $settings[1] );
        $field['label_class'] = array( 'checkout-field__label' );
        $field['input_class'] = array( 'checkout-field__input' );

        if ( 'country' === $name ) {
            $countries = WC()->countries->get_allowed_countries();

            if ( 1 === count( $countries ) ) {
                $field['type']        = 'hidden';
                $field['value']       = key( $countries );
                $field['class']       = array( 'checkout-field', 'checkout-field--hidden' );
                $field['input_class'] = array();
            } else {
                $field['type']    = 'select';
                $field['options'] = $countries;
            }
        }

        $sorted[ $key ] = $field;
        unset( $address[ $key ] );
    }

    // Anything else, e.g. fields added by a plugin, follows at full width.
    foreach ( $address as $key => $field ) {
        $field['class']       = array( 'checkout-field', 'checkout-field--full' );
        $field['label_class'] = array( 'checkout-field__label' );
        $field['input_class'] = array( 'checkout-field__input' );
        $sorted[ $key ]       = $field;
    }

    return $sorted;
}
add_filter( 'woocommerce_address_to_edit', 'tanjandi_account_address_fields', 20, 2 );

/**
 * Order list in the account: the link to an order reads "Ansehen".
 */
function tanjandi_account_orders_actions( $actions ) {
    if ( isset( $actions['view'] ) ) {
        $actions['view']['name'] = __( 'Ansehen', 'tanjandi' );
    }

    return $actions;
}
add_filter( 'woocommerce_my_account_my_orders_actions', 'tanjandi_account_orders_actions' );

/**
 * Line below the product name of an order item, e.g. "Vase · Suna".
 * Counterpart of tanjandi_cart_item_meta() for placed orders.
 */
function tanjandi_order_item_meta( $item ) {
    $parts    = array();
    $subtitle = function_exists( 'get_field' ) ? (string) get_field( 'product_subtitle', $item->get_product_id() ) : '';

    if ( '' !== $subtitle ) {
        $parts[] = trim( explode( '·', $subtitle )[0] );
    }

    $variation = $item->get_variation_id() ? wc_get_product( $item->get_variation_id() ) : null;

    if ( $variation ) {
        foreach ( $variation->get_attributes() as $taxonomy => $value ) {
            $term    = taxonomy_exists( $taxonomy ) ? get_term_by( 'slug', $value, $taxonomy ) : false;
            $parts[] = $term ? $term->name : $value;
        }
    }

    return implode( ' · ', array_filter( $parts ) );
}

/**
 * "Erneut bestellen" is offered as soon as an order is being worked on,
 * not only once it is completed.
 */
function tanjandi_order_again_statuses( $statuses ) {
    return array_unique( array_merge( $statuses, array( 'processing', 'on-hold' ) ) );
}
add_filter( 'woocommerce_valid_order_statuses_for_order_again', 'tanjandi_order_again_statuses' );

/**
 * Pages that stay reachable while the shop is in coming soon mode:
 * the legal notice and the privacy policy.
 */
function tanjandi_coming_soon_exclude( $is_excluded ) {
    if ( $is_excluded ) {
        return $is_excluded;
    }

    $privacy_page = (int) get_option( 'wp_page_for_privacy_policy' );

    return is_page( 'impressum' ) || ( $privacy_page && is_page( $privacy_page ) );
}
add_filter( 'woocommerce_coming_soon_exclude', 'tanjandi_coming_soon_exclude' );

/**
 * While the shop is in coming soon mode, visitors get the minimal header
 * and footer on the pages that stay reachable too, so no link leads into
 * the closed shop. Shop managers keep the full navigation.
 */
function tanjandi_coming_soon_template_parts( $parsed_block ) {
    if ( 'core/template-part' !== $parsed_block['blockName'] || is_admin() ) {
        return $parsed_block;
    }

    $slug = $parsed_block['attrs']['slug'] ?? '';

    if ( ! in_array( $slug, array( 'header', 'footer' ), true ) ) {
        return $parsed_block;
    }

    if ( ! tanjandi_is_coming_soon_visitor() ) {
        return $parsed_block;
    }

    $parsed_block['attrs']['slug'] = $slug . '-minimal';

    return $parsed_block;
}
add_filter( 'render_block_data', 'tanjandi_coming_soon_template_parts' );

/**
 * Whether the whole site is in coming soon mode for the current visitor.
 * Shop managers see the real site.
 */
function tanjandi_is_coming_soon_visitor() {
    return 'yes' === get_option( 'woocommerce_coming_soon' )
        && 'yes' !== get_option( 'woocommerce_store_pages_only' )
        && ! current_user_can( 'manage_woocommerce' );
}

/**
 * Description of the coming soon page for search engines and link
 * previews. Without it Yoast would use the description or the text of the
 * page that is hidden behind the coming soon page.
 */
function tanjandi_coming_soon_description( $description ) {
    if ( ! tanjandi_is_coming_soon_visitor() || tanjandi_coming_soon_exclude( false ) ) {
        return $description;
    }

    return __( 'tanjandi – 3D-gedruckte Vasen aus der Schweiz, Schicht für Schicht auf Bestellung gefertigt. Der Shop öffnet bald. Schreib uns bis dahin per E-Mail.', 'tanjandi' );
}
add_filter( 'wpseo_metadesc', 'tanjandi_coming_soon_description' );
add_filter( 'wpseo_opengraph_desc', 'tanjandi_coming_soon_description' );
add_filter( 'wpseo_twitter_description', 'tanjandi_coming_soon_description' );

/**
 * Title of the coming soon page, instead of the title of the page hidden
 * behind it.
 */
function tanjandi_coming_soon_title( $title ) {
    if ( ! tanjandi_is_coming_soon_visitor() || tanjandi_coming_soon_exclude( false ) ) {
        return $title;
    }

    return __( 'tanjandi – Bald geöffnet', 'tanjandi' );
}
add_filter( 'wpseo_title', 'tanjandi_coming_soon_title' );
// Late, so it also wins over the shop archive title.
add_filter( 'pre_get_document_title', 'tanjandi_coming_soon_title', 99 );
add_filter( 'wpseo_opengraph_title', 'tanjandi_coming_soon_title' );
add_filter( 'wpseo_twitter_title', 'tanjandi_coming_soon_title' );

/**
 * Customer e-mails in the look of the site: brand fonts with web-safe
 * fallbacks, hairlines in the line colour and calmer headings. Colours,
 * logo and footer text are set in WooCommerce → Settings → E-Mails.
 */
function tanjandi_email_styles( $css ) {
    $body_font    = "'Zen Kaku Gothic New', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    $heading_font = "'Shippori Mincho', Georgia, 'Times New Roman', serif";
    $line         = '#d6cec2';

    // The font chosen in the settings is replaced by the brand font.
    $css = str_replace( \Automattic\WooCommerce\Internal\Email\EmailFont::$font['Helvetica'], $body_font, $css );
    $css = str_replace( array( 'rgba(0, 0, 0, .2)', '#1e1e1e' ), $line, $css );

    return "@import url('https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500&family=Zen+Kaku+Gothic+New:wght@400;500&display=swap');\n" . $css . "
h1,
#template_header h1,
#header_wrapper h1 {
    font-family: {$heading_font};
    font-size: 30px;
    font-weight: 500;
    letter-spacing: 0;
    line-height: 130%;
}

h2,
h3 {
    font-family: {$heading_font};
    font-weight: 500;
}

h2 {
    font-size: 22px;
}

h2 span {
    font-family: {$body_font};
}

#body_content p,
#body_content_inner {
    line-height: 170%;
}

#template_footer #credit {
    font-size: 13px;
    line-height: 170%;
}

#template_header_image img {
    width: 160px;
}
";
}
add_filter( 'woocommerce_email_styles', 'tanjandi_email_styles' );

/**
 * Introductions of the customer e-mails in the voice of the shop: every
 * object is printed to order, so the e-mails say what happens next.
 */
function tanjandi_email_texts( $translation, $text, $domain ) {
    if ( 'woocommerce' !== $domain ) {
        return $translation;
    }

    $texts = array(
        'Just to let you know &mdash; we’ve received your order, and it is now being processed.'                     => 'Schön, dass du dich für ein Objekt von uns entschieden hast. Wir drucken es jetzt für dich und versenden es innerhalb von 3–5 Werktagen.',
        'We’ve received your order and it’s currently on hold until we can confirm your payment has been processed.' => 'Schön, dass du dich für ein Objekt von uns entschieden hast. Sobald deine Zahlung bei uns eingegangen ist, beginnen wir mit dem Druck.',
        'We have finished processing your order.'                                                                     => 'Dein Objekt ist fertig gedruckt, von Hand geprüft und sorgfältig verpackt. Jetzt ist es auf dem Weg zu dir.',
        'Here’s a reminder of what you’ve ordered:'                                                                   => 'Hier nochmals deine Bestellung im Überblick:',
    );

    return $texts[ $text ] ?? $translation;
}
add_filter( 'gettext', 'tanjandi_email_texts', 10, 3 );
