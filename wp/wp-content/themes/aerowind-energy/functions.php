<?php
/**
 * AeroWind Energy — Theme functions
 *
 * Theme setup, asset enqueues, the "Turbine" custom post type, and the
 * bootstrap for the bundled (Composer) Carbon Fields library.
 *
 * @package AeroWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AEROWIND_VERSION', '1.0.0' );
define( 'AEROWIND_DIR', get_template_directory() );
define( 'AEROWIND_URI', get_template_directory_uri() );

/* ---------------------------------------------------------------------------
 * 1. Bootstrap Carbon Fields (bundled via Composer inside the theme)
 * ------------------------------------------------------------------------- */
if ( file_exists( AEROWIND_DIR . '/vendor/autoload.php' ) ) {
	require_once AEROWIND_DIR . '/vendor/autoload.php';
}

require_once AEROWIND_DIR . '/inc/icons.php';

add_action( 'after_setup_theme', 'aerowind_boot_carbon_fields' );
function aerowind_boot_carbon_fields() {
	if ( class_exists( '\Carbon_Fields\Carbon_Fields' ) ) {
		\Carbon_Fields\Carbon_Fields::boot();
	}
}

/* ---------------------------------------------------------------------------
 * 2. Register the Carbon Fields containers (Home page + Theme Options)
 * ------------------------------------------------------------------------- */
add_action( 'carbon_fields_register_fields', 'aerowind_register_fields' );
function aerowind_register_fields() {
	require_once AEROWIND_DIR . '/inc/carbon-fields.php';
}

/* ---------------------------------------------------------------------------
 * 3. Theme setup
 * ------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'aerowind_setup' );
function aerowind_setup() {
	load_theme_textdomain( 'aerowind', AEROWIND_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'aerowind' ),
		'footer'  => __( 'Footer Menu', 'aerowind' ),
	) );

	// Image size for turbine cards.
	add_image_size( 'aerowind-card', 640, 480, true );
}

/* ---------------------------------------------------------------------------
 * 4. Enqueue styles & scripts
 * ------------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', 'aerowind_assets' );
function aerowind_assets() {
	// Google Fonts.
	wp_enqueue_style(
		'aerowind-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap',
		array(),
		null
	);

	// Main stylesheet (style.css in theme root).
	wp_enqueue_style( 'aerowind-style', get_stylesheet_uri(), array( 'aerowind-fonts' ), AEROWIND_VERSION );

	// Front-end JS (mobile nav).
	wp_enqueue_script( 'aerowind-main', AEROWIND_URI . '/assets/js/main.js', array(), AEROWIND_VERSION, true );
}

/* ---------------------------------------------------------------------------
 * 5. Custom Post Type: Turbine (slug: aerowind_turbine)
 * ------------------------------------------------------------------------- */
add_action( 'init', 'aerowind_register_turbine_cpt' );
function aerowind_register_turbine_cpt() {
	$labels = array(
		'name'               => __( 'Turbines', 'aerowind' ),
		'singular_name'      => __( 'Turbine', 'aerowind' ),
		'menu_name'          => __( 'Turbines', 'aerowind' ),
		'name_admin_bar'     => __( 'Turbine', 'aerowind' ),
		'add_new'            => __( 'Add New', 'aerowind' ),
		'add_new_item'       => __( 'Add New Turbine', 'aerowind' ),
		'new_item'           => __( 'New Turbine', 'aerowind' ),
		'edit_item'          => __( 'Edit Turbine', 'aerowind' ),
		'view_item'          => __( 'View Turbine', 'aerowind' ),
		'all_items'          => __( 'All Turbines', 'aerowind' ),
		'search_items'       => __( 'Search Turbines', 'aerowind' ),
		'not_found'          => __( 'No turbines found.', 'aerowind' ),
		'not_found_in_trash' => __( 'No turbines found in Trash.', 'aerowind' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'turbines', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-image-rotate',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'aerowind_turbine', $args );
}

/* ---------------------------------------------------------------------------
 * 6. Helper: get a Carbon Fields theme-option with fallback
 * ------------------------------------------------------------------------- */
function aerowind_opt( $key, $default = '' ) {
	if ( ! function_exists( 'carbon_get_theme_option' ) ) {
		return $default;
	}
	$val = carbon_get_theme_option( $key );
	return ( '' === $val || null === $val ) ? $default : $val;
}

/**
 * Helper: get a Carbon Fields post meta with fallback.
 */
function aerowind_meta( $post_id, $key, $default = '' ) {
	if ( ! function_exists( 'carbon_get_post_meta' ) ) {
		return $default;
	}
	$val = carbon_get_post_meta( $post_id, $key );
	return ( '' === $val || null === $val ) ? $default : $val;
}

/* ---------------------------------------------------------------------------
 * 7. Deactivate ACF if present (keep a clean Carbon Fields environment)
 * ------------------------------------------------------------------------- */
add_action( 'admin_init', 'aerowind_deactivate_acf' );
function aerowind_deactivate_acf() {
	if ( ! function_exists( 'deactivate_plugins' ) ) {
		return;
	}
	$acf_plugins = array(
		'advanced-custom-fields/acf.php',
		'advanced-custom-fields-pro/acf.php',
	);
	foreach ( $acf_plugins as $plugin ) {
		if ( is_plugin_active( $plugin ) ) {
			deactivate_plugins( $plugin );
		}
	}
}

/* ---------------------------------------------------------------------------
 * 8. Lead form handler (front-page contact form) — simple, no external deps
 * ------------------------------------------------------------------------- */
add_action( 'admin_post_nopriv_aerowind_lead', 'aerowind_handle_lead' );
add_action( 'admin_post_aerowind_lead', 'aerowind_handle_lead' );
function aerowind_handle_lead() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if ( ! isset( $_POST['aerowind_lead_nonce'] ) || ! wp_verify_nonce( $_POST['aerowind_lead_nonce'], 'aerowind_lead' ) ) {
		wp_safe_redirect( add_query_arg( 'lead', 'error', $redirect ) );
		exit;
	}

	$name  = sanitize_text_field( $_POST['aw_name'] ?? '' );
	$email = sanitize_email( $_POST['aw_email'] ?? '' );

	// Store the lead as a private "lead" post so nothing is lost in the demo.
	if ( $name && $email ) {
		wp_insert_post( array(
			'post_type'    => 'aerowind_lead',
			'post_status'  => 'private',
			'post_title'   => $name . ' — ' . $email,
			'post_content' => wp_json_encode( array_map( 'sanitize_text_field', $_POST ) ),
		) );
	}

	wp_safe_redirect( add_query_arg( 'lead', 'success', $redirect ) . '#contact' );
	exit;
}

// Lightweight internal CPT to capture leads (not public).
add_action( 'init', function () {
	register_post_type( 'aerowind_lead', array(
		'label'    => 'Leads',
		'public'   => false,
		'show_ui'  => true,
		'menu_icon'=> 'dashicons-email',
		'supports' => array( 'title', 'editor' ),
	) );
} );

/* ---------------------------------------------------------------------------
 * 9. Fallback primary menu (when no menu is assigned)
 * ------------------------------------------------------------------------- */
function aerowind_default_menu() {
	echo '<ul>';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
	echo '<li><a href="#why">Why Wind</a></li>';
	echo '<li><a href="#turbines">Turbines</a></li>';
	echo '<li><a href="#reviews">Reviews</a></li>';
	echo '<li><a href="#contact">Contact</a></li>';
	echo '</ul>';
}
