<?php
/**
 * Edit account form
 *
 * Overrides woocommerce/templates/myaccount/form-edit-account.php.
 *
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
?>

<form class="account-form account-page__form woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>

    <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

    <div class="account-form__fields">
        <p class="checkout-field checkout-field--half form-row">
            <label class="checkout-field__label" for="account_first_name"><?php esc_html_e( 'Vorname', 'tanjandi' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="checkout-field__input input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" aria-required="true" />
        </p>
        <p class="checkout-field checkout-field--half form-row">
            <label class="checkout-field__label" for="account_last_name"><?php esc_html_e( 'Nachname', 'tanjandi' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="checkout-field__input input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" aria-required="true" />
        </p>
        <p class="checkout-field checkout-field--full form-row">
            <label class="checkout-field__label" for="account_display_name"><?php esc_html_e( 'Anzeigename', 'tanjandi' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="checkout-field__input input-text" name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="<?php echo esc_attr( $user->display_name ); ?>" aria-required="true" />
            <span class="checkout-field__hint" id="account_display_name_description">
                <?php echo esc_html( wc_reviews_enabled() ? __( 'So wird dein Name in deinem Konto und bei Bewertungen angezeigt.', 'tanjandi' ) : __( 'So wird dein Name in deinem Konto angezeigt.', 'tanjandi' ) ); ?>
            </span>
        </p>
        <p class="checkout-field checkout-field--full form-row">
            <label class="checkout-field__label" for="account_email"><?php esc_html_e( 'E-Mail-Adresse', 'tanjandi' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="email" class="checkout-field__input input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" aria-required="true" />
        </p>

        <?php do_action( 'woocommerce_edit_account_form_fields' ); ?>
    </div>

    <fieldset class="account-form__section">
        <legend class="account-form__heading"><?php esc_html_e( 'Passwort ändern', 'tanjandi' ); ?></legend>

        <div class="account-form__fields">
            <p class="checkout-field checkout-field--full form-row">
                <label class="checkout-field__label" for="password_current"><?php esc_html_e( 'Aktuelles Passwort (leer lassen für keine Änderung)', 'tanjandi' ); ?></label>
                <input type="password" class="checkout-field__input input-text" name="password_current" id="password_current" autocomplete="current-password" />
            </p>
            <p class="checkout-field checkout-field--full form-row">
                <label class="checkout-field__label" for="password_1"><?php esc_html_e( 'Neues Passwort (leer lassen für keine Änderung)', 'tanjandi' ); ?></label>
                <input type="password" class="checkout-field__input input-text" name="password_1" id="password_1" autocomplete="new-password" />
            </p>
            <p class="checkout-field checkout-field--full form-row">
                <label class="checkout-field__label" for="password_2"><?php esc_html_e( 'Neues Passwort bestätigen', 'tanjandi' ); ?></label>
                <input type="password" class="checkout-field__input input-text" name="password_2" id="password_2" autocomplete="new-password" />
            </p>
        </div>
    </fieldset>

    <?php do_action( 'woocommerce_edit_account_form' ); ?>

    <div class="account-form__actions">
        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
        <div class="account-form__submit wp-block-button">
            <button type="submit" class="wp-block-button__link wp-element-button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Änderungen speichern', 'tanjandi' ); ?></button>
        </div>
        <input type="hidden" name="action" value="save_account_details" />
    </div>

    <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
