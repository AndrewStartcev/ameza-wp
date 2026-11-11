<?php defined('ABSPATH') || exit; get_header(); ?>
<main id="main" class="page-main">
    <div class="container">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('page-main__article'); ?>>
            <h1 class="page-main__title"><?php the_title(); ?></h1>
            <div class="page-main__content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>
