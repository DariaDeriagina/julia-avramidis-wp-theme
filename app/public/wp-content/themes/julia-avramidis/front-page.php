<?php
/**
 * Front Page template
 * Theme: Julia Avramidis
 *
 * Layout = code (Figma-driven)
 * Content = ACF fields (client-safe for Julia)
 */

get_header();

/* =========================================================
   0) Page context
   - Ensures get_field() reads fields from the correct page
   ========================================================= */
$page_id = get_queried_object_id();

/* =========================================================
   1) HERO defaults (fallbacks keep layout stable)
   ========================================================= */
$hero_headline   = 'Where Scenes Find Their Voice';
$hero_subtitle   = 'Crafting scripts that linger long after the final frame.';
$hero_btn_label  = 'Explore Services';
$hero_btn_url    = '#services';
$hero_btn_target = '_self';
$hero_image_id   = 0;

/* =========================================================
   2) HERO ACF fields (only if ACF is active)
   ========================================================= */
if (function_exists('get_field')) {

  // -----------------------------
  // Text fields
  // -----------------------------
  $hero_headline  = get_field('hero_headline', $page_id) ?: $hero_headline;
  $hero_subtitle  = get_field('hero_subtitle', $page_id) ?: $hero_subtitle;
  $hero_btn_label = get_field('hero_button_label', $page_id) ?: $hero_btn_label;

  // -----------------------------
  // Link field (ACF "Link" array: url/title/target)
  // Return Format: Link Array (recommended)
  // -----------------------------
  $link = get_field('hero_button_link', $page_id);

  if (is_array($link) && !empty($link['url'])) {
    $hero_btn_url = $link['url'];

    // Allow ACF target if set; otherwise default to _self
    $hero_btn_target = !empty($link['target']) ? $link['target'] : $hero_btn_target;
  }

  // -----------------------------
  // Image field (ACF Image)
  // Return Format: Image ID (recommended)
  // -----------------------------
  $hero_image_id = (int) get_field('hero_image', $page_id);
}
?>

<main class="site-main" id="main">

  <!-- =========================================================
       HERO (ACF-driven)
       ========================================================= -->
  <section id="hero" class="hero" aria-label="Hero">
    <div class="container hero__grid">

      <!-- =========================
           Hero content (left)
           ========================= -->
      <div class="hero__content">

        <!-- H1 (ACF: hero_headline) -->
        <?php
/**
 * Force a consistent 2-line headline:
 * Line 1: "Where Scenes"
 * Line 2: "Find Their Voice"
 *
 * Works even if Julia edits the headline in ACF.
 */
$headline_safe = trim($hero_headline);

// Replace the first " Find " with a line break
$headline_with_break = preg_replace('/\s+Find\s+/i', '<br>Find ', $headline_safe, 1);
?>

<h1 class="hero__title"><?php echo wp_kses_post($headline_with_break); ?></h1>


        <!-- Subtitle (ACF: hero_subtitle)
             - wpautop(): nice paragraphs if Julia adds line breaks
             - wp_kses_post(): safe HTML output if WP adds <br> / <p>
        -->
        <div class="hero__subtitle">
          <?php echo wp_kses_post( wpautop($hero_subtitle) ); ?>
        </div>

        <!-- Button (ACF: hero_button_label + hero_button_link)
             - rel added only when target is _blank (security best practice)
        -->
        <a class="btn btn--primary"
           href="<?php echo esc_url($hero_btn_url); ?>"
           target="<?php echo esc_attr($hero_btn_target); ?>"
           <?php echo ($hero_btn_target === '_blank') ? 'rel="noopener noreferrer"' : ''; ?>>
          <?php echo esc_html($hero_btn_label); ?>
        </a>

      </div>

      <!-- =========================
           Hero media (right)
           ========================= -->
      <div class="hero__media">
        <?php
        /**
         * Image strategy:
         * 1) Preferred: ACF Image -> Media Library (Julia can change anytime)
         *    - WP generates srcset automatically (smaller on mobile)
         *    - ALT comes from Media Library "Alt Text" (Julia controls it)
         *
         * 2) Fallback: theme asset while developing
         */
        if ($hero_image_id) {

          echo wp_get_attachment_image(
            $hero_image_id,
            'large',
            false,
            [
              // IMPORTANT: do NOT set 'alt' here
              // so WP uses Media Library alt text (Julia-controlled).
              'loading'       => 'eager',
              'decoding'      => 'async',
              'fetchpriority' => 'high',

              // Helps browser pick the correct image size
              // Mobile ~ full width, Desktop ~ right column
              'sizes' => '(max-width: 900px) 92vw, 40vw',
            ]
          );

        } else { ?>

          <img
            src="<?php echo esc_url( get_theme_file_uri('/assets/images/hero-typewriter.jpg') ); ?>"
            alt=""
            loading="eager"
            decoding="async"
            fetchpriority="high"
          />

        <?php } ?>
      </div>

    </div>
  </section>


