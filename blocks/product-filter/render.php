<?php
/**
 * Product Filter Block Template.
 * Pills on top of the shop: all products plus one per product category,
 * shown once there are at least two categories with products.
 */

if ( ! function_exists( 'wc_get_page_permalink' ) ) {
    return;
}

$categories = get_terms(
    array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => 0,
        'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
    )
);

// With a single category the pills would only repeat "all products".
if ( is_wp_error( $categories ) || count( $categories ) < 2 ) {
    return;
}

$current = is_tax( 'product_cat' ) ? get_queried_object_id() : 0;
?>
<nav class="product-filter" aria-label="<?php esc_attr_e( 'Kategorien', 'tanjandi' ); ?>">
    <ul class="product-filter__list">
        <li class="product-filter__item">
            <a class="product-filter__link<?php echo $current ? '' : ' product-filter__link--current'; ?>" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" <?php echo $current ? '' : 'aria-current="page"'; ?>><?php esc_html_e( 'Alle', 'tanjandi' ); ?></a>
        </li>
        <?php foreach ( $categories as $category ) : ?>
            <?php $is_current = $current === $category->term_id; ?>
            <li class="product-filter__item">
                <a class="product-filter__link<?php echo $is_current ? ' product-filter__link--current' : ''; ?>" href="<?php echo esc_url( get_term_link( $category ) ); ?>" <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo esc_html( $category->name ); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
