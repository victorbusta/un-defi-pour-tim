<?php
defined('ABSPATH') || exit;

/* ============================================================
   THEME SETUP
   ============================================================ */
function defitim_setup() {
    load_theme_textdomain('defitim', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_image_size('defi-hero',   900, 1125, true);
    add_image_size('defi-story',  800,  600, true);
    add_image_size('sponsor-logo',400,  240, false);
    register_nav_menus(['primary' => __('Navigation principale', 'defitim')]);
}
add_action('after_setup_theme', 'defitim_setup');

/* ============================================================
   ENQUEUE ASSETS
   ============================================================ */
function defitim_assets() {
    $v = wp_get_theme()->get('Version');

    wp_enqueue_style('defitim-fonts',
        'https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
        [], null);
    wp_enqueue_style('defitim-main',
        get_template_directory_uri() . '/assets/css/main.css', ['defitim-fonts'], $v);

    wp_enqueue_script('defitim-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [], $v, true);

    // Pass data to JS
    wp_localize_script('defitim-main', 'defitim', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('defitim_contact'),
        'lang'     => function_exists('pll_current_language') ? pll_current_language() : 'fr',
        'strings'  => [
            'sending'  => __('Envoi en cours…', 'defitim'),
            'success'  => __('Message envoyé. Nous vous répondons rapidement.', 'defitim'),
            'error'    => __('Erreur lors de l\'envoi. Veuillez réessayer.', 'defitim'),
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'defitim_assets');

/* ============================================================
   CUSTOM POST TYPE: DEFI
   ============================================================ */
require get_template_directory() . '/inc/post-types.php';

/* ============================================================
   ACF FIELDS (registered in PHP — version-controlled)
   ============================================================ */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    require get_template_directory() . '/inc/acf-fields.php';
});

/* ============================================================
   AJAX: CONTACT FORM
   ============================================================ */
require get_template_directory() . '/inc/ajax.php';

/* ============================================================
   HELPERS
   ============================================================ */

// Get ACF option with fallback
function dt_opt($key, $fallback = '') {
    if (function_exists('get_field')) {
        $v = get_field($key, 'option');
        return ($v !== null && $v !== false && $v !== '') ? $v : $fallback;
    }
    return $fallback;
}

// Safe ACF get_field with fallback
function dt_field($key, $post_id = null, $fallback = '') {
    if (function_exists('get_field')) {
        $v = $post_id ? get_field($key, $post_id) : get_field($key);
        return ($v !== null && $v !== false && $v !== '') ? $v : $fallback;
    }
    return $fallback;
}

// Render SVG arrow
function dt_arrow() {
    return '<svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>';
}

// Polylang language switcher URLs
function dt_lang_urls() {
    if (!function_exists('pll_the_languages')) return [];
    ob_start();
    pll_the_languages(['show_flags' => 0, 'show_names' => 1, 'raw' => 1]);
    // pll_the_languages with raw=1 returns array directly
    return pll_the_languages(['show_flags' => 0, 'show_names' => 1, 'raw' => 1]) ?: [];
}

// Format amount
function dt_amount($n) {
    return '€' . number_format((int)$n, 0, ',', ' ');
}

// Progress percentage
function dt_progress_pct($raised, $goal) {
    if (!$goal) return 0;
    return min(100, round(($raised / $goal) * 100));
}

/* ============================================================
   ADMIN: OPTIONS PAGE (requires ACF Pro or ACF free 5.0+)
   ============================================================ */
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Défi Tim — Contenu du site',
            'menu_title' => 'Défi Tim',
            'menu_slug'  => 'defitim-options',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'icon_url'   => 'dashicons-heart',
        ]);
        acf_add_options_sub_page([
            'page_title'  => 'Héros & Stats',
            'menu_title'  => 'Héros & Stats',
            'parent_slug' => 'defitim-options',
        ]);
        acf_add_options_sub_page([
            'page_title'  => 'Histoire & Membres',
            'menu_title'  => 'Histoire & Membres',
            'parent_slug' => 'defitim-options',
        ]);
        acf_add_options_sub_page([
            'page_title'  => 'Mécénat & Budget',
            'menu_title'  => 'Mécénat & Budget',
            'parent_slug' => 'defitim-options',
        ]);
        acf_add_options_sub_page([
            'page_title'  => 'Collecte & FAQ',
            'menu_title'  => 'Collecte & FAQ',
            'parent_slug' => 'defitim-options',
        ]);
        acf_add_options_sub_page([
            'page_title'  => 'Contact & Partenaires',
            'menu_title'  => 'Contact & Partenaires',
            'parent_slug' => 'defitim-options',
        ]);
    }
});

/* ============================================================
   SECURITY: DISABLE XMLRPC, HIDE WP VERSION
   ============================================================ */
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

/* ============================================================
   POLYLANG: register strings for translation
   ============================================================ */
add_action('init', function () {
    if (!function_exists('pll_register_string')) return;
    $strings = [
        'Faire un don'         => 'donate_cta',
        'Soutenir les défis'   => 'hero_cta_primary',
        'Lire son histoire'    => 'hero_cta_secondary',
        'Voir le défi en détail' => 'story_readmore',
        'À venir'              => 'status_upcoming',
        'Terminé'              => 'status_past',
    ];
    foreach ($strings as $string => $name) {
        pll_register_string($name, $string, 'defitim');
    }
});
