<?php
/**
 * Lost password reset form
 *
 * Overrides woocommerce/templates/myaccount/form-reset-password.php.
 *
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>

<div class="account-page__auth">

    <a class="account-page__back" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Zurück zur Anmeldung', 'tanjandi' ); ?></a>

    <p class="account-page__intro"><?php esc_html_e( 'Mein Konto', 'tanjandi' ); ?></p>
    <h1 class="account-page__title account-page__title--small"><?php esc_html_e( 'Neues Passwort', 'tanjandi' ); ?></h1>

    <p class="account-page__lead">
        <?php echo wp_kses_post( apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Lege hier dein neues Passwort fest.', 'tanjandi' ) ) ); ?>
    </p>

    <form method="post" class="account-form account-page__form woocommerce-ResetPassword lost_reset_password">

        <div class="account-form__fields">
            <p class="checkout-field checkout-field--full form-row">
                <label class="checkout-field__label" for="password_1"><?php esc_html_e( 'Neues Passwort', 'tanjandi' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
                <input type="password" class="checkout-field__input input-text" name="password_1" id="password_1" autocomplete="new-password" required aria-required="true" />
            </p>
            <p class="checkout-field checkout-field--full form-row">
                <label class="checkout-field__label" for="password_2"><?php esc_html_e( 'Neues Passwort wiederholen', 'tanjandi' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
                <input type="password" class="checkout-field__input input-text" name="password_2" id="password_2" autocomplete="new-password" required aria-required="true" />
            </p>
        </div>

        <input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
        <input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

        <?php do_action( 'woocommerce_resetpassword_form' ); ?>

        <div class="account-form__actions">
            <input type="hidden" name="wc_reset_password" value="true" />
            <div class="account-form__submit wp-block-button">
                <button type="submit" class="wp-block-button__link wp-element-button" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>"><?php esc_html_e( 'Passwort speichern', 'tanjandi' ); ?></button>
            </div>
        </div>

        <?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

    </form>

</div>

<?php
do_action( 'woocommerce_after_reset_password_form' );
