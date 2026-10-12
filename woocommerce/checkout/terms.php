<?php
/**
 * Checkout terms and conditions checkbox
 *
 * Overrides woocommerce/templates/checkout/terms.php: one sentence with
 * links to the terms and the privacy policy instead of WooCommerce's
 * separate privacy text and expandable terms.
 *
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! apply_filters( 'woocommerce_checkout_show_terms', true ) || ! function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
    return;
}

do_action( 'woocommerce_checkout_before_terms_and_conditions' );

$terms_url   = wc_terms_and_conditions_page_id() ? get_permalink( wc_terms_and_conditions_page_id() ) : '';
$privacy_url = wc_privacy_policy_page_id() ? get_permalink( wc_privacy_policy_page_id() ) : '';
?>
<div class="checkout-terms woocommerce-terms-and-conditions-wrapper">
    <?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
        <p class="checkout-terms__row form-row validate-required">
            <label class="checkout-terms__label woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input type="checkbox" class="checkout-terms__input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" id="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // phpcs:ignore WordPress.Security.NonceVerification.Missing ?> />
                <span class="checkout-terms__text woocommerce-terms-and-conditions-checkbox-text">
                    <?php
                    printf(
                        /* translators: 1: link to the terms, 2: link to the privacy policy. */
                        esc_html__( 'Ich habe die %1$s und die %2$s gelesen und bin einverstanden.', 'tanjandi' ),
                        '<a class="checkout-terms__link" href="' . esc_url( $terms_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'AGB', 'tanjandi' ) . '</a>',
                        '<a class="checkout-terms__link" href="' . esc_url( $privacy_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'Datenschutzerklärung', 'tanjandi' ) . '</a>'
                    );
                    ?>
                </span>
            </label>
            <input type="hidden" name="terms-field" value="1" />
        </p>
    <?php endif; ?>
</div>
<?php
do_action( 'woocommerce_checkout_after_terms_and_conditions' );
