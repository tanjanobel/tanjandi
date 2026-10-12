<?php
/**
 * Shipping methods of one package, as a list of options
 *
 * Overrides woocommerce/templates/cart/cart-shipping.php. Used in the
 * shipping step of the checkout.
 *
 * @package WooCommerce\Templates
 * @version 11.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="checkout-shipping__package woocommerce-shipping-totals shipping">
    <?php if ( ! empty( $available_methods ) && is_array( $available_methods ) ) : ?>
        <ul class="checkout-options woocommerce-shipping-methods" id="shipping_method">
            <?php foreach ( $available_methods as $method ) : ?>
                <?php
                $input_id = sprintf( 'shipping_method_%1$d_%2$s', $index, sanitize_title( $method->id ) );
                $cost     = (float) $method->cost + ( WC()->cart->display_prices_including_tax() ? (float) $method->get_shipping_tax() : 0 );
                $note     = tanjandi_shipping_delivery_note( $method );
                ?>
                <li class="checkout-options__item">
                    <input type="radio" name="shipping_method[<?php echo esc_attr( $index ); ?>]" data-index="<?php echo esc_attr( $index ); ?>" id="<?php echo esc_attr( $input_id ); ?>" value="<?php echo esc_attr( $method->id ); ?>" class="shipping_method checkout-options__input" autocomplete="off" <?php checked( $method->id, $chosen_method ); ?> />
                    <label class="checkout-options__label" for="<?php echo esc_attr( $input_id ); ?>">
                        <span class="checkout-options__text">
                            <span class="checkout-options__name"><?php echo esc_html( $method->get_label() ); ?></span>
                            <?php if ( $note ) : ?>
                                <span class="checkout-options__description"><?php echo esc_html( $note ); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="checkout-options__price"><?php echo esc_html( $cost > 0 ? tanjandi_price_dash( $cost ) : __( 'kostenlos', 'tanjandi' ) ); ?></span>
                    </label>
                    <?php do_action( 'woocommerce_after_shipping_rate', $method, $index ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="checkout-shipping__note"><?php esc_html_e( 'Dein Objekt wird zuerst für dich gedruckt. Die Lieferzeit beginnt danach.', 'tanjandi' ); ?></p>
    <?php else : ?>
        <p class="checkout-shipping__message"><?php esc_html_e( 'Für diese Adresse haben wir leider keine Versandart. Bitte prüfe das Land oder melde dich bei uns.', 'tanjandi' ); ?></p>
    <?php endif; ?>
</div>
