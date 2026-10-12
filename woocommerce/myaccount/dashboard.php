<?php
/**
 * My Account Dashboard
 *
 * Overrides woocommerce/templates/myaccount/dashboard.php.
 *
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

$name   = $current_user->first_name ? $current_user->first_name : $current_user->display_name;
$orders = wc_get_orders(
    array(
        'customer_id' => $current_user->ID,
        'limit'       => 1,
        'orderby'     => 'date',
        'order'       => 'DESC',
    )
);
$order  = $orders ? $orders[0] : null;
?>

<p class="account-page__greeting">
    <?php
    printf(
        /* translators: 1: first name of the customer 2: logout link. */
        esc_html__( 'Hallo %1$s (nicht %1$s? %2$s)', 'tanjandi' ),
        esc_html( $name ),
        '<a class="account-page__link account-page__link--strong" href="' . esc_url( wc_logout_url() ) . '">' . esc_html__( 'Abmelden', 'tanjandi' ) . '</a>'
    );
    ?>
</p>

<p class="account-page__text">
    <?php
    printf(
        /* translators: 1: orders link 2: address link 3: account details link. */
        esc_html__( 'In deinem Konto siehst du deine %1$s, verwaltest deine %2$s und kannst dein %3$s ändern.', 'tanjandi' ),
        '<a class="account-page__link" href="' . esc_url( wc_get_endpoint_url( 'orders' ) ) . '">' . esc_html__( 'letzten Bestellungen', 'tanjandi' ) . '</a>',
        '<a class="account-page__link" href="' . esc_url( wc_get_endpoint_url( 'edit-address' ) ) . '">' . esc_html__( 'Liefer- und Rechnungsadresse', 'tanjandi' ) . '</a>',
        '<a class="account-page__link" href="' . esc_url( wc_get_endpoint_url( 'edit-account' ) ) . '">' . esc_html__( 'Passwort und deine Kontodetails', 'tanjandi' ) . '</a>'
    );
    ?>
</p>

<?php if ( $order ) : ?>
    <?php
    $names = array();

    foreach ( $order->get_items() as $item ) {
        $product = $item->get_product();
        $parent  = $product && $product->get_parent_id() ? wc_get_product( $product->get_parent_id() ) : $product;
        $names[] = $parent ? $parent->get_name() : $item->get_name();
    }

    $meta = array(
        wc_format_datetime( $order->get_date_created(), 'j. F Y' ),
        implode( ', ', array_unique( $names ) ),
        tanjandi_price_dash( $order->get_total() ),
    );
    ?>
    <article class="account-order">
        <div class="account-order__body">
            <p class="account-order__label"><?php esc_html_e( 'Letzte Bestellung', 'tanjandi' ); ?></p>
            <h2 class="account-order__number"><?php echo esc_html( $order->get_order_number() ); ?></h2>
            <p class="account-order__meta"><?php echo esc_html( implode( ' · ', array_filter( $meta ) ) ); ?></p>
            <a class="account-order__link" href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php esc_html_e( 'Bestellung ansehen', 'tanjandi' ); ?></a>
        </div>
        <span class="account-order__status"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></span>
    </article>
<?php endif; ?>

<?php
do_action( 'woocommerce_account_dashboard' );
do_action( 'woocommerce_before_my_account' );
do_action( 'woocommerce_after_my_account' );
