<?php
/**
 * Theme functions for "Julia Avramidis"
 * - Theme supports + menu locations
 * - Enqueue CSS + Google Fonts + JS (mobile nav, header helpers)
 */

if ( ! defined('ABSPATH') ) exit;

/* =========================================================
   1) Theme setup (runs once)
   ========================================================= */
add_action('after_setup_theme', function () {

  // ---------------------------------------------------------
  // Document title (<title>) handled by WordPress
  // ---------------------------------------------------------
  add_theme_support('title-tag');

  // ---------------------------------------------------------
  // Featured images (useful for blog + OG sharing)
  // ---------------------------------------------------------
  add_theme_support('post-thumbnails');

  // ---------------------------------------------------------
  // Cleaner HTML output for some core elements
  // ---------------------------------------------------------
  add_theme_support('html5', ['style', 'script']);

  // ---------------------------------------------------------
  // Register menu locations (Appearance → Menus)
  // ---------------------------------------------------------
  register_nav_menus([
    'primary' => __('Primary Menu', 'julia'),
  ]);
});

/* =========================================================
   2) Front-end assets (CSS/JS + Google Fonts)
   ========================================================= */
add_action('wp_enqueue_scripts', function () {

  // ---------------------------------------------------------
  // Cache-busting: when you bump theme version, browsers reload
  // ---------------------------------------------------------
  $ver = wp_get_theme()->get('Version');

  // ---------------------------------------------------------
  // Google Fonts (Playfair / Cormorant / Inter)
  // NOTE: This must live INSIDE the action.
  // ---------------------------------------------------------
 wp_enqueue_style(
  'julia-fonts',
  'https://fonts.googleapis.com/css2?family=Playfair+Display+SC:wght@400;700&family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500;600&display=swap',
  [],
  null
);


  // ---------------------------------------------------------
  // Main stylesheet (style.css)
  // Depends on fonts so typography is correct immediately.
  // ---------------------------------------------------------
  wp_enqueue_style(
    'julia-style',
    get_stylesheet_uri(),
    ['julia-fonts'],
    $ver
  );

  // ---------------------------------------------------------
  // Theme JS
  // File: /assets/js/nav.js
  // (your hamburger script expects #site-header + .nav-toggle + #site-nav)
  // ---------------------------------------------------------
  wp_enqueue_script(
    'julia-nav',
    get_theme_file_uri('/assets/js/nav.js'),
    [],
    $ver,
    true // load in footer
  );
});
// ---------------------------------------------------------
// Custom Logo (Appearance → Customize → Site Identity)
// ---------------------------------------------------------
add_theme_support('custom-logo', [
  'height'      => 80,
  'width'       => 320,
  'flex-height' => true,
  'flex-width'  => true,
]);

