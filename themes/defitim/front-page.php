<?php
defined('ABSPATH') || exit;
get_header();

// Use Elementor content once the sister has built the page in the visual editor.
// Until then, serve the PHP template-parts so the site stays live.
// Note: Elementor stores '[]' (empty array) when the editor is opened but nothing added yet —
// we require at least 20 chars of data to confirm real content exists.
$front_page_id        = (int) get_option('page_on_front');
$elementor_raw        = $front_page_id ? (string) get_post_meta($front_page_id, '_elementor_data', true) : '';
$has_elementor_content = strlen($elementor_raw) > 20;
?>
<main id="top">
<?php if ($has_elementor_content) :
    while (have_posts()) { the_post(); the_content(); }
else : ?>
    <?php get_template_part('template-parts/hero'); ?>
    <?php get_template_part('template-parts/story'); ?>
    <?php get_template_part('template-parts/defis'); ?>
    <?php get_template_part('template-parts/members'); ?>
    <?php get_template_part('template-parts/mecenat'); ?>
    <?php get_template_part('template-parts/sens'); ?>
    <?php get_template_part('template-parts/help'); ?>
    <?php get_template_part('template-parts/progress'); ?>
    <?php get_template_part('template-parts/sponsors'); ?>
    <?php get_template_part('template-parts/faq'); ?>
    <?php get_template_part('template-parts/contact'); ?>
<?php endif; ?>
</main>
<?php get_footer();