<?php
/**
 * ABOUT section (Home)
 * ACF Group: about
 */

$about = function_exists('get_field') ? (get_field('about', $page_id) ?: []) : [];

$line1 = !empty($about['headline_line_1']) ? $about['headline_line_1'] : 'SCREENWRITER.';
$line2 = !empty($about['headline_line_2']) ? $about['headline_line_2'] : 'STORY CONSULTANT.';
$line3 = !empty($about['headline_line_3']) ? $about['headline_line_3'] : 'CREATIVE ALLY.';

$body = !empty($about['body']) ? $about['body'] : 'Lorem ipsum dolor sit amet consectetur. Dolor blandit est aliquet quis viverra vitae adipiscing. Est maecenas est eget leo nunc neque mi. Ac id diam vivamus volutpat nisi. Viverra nisi vitae mauris arcu a. Venenatis varius integer nisi et lorem sapien proin enim. Scelerisque arcu sit blandit risus. Suscipit leo est ac mauris.';

$cta = (!empty($about['cta']) && is_array($about['cta']))
  ? $about['cta']
  : ['url' => '#contact', 'title' => 'Get in Touch', 'target' => '_self'];

$portrait_id = !empty($about['portrait_image']) ? (int) $about['portrait_image'] : 0;
$wordmark_id = !empty($about['wordmark_image']) ? (int) $about['wordmark_image'] : 0;

// Portrait alt from Media Library (fallback only if empty)
$portrait_alt = $portrait_id ? get_post_meta($portrait_id, '_wp_attachment_image_alt', true) : '';
$portrait_alt = $portrait_alt ?: 'Portrait of Julia Avramidis';

$cta_url    = !empty($cta['url']) ? $cta['url'] : '#contact';
$cta_label  = !empty($cta['title']) ? $cta['title'] : 'Get in Touch';
$cta_target = !empty($cta['target']) ? $cta['target'] : '_self';
$cta_rel    = ($cta_target === '_blank') ? 'noopener noreferrer' : '';
?>

