<?php
/**
 * Posts Page (Blog Index)
 * Theme: Julia Avramidis
 */

get_header();

?>


<main id="primary" class="site-main">

  <!-- ================================
       BLOG HERO
       ================================ -->
  <section class="section--blog-hero">
    <div class="container">
      <h1 class="blog-title">BLOG</h1>
  
    </div>
  </section>

  <!-- ================================
       BLOG GRID
       ================================ -->
  <section class="section--blog">
    <div class="container blog-frame">

      <?php if ( have_posts() ) : ?>

        <div class="blog-grid">

          <?php
         $post_index = 0;

while ( have_posts() ) :
  the_post();
  get_template_part( 'template-parts/blog/card' );
endwhile;


          ?>

        </div>

        <!-- ================================
             PAGINATION
             ================================ -->
        <nav class="blog-pagination" aria-label="Posts navigation">
          <?php
          echo paginate_links( [
            'mid_size'  => 2,
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
          ] );
          ?>
        </nav>

      <?php else : ?>

        <p>No posts found.</p>

      <?php endif; ?>

    </div>
  </section>

</main>

<?php
get_footer();
