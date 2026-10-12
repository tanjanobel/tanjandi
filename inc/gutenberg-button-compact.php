<?php
/**
 * Gutenberg: Compact button style + ARIA label support.
 *
 * - Adds a "Kompakt" style to core/button.
 * - Adds aria-label for compact buttons:
 *   1) Uses custom attribute (tanjandiAriaLabel) if provided in editor
 *   2) Falls back to button text
 *   3) Falls back to "Mehr erfahren"
 * - Wraps link text in a visually-hidden span for compact style (so the icon-only UI stays accessible).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the "compact" style for the core/button block.
 */
function tanjandi_register_compact_button_style() {
    register_block_style(
        'core/button',
        array(
            'label' => __( 'Kompakt', 'tanjandi' ),
            'name'  => 'compact',
        )
    );

    register_block_style(
        'core/button',
        array(
            'label' => __( 'Outline Weiss', 'tanjandi' ),
            'name'  => 'outline-white',
        )
    );

    register_block_style(
        'core/button',
        array(
            'label' => __( 'Outline Primary', 'tanjandi' ),
            'name'  => 'outline-primary',
        )
    );

    register_block_style(
        'core/button',
        array(
            'label' => __( 'Outline Weiss Kompakt', 'tanjandi' ),
            'name'  => 'outline-white-compact',
        )
    );
}
add_action( 'after_setup_theme', 'tanjandi_register_compact_button_style' );

/**
 * Enqueue editor script that adds an "ARIA label" field to the button block.
 */
function tanjandi_enqueue_compact_button_editor_assets() {
    $handle    = 'tanjandi-button-compact-editor';
    $src       = get_template_directory_uri() . '/assets/js/editor/button-compact.js';
    $deps      = array( 'wp-blocks', 'wp-compose', 'wp-data', 'wp-element', 'wp-hooks', 'wp-components', 'wp-block-editor' );
    $ver       = file_exists( get_template_directory() . '/assets/js/editor/button-compact.js' ) ? filemtime( get_template_directory() . '/assets/js/editor/button-compact.js' ) : false;

    wp_enqueue_script( $handle, $src, $deps, $ver, true );
}
add_action( 'enqueue_block_editor_assets', 'tanjandi_enqueue_compact_button_editor_assets' );

/**
 * Render filter for the core/button block.
 * Ensures buttons have their text wrapped in a span for better layering (z-index) on iOS.
 * Also ensures compact buttons have an accessible name and keep text for screen readers while being icon-only visually.
 */
function tanjandi_render_button_enhancements( $block_content, $block ) {
    if ( empty( $block['blockName'] ) || 'core/button' !== $block['blockName'] ) {
        return $block_content;
    }

    $is_compact = ( strpos( $block_content, 'is-style-compact' ) !== false || strpos( $block_content, 'is-style-outline-white-compact' ) !== false );

    // Extract visible text (as entered in editor).
    $button_text = '';
    if ( preg_match( '/<a\b[^>]*>(.*?)<\/a>/s', $block_content, $matches ) ) {
        $button_text = trim( wp_strip_all_tags( $matches[1] ) );
    }

    // 1) Handle ARIA label and accessible name for compact buttons.
    $custom_aria = '';
    if ( ! empty( $block['attrs']['tanjandiAriaLabel'] ) ) {
        $custom_aria = trim( (string) $block['attrs']['tanjandiAriaLabel'] );
    }

    // Determine final aria-label.
    $aria_label = $custom_aria !== '' ? $custom_aria : ( $button_text !== '' ? $button_text : __( 'Mehr erfahren', 'tanjandi' ) );

    // Ensure aria-label exists on the <a> for compact buttons.
    if ( $is_compact ) {
        if ( class_exists( 'WP_HTML_Tag_Processor' ) ) {
            $processor = new WP_HTML_Tag_Processor( $block_content );
            if ( $processor->next_tag( array( 'tag_name' => 'a' ) ) ) {
                $processor->set_attribute( 'aria-label', $aria_label );
                $block_content = $processor->get_updated_html();
            }
        } else {
            if ( strpos( $block_content, 'aria-label=' ) === false ) {
                $block_content = preg_replace(
                    '/<a\b/',
                    '<a aria-label="' . esc_attr( $aria_label ) . '"',
                    $block_content,
                    1
                );
            }
        }

        // Replace anchor inner HTML with visually hidden text for compact style.
        $hidden_inner = '<span class="visually-hidden">' . esc_html( $aria_label ) . '</span>';
        $block_content = preg_replace(
            '/(<a\b[^>]*>)(.*?)(<\/a>)/s',
            '$1' . $hidden_inner . '$3',
            $block_content,
            1
        );
    } else {
        // Wrap normal button text in a span for layering (z-index)
        $block_content = preg_replace(
            '/(<a\b[^>]*>)(.*?)(<\/a>)/s',
            '$1<span class="wp-block-button__label">$2</span>$3',
            $block_content,
            1
        );
    }

    return $block_content;
}
add_filter( 'render_block_core/button', 'tanjandi_render_button_enhancements', 10, 2 );
