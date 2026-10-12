<?php
/**
 * Edit address form
 *
 * Overrides woocommerce/templates/myaccount/form-edit-address.php.
 *
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_address_form' );
?>

<?php if ( ! $load_address ) : ?>
    <?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

    <form class="account-form account-page__form" method="post" novalidate>

        <div class="woocommerce-address-fields">
            <?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

            <div class="account-form__fields woocommerce-address-fields__field-wrapper">
                <?php
                foreach ( $address as $key => $field ) {
                    woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
                }
                ?>
            </div>

            <?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

            <div class="account-form__actions">
                <div class="account-form__submit wp-block-button">
                    <button type="submit" class="wp-block-button__link wp-element-button" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>"><?php esc_html_e( 'Adresse speichern', 'tanjandi' ); ?></button>
                </div>
                <?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
                <input type="hidden" name="action" value="edit_address" />
            </div>
        </div>

    </form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
