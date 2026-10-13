<?php
/**
 * My Account navigation
 *
 * Overrides woocommerce/templates/myaccount/navigation.php.
 *
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="side-nav" aria-label="<?php esc_attr_e( 'Account pages', 'woocommerce' ); ?>">
    <ul class="side-nav__list">
        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <?php $is_current = wc_is_current_account_menu_item( $endpoint ); ?>
            <li class="side-nav__item">
                <a class="side-nav__link<?php echo $is_current ? ' side-nav__link--current' : ''; ?>" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
                    <?php echo esc_html( $label ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
