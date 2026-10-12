<?php
/**
 * Product Card Actions Block Template.
 * Last row of a product card: the available colours and a link that adds
 * the product to the cart. For a product with colours the link adds the
 * default colour.
 */

$product = ( function_exists( 'wc_get_product' ) && ! empty( $block->context['postId'] ) ) ? wc_get_product( $block->context['postId'] ) : null;

if ( ! $product ) {
    return;
}

$colors    = $product->is_type( 'variable' ) ? wc_get_product_terms( $product->get_id(), 'pa_farbe', array( 'fields' => 'all' ) ) : array();
$add_id    = 0;
$add_color = '';

if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) {
    $add_id = $product->get_id();
} elseif ( $product->is_type( 'variable' ) ) {
    $defaults = array();

    foreach ( $product->get_default_attributes() as $name => $value ) {
        $defaults[ 'attribute_' . $name ] = $value;
    }

    $variation_id = $defaults ? ( new WC_Product_Data_Store_CPT() )->find_matching_product_variation( $product, $defaults ) : 0;
    $variation    = $variation_id ? wc_get_product( $variation_id ) : null;

    if ( $variation && $variation->is_purchasable() && $variation->is_in_stock() ) {
        $add_id = $variation_id;

        foreach ( $colors as $color ) {
            if ( $color->slug === $variation->get_attribute( 'pa_farbe' ) || $color->name === $variation->get_attribute( 'pa_farbe' ) ) {
                $add_color = $color->name;
            }
        }
    }
}
?>
<div class="product-card__actions">
    <?php if ( $colors ) : ?>
        <ul class="product-card__swatches" aria-label="<?php esc_attr_e( 'Farben', 'tanjandi' ); ?>">
            <?php foreach ( $colors as $color ) : ?>
                <li class="product-card__swatch product-card__swatch--<?php echo esc_attr( $color->slug ); ?>">
                    <span class="screen-reader-text"><?php echo esc_html( $color->name ); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ( $add_id ) : ?>
        <?php
        /* translators: 1: product name 2: colour. */
        $label = $add_color ? sprintf( __( '%1$s in %2$s in den Warenkorb', 'tanjandi' ), $product->get_name(), $add_color ) : sprintf( __( '%s in den Warenkorb', 'tanjandi' ), $product->get_name() );
        ?>
        <a class="product-card__add add_to_cart_button ajax_add_to_cart" href="<?php echo esc_url( add_query_arg( 'add-to-cart', $add_id, wc_get_page_permalink( 'shop' ) ) ); ?>" data-product_id="<?php echo esc_attr( $add_id ); ?>" data-quantity="1" aria-label="<?php echo esc_attr( $label ); ?>" rel="nofollow"><?php esc_html_e( 'In den Warenkorb', 'tanjandi' ); ?></a>
    <?php else : ?>
        <a class="product-card__add" href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php esc_html_e( 'Ansehen', 'tanjandi' ); ?></a>
    <?php endif; ?>
</div>
