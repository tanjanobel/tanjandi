<?php
/**
 * Empty cart page
 *
 * Overrides woocommerce/templates/cart/cart-empty.php.
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

// The message is part of the markup below instead of a notice banner.
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );

do_action( 'woocommerce_cart_is_empty' );
?>

<div class="cart-page__empty">
    <p class="cart-page__empty-text"><?php esc_html_e( 'Dein Warenkorb ist derzeit leer.', 'tanjandi' ); ?></p>

    <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <div class="cart-page__empty-actions wp-block-button">
            <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Zurück zum Shop', 'tanjandi' ); ?></a>
        </div>
    <?php endif; ?>
</div>
