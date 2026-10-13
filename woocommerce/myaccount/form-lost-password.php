<?php
/**
 * Lost password form
 *
 * Overrides woocommerce/templates/myaccount/form-lost-password.php.
 *
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="account-page__auth">

    <a class="account-page__back" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Zurück zur Anmeldung', 'tanjandi' ); ?></a>

    <p class="account-page__intro"><?php esc_html_e( 'Mein Konto', 'tanjandi' ); ?></p>
    <h1 class="account-page__title account-page__title--small"><?php esc_html_e( 'Passwort vergessen?', 'tanjandi' ); ?></h1>

    <p class="account-page__lead">
        <?php echo wp_kses_post( apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Gib deinen Benutzernamen oder deine E-Mail-Adresse ein. Du erhältst einen Link, mit dem du ein neues Passwort festlegen kannst.', 'tanjandi' ) ) ); ?>
    </p>

    <form method="post" class="account-form account-page__form woocommerce-ResetPassword lost_reset_password">

        <div class="account-form__fields">
            <p class="checkout-field checkout-field--full form-row">
                <label class="checkout-field__label" for="user_login"><?php esc_html_e( 'Benutzername oder E-Mail-Adresse', 'tanjandi' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
                <input class="checkout-field__input input-text" type="text" name="user_login" id="user_login" autocomplete="username" required aria-required="true" />
            </p>
        </div>

        <?php do_action( 'woocommerce_lostpassword_form' ); ?>

        <div class="account-form__actions">
            <input type="hidden" name="wc_reset_password" value="true" />
            <div class="account-form__submit wp-block-button">
                <button type="submit" class="wp-block-button__link wp-element-button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Passwort zurücksetzen', 'tanjandi' ); ?></button>
            </div>
        </div>

        <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

    </form>

</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
