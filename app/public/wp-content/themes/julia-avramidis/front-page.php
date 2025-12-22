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
$page_id = (int) get_option('page_on_front');
if (!$page_id) {
  $page_id = get_queried_object_id();
}


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



<?php
/**
 * MARK: SERVICES section (ACF Free: fixed 2 scenes, no repeater)
 * - Reads ACF fields directly (because "services" is a Field Group title, not a field)
 * - Uses scene_1 + scene_2 (Group fields)
 * - Image return format: Image ID (your setting)
 */

/* Real front page ID (critical) */
$page_id = (int) get_option('page_on_front');
if (!$page_id) {
  $page_id = (int) get_queried_object_id();
}

/* -----------------------------
   Defaults
----------------------------- */
$section_title    = 'SERVICES';
$section_subtitle = 'How Julia can support your story';

$scene_1 = array(
  'label'       => 'SCENE 01',
  'title'       => 'Script Evaluation & Story Notes',
  'description' => 'A focused review of your script and story structure with clear, actionable notes to strengthen character, pacing, and emotional impact.',
  'image_id'    => 0,
  'link'        => array(),
);

$scene_2 = array(
  'label'       => 'SCENE 02',
  'title'       => 'Development Support & Revisions',
  'description' => 'Ongoing guidance through revisions—scene-level feedback, narrative clarity, and industry-aware suggestions to elevate the next draft.',
  'image_id'    => 0,
  'link'        => array(),
);

$cta_link = array(
  'url'    => '#contact',
  'title'  => "LET'S CRAFT YOUR STORY",
  'target' => '_self',
);

$cta_label_override = '';

/* -----------------------------
   Helpers
----------------------------- */
$build_desc = function ($raw) {
  if (empty($raw)) return '';
  if (is_string($raw) && strpos($raw, '<') === false) return wpautop($raw);
  return $raw;
};

/* -----------------------------
   ACF reads
----------------------------- */
if (function_exists('get_field')) {

  // Top-level fields in the "services" field group
  $section_title    = get_field('section_title', $page_id) ?: $section_title;
  $section_subtitle = get_field('section_subtitle', $page_id) ?: $section_subtitle;

  // Group field: scene_1
  $s1 = get_field('scene_1', $page_id);
  if (is_array($s1)) {
    $scene_1['label']       = !empty($s1['scene_1_label']) ? (string) $s1['scene_1_label'] : $scene_1['label'];
    $scene_1['title']       = !empty($s1['scene_1_title']) ? (string) $s1['scene_1_title'] : $scene_1['title'];
    $scene_1['description'] = !empty($s1['scene_1_description']) ? $s1['scene_1_description'] : $scene_1['description'];
    $scene_1['image_id']    = !empty($s1['scene_1_image']) ? (int) $s1['scene_1_image'] : 0;
    $scene_1['link']        = (!empty($s1['scene_1_link']) && is_array($s1['scene_1_link'])) ? $s1['scene_1_link'] : array();
  }

  // Group field: scene_2
  $s2 = get_field('scene_2', $page_id);
  if (is_array($s2)) {
    $scene_2['label']       = !empty($s2['scene_2_label']) ? (string) $s2['scene_2_label'] : $scene_2['label'];
    $scene_2['title']       = !empty($s2['scene_2_title']) ? (string) $s2['scene_2_title'] : $scene_2['title'];
    $scene_2['description'] = !empty($s2['scene_2_description']) ? $s2['scene_2_description'] : $scene_2['description'];
    $scene_2['image_id']    = !empty($s2['scene_2_image']) ? (int) $s2['scene_2_image'] : 0;
    $scene_2['link']        = (!empty($s2['scene_2_link']) && is_array($s2['scene_2_link'])) ? $s2['scene_2_link'] : array();
  }

  // CTA fields (top-level)
  $cta = get_field('cta_link', $page_id);
  if (is_array($cta) && !empty($cta['url'])) {
    $cta_link = array_merge($cta_link, $cta);
  }

  $cta_label_override = get_field('cta_label', $page_id) ?: '';
}

