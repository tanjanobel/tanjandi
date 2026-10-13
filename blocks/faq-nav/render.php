<?php
/**
 * FAQ Navigation Block Template.
 * Lists the FAQ groups of the current page: every group block with the
 * class faq__group and an HTML anchor, named after its first heading.
 */

$post_id = ! empty( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
$source  = $post_id ? get_post( $post_id ) : null;

if ( ! $source ) {
    return;
}

$groups = array();
$walk   = function ( $blocks ) use ( &$walk, &$groups ) {
    foreach ( $blocks as $item ) {
        $class  = isset( $item['attrs']['className'] ) ? $item['attrs']['className'] : '';
        $anchor = isset( $item['attrs']['anchor'] ) ? $item['attrs']['anchor'] : '';

        if ( 'core/group' === $item['blockName'] && $anchor && in_array( 'faq__group', explode( ' ', $class ), true ) ) {
            foreach ( $item['innerBlocks'] as $inner ) {
                if ( 'core/heading' === $inner['blockName'] ) {
                    $groups[ $anchor ] = trim( wp_strip_all_tags( $inner['innerHTML'] ) );
                    break;
                }
            }

            continue;
        }

        if ( ! empty( $item['innerBlocks'] ) ) {
            $walk( $item['innerBlocks'] );
        }
    }
};
$walk( parse_blocks( $source->post_content ) );

if ( ! $groups ) {
    return;
}

$first = true;
?>
<nav class="side-nav" aria-label="<?php esc_attr_e( 'Themen', 'tanjandi' ); ?>" data-faq-nav>
    <ul class="side-nav__list">
        <?php foreach ( $groups as $anchor => $label ) : ?>
            <li class="side-nav__item">
                <a class="side-nav__link<?php echo $first ? ' side-nav__link--current' : ''; ?>" href="#<?php echo esc_attr( $anchor ); ?>" <?php echo $first ? 'aria-current="true"' : ''; ?>><?php echo esc_html( html_entity_decode( $label, ENT_QUOTES, 'UTF-8' ) ); ?></a>
            </li>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </ul>
</nav>
