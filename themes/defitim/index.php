<?php
// WordPress fallback template — front-page.php handles the homepage.
get_header();
?>
<main>
    <div class="section section-cream">
        <div class="section-inner" style="padding-top:4rem;padding-bottom:4rem;">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
            <?php endwhile; else : ?>
                <p><?php esc_html_e('Aucun contenu trouvé.', 'defitim'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php get_footer();
