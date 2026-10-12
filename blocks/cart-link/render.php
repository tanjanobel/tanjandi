<?php
/**
 * Cart Link Block Template.
 * Icons on the right of the header: account and cart with item count.
 */

$cart_url    = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/warenkorb/' );
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/mein-konto/' );
?>
<div class="header__actions">
    <a class="header__action header__account" href="<?php echo esc_url( $account_url ); ?>">
        <svg class="header__action-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true" focusable="false">
            <circle cx="10" cy="6.5" r="3.6" stroke="currentColor" stroke-width="1.3"/>
            <path d="M2.8 18.2c.7-3.6 3.6-5.6 7.2-5.6s6.5 2 7.2 5.6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
        </svg>
        <span class="header__action-label"><?php esc_html_e( 'Mein Konto', 'tanjandi' ); ?></span>
    </a>
    <a class="header__action header__cart" href="<?php echo esc_url( $cart_url ); ?>">
        <svg class="header__action-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true" focusable="false">
            <path d="M3.6 6.8h12.800l-.8 11H4.400l-.8-11z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
            <path d="M7 6.8V5a3 3 0 0 1 6 0v1.800" stroke="currentColor" stroke-width="1.3"/>
        </svg>
        <span class="header__action-label"><?php esc_html_e( 'Warenkorb', 'tanjandi' ); ?></span>
        <?php echo tanjandi_cart_count_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </a>
</div>
