<?php
/**
 * Gutenberg specific settings and configurations.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Includes
 * Load Gutenberg feature modules early (so they can attach hooks in time).
 */
require_once get_template_directory() . '/inc/gutenberg-button-compact.php';

/**
 * Gutenberg setup
 * Keep this for Gutenberg-wide settings if needed.
 */
function wp_starter_gutenberg_settings() {
    // Add custom font sizes, colors, etc. here if needed.
    $block_path = get_template_directory() . '/blocks/project-card';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/employee-card';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/subheader';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/project-services';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/hero';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/icon-link';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

    $block_path = get_template_directory() . '/blocks/image-box';
    if ( file_exists( $block_path . '/block.json' ) ) {
        register_block_type( $block_path );
    }

}
add_action( 'init', 'wp_starter_gutenberg_settings' );
