<?php
/**
 * Lost password confirmation text
 *
 * Overrides woocommerce/templates/myaccount/lost-password-confirmation.php.
 *
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="account-page__auth">

    <a class="account-page__back" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Zurück zur Anmeldung', 'tanjandi' ); ?></a>

    <p class="account-page__intro"><?php esc_html_e( 'Mein Konto', 'tanjandi' ); ?></p>
    <h1 class="account-page__title account-page__title--small"><?php esc_html_e( 'E-Mail ist unterwegs', 'tanjandi' ); ?></h1>

    <?php do_action( 'woocommerce_before_lost_password_confirmation_message' ); ?>

    <p class="account-page__lead">
        <?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', __( 'Wir haben dir einen Link geschickt, mit dem du ein neues Passwort festlegen kannst. Es kann einige Minuten dauern, bis die E-Mail ankommt. Bitte warte mindestens 10 Minuten, bevor du es noch einmal versuchst.', 'tanjandi' ) ) ); ?>
    </p>

    <?php do_action( 'woocommerce_after_lost_password_confirmation_message' ); ?>

</div>
