<?php
/**
 * Cart totals
 *
 * Overrides woocommerce/templates/cart/cart-totals.php.
 *
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

$cart     = WC()->cart;
$goal     = tanjandi_free_shipping_goal();
$shipping = tanjandi_cart_shipping_row();
?>
<div class="cart_totals cart-summary <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <h2 class="cart-summary__title"><?php esc_html_e( 'Übersicht', 'tanjandi' ); ?></h2>

    <?php if ( $goal ) : ?>
        <div class="cart-summary__goal">
            <p class="cart-summary__goal-text">
                <?php
                if ( $goal['remaining'] > 0 ) {
                    /* translators: %s: amount missing for free shipping. */
                    echo esc_html( sprintf( __( 'Noch %s bis zum kostenlosen Versand', 'tanjandi' ), tanjandi_price_text( $goal['remaining'] ) ) );
                } else {
                    esc_html_e( 'Dein Versand ist kostenlos', 'tanjandi' );
                }
                ?>
            </p>
            <div class="cart-summary__progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo esc_attr( $goal['percent'] ); ?>" aria-label="<?php esc_attr_e( 'Fortschritt bis zum kostenlosen Versand', 'tanjandi' ); ?>">
                <span class="cart-summary__progress-bar" style="width: <?php echo esc_attr( $goal['percent'] ); ?>%"></span>
            </div>
        </div>
    <?php endif; ?>

    <dl class="cart-summary__rows">
        <div class="cart-summary__row cart-subtotal">
            <dt class="cart-summary__label"><?php esc_html_e( 'Zwischensumme', 'tanjandi' ); ?></dt>
            <dd class="cart-summary__value"><?php echo esc_html( tanjandi_price_text( $cart->get_displayed_subtotal() ) ); ?></dd>
        </div>

        <?php foreach ( $cart->get_coupons() as $code => $coupon ) : ?>
            <div class="cart-summary__row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <dt class="cart-summary__label">
                    <?php
                    /* translators: %s: coupon code. */
                    echo esc_html( sprintf( __( 'Gutschein «%s»', 'tanjandi' ), wc_strtoupper( $code ) ) );
                    ?>
                    <a class="cart-summary__coupon-remove" href="<?php echo esc_url( add_query_arg( 'remove_coupon', rawurlencode( $code ), wc_get_cart_url() ) ); ?>"><?php esc_html_e( 'Entfernen', 'tanjandi' ); ?></a>
                </dt>
                <dd class="cart-summary__value">– <?php echo esc_html( tanjandi_price_text( $cart->get_coupon_discount_amount( $code, $cart->display_cart_ex_tax ) ) ); ?></dd>
            </div>
        <?php endforeach; ?>

        <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

        <?php if ( $shipping ) : ?>
            <div class="cart-summary__row shipping">
                <dt class="cart-summary__label"><?php echo esc_html( $shipping['label'] ); ?></dt>
                <dd class="cart-summary__value"><?php echo esc_html( $shipping['value'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

        <?php foreach ( $cart->get_fees() as $fee ) : ?>
            <div class="cart-summary__row fee">
                <dt class="cart-summary__label"><?php echo esc_html( $fee->name ); ?></dt>
                <dd class="cart-summary__value"><?php echo esc_html( tanjandi_price_text( $cart->display_prices_including_tax() ? $fee->total + $fee->tax : $fee->total ) ); ?></dd>
            </div>
        <?php endforeach; ?>
    </dl>

    <?php if ( wc_coupons_enabled() ) : ?>
        <?php // A form of its own, so that Enter in the field redeems the code instead of updating the cart. ?>
        <form class="cart-summary__coupon coupon" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <label class="screen-reader-text" for="coupon_code"><?php esc_html_e( 'Gutscheincode', 'tanjandi' ); ?></label>
            <input type="text" name="coupon_code" id="coupon_code" class="cart-summary__coupon-input" value="" placeholder="<?php esc_attr_e( 'Gutscheincode', 'tanjandi' ); ?>" autocomplete="off" />
            <button type="submit" name="apply_coupon" class="cart-summary__coupon-button" value="<?php esc_attr_e( 'Einlösen', 'tanjandi' ); ?>"><?php esc_html_e( 'Einlösen', 'tanjandi' ); ?></button>
            <input type="hidden" name="woocommerce-cart-nonce" value="<?php echo esc_attr( wp_create_nonce( 'woocommerce-cart' ) ); ?>" />
            <?php do_action( 'woocommerce_cart_coupon' ); ?>
        </form>
    <?php endif; ?>

    <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

    <div class="cart-summary__total order-total">
        <p class="cart-summary__total-label"><?php esc_html_e( 'Total', 'tanjandi' ); ?></p>
        <p class="cart-summary__total-value"><?php echo esc_html( tanjandi_price_text( $cart->get_total( 'edit' ) ) ); ?></p>
    </div>

    <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    <div class="wc-proceed-to-checkout cart-summary__checkout wp-block-button">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <p class="cart-summary__note"><?php esc_html_e( 'Bezahlen mit TWINT oder per Vorauszahlung', 'tanjandi' ); ?></p>
    <p class="cart-summary__note"><?php esc_html_e( 'Rückgabe innert 14 Tagen', 'tanjandi' ); ?></p>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
