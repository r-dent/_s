<?php
/**
 * rg_wp_base functions and definitions
 *
 * @package rg_wp_base
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'rg_wp_base_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function rg_wp_base_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on rg_wp_base, use a find and replace
	 * to change 'rg_wp_base' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'rg_wp_base', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'rg_wp_base' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // rg_wp_base_setup
add_action( 'after_setup_theme', 'rg_wp_base_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function rg_wp_base_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'rg_wp_base_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'rg_wp_base_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function rg_wp_base_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'rg_wp_base' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'rg_wp_base_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function rg_wp_base_scripts() {
	wp_enqueue_style( 'rg_wp_base-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
	// wp_enqueue_style( 'rg_wp_base-style', get_template_directory_uri() . '/css/bootstrap-responsive.min.css' );

	wp_enqueue_style( 'rg_wp_base-style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/vendor/jquery-1.9.1.min.js', array(), '1.9.1', true );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '20120206', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array(), '20120206', true );

	wp_enqueue_script( 'rg_wp_base-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'rg_wp_base-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'rg_wp_base-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'rg_wp_base_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );
