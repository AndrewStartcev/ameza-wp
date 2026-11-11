<?php defined('ABSPATH') || exit; get_header(); ?>
<main id="main" class="page-main"><div class="container">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article <?php post_class('page-main__article'); ?>>
        <h1 class="page-main__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="page-main__content"><?php the_excerpt(); ?></div>
    </article>
<?php endwhile; the_posts_pagination(); else : ?>
    <h1 class="page-main__title">Ничего не найдено</h1>
<?php endif; ?>
</div></main>
<?php get_footer(); ?>