/* -----------------------------
   Normalize CTA
----------------------------- */
$cta_url     = !empty($cta_link['url']) ? $cta_link['url'] : '';
$cta_target  = !empty($cta_link['target']) ? $cta_link['target'] : '_self';
$cta_label   = !empty($cta_label_override)
  ? $cta_label_override
  : (!empty($cta_link['title']) ? $cta_link['title'] : "LET'S CRAFT YOUR STORY");

$scenes = array($scene_1, $scene_2);
?>

<section id="services" class="section section--services" aria-labelledby="services-title">
  <div class="services__header">
    <h2 id="services-title" class="services__title"><?php echo esc_html($section_title); ?></h2>

    <?php if (!empty($section_subtitle)) : ?>
      <p class="services__subtitle"><?php echo esc_html($section_subtitle); ?></p>
    <?php endif; ?>
  </div>

  <div class="services__list">
    <?php foreach ($scenes as $i => $scene) : ?>
      <?php
        $label  = !empty($scene['label']) ? $scene['label'] : ('SCENE ' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT));
        $title  = !empty($scene['title']) ? $scene['title'] : '';
        $desc   = $build_desc($scene['description'] ?? '');
        $img_id = !empty($scene['image_id']) ? (int) $scene['image_id'] : 0;

        $link   = (is_array($scene['link'] ?? null)) ? $scene['link'] : array();
        $url    = !empty($link['url']) ? $link['url'] : '';
        $target = !empty($link['target']) ? $link['target'] : '_self';
        $rel    = ($target === '_blank') ? 'noopener noreferrer' : 'noopener';
      ?>

      <article class="service-card">
        <div class="service-card__media">
          <?php if ($img_id) : ?>
            <?php
              echo wp_get_attachment_image(
                $img_id,
                'large',
                false,
                array(
                  'class'    => 'service-card__img',
                  'loading'  => 'lazy',
                  'decoding' => 'async',
                  'sizes'    => '(max-width: 900px) 92vw, 280px',
                )
              );
            ?>
          <?php else : ?>
            <div class="service-card__img" aria-hidden="true"></div>
          <?php endif; ?>
        </div>

        <div class="service-card__content">
          <div class="service-card__label"><?php echo esc_html($label); ?></div>

          <?php if (!empty($title)) : ?>
            <h3 class="service-card__heading">
              <?php if (!empty($url)) : ?>
                <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" rel="<?php echo esc_attr($rel); ?>">
                  <?php echo esc_html($title); ?>
                </a>
              <?php else : ?>
                <?php echo esc_html($title); ?>
              <?php endif; ?>
            </h3>
          <?php endif; ?>

          <?php if (!empty($desc)) : ?>
            <div class="service-card__text">
              <?php echo wp_kses_post($desc); ?>
            </div>
          <?php endif; ?>
        </div>
      </article>

    <?php endforeach; ?>
  </div>

  <?php if (!empty($cta_url) && !empty($cta_label)) : ?>
   <div class="services__cta">
    <a class="btn btn--outline"
       href="<?php echo esc_url($cta_url); ?>"
       target="<?php echo esc_attr($cta_target); ?>"
       <?php echo ($cta_target === '_blank') ? 'rel="noopener noreferrer"' : 'rel="noopener"'; ?>>
      <?php echo esc_html($cta_label); ?>
    </a>
  </div>
  <?php endif; ?>
</section>


<?php
/* =========================================================
   MARK: TESTIMONIALS (ACF Free: fixed 3 cards)
========================================================= */

$page_id = (int) get_option('page_on_front');
if (!$page_id) {
  $page_id = get_queried_object_id();
}

