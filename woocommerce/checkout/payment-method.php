<?php
/**
 * One payment method in the payment step
 *
 * Overrides woocommerce/templates/checkout/payment-method.php. The classes
 * wc_payment_method, payment_method_*, input-radio and payment_box are used
 * by WooCommerce's checkout script. The description is always shown below
 * the name; the box underneath only appears for methods with input fields.
 *
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$description = wp_strip_all_tags( $gateway->get_description() );
?>
<li class="checkout-options__item wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
    <input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="checkout-options__input input-radio" autocomplete="off" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

    <label class="checkout-options__label" for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
        <span class="checkout-options__text">
            <span class="checkout-options__name"><?php echo $gateway->get_title(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></span>
            <?php if ( $description ) : ?>
                <span class="checkout-options__description"><?php echo esc_html( $description ); ?></span>
            <?php endif; ?>
        </span>
        <?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
    </label>

    <?php if ( $gateway->has_fields() ) : ?>
        <div class="checkout-options__details payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php echo $gateway->chosen ? '' : 'style="display:none;"'; ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
