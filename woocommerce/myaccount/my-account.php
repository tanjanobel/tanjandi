<?php
/**
 * My Account page
 *
 * Overrides woocommerce/templates/myaccount/my-account.php.
 *
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$endpoint = WC()->query->get_current_endpoint();
$title    = $endpoint ? WC()->query->get_endpoint_title( $endpoint ) : __( 'Willkommen zurück', 'tanjandi' );

if ( 'view-order' === $endpoint ) {
    $viewed_order = wc_get_order( absint( get_query_var( 'view-order' ) ) );

    if ( $viewed_order ) {
        /* translators: %s: order number. */
        $title = sprintf( __( 'Bestellung %s', 'tanjandi' ), $viewed_order->get_order_number() );
    }
}
?>

<header class="account-page__header">
    <p class="account-page__intro"><?php esc_html_e( 'Mein Konto', 'tanjandi' ); ?></p>
    <h1 class="account-page__title"><?php echo esc_html( $title ); ?></h1>
</header>

<div class="account-page__layout">

    <?php do_action( 'woocommerce_account_navigation' ); ?>

    <div class="account-page__main woocommerce-MyAccount-content">
        <?php do_action( 'woocommerce_account_content' ); ?>
    </div>

</div>
