<article <?php post_class('blog-card'); ?>>
  <a href="<?php the_permalink(); ?>" class="blog-card__link">

    <?php if ( has_post_thumbnail() ) : ?>
      <div class="blog-card__image">
        <?php the_post_thumbnail('large'); ?>
      </div>
    <?php endif; ?>

    <div class="blog-card__content">
      <h2 class="blog-card__title">
        <?php the_title(); ?>
      </h2>

      <p class="blog-card__excerpt">
        <?php echo esc_html( get_the_excerpt() ); ?>
      </p>
    </div>

  </a>
</article>
