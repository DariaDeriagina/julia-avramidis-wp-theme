<?php
/**
 * Theme functions for "Julia Avramidis"
 * - Theme supports + menu locations
 * - Enqueue CSS + Google Fonts + JS (nav + helpers + testimonials)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =========================================================
   1) Theme setup (runs once)
   ========================================================= */
add_action( 'after_setup_theme', 'julia_setup_theme' );

function julia_setup_theme() {

	// Document title (<title>) handled by WordPress
	add_theme_support( 'title-tag' );

	// Featured images (useful for blog + OG sharing)
	add_theme_support( 'post-thumbnails' );

	// Cleaner HTML output for some core elements
	add_theme_support( 'html5', array( 'style', 'script' ) );

	// Custom Logo (Appearance → Customize → Site Identity)
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Register menu locations (Appearance → Menus)
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'julia' ),
		)
	);
}

/* =========================================================
   2) Front-end assets (CSS/JS + Google Fonts)
   ========================================================= */
add_action( 'wp_enqueue_scripts', 'julia_enqueue_assets' );

function julia_enqueue_assets() {

	$ver = wp_get_theme()->get( 'Version' );

	// Google Fonts (Playfair / Cormorant / Inter)
	wp_enqueue_style(
		'julia-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display+SC:wght@400;700&family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	// Main stylesheet (style.css) — depends on fonts so typography loads cleanly
	wp_enqueue_style(
		'julia-style',
		get_stylesheet_uri(),
		array( 'julia-fonts' ),
		$ver
	);

	// Theme JS: nav / header helpers
	wp_enqueue_script(
		'julia-nav',
		get_theme_file_uri( '/assets/js/nav.js' ),
		array(),
		$ver,
		true
	);

	// Theme JS: testimonials slider (dots + prev/next)
	wp_enqueue_script(
		'julia-testimonials',
		get_theme_file_uri( '/assets/js/testimonials.js' ),
		array(),
		$ver,
		true
	);
}
