<?php
defined('ABSPATH') || exit;

/* ============================================================
   ACF FIELD GROUPS — registered in PHP (version-controlled)
   Sister edits these via wp-admin; field structure is here.
   ============================================================ */

// ─── DEFI CPT FIELDS ───────────────────────────────────────
acf_add_local_field_group([
    'key'    => 'group_defi',
    'title'  => 'Informations du défi',
    'fields' => [
        [
            'key'   => 'field_defi_status',
            'label' => 'Statut',
            'name'  => 'defi_status',
            'type'  => 'select',
            'choices' => ['upcoming' => 'À venir', 'live' => 'En cours', 'past' => 'Terminé'],
            'default_value' => 'upcoming',
            'instructions' => 'Le premier défi "À venir" ou "En cours" sera mis en avant sur la page d\'accueil.',
        ],
        [
            'key'   => 'field_defi_date_display',
            'label' => 'Date affichée',
            'name'  => 'defi_date_display',
            'type'  => 'text',
            'instructions' => 'Ex : 29 mars 2026 ou 2025',
        ],
        [
            'key'   => 'field_defi_date_iso',
            'label' => 'Date (pour le tri)',
            'name'  => 'defi_date_iso',
            'type'  => 'date_picker',
            'display_format' => 'd/m/Y',
            'return_format'  => 'Y-m-d',
        ],
        [
            'key'   => 'field_defi_kind',
            'label' => 'Type de défi',
            'name'  => 'defi_kind',
            'type'  => 'text',
            'instructions' => 'Ex : Marathon en relais · 42,195 km',
        ],
        [
            'key'   => 'field_defi_location',
            'label' => 'Lieu',
            'name'  => 'defi_location',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_defi_lede',
            'label' => 'Description courte',
            'name'  => 'defi_lede',
            'type'  => 'textarea',
            'rows'  => 4,
        ],
        [
            'key'   => 'field_defi_who',
            'label' => 'Participants',
            'name'  => 'defi_who',
            'type'  => 'text',
            'instructions' => 'Ex : 20 sapeurs-pompiers de Paris, anciens, famille, enfants',
        ],
        [
            'key'   => 'field_defi_goal',
            'label' => 'Objectif de collecte (€)',
            'name'  => 'defi_goal',
            'type'  => 'number',
            'instructions' => 'Laisser vide si pas de collecte pour ce défi.',
        ],
        [
            'key'   => 'field_defi_raised',
            'label' => 'Montant collecté (€)',
            'name'  => 'defi_raised',
            'type'  => 'number',
            'instructions' => 'Mettre à jour régulièrement.',
        ],
        [
            'key'      => 'field_defi_relays',
            'label'    => 'Relais (si marathon en relais)',
            'name'     => 'defi_relays',
            'type'     => 'repeater',
            'button_label' => 'Ajouter un relais',
            'sub_fields' => [
                ['key' => 'field_relay_n',    'label' => 'N°',       'name' => 'n',    'type' => 'text'],
                ['key' => 'field_relay_km',   'label' => 'Distance', 'name' => 'km',   'type' => 'text', 'instructions' => 'Ex : 9,360 km'],
                ['key' => 'field_relay_note', 'label' => 'Note',     'name' => 'note', 'type' => 'text'],
            ],
        ],
        [
            'key'      => 'field_defi_program',
            'label'    => 'Programme du séjour',
            'name'     => 'defi_program',
            'type'     => 'repeater',
            'button_label' => 'Ajouter une étape',
            'sub_fields' => [
                ['key' => 'field_prog_d',    'label' => 'Date',       'name' => 'd', 'type' => 'text', 'instructions' => 'Ex : 25.03'],
                ['key' => 'field_prog_e',    'label' => 'Description','name' => 'e', 'type' => 'text'],
                ['key' => 'field_prog_race', 'label' => 'Jour de course ?', 'name' => 'is_race_day', 'type' => 'true_false', 'default_value' => 0],
            ],
        ],
    ],
    'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'defi']]],
    'menu_order' => 0,
    'position'   => 'normal',
]);

