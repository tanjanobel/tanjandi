<?php
/**
 * Proceed to checkout button
 *
 * Overrides woocommerce/templates/cart/proceed-to-checkout-button.php.
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
?>

<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button wp-block-button__link wp-element-button"><?php esc_html_e( 'Zur Kasse', 'tanjandi' ); ?></a>
