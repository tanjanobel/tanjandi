<?php
/**
 * Cart Link Block Template.
 */

$cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/warenkorb/' );
?>
<a class="header__cart" href="<?php echo esc_url( $cart_url ); ?>">
    <span class="header__cart-label"><?php esc_html_e( 'Warenkorb', 'tanjandi' ); ?></span>
    <?php echo tanjandi_cart_count_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</a>