// ─── HERO & STATS OPTIONS ──────────────────────────────────
acf_add_local_field_group([
    'key'    => 'group_hero',
    'title'  => 'Héros & Stats',
    'fields' => [
        ['key' => 'field_hero_portrait', 'label' => 'Portrait de Tim', 'name' => 'hero_portrait', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'],
        ['key' => 'field_hero_lede_fr', 'label' => 'Accroche (FR)', 'name' => 'hero_lede_fr', 'type' => 'textarea', 'rows' => 3],
        ['key' => 'field_hero_lede_en', 'label' => 'Accroche (EN)', 'name' => 'hero_lede_en', 'type' => 'textarea', 'rows' => 3],
        ['key' => 'field_stat1_n',     'label' => 'Stat 1 — Nombre',  'name' => 'stat1_n',     'type' => 'text', 'default_value' => '8'],
        ['key' => 'field_stat1_l',     'label' => 'Stat 1 — Label FR','name' => 'stat1_l',     'type' => 'text', 'default_value' => 'Défis organisés'],
        ['key' => 'field_stat1_l_en',  'label' => 'Stat 1 — Label EN','name' => 'stat1_l_en',  'type' => 'text', 'default_value' => 'Challenges organised'],
        ['key' => 'field_stat2_n',     'label' => 'Stat 2 — Nombre',  'name' => 'stat2_n',     'type' => 'text', 'default_value' => '120+'],
        ['key' => 'field_stat2_l',     'label' => 'Stat 2 — Label FR','name' => 'stat2_l',     'type' => 'text', 'default_value' => 'Frères d\'armes mobilisés'],
        ['key' => 'field_stat2_l_en',  'label' => 'Stat 2 — Label EN','name' => 'stat2_l_en',  'type' => 'text', 'default_value' => 'Brothers mobilised'],
        ['key' => 'field_stat3_n',     'label' => 'Stat 3 — Nombre',  'name' => 'stat3_n',     'type' => 'text', 'default_value' => '38 K€'],
        ['key' => 'field_stat3_l',     'label' => 'Stat 3 — Label FR','name' => 'stat3_l',     'type' => 'text', 'default_value' => 'Collectés à ce jour'],
        ['key' => 'field_stat3_l_en',  'label' => 'Stat 3 — Label EN','name' => 'stat3_l_en',  'type' => 'text', 'default_value' => 'Raised to date'],
        ['key' => 'field_stat4_n',     'label' => 'Stat 4 — Nombre',  'name' => 'stat4_n',     'type' => 'text', 'default_value' => '29.03.26'],
        ['key' => 'field_stat4_l',     'label' => 'Stat 4 — Label FR','name' => 'stat4_l',     'type' => 'text', 'default_value' => 'Prochain défi · Kourou'],
        ['key' => 'field_stat4_l_en',  'label' => 'Stat 4 — Label EN','name' => 'stat4_l_en',  'type' => 'text', 'default_value' => 'Next challenge · Kourou'],
    ],
    'location'   => [[['param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-hros--stats']]],
    'menu_order' => 0,
]);

// ─── STORY & MEMBERS OPTIONS ───────────────────────────────
acf_add_local_field_group([
    'key'    => 'group_story',
    'title'  => 'Histoire & Membres',
    'fields' => [
        ['key' => 'field_story_photo_main', 'label' => 'Photo principale (Tim)', 'name' => 'story_photo_main', 'type' => 'image', 'return_format' => 'array'],
        ['key' => 'field_story_photo_sub',  'label' => 'Photo secondaire (équipe)', 'name' => 'story_photo_sub', 'type' => 'image', 'return_format' => 'array'],
        ['key' => 'field_story_body_a_fr', 'label' => 'Paragraphe 1 (FR)', 'name' => 'story_body_a_fr', 'type' => 'textarea', 'rows' => 5],
        ['key' => 'field_story_body_b_fr', 'label' => 'Paragraphe 2 (FR)', 'name' => 'story_body_b_fr', 'type' => 'textarea', 'rows' => 5],
        ['key' => 'field_story_body_c_fr', 'label' => 'Paragraphe 3 (FR)', 'name' => 'story_body_c_fr', 'type' => 'textarea', 'rows' => 5],
        ['key' => 'field_story_body_a_en', 'label' => 'Paragraphe 1 (EN)', 'name' => 'story_body_a_en', 'type' => 'textarea', 'rows' => 5],
        ['key' => 'field_story_body_b_en', 'label' => 'Paragraphe 2 (EN)', 'name' => 'story_body_b_en', 'type' => 'textarea', 'rows' => 5],
        ['key' => 'field_story_body_c_en', 'label' => 'Paragraphe 3 (EN)', 'name' => 'story_body_c_en', 'type' => 'textarea', 'rows' => 5],
        [
            'key'      => 'field_members_cards',
            'label'    => 'Cartes membres',
            'name'     => 'members_cards',
            'type'     => 'repeater',
            'button_label' => 'Ajouter une carte',
            'sub_fields'   => [
                ['key' => 'field_mc_n',       'label' => 'Nombre',    'name' => 'n',       'type' => 'text'],
                ['key' => 'field_mc_label_fr','label' => 'Label (FR)','name' => 'label_fr','type' => 'text'],
                ['key' => 'field_mc_label_en','label' => 'Label (EN)','name' => 'label_en','type' => 'text'],
                ['key' => 'field_mc_note_fr', 'label' => 'Note (FR)', 'name' => 'note_fr', 'type' => 'text'],
                ['key' => 'field_mc_note_en', 'label' => 'Note (EN)', 'name' => 'note_en', 'type' => 'text'],
            ],
        ],
        ['key' => 'field_members_bureau_fr', 'label' => 'Bureau de l\'asso (FR)', 'name' => 'members_bureau_fr', 'type' => 'text'],
        ['key' => 'field_members_bureau_en', 'label' => 'Bureau de l\'asso (EN)', 'name' => 'members_bureau_en', 'type' => 'text'],
    ],
    'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-histoire--membres']]],
]);

