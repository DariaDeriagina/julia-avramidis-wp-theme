<?php
get_header();
?>

<main id="primary" class="site-main">

  <?php
  if ( have_posts() ) :
    while ( have_posts() ) :
      the_post();
  ?>

      <article class="single-post">

        <!-- =========================
             Post Header
             ========================= -->
        <header class="single-post__header">

          <h1 class="single-post__title">
            <?php the_title(); ?>
          </h1>

          <?php if ( has_post_thumbnail() ) : ?>
            <figure class="single-post__featured-image">
              <?php
                the_post_thumbnail(
                  'large',
                  [
                    'loading' => 'eager',
                    'class'   => 'single-post__image',
                  ]
                );
              ?>
            </figure>
          <?php endif; ?>

        </header>

        <!-- =========================
             Post Content
             ========================= -->
        <div class="single-post__content">
          <?php the_content(); ?>
        </div>

      </article>

  <?php
    endwhile;
  endif;
  ?>

</main>

<?php
get_footer();
