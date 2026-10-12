<?php
/**
 * Product Teaser Block Template.
 * Box below a news post with the product the post is about. The product is
 * chosen in the field "Produkt im Shop"; without one the box is left out.
 */

$post_id    = ! empty( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
$product_id = function_exists( 'get_field' ) ? (int) get_field( 'news_product', $post_id, false ) : 0;
$product    = ( $product_id && function_exists( 'wc_get_product' ) ) ? wc_get_product( $product_id ) : null;

if ( ! $product || 'publish' !== $product->get_status() ) {
    return;
}
?>
<aside class="product-teaser">
    <a class="product-teaser__media" href="<?php echo esc_url( $product->get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
        <?php echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'product-teaser__img', 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </a>

    <div class="product-teaser__body">
        <p class="product-teaser__label"><?php esc_html_e( 'Im Shop', 'tanjandi' ); ?></p>
        <h2 class="product-teaser__name"><?php echo esc_html( $product->get_name() ); ?></h2>
        <p class="product-teaser__price"><?php echo esc_html( tanjandi_price_text( wc_get_price_to_display( $product ) ) ); ?></p>
    </div>

    <div class="product-teaser__action wp-block-button">
        <?php /* translators: %s: product name. */ ?>
        <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $product->get_permalink() ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%s ansehen', 'tanjandi' ), $product->get_name() ) ); ?>"><?php esc_html_e( 'Ansehen', 'tanjandi' ); ?></a>
    </div>
</aside>