// ─── MECENAT & BUDGET OPTIONS ──────────────────────────────
acf_add_local_field_group([
    'key'    => 'group_mecenat',
    'title'  => 'Mécénat & Budget',
    'fields' => [
        [
            'key'      => 'field_mec_benefits',
            'label'    => 'Avantages mécènes',
            'name'     => 'mec_benefits',
            'type'     => 'repeater',
            'button_label' => 'Ajouter un avantage',
            'sub_fields' => [
                ['key' => 'field_mb_t_fr', 'label' => 'Titre (FR)', 'name' => 't_fr', 'type' => 'text'],
                ['key' => 'field_mb_t_en', 'label' => 'Titre (EN)', 'name' => 't_en', 'type' => 'text'],
                ['key' => 'field_mb_b_fr', 'label' => 'Texte (FR)', 'name' => 'b_fr', 'type' => 'text'],
                ['key' => 'field_mb_b_en', 'label' => 'Texte (EN)', 'name' => 'b_en', 'type' => 'text'],
            ],
        ],
        [
            'key'      => 'field_budget_rows',
            'label'    => 'Lignes budget',
            'name'     => 'budget_rows',
            'type'     => 'repeater',
            'button_label' => 'Ajouter une ligne',
            'sub_fields' => [
                ['key' => 'field_br_k_fr', 'label' => 'Poste (FR)',        'name' => 'k_fr', 'type' => 'text'],
                ['key' => 'field_br_k_en', 'label' => 'Poste (EN)',        'name' => 'k_en', 'type' => 'text'],
                ['key' => 'field_br_n_fr', 'label' => 'Détail (FR)',       'name' => 'n_fr', 'type' => 'text'],
                ['key' => 'field_br_n_en', 'label' => 'Détail (EN)',       'name' => 'n_en', 'type' => 'text'],
                ['key' => 'field_br_v',    'label' => 'Montant (€)',       'name' => 'v',    'type' => 'text'],
            ],
        ],
        ['key' => 'field_budget_total',   'label' => 'Total (ex: 52 780 €)', 'name' => 'budget_total',   'type' => 'text', 'default_value' => '52 780 €'],
        ['key' => 'field_budget_self',    'label' => 'Apport section',       'name' => 'budget_self',    'type' => 'text', 'default_value' => '− 10 000 €'],
        ['key' => 'field_budget_need',    'label' => 'Besoin de financement','name' => 'budget_need',    'type' => 'text', 'default_value' => '42 780 €'],
    ],
    'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-mcenat--budget']]],
]);