$defaults = [
  [
    'heading'    => 'THEIR HONEST WORDS',
    'pull_quote' => '“Julia’s notes helped me see the story I was *trying* to tell — and then actually tell it.”',
    'body'       => '"She identified the emotional engine of each scene, flagged what wasn’t landing, and gave clear, practical suggestions that strengthened pacing and character motivation. I left the process with a sharper draft and a stronger sense of direction."',
    'name'       => 'Maya Caldwell',
    'role'       => 'Independent Screenwriter',
  ],
  [
    'heading'    => 'REVIEW NUMBER TWO',
    'pull_quote' => '“Thoughtful, precise, and deeply respectful of the voice of the writer.”',
    'body'       => '"Julia’s feedback was both rigorous and encouraging. She caught structural issues I’d been circling for months and offered solutions that felt true to the world and tone of the script. The rewrite was faster, cleaner, and more confident because of her guidance."',
    'name'       => 'Daniel Rivera',
    'role'       => 'Writer / Director',
  ],
  [
    'heading'    => 'REVIEW NUMBER THREE',
    'pull_quote' => '“If you want clarity, craft, and next-step momentum — this is the support you’re looking for.”',
    'body'       => '"The notes were organized, actionable, and industry-aware. Julia helped me strengthen character arcs, tighten scenes, and raise the emotional stakes without losing what made the script mine. I’d recommend her to any writer serious about leveling up their draft."',
    'name'       => 'Sofia Bennett',
    'role'       => 'Story Producer',
  ],
];


$cards = $defaults;

if (function_exists('get_field')) {
  $t = get_field('testimonials', $page_id);

  if (is_array($t)) {
    $map = ['t1' => 0, 't2' => 1, 't3' => 2];

    foreach ($map as $key => $idx) {
      if (!empty($t[$key]) && is_array($t[$key])) {
        $g = $t[$key];

        $cards[$idx]['heading']    = !empty($g['heading']) ? (string) $g['heading'] : $cards[$idx]['heading'];
        $cards[$idx]['pull_quote'] = !empty($g['pull_quote']) ? (string) $g['pull_quote'] : $cards[$idx]['pull_quote'];
        $cards[$idx]['body']       = !empty($g['body']) ? (string) $g['body'] : $cards[$idx]['body'];
        $cards[$idx]['name']       = !empty($g['name']) ? (string) $g['name'] : $cards[$idx]['name'];
        $cards[$idx]['role']       = !empty($g['role']) ? (string) $g['role'] : $cards[$idx]['role'];
      }
    }
  }
}
?>

<section id="testimonials" class="section section--testimonials" aria-label="Testimonials">
  <div class="container">

    <div class="testimonials" data-testimonials>
      <div class="testimonials__viewport">
        <div class="testimonials__track">
          <?php foreach ($cards as $i => $c) : ?>
            <article class="testimonial" data-testimonial>
              <h3 class="testimonial__heading"><?php echo esc_html($c['heading']); ?></h3>

              <p class="testimonial__pull">
                <?php echo esc_html($c['pull_quote']); ?>
              </p>

              <p class="testimonial__body">
                <?php echo esc_html($c['body']); ?>
              </p>

              <p class="testimonial__name">
                <span class="testimonial__dash" aria-hidden="true">—</span>
                <?php echo esc_html($c['name']); ?>
              </p>

              <p class="testimonial__role"><?php echo esc_html($c['role']); ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Dots (mobile) -->
      <div class="testimonials__dots" aria-label="Testimonials navigation">
        <?php foreach ($cards as $i => $_c) : ?>
          <button class="testimonials__dot" type="button" data-dot="<?php echo esc_attr($i); ?>" aria-label="Go to testimonial <?php echo esc_attr($i + 1); ?>"></button>
        <?php endforeach; ?>
      </div>

      <!-- Prev / Next (desktop) -->
      <div class="testimonials__nav" aria-label="Testimonials controls">
        <button class="testimonials__btn testimonials__btn--prev" type="button" data-prev>
          <span aria-hidden="true" class="testimonials__arrow testimonials__arrow--left"></span>
          <span class="testimonials__btn-text">PREV</span>
        </button>

        <button class="testimonials__btn testimonials__btn--next" type="button" data-next>
          <span class="testimonials__btn-text">NEXT</span>
          <span aria-hidden="true" class="testimonials__arrow testimonials__arrow--right"></span>
        </button>
      </div>

    </div>

  </div>
</section>


  <!-- =========================================================
       PLACEHOLDER SECTIONS (keep for now)
       ========================================================= -->



  <section id="contact" class="section"><div class="container"><h2>Contact</h2></div></section>

</main>

<?php get_footer(); ?>
