<?php
/**
 * Header template
 * - Sticky header container
 * - Accessible mobile toggle (hamburger)
 * - Primary menu output via wp_nav_menu()
 */
if (!defined('ABSPATH')) exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip link (accessibility): allows keyboard users to jump to content -->
<a class="skip-link sr-only" href="#main">Skip to content</a>

<header class="site-header" id="site-header">
  <div class="container site-header__inner">

<!-- =========================
     Site Branding (Logo / Title)
     ========================= -->
<div class="site-branding">

  <?php if (has_custom_logo()) : ?>
    <!-- If a custom logo is set in Customizer, output it -->
    <?php the_custom_logo(); ?>

  <?php else : ?>
    <!-- Fallback: show site name as text if no logo yet -->
    <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
  <?php endif; ?>

</div>


    <!-- Mobile hamburger button
         JS will toggle:
         - aria-expanded (true/false)
         - .is-open class on #site-nav
    -->
   <button class="nav-toggle"
        type="button"
        aria-controls="site-nav"
        aria-expanded="false">
  <span class="sr-only">Open menu</span>
  <span class="nav-toggle__icon" aria-hidden="true"></span>
</button>


    <!-- Primary navigation -->
    <nav class="site-nav" id="site-nav" aria-label="Primary">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'menu menu--primary',
        'fallback_cb'    => false,
        // 'depth'        => 1, // uncomment if you want ONLY top-level links
      ]);
      ?>
    </nav>

  </div>
</header>
