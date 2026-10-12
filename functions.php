<?php
/**
 * WP Starter Theme functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup Theme
 */
function wp_starter_setup() {
	// Internationalization
	load_theme_textdomain( 'tanjandi', get_template_directory() . '/languages' );

	// Theme Support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Gutenberg Support
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
    add_editor_style( 'style-editor.css' );

    // Block Theme Hinweis: Navigation erfolgt über den Navigations-Block, keine klassischen Menüs notwendig.
}
add_action( 'after_setup_theme', 'wp_starter_setup' );

/**
 * Enqueue scripts and styles
 */
function wp_starter_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// CSS
	wp_enqueue_style( 'tanjandi-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ) );

	// JS
	wp_enqueue_script( 'tanjandi-app', get_template_directory_uri() . '/app.js', array('jquery'), filemtime( get_template_directory() . '/app.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'wp_starter_scripts' );

/**
 * Include separate logic files
 */
require get_template_directory() . '/inc/gutenberg.php';
require get_template_directory() . '/inc/woocommerce.php';


/**
 * Disable Lazy Blocks Frontend Wrapper
 */
add_filter( 'lazyblock/accordion-container/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/accordion-item/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/button/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/card/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/container/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/fact/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/hero/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/icon/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/lead/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/list-container/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/list-item/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/next-project-link/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/overview-project-link/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/previous-project-link/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/project-card/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/testimonials-carousel/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/section/frontend_allow_wrapper', '__return_false' );
add_filter( 'lazyblock/spacer/frontend_allow_wrapper', '__return_false' );

/**
 * Disable Lazy Blocks <InnerBlocks /> Wrapper
 */
add_filter( 'lazyblock/accordion-container/allow_inner_blocks_wrapper', '__return_false' );


/**
 * Wrap post navigation link labels in a span
 */
add_filter( 'render_block_core/post-navigation-link', function( $block_content, $block ) {
	if ( empty( $block_content ) ) {
		return $block_content;
	}

	// Regex to find the <a> tag and wrap its inner text in a <span> if it's not already wrapped
	// Matches: <a ...>Inner Text</a>
	$pattern = '/(<a[^>]*>)(.*?)(<\/a>)/is';

	if ( preg_match( $pattern, $block_content ) ) {
		$block_content = preg_replace_callback( $pattern, function( $matches ) {
			$inner_html = trim( $matches[2] );

			// If the inner content doesn't already start with a span, wrap it
			if ( ! empty( $inner_html ) && strpos( $inner_html, '<span' ) !== 0 ) {
				return $matches[1] . '<span>' . $inner_html . '</span>' . $matches[3];
			}
			return $matches[0];
		}, $block_content );
	}

	return $block_content;
}, 10, 2 );

/**
 * Hide the decorative step numbers ("01", "02", "03" in "Was wir tun" and
 * on the Dienstleistungen process steps) from assistive tech - the order
 * is already conveyed by the heading order, so the numbers carry no
 * information a screen reader user would be missing.
 */
add_filter( 'render_block_core/paragraph', function( $block_content, $block ) {
	$class_name = $block['attrs']['className'] ?? '';

	if ( ! preg_match( '/(^|\s)(service__number|step__number)(\s|$)/', $class_name ) ) {
		return $block_content;
	}

	if ( strpos( $block_content, 'aria-hidden' ) !== false ) {
		return $block_content;
	}

	return preg_replace( '/<p /', '<p aria-hidden="true" ', $block_content, 1 );
}, 10, 2 );

/**
 * Disable Contact Form 7 automatic paragraph tags
 */
add_filter('wpcf7_autop_or_not', '__return_false');


/**
 * Adjust Yoast Breadcrumbs for single references
 */
add_filter( 'wpseo_breadcrumb_links', function( $links ) {
    if ( is_singular( 'reference' ) ) {
        $breadcrumb[] = array(
            'url'  => home_url( '/referenzen/' ),
            'text' => 'Referenzen',
        );

        array_splice( $links, 0, 0, $breadcrumb );
    }

    return $links;
});

/**
 * Disable single pages for specific CPTs (return 404).
 */
add_action('template_redirect', function () {
    $disabled_singles = ['sale', 'employee'];

    if (is_singular($disabled_singles)) {
        global $wp_query;

        $wp_query->set_404();
        status_header(404);
        nocache_headers();

        // Load the theme's 404 template.
        include get_404_template();
        exit;
    }
});

/**
 * Force 'project-single' template for 'reference' CPT
 */
add_filter( 'template_include', function( $template ) {
    if ( is_singular( 'reference' ) ) {
        $project_template = locate_block_template( get_stylesheet_directory() . '/templates/project-single.html', 'project-single', [] );
        if ( $project_template ) {
            return $project_template;
        }
    }
    return $template;
}, 99 );
