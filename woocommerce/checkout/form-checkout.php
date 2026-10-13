<?php
/**
 * Checkout Form
 *
 * Overrides woocommerce/templates/checkout/form-checkout.php.
 * One form, shown in three steps by src/js/components/checkout-steps.js:
 * address, shipping, payment.
 *
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}

$billing_fields = $checkout->get_checkout_fields( 'billing' );
$countries      = WC()->countries->get_allowed_countries();
$country_name   = 1 === count( $countries ) ? reset( $countries ) : '';
$steps          = array(
    'address'  => __( 'Adresse', 'tanjandi' ),
    'shipping' => __( 'Versand', 'tanjandi' ),
    'payment'  => __( 'Zahlung', 'tanjandi' ),
);
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout checkout-page__form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>" novalidate="novalidate">

    <div class="checkout-page__main">
        <h1 class="checkout-page__title"><?php echo esc_html( get_the_title() ); ?></h1>

        <ol class="checkout-steps">
            <?php $number = 0; ?>
            <?php foreach ( $steps as $step => $label ) : ?>
                <?php ++$number; ?>
                <li class="checkout-steps__item<?php echo 1 === $number ? ' is-active' : ''; ?>" data-step-target="<?php echo esc_attr( $step ); ?>">
                    <button type="button" class="checkout-steps__button"<?php echo 1 === $number ? ' aria-current="step"' : ' disabled'; ?>>
                        <span class="checkout-steps__number"><?php echo esc_html( $number ); ?></span>
                        <span class="checkout-steps__label"><?php echo esc_html( $label ); ?></span>
                    </button>
                </li>
            <?php endforeach; ?>
        </ol>

        <section class="checkout-page__step" data-step="address">
            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

            <div class="checkout-page__details" id="customer_details">
                <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

                <div class="checkout-page__heading-row">
                    <h2 class="checkout-page__heading"><?php esc_html_e( 'Kontakt', 'tanjandi' ); ?></h2>

                    <?php if ( ! is_user_logged_in() ) : ?>
                        <p class="checkout-page__login">
                            <?php esc_html_e( 'Schon ein Konto?', 'tanjandi' ); ?>
                            <a class="checkout-page__login-link" href="<?php echo esc_url( add_query_arg( 'redirect_to', rawurlencode( wc_get_checkout_url() ), wc_get_page_permalink( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'Anmelden', 'tanjandi' ); ?></a>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="checkout-page__fields">
                    <?php
                    if ( isset( $billing_fields['billing_email'] ) ) {
                        woocommerce_form_field( 'billing_email', $billing_fields['billing_email'], $checkout->get_value( 'billing_email' ) );
                    }
                    ?>
                </div>

                <h2 class="checkout-page__heading"><?php esc_html_e( 'Lieferadresse', 'tanjandi' ); ?></h2>

                <div class="checkout-page__fields woocommerce-billing-fields__field-wrapper">
                    <?php
                    foreach ( $billing_fields as $key => $field ) {
                        if ( 'billing_email' === $key ) {
                            continue;
                        }

                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                    }
                    ?>
                </div>

                <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
            </div>

            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

            <div class="checkout-page__actions">
                <div class="checkout-page__next wp-block-button">
                    <button type="button" class="wp-block-button__link wp-element-button" data-step-next="shipping"><?php esc_html_e( 'Weiter zum Versand', 'tanjandi' ); ?></button>
                </div>
            </div>
        </section>

        <section class="checkout-page__step" data-step="shipping" hidden>
            <div class="checkout-recap" data-recap="address" data-country="<?php echo esc_attr( $country_name ); ?>">
                <p class="checkout-recap__title"><?php esc_html_e( 'Lieferadresse', 'tanjandi' ); ?></p>
                <button type="button" class="checkout-recap__edit" data-step-prev="address"><?php esc_html_e( 'Ändern', 'tanjandi' ); ?></button>
                <p class="checkout-recap__line" data-recap-line="name"></p>
                <p class="checkout-recap__line" data-recap-line="street"></p>
                <p class="checkout-recap__line" data-recap-line="place"></p>
                <p class="checkout-recap__line" data-recap-line="country"></p>
            </div>

            <h2 class="checkout-page__heading" tabindex="-1"><?php esc_html_e( 'Versandart', 'tanjandi' ); ?></h2>

            <?php tanjandi_checkout_shipping(); ?>

            <div class="checkout-page__actions">
                <div class="checkout-page__next wp-block-button">
                    <button type="button" class="wp-block-button__link wp-element-button" data-step-next="payment"><?php esc_html_e( 'Weiter zur Zahlung', 'tanjandi' ); ?></button>
                </div>
            </div>
        </section>

        <section class="checkout-page__step" data-step="payment" hidden>
            <div class="checkout-recap" data-recap="address" data-country="<?php echo esc_attr( $country_name ); ?>">
                <p class="checkout-recap__title"><?php esc_html_e( 'Lieferadresse', 'tanjandi' ); ?></p>
                <button type="button" class="checkout-recap__edit" data-step-prev="address"><?php esc_html_e( 'Ändern', 'tanjandi' ); ?></button>
                <p class="checkout-recap__line" data-recap-line="name"></p>
                <p class="checkout-recap__line" data-recap-line="street"></p>
                <p class="checkout-recap__line" data-recap-line="place"></p>
                <p class="checkout-recap__line" data-recap-line="country"></p>
            </div>

            <div class="checkout-recap" data-recap="shipping">
                <p class="checkout-recap__title"><?php esc_html_e( 'Versand', 'tanjandi' ); ?></p>
                <button type="button" class="checkout-recap__edit" data-step-prev="shipping"><?php esc_html_e( 'Ändern', 'tanjandi' ); ?></button>
                <p class="checkout-recap__line" data-recap-line="shipping"></p>
            </div>

            <h2 class="checkout-page__heading" tabindex="-1"><?php esc_html_e( 'Zahlungsart', 'tanjandi' ); ?></h2>

            <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

            <div class="checkout-page__payment woocommerce-checkout-review-order" id="order_review">
                <?php woocommerce_checkout_payment(); ?>
            </div>

            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
        </section>
    </div>

    <aside class="checkout-page__sidebar" aria-label="<?php esc_attr_e( 'Deine Bestellung', 'tanjandi' ); ?>">
        <?php woocommerce_order_review(); ?>
    </aside>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