// ─── COLLECTE, PROGRESS & FAQ OPTIONS ─────────────────────
acf_add_local_field_group([
    'key'    => 'group_faq',
    'title'  => 'Collecte & FAQ',
    'fields' => [
        ['key' => 'field_progress_goal',   'label' => 'Objectif collecte global (€)',   'name' => 'progress_goal',   'type' => 'number', 'default_value' => 42780],
        ['key' => 'field_progress_raised', 'label' => 'Montant collecté global (€)',    'name' => 'progress_raised', 'type' => 'number', 'default_value' => 9620],
        ['key' => 'field_progress_donors', 'label' => 'Nombre de donateurs',            'name' => 'progress_donors', 'type' => 'number', 'default_value' => 54],
        ['key' => 'field_progress_events', 'label' => 'Événements de collecte',         'name' => 'progress_events', 'type' => 'number', 'default_value' => 3],
        ['key' => 'field_helloasso_url',   'label' => 'Lien HelloAsso (paiement en ligne)', 'name' => 'helloasso_url', 'type' => 'url', 'instructions' => 'URL vers le formulaire de don HelloAsso. Laisser vide pour utiliser le mode chèque.'],
        [
            'key'      => 'field_faq_items',
            'label'    => 'Questions / Réponses',
            'name'     => 'faq_items',
            'type'     => 'repeater',
            'button_label' => 'Ajouter une question',
            'sub_fields' => [
                ['key' => 'field_faq_q_fr', 'label' => 'Question (FR)', 'name' => 'q_fr', 'type' => 'text'],
                ['key' => 'field_faq_q_en', 'label' => 'Question (EN)', 'name' => 'q_en', 'type' => 'text'],
                ['key' => 'field_faq_a_fr', 'label' => 'Réponse (FR)',  'name' => 'a_fr', 'type' => 'textarea', 'rows' => 4],
                ['key' => 'field_faq_a_en', 'label' => 'Réponse (EN)',  'name' => 'a_en', 'type' => 'textarea', 'rows' => 4],
            ],
        ],
    ],
    'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-collecte--faq']]],
]);

// ─── CONTACT & SPONSORS OPTIONS ───────────────────────────
acf_add_local_field_group([
    'key'    => 'group_contact',
    'title'  => 'Contact & Partenaires',
    'fields' => [
        ['key' => 'field_contact_email', 'label' => 'Email de réception des messages', 'name' => 'contact_email', 'type' => 'email', 'instructions' => 'Adresse qui reçoit les messages du formulaire de contact.'],
        [
            'key'      => 'field_contact_cards',
            'label'    => 'Contacts directs',
            'name'     => 'contact_cards',
            'type'     => 'repeater',
            'button_label' => 'Ajouter un contact',
            'sub_fields'   => [
                ['key' => 'field_cc_role_fr', 'label' => 'Rôle (FR)',  'name' => 'role_fr', 'type' => 'text'],
                ['key' => 'field_cc_role_en', 'label' => 'Rôle (EN)',  'name' => 'role_en', 'type' => 'text'],
                ['key' => 'field_cc_name',    'label' => 'Nom',        'name' => 'name',    'type' => 'text'],
                ['key' => 'field_cc_tel',     'label' => 'Téléphone',  'name' => 'tel',     'type' => 'text'],
                ['key' => 'field_cc_mail',    'label' => 'Email',      'name' => 'mail',    'type' => 'email'],
            ],
        ],
        ['key' => 'field_social_instagram', 'label' => 'Instagram URL', 'name' => 'social_instagram', 'type' => 'url'],
        ['key' => 'field_social_facebook',  'label' => 'Facebook URL',  'name' => 'social_facebook',  'type' => 'url'],
        ['key' => 'field_social_linkedin',  'label' => 'LinkedIn URL',  'name' => 'social_linkedin',  'type' => 'url'],
        ['key' => 'field_social_bspp',      'label' => 'Site BSPP URL', 'name' => 'social_bspp',      'type' => 'url', 'default_value' => 'https://www.pompiersparis.fr'],
        [
            'key'      => 'field_sponsors',
            'label'    => 'Logos partenaires',
            'name'     => 'sponsors',
            'type'     => 'repeater',
            'button_label' => 'Ajouter un partenaire',
            'sub_fields'   => [
                ['key' => 'field_sp_logo', 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail'],
                ['key' => 'field_sp_name', 'label' => 'Nom',  'name' => 'name', 'type' => 'text'],
                ['key' => 'field_sp_url',  'label' => 'Site', 'name' => 'url',  'type' => 'url'],
            ],
        ],
    ],
    'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-contact--partenaires']]],
]);
