<?php
/**
 * My Addresses
 *
 * Overrides woocommerce/templates/myaccount/my-address.php.
 *
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();
$is_single   = wc_ship_to_billing_address_only() || ! wc_shipping_enabled();

// With one address for everything, that address is the delivery address,
// as in the checkout.
$addresses = $is_single
    ? array( 'billing' => __( 'Lieferadresse', 'tanjandi' ) )
    : array(
        'billing'  => __( 'Rechnungsadresse', 'tanjandi' ),
        'shipping' => __( 'Lieferadresse', 'tanjandi' ),
    );
$addresses = apply_filters( 'woocommerce_my_account_get_addresses', $addresses, $customer_id );

// The country is part of the address even when it is the shop's own.
add_filter( 'woocommerce_formatted_address_force_country_display', '__return_true' );
?>

<p class="account-page__text">
    <?php
    echo esc_html(
        $is_single
            ? __( 'Die folgende Adresse wird standardmässig an der Kasse verwendet.', 'tanjandi' )
            : __( 'Die folgenden Adressen werden standardmässig an der Kasse verwendet.', 'tanjandi' )
    );
    ?>
</p>

<div class="account-addresses">

    <?php foreach ( $addresses as $name => $address_title ) : ?>
        <?php $address = wc_get_account_formatted_address( $name ); ?>

        <section class="account-address">
            <header class="account-address__header">
                <h2 class="account-address__title"><?php echo esc_html( $address_title ); ?></h2>
                <?php /* translators: %s: address title. */ ?>
                <a class="account-address__edit" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%s bearbeiten', 'tanjandi' ), $address_title ) ); ?>">
                    <?php echo esc_html( $address ? __( 'Bearbeiten', 'tanjandi' ) : __( 'Hinzufügen', 'tanjandi' ) ); ?>
                </a>
            </header>
            <address class="account-address__lines">
                <?php
                echo $address ? wp_kses_post( $address ) : esc_html__( 'Du hast noch keine Adresse hinterlegt.', 'tanjandi' );

                do_action( 'woocommerce_my_account_after_my_address', $name );
                ?>
            </address>
        </section>

    <?php endforeach; ?>

</div>

<?php
remove_filter( 'woocommerce_formatted_address_force_country_display', '__return_true' );
