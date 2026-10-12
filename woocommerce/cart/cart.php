<?php
/**
 * Cart Page
 *
 * Overrides woocommerce/templates/cart/cart.php.
 *
 * @package WooCommerce\Templates
 * @version 11.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="cart-page__columns">
    <form class="woocommerce-cart-form cart-page__items" id="cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <?php // woocommerce-cart-form__contents: WooCommerce's cart script only updates without a page reload when it finds this class. ?>
        <ul class="cart-page__list woocommerce-cart-form__contents">
            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

            <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    continue;
                }

                $product_name      = apply_filters( 'woocommerce_cart_item_name', get_the_title( $product_id ), $cart_item, $cart_item_key );
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_single', array( 'class' => 'cart-item__img' ) ), $cart_item, $cart_item_key );
                $item_meta         = tanjandi_cart_item_meta( $cart_item );
                $max_quantity      = $_product->is_sold_individually() ? 1 : $_product->get_max_purchase_quantity();
                $input_id          = 'quantity-' . $cart_item_key;
                ?>
                <li class="cart-item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <?php if ( $product_permalink ) : ?>
                        <a class="cart-item__image" href="<?php echo esc_url( $product_permalink ); ?>" tabindex="-1" aria-hidden="true"><?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                    <?php else : ?>
                        <span class="cart-item__image"><?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <?php endif; ?>

                    <div class="cart-item__body">
                        <div class="cart-item__info">
                            <h2 class="cart-item__name">
                                <?php if ( $product_permalink ) : ?>
                                    <a class="cart-item__link" href="<?php echo esc_url( $product_permalink ); ?>"><?php echo wp_kses_post( $product_name ); ?></a>
                                <?php else : ?>
                                    <?php echo wp_kses_post( $product_name ); ?>
                                <?php endif; ?>
                            </h2>

                            <?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>

                            <?php if ( $item_meta ) : ?>
                                <p class="cart-item__meta"><?php echo esc_html( $item_meta ); ?></p>
                            <?php endif; ?>

                            <p class="cart-item__unit-price">
                                <?php
                                /* translators: %s: price of one piece. */
                                echo wp_kses_post( sprintf( __( '%s / Stück', 'tanjandi' ), apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) ) );
                                ?>
                            </p>
                        </div>

                        <p class="cart-item__total">
                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </p>

                        <div class="cart-item__quantity quantity">
                            <button type="button" class="cart-item__quantity-button cart-item__quantity-button--minus" data-step="-1" aria-label="<?php esc_attr_e( 'Menge verringern', 'tanjandi' ); ?>"></button>
                            <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>">
                                <?php
                                /* translators: %s: product name. */
                                echo esc_html( sprintf( __( 'Menge für %s', 'tanjandi' ), wp_strip_all_tags( $product_name ) ) );
                                ?>
                            </label>
                            <input
                                type="number"
                                id="<?php echo esc_attr( $input_id ); ?>"
                                class="cart-item__quantity-input qty"
                                name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
                                value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
                                min="1"
                                <?php echo $max_quantity > 0 ? 'max="' . esc_attr( $max_quantity ) . '"' : ''; ?>
                                step="1"
                                inputmode="numeric"
                                autocomplete="off"
                            />
                            <button type="button" class="cart-item__quantity-button cart-item__quantity-button--plus" data-step="1" aria-label="<?php esc_attr_e( 'Menge erhöhen', 'tanjandi' ); ?>"></button>
                        </div>

                        <a
                            class="cart-item__remove"
                            href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"
                            aria-label="<?php /* translators: %s: product name. */ echo esc_attr( sprintf( __( '%s aus dem Warenkorb entfernen', 'tanjandi' ), wp_strip_all_tags( $product_name ) ) ); ?>"
                        ><?php esc_html_e( 'Entfernen', 'tanjandi' ); ?></a>
                    </div>
                </li>
                <?php
            }
            ?>

            <?php do_action( 'woocommerce_cart_contents' ); ?>
        </ul>

        <button type="submit" class="cart-page__update" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

        <?php do_action( 'woocommerce_cart_actions' ); ?>
        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
        <?php do_action( 'woocommerce_after_cart_contents' ); ?>

        <p class="cart-page__note"><?php esc_html_e( 'Jedes Objekt wird für dich gedruckt. Produktion und Versand dauern 3–5 Werktage.', 'tanjandi' ); ?></p>

        <?php do_action( 'woocommerce_after_cart_table' ); ?>
    </form>

    <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

    <div class="cart-page__sidebar">
        <?php do_action( 'woocommerce_cart_collaterals' ); ?>
    </div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