<section id="about" class="section section--about" aria-labelledby="about-title">
  <div class="container">

    <div class="about__grid">

      <div class="about__media">
        <div class="about__media-frame">

          <?php if ($wordmark_id) : ?>
            <div class="about__wordmark" aria-hidden="true">
              <?php
                echo wp_get_attachment_image(
                  $wordmark_id,
                  'large',
                  false,
                  [
                    'class' => 'about__wordmark-img',
                    'alt' => '',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                  ]
                );
              ?>
            </div>
          <?php endif; ?>

          <?php if ($portrait_id) : ?>
            <?php
              echo wp_get_attachment_image(
                $portrait_id,
                'large',
                false,
                [
                  'class' => 'about__portrait-img',
                  'alt' => $portrait_alt,
                  'loading' => 'lazy',
                  'decoding' => 'async',
                  'sizes' => '(min-width: 1024px) 520px, 92vw',
                ]
              );
            ?>
          <?php else : ?>
            <div class="about__portrait-placeholder" role="img" aria-label="Portrait placeholder"></div>
          <?php endif; ?>

        </div>
      </div>

      <div class="about__content">
        <h2 id="about-title" class="about__title">
          <span class="about__title-line"><?php echo esc_html($line1); ?></span>
          <span class="about__title-line"><?php echo esc_html($line2); ?></span>
          <span class="about__title-line"><?php echo esc_html($line3); ?></span>
        </h2>

        <div class="about__body">
          <?php echo wp_kses_post($body); ?>
        </div>

        <div class="about__cta">
          <a class="btn btn--outline"
             href="<?php echo esc_url($cta_url); ?>"
             target="<?php echo esc_attr($cta_target); ?>"
             <?php echo $cta_rel ? 'rel="'.esc_attr($cta_rel).'"' : ''; ?>>
            <?php echo esc_html($cta_label); ?>
          </a>
        </div>
      </div>

    </div>

  </div>
</section>
<?php
/**
 * DIVIDER banner (Between sections) — ACF Free
 * ACF Group: divider
 */
$divider = function_exists('get_field') ? (get_field('divider', $page_id) ?: []) : [];

$divider_headline = !empty($divider['headline']) ? $divider['headline'] : 'WHERE WORDS BECOME MOMENTS.';
$divider_img_id   = !empty($divider['image']) ? (int) $divider['image'] : 0;

/**
 * Border color can be:
 * - Hex string (e.g. "#7a0000")
 * - RGBA array (ACF Color Picker return format)
 */
$divider_border_raw = $divider['border_color'] ?? '#7a0000';

if (is_array($divider_border_raw)) {
  // Try common keys used by ACF variations
  if (!empty($divider_border_raw['hex'])) {
    $divider_border = $divider_border_raw['hex'];
  } elseif (isset($divider_border_raw['r'], $divider_border_raw['g'], $divider_border_raw['b'])) {
    $a = isset($divider_border_raw['a']) ? (float) $divider_border_raw['a'] : 1;
    $divider_border = sprintf(
      'rgba(%d,%d,%d,%.3f)',
      (int) $divider_border_raw['r'],
      (int) $divider_border_raw['g'],
      (int) $divider_border_raw['b'],
      $a
    );
  } else {
    $divider_border = '#7a0000';
  }
} else {
  $divider_border = (string) $divider_border_raw;
}

// Optional: allow line breaks if you use a textarea field for headline
$divider_headline_safe = wp_kses_post( nl2br( esc_html($divider_headline) ) );
?>

<section class="section section--divider" aria-label="Section divider">
  <div class="divider-card" style="--divider-border: <?php echo esc_attr($divider_border); ?>;">

    <?php if ($divider_img_id) : ?>
      <div class="divider-card__media" aria-hidden="true">
        <?php
          echo wp_get_attachment_image(
            $divider_img_id,
            'large',
            false,
            [
              'class'    => 'divider-card__img',
              'alt'      => '',
              'loading'  => 'lazy',
              'decoding' => 'async',
              'sizes'    => '(max-width: 900px) 88vw, 720px',
            ]
          );
        ?>
      </div>
    <?php endif; ?>

    <h2 class="divider-card__title"><?php echo $divider_headline_safe; ?></h2>

  </div>
</section>




  <!-- =========================================================
       PLACEHOLDER SECTIONS (keep for now)
       ========================================================= -->

  <section id="services" class="section"><div class="container"><h2>Services</h2></div></section>
  <section id="testimonials" class="section"><div class="container"><h2>Testimonials</h2></div></section>
  <section id="contact" class="section"><div class="container"><h2>Contact</h2></div></section>

</main>

<?php get_footer(); ?>
