<?php get_header(); ?>

<main class="site-main">

  <div class="container" style="padding:60px 0">

    <?php
    while ( have_posts() ) :
      the_post();
    ?>

      <h1 class="page-title"><?php the_title(); ?></h1>

      <div class="page-content">
        <?php the_content(); ?>
      </div>

    <?php endwhile; ?>

  </div>

</main>

<?php get_footer(); ?>
