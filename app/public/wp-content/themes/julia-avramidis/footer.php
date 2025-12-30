<?php
/**
 * Footer
 * Theme: Julia Avramidis
 * Author: DashDev Studio
 */

/* =========================================================
   Page context
========================================================= */
$page_id = (int) get_option('page_on_front');
if (!$page_id) {
  $page_id = get_queried_object_id();
}

/* =========================================================
   FOOTER LOGOS (ACF Image IDs)
========================================================= */
$logo_desktop_id = function_exists('get_field')
  ? (int) get_field('footer_logo_desktop', $page_id)
  : 0;

$logo_mobile_id = function_exists('get_field')
  ? (int) get_field('footer_logo_mobile', $page_id)
  : 0;

/* =========================================================
   FOOTER NAV LINKS (ACF Free – individual Link fields)
========================================================= */
$menu_links = [];

if (function_exists('get_field')) {
  $menu_keys = [
    'footer_menu_home',
    'footer_menu_about',
    'footer_menu_services',
    'footer_menu_blog',
    'footer_menu_contact',
  ];

  foreach ($menu_keys as $key) {
    $link = get_field($key, $page_id);
    if (is_array($link) && !empty($link['url'])) {
      $menu_links[] = $link;
    }
  }
}

/* =========================================================
   SOCIAL LINKS (ACF Group)
========================================================= */
$socials = function_exists('get_field')
  ? (get_field('footer_socials', $page_id) ?: [])
  : [];

/* =========================================================
   COPYRIGHT + PRIVACY
========================================================= */
$copyright =
  function_exists('get_field')
    ? get_field('footer_copyright', $page_id)
    : '';

if (!$copyright) {
  $copyright = '© ' . date('Y') . ' Julia Avramidis. All rights reserved.';
}

$privacy_url = get_privacy_policy_url();
?>

<footer class="site-footer" role="contentinfo">

  <!-- =========================
       FOOTER MAIN
       ========================= -->
  <div class="footer-inner">

    <!-- BRAND / LOGO -->
    <div class="footer-brand">

      <?php if ($logo_desktop_id) : ?>
        <div class="footer-logo footer-logo--desktop">
          <?php echo wp_get_attachment_image(
            $logo_desktop_id,
            'large',
            false,
            [
              'class'    => 'footer-logo__img',
              'alt'      => 'Julia Avramidis',
              'loading'  => 'lazy',
              'decoding' => 'async',
            ]
          ); ?>
        </div>
      <?php endif; ?>

      <?php if ($logo_mobile_id) : ?>
        <div class="footer-logo footer-logo--mobile">
          <?php echo wp_get_attachment_image(
            $logo_mobile_id,
            'medium',
            false,
            [
              'class'    => 'footer-logo__img',
              'alt'      => 'Julia Avramidis',
              'loading'  => 'lazy',
              'decoding' => 'async',
            ]
          ); ?>
        </div>
      <?php endif; ?>

    </div>

    <!-- FOOTER NAV -->
    <?php if (!empty($menu_links)) : ?>
      <nav class="footer-nav" aria-label="Footer navigation">
        <ul class="footer-nav__list">
          <?php foreach ($menu_links as $link) : ?>
            <li class="footer-nav__item">
              <a
                href="<?php echo esc_url($link['url']); ?>"
                target="<?php echo esc_attr($link['target'] ?? '_self'); ?>"
                <?php echo (!empty($link['target']) && $link['target'] === '_blank') ? 'rel="noopener noreferrer"' : ''; ?>
              >
                <?php echo esc_html(strtoupper($link['title'])); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </nav>
    <?php endif; ?>

    <!-- SOCIAL LINKS -->
    <div class="footer-socials" aria-label="Social links">
      <?php foreach (['instagram', 'tiktok', 'facebook'] as $key) : ?>
        <?php if (!empty($socials[$key]['url'])) : ?>
          <a
            class="footer-social footer-social--<?php echo esc_attr($key); ?>"
            href="<?php echo esc_url($socials[$key]['url']); ?>"
            target="_blank"
            rel="noopener noreferrer"
          >
            <?php echo esc_html(strtoupper($key)); ?>
          </a>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

  </div>

  <!-- =========================
       FOOTER BOTTOM
       ========================= -->
  <div class="footer-bottom">

    <p class="footer-copy">
      <?php echo esc_html($copyright); ?>

      <?php if ($privacy_url) : ?>
        · <a href="<?php echo esc_url($privacy_url); ?>">
          Privacy Policy
        </a>
      <?php endif; ?>
    </p>

    <p class="footer-credit">
      Designed &amp; Developed by
      <a href="https://dash-dev.net" target="_blank" rel="noopener noreferrer">
        DashDev Studio
      </a>
    </p>

  </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
