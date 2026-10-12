<?php
/**
 * Orders
 *
 * Overrides woocommerce/templates/myaccount/orders.php.
 *
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders );
?>

<?php if ( $has_orders ) : ?>

    <table class="account-orders">
        <thead class="account-orders__head">
            <tr class="account-orders__row account-orders__row--head">
                <th class="account-orders__heading account-orders__heading--number" scope="col"><?php esc_html_e( 'Bestellung', 'tanjandi' ); ?></th>
                <th class="account-orders__heading account-orders__heading--date" scope="col"><?php esc_html_e( 'Datum', 'tanjandi' ); ?></th>
                <th class="account-orders__heading account-orders__heading--status" scope="col"><?php esc_html_e( 'Status', 'tanjandi' ); ?></th>
                <th class="account-orders__heading account-orders__heading--total" scope="col"><?php esc_html_e( 'Total', 'tanjandi' ); ?></th>
                <th class="account-orders__heading account-orders__heading--actions" scope="col"><span class="screen-reader-text"><?php esc_html_e( 'Aktionen', 'tanjandi' ); ?></span></th>
            </tr>
        </thead>

        <tbody class="account-orders__body">
            <?php foreach ( $customer_orders->orders as $customer_order ) : ?>
                <?php
                $order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                $is_open    = $order->has_status( array( 'pending', 'on-hold', 'processing' ) );
                ?>
                <tr class="account-orders__row">
                    <th class="account-orders__cell account-orders__cell--number" scope="row">
                        <a class="account-orders__number" href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php echo esc_html( $order->get_order_number() ); ?></a>
                    </th>
                    <td class="account-orders__cell account-orders__cell--date">
                        <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created(), 'j. F Y' ) ); ?></time>
                    </td>
                    <td class="account-orders__cell account-orders__cell--status">
                        <span class="account-orders__status<?php echo $is_open ? ' account-orders__status--open' : ''; ?>"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></span>
                    </td>
                    <td class="account-orders__cell account-orders__cell--total">
                        <?php echo esc_html( tanjandi_price_dash( $order->get_total() ) ); ?>
                        <span class="account-orders__count">
                            <?php
                            /* translators: %s: number of items in the order. */
                            echo esc_html( '· ' . sprintf( _n( '%s Artikel', '%s Artikel', $item_count, 'tanjandi' ), $item_count ) );
                            ?>
                        </span>
                    </td>
                    <td class="account-orders__cell account-orders__cell--actions">
                        <?php foreach ( wc_get_account_orders_actions( $order ) as $key => $action ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                            <?php
                            /* translators: 1: action name 2: order number. */
                            $label = empty( $action['aria-label'] ) ? sprintf( __( '%1$s: Bestellung %2$s', 'tanjandi' ), $action['name'], $order->get_order_number() ) : $action['aria-label'];
                            ?>
                            <a class="account-orders__action <?php echo sanitize_html_class( $key ); ?>" href="<?php echo esc_url( $action['url'] ); ?>" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( $action['name'] ); ?></a>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

    <?php if ( 1 < $customer_orders->max_num_pages ) : ?>
        <nav class="account-orders__pagination" aria-label="<?php esc_attr_e( 'Seiten', 'tanjandi' ); ?>">
            <?php if ( 1 !== $current_page ) : ?>
                <a class="account-orders__page account-orders__page--previous" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Neuere Bestellungen', 'tanjandi' ); ?></a>
            <?php endif; ?>

            <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
                <a class="account-orders__page account-orders__page--next" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Ältere Bestellungen', 'tanjandi' ); ?></a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>

<?php else : ?>

    <p class="account-page__text">
        <?php esc_html_e( 'Du hast noch nichts bestellt.', 'tanjandi' ); ?>
        <a class="account-page__link" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Zum Shop', 'tanjandi' ); ?></a>
    </p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
