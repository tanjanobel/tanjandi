<?php
/**
 * View Order
 *
 * Overrides woocommerce/templates/myaccount/view-order.php.
 *
 * @package WooCommerce\Templates
 * @version 10.6.0
 */

defined( 'ABSPATH' ) || exit;

$notes    = $order->get_customer_order_notes();
$shipping = $order->get_shipping_method();
$discount = (float) $order->get_total_discount( false );
$contact  = get_option( 'woocommerce_email_from_address' );

// The order table and addresses WooCommerce adds by default are left out.
remove_action( 'woocommerce_view_order', 'woocommerce_order_details_table', 10 );
?>

<div class="order-details">

    <a class="order-details__back" href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>"><?php esc_html_e( 'Alle Bestellungen', 'tanjandi' ); ?></a>

    <p class="order-details__status">
        <?php
        printf(
            /* translators: 1: order number 2: order date 3: order status. */
            esc_html__( 'Bestellung %1$s wurde am %2$s aufgegeben und ist derzeit %3$s.', 'tanjandi' ),
            '<strong class="order-details__strong">' . esc_html( $order->get_order_number() ) . '</strong>',
            '<strong class="order-details__strong">' . esc_html( wc_format_datetime( $order->get_date_created(), 'j. F Y' ) ) . '</strong>',
            '<strong class="order-details__strong order-details__strong--status">' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '</strong>'
        );
        ?>
    </p>

    <ul class="order-details__items">
        <?php foreach ( $order->get_items() as $item ) : ?>
            <?php
            $product   = $item->get_product();
            $item_meta = tanjandi_order_item_meta( $item );
            ?>
            <li class="order-item order-item--large">
                <div class="order-item__media">
                    <?php
                    if ( $product ) {
                        echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'order-item__img' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </div>

                <div class="order-item__info">
                    <p class="order-item__name"><?php echo esc_html( get_the_title( $item->get_product_id() ) ? get_the_title( $item->get_product_id() ) : $item->get_name() ); ?> × <?php echo esc_html( $item->get_quantity() ); ?></p>

                    <?php if ( $item_meta ) : ?>
                        <p class="order-item__meta"><?php echo esc_html( $item_meta ); ?></p>
                    <?php endif; ?>
                </div>

                <p class="order-item__total"><?php echo esc_html( tanjandi_price_text( $order->get_line_subtotal( $item, true ) ) ); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <dl class="order-details__rows">
        <div class="order-details__row">
            <dt class="order-details__label"><?php esc_html_e( 'Zwischensumme', 'tanjandi' ); ?></dt>
            <dd class="order-details__value"><?php echo esc_html( tanjandi_price_dash( $order->get_subtotal() + $order->get_cart_tax() + (float) $order->get_discount_tax() ) ); ?></dd>
        </div>

        <?php if ( $discount > 0 ) : ?>
            <div class="order-details__row">
                <dt class="order-details__label"><?php esc_html_e( 'Rabatt', 'tanjandi' ); ?></dt>
                <dd class="order-details__value">– <?php echo esc_html( tanjandi_price_dash( $discount ) ); ?></dd>
            </div>
        <?php endif; ?>

        <?php if ( $shipping ) : ?>
            <?php $shipping_total = (float) $order->get_shipping_total() + (float) $order->get_shipping_tax(); ?>
            <div class="order-details__row">
                <dt class="order-details__label"><?php esc_html_e( 'Versand', 'tanjandi' ); ?></dt>
                <dd class="order-details__value">
                    <?php
                    /* translators: 1: shipping costs 2: shipping method. */
                    echo esc_html( sprintf( __( '%1$s (%2$s)', 'tanjandi' ), $shipping_total > 0 ? tanjandi_price_dash( $shipping_total ) : __( 'Kostenlos', 'tanjandi' ), $shipping ) );
                    ?>
                </dd>
            </div>
        <?php endif; ?>

        <?php if ( $order->get_payment_method_title() ) : ?>
            <div class="order-details__row">
                <dt class="order-details__label"><?php esc_html_e( 'Zahlungsmethode', 'tanjandi' ); ?></dt>
                <dd class="order-details__value"><?php echo esc_html( $order->get_payment_method_title() ); ?></dd>
            </div>
        <?php endif; ?>
    </dl>

    <div class="order-details__total">
        <p class="order-details__total-label"><?php esc_html_e( 'Total', 'tanjandi' ); ?></p>
        <p class="order-details__total-value"><?php echo esc_html( tanjandi_price_dash( $order->get_total() ) ); ?></p>
    </div>

    <?php if ( $notes ) : ?>
        <h2 class="order-details__heading"><?php esc_html_e( 'Neuigkeiten zur Bestellung', 'tanjandi' ); ?></h2>
        <ol class="order-details__notes">
            <?php foreach ( $notes as $note ) : ?>
                <li class="order-details__note">
                    <span class="order-details__note-date"><?php echo esc_html( date_i18n( 'j. F Y', strtotime( $note->comment_date ) ) ); ?></span>
                    <?php echo wp_kses_post( wptexturize( $note->comment_content ) ); ?>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <div class="order-details__actions">
        <?php if ( $order->has_status( apply_filters( 'woocommerce_valid_order_statuses_for_order_again', array( 'completed' ) ) ) ) : ?>
            <div class="order-details__primary wp-block-button">
                <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'order_again', $order->get_id(), wc_get_cart_url() ), 'woocommerce-order_again' ) ); ?>"><?php esc_html_e( 'Erneut bestellen', 'tanjandi' ); ?></a>
            </div>
        <?php endif; ?>

        <?php if ( $contact ) : ?>
            <?php /* translators: %s: order number. */ ?>
            <a class="order-details__secondary" href="<?php echo esc_url( 'mailto:' . $contact . '?subject=' . rawurlencode( sprintf( __( 'Frage zur Bestellung %s', 'tanjandi' ), $order->get_order_number() ) ) ); ?>"><?php esc_html_e( 'Frage zur Bestellung', 'tanjandi' ); ?></a>
        <?php endif; ?>
    </div>

    <?php do_action( 'woocommerce_view_order', $order_id ); ?>

</div>
