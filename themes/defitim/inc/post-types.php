<?php
defined('ABSPATH') || exit;

/* ============================================================
   CPT: DEFI
   ============================================================ */
add_action('init', function () {
    register_post_type('defi', [
        'labels' => [
            'name'               => __('Défis', 'defitim'),
            'singular_name'      => __('Défi', 'defitim'),
            'add_new'            => __('Ajouter un défi', 'defitim'),
            'add_new_item'       => __('Nouveau défi', 'defitim'),
            'edit_item'          => __('Modifier le défi', 'defitim'),
            'new_item'           => __('Nouveau défi', 'defitim'),
            'view_item'          => __('Voir le défi', 'defitim'),
            'search_items'       => __('Chercher un défi', 'defitim'),
            'not_found'          => __('Aucun défi trouvé', 'defitim'),
            'not_found_in_trash' => __('Aucun défi dans la corbeille', 'defitim'),
            'menu_name'          => __('Les Défis', 'defitim'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'defi'],
        'supports'     => ['title', 'editor', 'thumbnail', 'revisions'],
        'menu_icon'    => 'dashicons-flag',
        'menu_position'=> 5,
    ]);
});

/* ============================================================
   ADMIN COLUMNS for Defi CPT
   ============================================================ */
add_filter('manage_defi_posts_columns', function ($cols) {
    return [
        'cb'       => $cols['cb'],
        'title'    => __('Titre', 'defitim'),
        'status'   => __('Statut', 'defitim'),
        'date_iso' => __('Date', 'defitim'),
        'location' => __('Lieu', 'defitim'),
        'goal'     => __('Objectif', 'defitim'),
        'raised'   => __('Collecté', 'defitim'),
    ];
});

add_action('manage_defi_posts_custom_column', function ($col, $post_id) {
    switch ($col) {
        case 'status':
            $s = get_field('defi_status', $post_id);
            $labels = ['upcoming' => '🟠 À venir', 'live' => '🟢 En cours', 'past' => '⚫ Terminé'];
            echo esc_html($labels[$s] ?? $s);
            break;
        case 'date_iso':
            echo esc_html(get_field('defi_date_display', $post_id));
            break;
        case 'location':
            echo esc_html(get_field('defi_location', $post_id));
            break;
        case 'goal':
            $g = get_field('defi_goal', $post_id);
            echo $g ? '€' . number_format((int)$g, 0, ',', ' ') : '—';
            break;
        case 'raised':
            $r = get_field('defi_raised', $post_id);
            echo $r ? '€' . number_format((int)$r, 0, ',', ' ') : '—';
            break;
    }
}, 10, 2);

add_filter('manage_edit-defi_sortable_columns', function ($cols) {
    $cols['date_iso'] = 'date_iso';
    $cols['status']   = 'status';
    return $cols;
});
