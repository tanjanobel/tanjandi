<?php
/**
 * Login form (and registration, if enabled)
 *
 * Overrides woocommerce/templates/myaccount/form-login.php.
 *
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

defined( 'ABSPATH' ) || exit;

$can_register = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );
// After a failed registration the page comes back on the register tab.
$show_register = $can_register && isset( $_POST['register'] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
$account_page  = wc_get_page_id( 'myaccount' );
// Where to go after registering, e.g. back to the checkout. Only addresses
// of this website are accepted. For signing in, WooCommerce adds the same
// field itself (woocommerce_login_form_end).
$redirect_to = isset( $_GET['redirect_to'] ) ? wp_validate_redirect( esc_url_raw( wp_unslash( $_GET['redirect_to'] ) ), '' ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<div class="account-login">

    <div class="account-login__media">
        <?php
        if ( $account_page > 0 && has_post_thumbnail( $account_page ) ) {
            echo get_the_post_thumbnail( $account_page, 'full', array( 'class' => 'account-login__img', 'alt' => '' ) );
        }
        ?>
        <div class="account-login__caption">
            <p class="account-login__caption-title"><?php esc_html_e( 'Willkommen zurück', 'tanjandi' ); ?><span class="account-login__caption-dot">.</span></p>
            <p class="account-login__caption-text"><?php esc_html_e( 'Deine Bestellungen, Adressen und Lieblingsstücke an einem Ort.', 'tanjandi' ); ?></p>
        </div>
    </div>

    <div class="account-login__body" id="customer_login">
        <div class="account-login__inner">

            <?php if ( $can_register ) : ?>
                <?php // The two radio buttons switch between the forms without JavaScript. ?>
                <input class="account-login__switch account-login__switch--login" type="radio" name="account-login-tab" id="account-tab-login" <?php checked( ! $show_register ); ?> />
                <input class="account-login__switch account-login__switch--register" type="radio" name="account-login-tab" id="account-tab-register" <?php checked( $show_register ); ?> />
            <?php endif; ?>

            <p class="account-page__intro"><?php esc_html_e( 'Mein Konto', 'tanjandi' ); ?></p>
            <h1 class="account-page__title account-page__title--small">
                <span class="account-login__title account-login__title--login"><?php esc_html_e( 'Anmelden', 'tanjandi' ); ?></span>
                <?php if ( $can_register ) : ?>
                    <span class="account-login__title account-login__title--register"><?php esc_html_e( 'Registrieren', 'tanjandi' ); ?></span>
                <?php endif; ?>
            </h1>

            <?php do_action( 'woocommerce_before_customer_login_form' ); ?>

            <?php if ( $can_register ) : ?>
                <div class="account-login__tabs">
                    <label class="account-login__tab account-login__tab--login" for="account-tab-login"><?php esc_html_e( 'Anmelden', 'tanjandi' ); ?></label>
                    <label class="account-login__tab account-login__tab--register" for="account-tab-register"><?php esc_html_e( 'Registrieren', 'tanjandi' ); ?></label>
                </div>
            <?php endif; ?>

            <form class="account-login__panel account-login__panel--login account-form account-page__form woocommerce-form woocommerce-form-login login" method="post" novalidate>

                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <div class="account-form__fields">
                    <p class="checkout-field checkout-field--full form-row">
                        <label class="checkout-field__label" for="username"><?php esc_html_e( 'E-Mail-Adresse oder Benutzername', 'tanjandi' ); ?><span class="screen-reader-text"> (<?php esc_html_e( 'Required', 'woocommerce' ); ?>)</span></label>
                        <input type="text" class="checkout-field__input input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized ?>" required aria-required="true" />
                    </p>
                    <p class="checkout-field checkout-field--full form-row">
                        <span class="account-login__label-row">
                            <label class="checkout-field__label" for="password"><?php esc_html_e( 'Passwort', 'tanjandi' ); ?><span class="screen-reader-text"> (<?php esc_html_e( 'Required', 'woocommerce' ); ?>)</span></label>
                            <a class="account-login__lost" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Vergessen?', 'tanjandi' ); ?></a>
                        </span>
                        <input class="checkout-field__input woocommerce-Input input-text" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
                    </p>
                </div>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <label class="account-login__remember" for="rememberme">
                    <input class="account-login__checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                    <span class="account-login__remember-text"><?php esc_html_e( 'Angemeldet bleiben', 'tanjandi' ); ?></span>
                </label>

                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

                <div class="account-login__submit wp-block-button">
                    <button type="submit" class="wp-block-button__link wp-element-button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Anmelden', 'tanjandi' ); ?></button>
                </div>

                <?php do_action( 'woocommerce_login_form_end' ); ?>

            </form>

            <?php if ( $can_register ) : ?>

                <form method="post" class="account-login__panel account-login__panel--register account-form account-page__form woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <div class="account-form__fields">
                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                            <p class="checkout-field checkout-field--full form-row">
                                <label class="checkout-field__label" for="reg_username"><?php esc_html_e( 'Benutzername', 'tanjandi' ); ?><span class="screen-reader-text"> (<?php esc_html_e( 'Required', 'woocommerce' ); ?>)</span></label>
                                <input type="text" class="checkout-field__input input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized ?>" required aria-required="true" />
                            </p>
                        <?php endif; ?>

                        <p class="checkout-field checkout-field--full form-row">
                            <label class="checkout-field__label" for="reg_email"><?php esc_html_e( 'E-Mail-Adresse', 'tanjandi' ); ?><span class="screen-reader-text"> (<?php esc_html_e( 'Required', 'woocommerce' ); ?>)</span></label>
                            <input type="email" class="checkout-field__input input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized ?>" required aria-required="true" />
                        </p>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                            <p class="checkout-field checkout-field--full form-row">
                                <label class="checkout-field__label" for="reg_password"><?php esc_html_e( 'Passwort', 'tanjandi' ); ?><span class="screen-reader-text"> (<?php esc_html_e( 'Required', 'woocommerce' ); ?>)</span></label>
                                <input type="password" class="checkout-field__input woocommerce-Input input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php if ( 'no' !== get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <p class="account-login__hint"><?php esc_html_e( 'Du erhältst eine E-Mail mit einem Link, über den du dein Passwort festlegst.', 'tanjandi' ); ?></p>
                    <?php endif; ?>

                    <?php do_action( 'woocommerce_register_form' ); ?>

                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

                    <?php if ( $redirect_to ) : ?>
                        <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect_to ); ?>" />
                    <?php endif; ?>

                    <div class="account-login__submit wp-block-button">
                        <button type="submit" class="wp-block-button__link wp-element-button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Registrieren', 'tanjandi' ); ?></button>
                    </div>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>

            <?php endif; ?>

            <div class="account-login__guest">
                <p class="account-login__guest-text"><?php esc_html_e( 'Du kannst auch ohne Konto bestellen.', 'tanjandi' ); ?></p>
                <a class="account-login__guest-link" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Weiter zum Shop', 'tanjandi' ); ?></a>
            </div>

        </div>
    </div>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
