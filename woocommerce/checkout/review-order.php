<?php
/**
 * Review order: summary in the checkout sidebar
 *
 * Overrides woocommerce/templates/checkout/review-order.php. WooCommerce
 * replaces the element with the class woocommerce-checkout-review-order-table
 * whenever the checkout is recalculated.
 *
 * @package WooCommerce\Templates
 * @version 11.2.0
 */

defined( 'ABSPATH' ) || exit;

$cart     = WC()->cart;
$shipping = tanjandi_cart_shipping_row();
?>
<div class="woocommerce-checkout-review-order-table cart-summary cart-summary--order">

    <div class="cart-summary__header">
        <h2 class="cart-summary__title"><?php esc_html_e( 'Deine Bestellung', 'tanjandi' ); ?></h2>
        <a class="cart-summary__edit" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Bestellung im Warenkorb ändern', 'tanjandi' ); ?>"><?php esc_html_e( 'Ändern', 'tanjandi' ); ?></a>
    </div>

    <ul class="cart-summary__items">
        <?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

        <?php
        foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                continue;
            }

            $item_meta = tanjandi_cart_item_meta( $cart_item );
            ?>
            <li class="order-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                <div class="order-item__media">
                    <?php echo $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'order-item__img' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <span class="order-item__quantity">
                        <span class="screen-reader-text"><?php esc_html_e( 'Menge:', 'tanjandi' ); ?></span>
                        <?php echo esc_html( $cart_item['quantity'] ); ?>
                    </span>
                </div>

                <div class="order-item__info">
                    <p class="order-item__name"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', get_the_title( $cart_item['product_id'] ), $cart_item, $cart_item_key ) ); ?></p>

                    <?php if ( $item_meta ) : ?>
                        <p class="order-item__meta"><?php echo esc_html( $item_meta ); ?></p>
                    <?php endif; ?>
                </div>

                <p class="order-item__total"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', $cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
            </li>
            <?php
        }
        ?>

        <?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>
    </ul>

    <dl class="cart-summary__rows">
        <div class="cart-summary__row cart-subtotal">
            <dt class="cart-summary__label"><?php esc_html_e( 'Zwischensumme', 'tanjandi' ); ?></dt>
            <dd class="cart-summary__value"><?php echo esc_html( tanjandi_price_dash( $cart->get_displayed_subtotal() ) ); ?></dd>
        </div>

        <?php foreach ( $cart->get_coupons() as $code => $coupon ) : ?>
            <div class="cart-summary__row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <dt class="cart-summary__label">
                    <?php
                    /* translators: %s: coupon code. */
                    echo esc_html( sprintf( __( 'Gutschein «%s»', 'tanjandi' ), wc_strtoupper( $code ) ) );
                    ?>
                </dt>
                <dd class="cart-summary__value">– <?php echo esc_html( tanjandi_price_dash( $cart->get_coupon_discount_amount( $code, $cart->display_cart_ex_tax ) ) ); ?></dd>
            </div>
        <?php endforeach; ?>

        <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

        <?php if ( $shipping ) : ?>
            <div class="cart-summary__row shipping">
                <dt class="cart-summary__label"><?php esc_html_e( 'Versand', 'tanjandi' ); ?></dt>
                <dd class="cart-summary__value"><?php echo esc_html( $shipping['value'] ); ?></dd>
            </div>
        <?php endif; ?>

        <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

        <?php foreach ( $cart->get_fees() as $fee ) : ?>
            <div class="cart-summary__row fee">
                <dt class="cart-summary__label"><?php echo esc_html( $fee->name ); ?></dt>
                <dd class="cart-summary__value"><?php echo esc_html( tanjandi_price_dash( $cart->display_prices_including_tax() ? $fee->total + $fee->tax : $fee->total ) ); ?></dd>
            </div>
        <?php endforeach; ?>
    </dl>

    <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

    <div class="cart-summary__total order-total">
        <p class="cart-summary__total-label"><?php esc_html_e( 'Total', 'tanjandi' ); ?></p>
        <p class="cart-summary__total-value"><?php echo esc_html( tanjandi_price_dash( $cart->get_total( 'edit' ) ) ); ?></p>
    </div>

    <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</div>
