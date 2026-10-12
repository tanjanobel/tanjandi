<?php
/**
 * Thankyou page (order confirmation)
 *
 * Overrides woocommerce/templates/checkout/thankyou.php.
 *
 * @package WooCommerce\Templates
 * @version 11.2.0
 */

defined( 'ABSPATH' ) || exit;

// The order details table and addresses WooCommerce adds by default are
// left out; payment methods can still print their instructions.
remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
?>

<div class="order-confirmation woocommerce-order">

    <?php if ( $order ) : ?>

        <?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

        <?php if ( $order->has_status( 'failed' ) ) : ?>

            <h1 class="order-confirmation__title"><?php esc_html_e( 'Die Zahlung hat nicht geklappt', 'tanjandi' ); ?></h1>

            <p class="order-confirmation__text woocommerce-thankyou-order-failed">
                <?php echo wp_kses_post( apply_filters( 'woocommerce_thankyou_order_failed_text', __( 'Deine Bank oder dein Zahlungsanbieter hat die Zahlung abgelehnt. Bitte versuche es noch einmal.', 'tanjandi' ), $order ) ); ?>
            </p>

            <div class="order-confirmation__actions wp-block-button">
                <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"><?php esc_html_e( 'Erneut bezahlen', 'tanjandi' ); ?></a>
            </div>

        <?php else : ?>

            <span class="order-confirmation__mark" aria-hidden="true"></span>

            <h1 class="order-confirmation__title">
                <?php
                $first_name = $order->get_billing_first_name();
                /* translators: %s: first name of the customer. */
                echo esc_html( $first_name ? sprintf( __( 'Danke, %s', 'tanjandi' ), $first_name ) : __( 'Danke', 'tanjandi' ) );
                ?><span class="order-confirmation__title-dot">.</span>
            </h1>

            <p class="order-confirmation__text">
                <?php
                printf(
                    /* translators: %s: e-mail address of the customer. */
                    esc_html__( 'Deine Bestellung ist bei uns angekommen. Wir beginnen jetzt mit dem Druck – Schicht für Schicht. Eine Bestätigung ist unterwegs an %s.', 'tanjandi' ),
                    esc_html( $order->get_billing_email() )
                );
                ?>
            </p>

            <dl class="order-confirmation__details woocommerce-order-overview">
                <div class="order-confirmation__row">
                    <dt class="order-confirmation__label"><?php esc_html_e( 'Bestellnummer', 'tanjandi' ); ?></dt>
                    <dd class="order-confirmation__value"><?php echo esc_html( $order->get_order_number() ); ?></dd>
                </div>
                <div class="order-confirmation__row">
                    <dt class="order-confirmation__label"><?php esc_html_e( 'Total', 'tanjandi' ); ?></dt>
                    <dd class="order-confirmation__value"><?php echo esc_html( tanjandi_price_dash( $order->get_total() ) ); ?></dd>
                </div>
                <?php if ( $order->get_payment_method_title() ) : ?>
                    <div class="order-confirmation__row">
                        <dt class="order-confirmation__label"><?php esc_html_e( 'Zahlung', 'tanjandi' ); ?></dt>
                        <dd class="order-confirmation__value"><?php echo esc_html( $order->get_payment_method_title() ); ?></dd>
                    </div>
                <?php endif; ?>
                <div class="order-confirmation__row">
                    <dt class="order-confirmation__label"><?php esc_html_e( 'Voraussichtlicher Versand', 'tanjandi' ); ?></dt>
                    <dd class="order-confirmation__value"><?php esc_html_e( 'in 3–5 Werktagen', 'tanjandi' ); ?></dd>
                </div>
            </dl>

            <div class="order-confirmation__instructions">
                <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
            </div>

            <div class="order-confirmation__actions wp-block-button">
                <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Zurück zur Startseite', 'tanjandi' ); ?></a>
            </div>

        <?php endif; ?>

    <?php else : ?>

        <h1 class="order-confirmation__title"><?php esc_html_e( 'Danke', 'tanjandi' ); ?><span class="order-confirmation__title-dot">.</span></h1>

        <p class="order-confirmation__text"><?php esc_html_e( 'Deine Bestellung ist bei uns angekommen.', 'tanjandi' ); ?></p>

    <?php endif; ?>

</div>
