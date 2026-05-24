<?php
/**
 * Elementor page builder — Un Défi pour Tim
 * ALL sections use real Elementor widgets. No shortcodes except the contact form.
 * Everything is click-to-edit in Elementor.
 *
 * Run: wp eval-file .../build-elementor-page.php --path=/var/www/html --allow-root
 */

define('NAVY',  '#0B1B3D');
define('RED',   '#E63329');
define('CREAM', '#F4EFE6');
define('BRASS', '#C8965A');
define('WHITE', '#FFFFFF');

$_used_ids = [];
function uid() {
    global $_used_ids;
    $c = 'abcdefghijklmnopqrstuvwxyz0123456789';
    do { $id = ''; for ($i = 0; $i < 7; $i++) $id .= $c[random_int(0, 35)]; }
    while (isset($_used_ids[$id]));
    $_used_ids[$id] = 1;
    return $id;
}

function el_section(string $bg, string $pv, array $cols, array $extra = []): array {
    return array_merge([
        'id'       => uid(),
        'elType'   => 'section',
        'isInner'  => false,
        'settings' => array_merge([
            'stretch_section'       => 'section-stretched',
            'content_width'         => ['unit' => 'px', 'size' => 1200],
            'gap'                   => 'no',
            'background_background' => 'classic',
            'background_color'      => $bg,
            'padding'               => ['unit' => 'px', 'top' => $pv, 'right' => '0', 'bottom' => $pv, 'left' => '0', 'isLinked' => false],
        ], $extra),
        'elements' => $cols,
    ]);
}

function el_inner(array $cols, array $extra = []): array {
    return array_merge([
        'id'       => uid(),
        'elType'   => 'section',
        'isInner'  => true,
        'settings' => array_merge([
            'gap'     => 'no',
            'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
        ], $extra),
        'elements' => $cols,
    ]);
}

function el_col(int $pct, array $widgets, array $extra = []): array {
    return array_merge([
        'id'       => uid(),
        'elType'   => 'column',
        'isInner'  => false,
        'settings' => array_merge(['_column_size' => $pct, 'content_position' => 'middle'], $extra),
        'elements' => $widgets,
    ]);
}

function el_widget(string $type, array $cfg): array {
    return ['id' => uid(), 'elType' => 'widget', 'widgetType' => $type, 'settings' => $cfg, 'elements' => []];
}

function w_heading(string $text, string $tag, string $color, int $px, float $lh = 1.1): array {
    return el_widget('heading', [
        'title'                  => $text,
        'header_size'            => $tag,
        'title_color'            => $color,
        'typography_typography'  => 'custom',
        'typography_font_family' => 'Archivo Black',
        'typography_font_weight' => '400',
        'typography_font_size'   => ['unit' => 'px', 'size' => $px, 'sizes' => []],
        'typography_line_height' => ['unit' => 'em', 'size' => $lh, 'sizes' => []],
    ]);
}

function w_text(string $html, string $color = NAVY, int $px = 18): array {
    return el_widget('text-editor', [
        'editor'                  => $html,
        'text_color'              => $color,
        'typography_typography'   => 'custom',
        'typography_font_family'  => 'Inter',
        'typography_font_weight'  => '400',
        'typography_font_size'    => ['unit' => 'px', 'size' => $px, 'sizes' => []],
        'typography_line_height'  => ['unit' => 'em', 'size' => 1.6, 'sizes' => []],
    ]);
}

function w_kicker(string $text, string $color = BRASS): array {
    return w_text(
        '<p style="font-family:Inter;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:2px;color:' . $color . '">' . $text . '</p>',
        $color, 12
    );
}

function w_spacer(int $px): array {
    return el_widget('spacer', ['space' => ['unit' => 'px', 'size' => $px, 'sizes' => []]]);
}

function w_button(string $label, string $url, string $bg = RED, string $size = 'md', string $align = 'left'): array {
    return el_widget('button', [
        'text'                      => $label,
        'link'                      => ['url' => $url, 'is_external' => '', 'nofollow' => ''],
        'size'                      => $size,
        'align'                     => $align,
        'button_background_color'   => $bg,
        'button_text_color'         => WHITE,
        'border_radius'             => ['unit' => 'px', 'top' => 4, 'right' => 4, 'bottom' => 4, 'left' => 4, 'isLinked' => true],
        'typography_typography'     => 'custom',
        'typography_font_family'    => 'Inter',
        'typography_font_weight'    => '700',
        'typography_font_size'      => ['unit' => 'px', 'size' => 13, 'sizes' => []],
        'typography_letter_spacing' => ['unit' => 'px', 'size' => 1, 'sizes' => []],
        'typography_text_transform' => 'uppercase',
    ]);
}

function w_counter(int $end, string $label, string $suffix = '', string $prefix = '', string $numColor = RED, string $lblColor = NAVY): array {
    return el_widget('counter', [
        'starting_number'                => 0,
        'ending_number'                  => $end,
        'suffix'                         => $suffix,
        'prefix'                         => $prefix,
        'title'                          => $label,
        'number_color'                   => $numColor,
        'title_color'                    => $lblColor,
        'typography_typography'          => 'custom',
        'typography_font_family'         => 'Archivo Black',
        'typography_font_weight'         => '400',
        'typography_font_size'           => ['unit' => 'px', 'size' => 40, 'sizes' => []],
        'title_typography_typography'    => 'custom',
        'title_typography_font_family'   => 'Inter',
        'title_typography_font_size'     => ['unit' => 'px', 'size' => 12, 'sizes' => []],
        'title_typography_font_weight'   => '500',
        'title_typography_text_transform'=> 'uppercase',
        'title_typography_letter_spacing'=> ['unit' => 'px', 'size' => 1, 'sizes' => []],
    ]);
}

function w_img(string $note): array {
    return w_text(
        '<p style="text-align:center;padding:48px 24px;background:rgba(200,150,90,0.08);border:2px dashed ' . BRASS . ';border-radius:8px;color:' . BRASS . ';font-family:monospace;font-size:13px;line-height:1.6">' . $note . '</p>',
        BRASS, 13
    );
}

function w_progress(int $pct, string $label): array {
    return el_widget('progress', [
        'title'              => $label,
        'percent'            => ['unit' => '%', 'size' => $pct, 'sizes' => []],
        'color'              => WHITE,
        'bar_color'          => RED,
        'bar_bg_color'       => 'rgba(255,255,255,0.15)',
        'display_percentage' => 'show',
        'typography_typography'  => 'custom',
        'typography_font_family' => 'Inter',
        'typography_font_weight' => '600',
        'typography_font_size'   => ['unit' => 'px', 'size' => 13, 'sizes' => []],
    ]);
}

function w_accordion(array $items, string $titleColor = NAVY, string $contentColor = NAVY): array {
    $tabs = [];
    foreach ($items as [$q, $a]) {
        $tabs[] = ['_id' => uid(), 'tab_title' => $q, 'tab_content' => $a];
    }
    return el_widget('accordion', [
        'tabs'                            => $tabs,
        'title_color'                     => $titleColor,
        'icon_color'                      => RED,
        'border_color'                    => 'rgba(11,27,61,0.12)',
        'title_typography_typography'     => 'custom',
        'title_typography_font_family'    => 'Inter',
        'title_typography_font_weight'    => '600',
        'title_typography_font_size'      => ['unit' => 'px', 'size' => 16, 'sizes' => []],
        'content_color'                   => $contentColor,
        'content_typography_typography'   => 'custom',
        'content_typography_font_family'  => 'Inter',
        'content_typography_font_size'    => ['unit' => 'px', 'size' => 15, 'sizes' => []],
        'content_typography_line_height'  => ['unit' => 'em', 'size' => 1.6, 'sizes' => []],
    ]);
}

// ─── Build page ───────────────────────────────────────────────────────────────
$menu_obj = wp_get_nav_menu_object('Navigation principale');
$menu_id  = $menu_obj ? (int) $menu_obj->term_id : 0;
$page = [];

// ════════════════════════════════════════════════════════
// NAV
// ════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '14', [
    el_col(18, [
        w_heading('Un Défi<br>pour <span style="color:' . RED . '">Tim</span>', 'div', WHITE, 13, 1.15),
    ], ['content_position' => 'middle']),
    el_col(64, [
        el_widget('nav-menu', [
            'menu'                                => $menu_id,
            'layout'                              => 'horizontal',
            'pointer'                             => 'none',
            'style_color'                         => WHITE,
            'style_color_hover'                   => RED,
            'style_typography_typography'         => 'custom',
            'style_typography_font_family'        => 'Inter',
            'style_typography_font_size'          => ['unit' => 'px', 'size' => 12, 'sizes' => []],
            'style_typography_font_weight'        => '500',
            'style_typography_text_transform'     => 'uppercase',
            'style_typography_letter_spacing'     => ['unit' => 'px', 'size' => 1, 'sizes' => []],
        ]),
    ], ['content_position' => 'middle']),
    el_col(18, [
        w_button('Faire un don', '#help', RED, 'sm', 'right'),
    ], ['content_position' => 'middle']),
], [
    '_position'   => 'fixed',
    'z_index'     => 999,
    'css_classes' => 'dt-topbar',
    'padding'     => ['unit' => 'px', 'top' => '14', 'right' => '24', 'bottom' => '14', 'left' => '24', 'isLinked' => false],
]);

// ════════════════════════════════════════════════════════
// HERO
// ════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '100', [
    el_col(55, [
        w_spacer(60),
        w_kicker('Marathon de l\'Espace · Kourou · 29 mars 2026'),
        w_spacer(8),
        w_heading('Un Défi<br>pour <span style="color:' . RED . '">Tim</span>', 'h1', NAVY, 72, 0.95),
        w_spacer(24),
        w_text('<p>Corporal Timothé Bernardeau, sapeur-pompier de Paris, a subi un grave traumatisme lors d\'une démonstration de gymnastique pour des enfants malades. Ses frères d\'armes relèvent des défis sportifs pour lui témoigner leur fraternité et soutenir son accompagnement.</p>', NAVY),
        w_spacer(40),
        el_inner([
            el_col(25, [w_counter(4,     'Défis organisés')]),
            el_col(25, [w_counter(26,    'Participants')]),
            el_col(25, [w_counter(42780, 'À collecter', ' €')]),
            el_col(25, [
                w_heading('29.03.26', 'h3', RED, 36, 1.0),
                w_text('<p style="font-family:Inter;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:1px;color:' . NAVY . ';margin-top:4px">Jour J</p>', NAVY, 12),
            ]),
        ]),
        w_spacer(40),
        el_inner([
            el_col(50, [w_button('Soutenir les défis', '#help', RED, 'lg')]),
            el_col(50, [w_button('Lire son histoire', '#story', NAVY, 'lg', 'left')]),
        ]),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
    el_col(45, [
        w_img('Portrait de Tim<br>→ Cliquer sur ce bloc dans Elementor<br>→ Remplacer par la photo via la médiathèque'),
    ], ['content_position' => 'middle']),
], ['_element_id' => 'hero']);

// ════════════════════════════════════════════════════════
// STORY
// ════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '80', [
    el_col(50, [
        w_kicker('Son histoire'),
        w_spacer(16),
        w_heading('Timothé Bernardeau.', 'h2', NAVY, 40),
        w_spacer(24),
        w_text('<p>Né à Nantes, Timothé rejoint la Brigade de Sapeurs-Pompiers de Paris en septembre 2012. Il intègre la 11<sup>e</sup> compagnie du Marais (4<sup>e</sup> arrondissement) comme conducteur de machine. Présent lors des attentats du 13 novembre 2015, il reçoit de nombreuses citations de ses commandants.</p>', NAVY),
        w_spacer(16),
        w_text('<p>En avril 2015, il rejoint le groupe de gymnastique d\'élite de la BSPP — fondé en 1919 — une équipe acrobatique et artistique qui se produit dans plus de 40 spectacles à travers la France et l\'Europe. Avant son accident, il avait couru le Marathon de New York.</p>', NAVY),
        w_spacer(16),
        w_text('<p>En mai 2018, lors d\'une démonstration de gymnastique pour des enfants malades, il subit un grave traumatisme médullaire : <strong>tétraplégie</strong>. Après 2,5 ans à l\'Institution Nationale des Invalides, il vit aujourd\'hui à domicile avec sa compagne infirmière et leur fille Lyla.</p>', NAVY),
        w_spacer(24),
        w_text('<blockquote style="border-left:3px solid ' . RED . ';padding-left:20px;margin:0"><p style="font-family:Archivo Black;font-size:20px;color:' . BRASS . ';line-height:1.3">« La solidarité transforme ce qui semblait impossible en aventure collective. »</p></blockquote>', BRASS),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
    el_col(50, [
        w_img('Photo principale de Tim<br>→ Remplacer via la médiathèque'),
        w_spacer(24),
        w_img('Photo secondaire — équipe / caserne<br>→ Remplacer via la médiathèque'),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '24', 'bottom' => '0', 'left' => '24', 'isLinked' => false],
    ]),
], ['_element_id' => 'story']);

// ════════════════════════════════════════════════════════
// DÉFIS — real Elementor cards
// ════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '80', [
    el_col(100, [
        w_kicker('Les défis', WHITE),
        w_spacer(16),
        w_heading('Quatre défis.<br>Un seul message.', 'h2', WHITE, 40),
        w_spacer(48),

        // Featured: 2026 upcoming
        el_inner([
            el_col(50, [
                w_text('<p style="display:inline-block;font-family:Inter;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:' . BRASS . ';background:rgba(200,150,90,0.15);border-radius:3px;padding:4px 10px">À venir</p>', BRASS, 11),
                w_spacer(12),
                w_heading('Marathon de l\'Espace', 'h3', WHITE, 28, 1.15),
                w_spacer(8),
                w_text('<p style="font-family:Inter;font-size:13px;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:1px;font-weight:500">29 mars 2026 · Kourou, Guyane française</p>', 'rgba(255,255,255,0.5)', 13),
                w_spacer(12),
                w_text('<p>42,195 km en relais à travers la forêt amazonienne. 5 coureurs + arrivée ensemble. Depuis 1991, cette course se déroule autour des complexes de lancement Ariane — là où la BSPP détache des pompiers en mission.</p>', WHITE, 15),
                w_spacer(12),
                w_text('<ul style="list-style:none;padding:0;margin:0;color:rgba(255,255,255,0.7);font-family:Inter;font-size:14px;line-height:2.2">
<li>Relais 1 — 9,360 km</li>
<li>Relais 2 — 7,640 km</li>
<li>Relais 3 — 8,080 km</li>
<li>Relais 4 — 7,760 km</li>
<li>Relais 5 — 7,580 km</li>
<li>Arrivée ensemble — 1,775 km</li>
</ul>', 'rgba(255,255,255,0.7)', 14),
            ], [
                'content_position' => 'top',
                'background_background' => 'classic',
                'background_color' => 'rgba(255,255,255,0.05)',
                'border_radius' => ['unit' => 'px', 'top' => 8, 'right' => 8, 'bottom' => 8, 'left' => 8, 'isLinked' => true],
                'padding' => ['unit' => 'px', 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'isLinked' => false],
            ]),
            el_col(50, [
                w_img('Photo · Marathon de l\'Espace<br>ou visuel Kourou / Ariane<br>→ Remplacer via la médiathèque'),
            ], [
                'content_position' => 'middle',
                'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '24', 'isLinked' => false],
            ]),
        ], ['padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '32', 'left' => '0', 'isLinked' => false]]),

        // Archive
        w_spacer(24),
        w_heading('Les défis précédents', 'h3', 'rgba(255,255,255,0.6)', 20),
        w_spacer(24),
        el_inner([
            el_col(33, [
                w_text('<p style="font-family:Inter;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,0.35)">Terminé · 2025</p>', 'rgba(255,255,255,0.35)', 11),
                w_spacer(8),
                w_heading('Bleuet de France', 'h4', WHITE, 18, 1.2),
                w_spacer(8),
                w_text('<p>Course en soutien au Bleuet de France, en hommage aux soldats blessés et aux victimes civiles de guerre.</p>', 'rgba(255,255,255,0.65)', 14),
            ], [
                'content_position' => 'top',
                'background_background' => 'classic',
                'background_color' => 'rgba(255,255,255,0.04)',
                'border_radius' => ['unit' => 'px', 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true],
                'padding' => ['unit' => 'px', 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'isLinked' => false],
            ]),
            el_col(33, [
                w_text('<p style="font-family:Inter;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,0.35)">Terminé · 2023</p>', 'rgba(255,255,255,0.35)', 11),
                w_spacer(8),
                w_heading('Tunnel to Towers', 'h4', WHITE, 18, 1.2),
                w_spacer(8),
                w_text('<p>5K Run à New York aux côtés de pompiers américains, en souvenir des 343 pompiers tombés le 11 septembre 2001.</p>', 'rgba(255,255,255,0.65)', 14),
            ], [
                'content_position' => 'top',
                'background_background' => 'classic',
                'background_color' => 'rgba(255,255,255,0.04)',
                'border_radius' => ['unit' => 'px', 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true],
                'padding' => ['unit' => 'px', 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'isLinked' => false],
            ]),
            el_col(33, [
                w_text('<p style="font-family:Inter;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,0.35)">Terminé · 2021</p>', 'rgba(255,255,255,0.35)', 11),
                w_spacer(8),
                w_heading('Tunnel to Towers', 'h4', WHITE, 18, 1.2),
                w_spacer(8),
                w_text('<p>Premier défi pour Tim — 5K Run à New York en tenue de pompier, pour honorer les héros du 11 septembre.</p>', 'rgba(255,255,255,0.65)', 14),
            ], [
                'content_position' => 'top',
                'background_background' => 'classic',
                'background_color' => 'rgba(255,255,255,0.04)',
                'border_radius' => ['unit' => 'px', 'top' => 6, 'right' => 6, 'bottom' => 6, 'left' => 6, 'isLinked' => true],
                'padding' => ['unit' => 'px', 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'isLinked' => false],
            ]),
        ]),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'defis']);

// ════════════════════════════════════════════════════════
// MEMBRES
// ════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '80', [
    el_col(100, [
        w_kicker('L\'équipe'),
        w_spacer(16),
        w_heading('Qui compose le collectif.', 'h2', NAVY, 40),
        w_spacer(48),
        el_inner([
            el_col(25, [w_counter(12, 'Sapeurs-pompiers de Paris')]),
            el_col(25, [w_counter(6,  'Anciens pompiers')]),
            el_col(25, [w_counter(5,  'Civils &amp; famille')]),
            el_col(25, [w_counter(3,  'Enfants')]),
        ]),
        w_spacer(48),
        el_inner([
            el_col(50, [
                w_heading('Adjudant-Chef Benjamin GUY', 'h3', NAVY, 20, 1.3),
                w_spacer(4),
                w_text('<p><strong>Responsable projet</strong><br>06 69 65 81 45<br>benjamin.guy@pompiersparis.fr</p>', NAVY, 15),
            ], ['content_position' => 'top']),
            el_col(50, [
                w_heading('Timothé Bernardeau', 'h3', NAVY, 20, 1.3),
                w_spacer(4),
                w_text('<p><strong>Coordinateur</strong><br>06 22 16 24 33<br>bernardeau.t@gmail.com</p>', NAVY, 15),
            ], ['content_position' => 'top']),
        ]),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'members']);

// ════════════════════════════════════════════════════════
// MÉCÉNAT
// ════════════════════════════════════════════════════════
$page[] = el_section(WHITE, '80', [
    el_col(58, [
        w_kicker('Mécénat'),
        w_spacer(16),
        w_heading('Associez votre nom à ce projet.', 'h2', NAVY, 40),
        w_spacer(24),
        w_text('<p>En devenant mécène, vous associez votre marque aux valeurs de <strong>Fraternité · Cohésion · Solidarité</strong> qui guident la BSPP. Chèque à l\'ordre de <em>ASASPP</em> ou contact direct pour le dossier de partenariat.</p>', NAVY),
        w_spacer(24),
        w_text('<ul style="list-style:none;padding:0;margin:0;font-family:Inter;font-size:16px;color:' . NAVY . ';line-height:2">
<li style="padding:8px 0;border-bottom:1px solid rgba(11,27,61,0.1)">✓ &nbsp;Logo sur tous les supports publicitaires de la course</li>
<li style="padding:8px 0;border-bottom:1px solid rgba(11,27,61,0.1)">✓ &nbsp;Visibilité lors des démonstrations de gymnastique BSPP partout en France</li>
<li style="padding:8px 0;border-bottom:1px solid rgba(11,27,61,0.1)">✓ &nbsp;Présence sur les réseaux sociaux avant, pendant et après l\'événement</li>
<li style="padding:8px 0">✓ &nbsp;Bannière sponsor portée lors du Marathon de l\'Espace à Kourou</li>
</ul>', NAVY),
        w_spacer(32),
        w_button('Contacter l\'équipe', '#contact', RED, 'lg'),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
    el_col(42, [
        w_heading('Budget prévisionnel', 'h3', NAVY, 24),
        w_spacer(16),
        w_text('<table style="width:100%;border-collapse:collapse;font-family:Inter;font-size:15px;color:' . NAVY . '">
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Vols (24 éco. + 3 PMR)</td><td style="padding:10px 0;text-align:right">25 000 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Hébergement (26+1 PMR)</td><td style="padding:10px 0;text-align:right">12 000 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Restauration</td><td style="padding:10px 0;text-align:right">4 680 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Transport sur place</td><td style="padding:10px 0;text-align:right">2 650 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Inscription + équipement</td><td style="padding:10px 0;text-align:right">3 350 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Tenues équipe (6 jours)</td><td style="padding:10px 0;text-align:right">4 600 €</td></tr>
<tr style="border-bottom:2px solid ' . NAVY . '"><td style="padding:10px 0;font-weight:700">Total</td><td style="padding:10px 0;text-align:right;font-weight:700">52 780 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Apport propre</td><td style="padding:10px 0;text-align:right">10 000 €</td></tr>
<tr><td style="padding:10px 0;font-weight:700;color:' . RED . '">Besoin de financement</td><td style="padding:10px 0;text-align:right;font-weight:700;color:' . RED . '">42 780 €</td></tr>
</table>', NAVY, 15),
        w_spacer(16),
        w_text('<p style="font-family:Inter;font-size:12px;color:rgba(11,27,61,0.5)">Don par chèque à l\'ordre de ASASPP<br>BSPP — Caserne Masséna, 3 rue Darmesteter, 75013 Paris</p>', 'rgba(11,27,61,0.5)', 12),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '24', 'isLinked' => false],
    ]),
], ['_element_id' => 'mecenat']);

// ════════════════════════════════════════════════════════
// SENS
// ════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '80', [
    el_col(100, [
        w_kicker('Pourquoi ce défi', WHITE),
        w_spacer(16),
        w_heading('Le sens de chaque kilomètre.', 'h2', WHITE, 40),
        w_spacer(24),
        w_text('<p>Tim avait couru le Marathon de New York avant son accident. Un marathon en relais, c\'est différent — mais cela prouve que tout reste possible. Que la solidarité transforme l\'impossible en aventure collective.</p>', WHITE),
        w_spacer(16),
        w_text('<p>Kourou accueille un détachement de la BSPP. Aller courir là-bas, c\'est aussi aller serrer la main à des frères en mission loin de Paris. Chaque kilomètre couru est un message : <strong style="color:' . BRASS . '">vous n\'êtes pas seuls.</strong></p>', WHITE),
        w_spacer(32),
        w_text('<blockquote style="border-left:3px solid ' . RED . ';padding:16px 0 16px 24px;margin:0"><p style="font-family:Archivo Black;font-size:22px;color:' . BRASS . ';line-height:1.3;margin:0">« Force et courage, Tim. Nous courrons pour toi. »</p></blockquote>', BRASS),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'sens']);

// ════════════════════════════════════════════════════════
// HELP — donation (real widgets)
// ════════════════════════════════════════════════════════
$page[] = el_section(RED, '80', [
    el_col(55, [
        w_kicker('Collecte de fonds', 'rgba(255,255,255,0.7)'),
        w_spacer(16),
        w_heading('Soutenir le défi.', 'h2', WHITE, 48, 1.0),
        w_spacer(24),
        w_text('<p>Chaque don contribue directement au financement du voyage et permet à Tim et sa famille d\'être présents à Kourou pour vivre ce moment aux côtés de l\'équipe.</p>', WHITE),
        w_spacer(16),
        w_text('<p><strong>HelloAsso</strong> : plateforme 100 % gratuite pour les associations. 100 % de votre don revient à l\'équipe — HelloAsso est financé par le pourboire facultatif des donateurs.</p>', 'rgba(255,255,255,0.85)', 15),
        w_spacer(32),
        w_button('Faire un don via HelloAsso', 'https://www.helloasso.com', WHITE, 'xl', 'left'),
        w_spacer(8),
        w_text('<p style="font-family:Inter;font-size:13px;color:rgba(255,255,255,0.6)">Paiement sécurisé · CB, Visa, Mastercard</p>', 'rgba(255,255,255,0.6)', 13),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
    el_col(45, [
        w_heading('Don par chèque', 'h3', WHITE, 20),
        w_spacer(12),
        w_text('<p>Chèque à l\'ordre de : <strong>ASASPP</strong><br>BSPP — Caserne Masséna<br>3 rue Darmesteter · 75013 Paris</p>', 'rgba(255,255,255,0.85)', 15),
        w_spacer(28),
        w_heading('Don par virement', 'h3', WHITE, 20),
        w_spacer(12),
        w_text('<p>Coordonnées bancaires disponibles sur demande — contactez-nous via le formulaire ci-dessous.</p>', 'rgba(255,255,255,0.85)', 15),
    ], [
        'content_position' => 'top',
        'background_background' => 'classic',
        'background_color' => 'rgba(0,0,0,0.12)',
        'border_radius' => ['unit' => 'px', 'top' => 8, 'right' => 8, 'bottom' => 8, 'left' => 8, 'isLinked' => true],
        'padding' => ['unit' => 'px', 'top' => '40', 'right' => '40', 'bottom' => '40', 'left' => '40', 'isLinked' => false],
        'margin' => ['unit' => 'px', 'right' => '48', 'left' => '0', 'isLinked' => false],
    ]),
], ['_element_id' => 'help']);

// ════════════════════════════════════════════════════════
// PROGRESS (real widgets)
// ════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '80', [
    el_col(100, [
        w_kicker('La collecte', WHITE),
        w_spacer(16),
        w_heading('Où en sommes-nous ?', 'h2', WHITE, 40),
        w_spacer(40),
        el_inner([
            el_col(33, [w_counter(0,     'Collecté',    ' €',  '', RED, WHITE)]),
            el_col(33, [w_counter(0,     'Donateurs',   '',    '', RED, WHITE)]),
            el_col(33, [w_counter(42780, 'Objectif',    ' €',  '', RED, WHITE)]),
        ]),
        w_spacer(40),
        w_progress(0, 'Avancement de la collecte — 0 %'),
        w_spacer(16),
        w_text('<p style="text-align:center;font-family:Inter;font-size:13px;color:rgba(255,255,255,0.4)">Pour mettre à jour : cliquez sur les chiffres directement dans l\'éditeur Elementor, puis modifiez la valeur et la barre de progression.</p>', 'rgba(255,255,255,0.4)', 13),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'progress']);

// ════════════════════════════════════════════════════════
// SPONSORS (real widgets)
// ════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '80', [
    el_col(100, [
        w_kicker('Partenaires'),
        w_spacer(16),
        w_heading('Mécènes & partenaires.', 'h2', NAVY, 40),
        w_spacer(16),
        w_text('<p>Ils font partie de l\'aventure et associent leur image aux valeurs portées par l\'équipe.</p>', NAVY),
        w_spacer(48),
        el_inner([
            el_col(25, [w_img('Logo mécène 1<br>→ Cliquer → Changer l\'image')]),
            el_col(25, [w_img('Logo mécène 2<br>→ Cliquer → Changer l\'image')]),
            el_col(25, [w_img('Logo mécène 3<br>→ Cliquer → Changer l\'image')]),
            el_col(25, [w_img('Logo mécène 4<br>→ Cliquer → Changer l\'image')]),
        ], ['padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '32', 'left' => '0', 'isLinked' => false]]),
        w_spacer(16),
        w_text('<p style="text-align:center;font-family:Inter;font-size:15px;color:rgba(11,27,61,0.6)">Votre entreprise peut rejoindre l\'aventure — <a href="#contact" style="color:' . RED . ';font-weight:600">contactez-nous</a> pour le dossier de partenariat.</p>', 'rgba(11,27,61,0.6)', 15),
        w_spacer(24),
        w_button('Devenir partenaire', '#contact', RED, 'lg', 'center'),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'sponsors']);

// ════════════════════════════════════════════════════════
// FAQ (Elementor accordion widget)
// ════════════════════════════════════════════════════════
$page[] = el_section(WHITE, '80', [
    el_col(100, [
        w_kicker('Questions fréquentes'),
        w_spacer(16),
        w_heading('Vous avez des questions ?', 'h2', NAVY, 40),
        w_spacer(40),
        w_accordion([
            [
                'Comment faire un don ?',
                'Le moyen le plus simple est de cliquer sur "Faire un don via HelloAsso" — c\'est gratuit, sécurisé, et 100 % de votre don revient à l\'équipe. Vous pouvez aussi envoyer un chèque à l\'ordre de <strong>ASASPP</strong>, à l\'adresse : BSPP — Caserne Masséna, 3 rue Darmesteter, 75013 Paris.',
            ],
            [
                'Puis-je obtenir un reçu fiscal ?',
                'L\'ASASPP est une association. Les dons peuvent ouvrir droit à une réduction d\'impôt selon votre situation. Contactez l\'équipe via le formulaire pour plus d\'informations sur les justificatifs disponibles.',
            ],
            [
                'Où va mon don exactement ?',
                'Le financement couvre les frais réels du voyage : vols (dont 3 en classe affaires pour l\'accessibilité PMR de Tim), hébergement, restauration, transport adapté, inscription à la course et équipement de l\'équipe. L\'objectif est de permettre à Tim et sa famille d\'être présents à Kourou le 29 mars 2026.',
            ],
            [
                'Qui organise ce défi ?',
                'Le défi est organisé par l\'<strong>Adjudant-Chef Benjamin GUY</strong> et coordonné par <strong>Timothé Bernardeau</strong> lui-même, sous l\'égide de l\'ASASPP (Association de Soutien à l\'Action Sociale des Sapeurs-Pompiers de Paris).',
            ],
            [
                'Comment devenir sponsor ou partenaire ?',
                'Contactez Benjamin GUY (benjamin.guy@pompiersparis.fr / 06 69 65 81 45) ou utilisez le formulaire de contact ci-dessous. Un dossier de partenariat vous sera envoyé avec les contreparties selon le niveau de mécénat.',
            ],
            [
                'Comment rester informé de l\'avancement ?',
                'Suivez l\'équipe sur les réseaux sociaux (Instagram, Facebook, LinkedIn) pour des mises à jour avant, pendant et après le Marathon de l\'Espace. Le site est mis à jour après chaque étape.',
            ],
        ]),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'faq']);

// ════════════════════════════════════════════════════════
// CONTACT (real widgets + shortcode for form only)
// ════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '80', [
    el_col(100, [
        w_kicker('Contact', WHITE),
        w_spacer(16),
        w_heading('Nous contacter.', 'h2', WHITE, 40),
        w_spacer(48),
        el_inner([
            el_col(50, [
                w_text('<div style="background:rgba(255,255,255,0.06);border-radius:8px;padding:28px">
<p style="font-family:Archivo Black;font-size:18px;color:' . WHITE . ';margin:0 0 4px">Benjamin GUY</p>
<p style="font-family:Inter;font-size:12px;color:' . BRASS . ';text-transform:uppercase;letter-spacing:1px;font-weight:600;margin:0 0 16px">Adjudant-Chef · Responsable projet</p>
<p style="font-family:Inter;font-size:15px;color:rgba(255,255,255,0.8);margin:0 0 6px">📞 06 69 65 81 45</p>
<p style="font-family:Inter;font-size:15px;color:rgba(255,255,255,0.8);margin:0">✉ benjamin.guy@pompiersparis.fr</p>
</div>', WHITE, 15),
                w_spacer(16),
                w_text('<div style="background:rgba(255,255,255,0.06);border-radius:8px;padding:28px">
<p style="font-family:Archivo Black;font-size:18px;color:' . WHITE . ';margin:0 0 4px">Timothé Bernardeau</p>
<p style="font-family:Inter;font-size:12px;color:' . BRASS . ';text-transform:uppercase;letter-spacing:1px;font-weight:600;margin:0 0 16px">Coordinateur</p>
<p style="font-family:Inter;font-size:15px;color:rgba(255,255,255,0.8);margin:0 0 6px">📞 06 22 16 24 33</p>
<p style="font-family:Inter;font-size:15px;color:rgba(255,255,255,0.8);margin:0">✉ bernardeau.t@gmail.com</p>
</div>', WHITE, 15),
                w_spacer(24),
                w_text('<p style="font-family:Inter;font-size:13px;color:rgba(255,255,255,0.35)">BSPP — Caserne Masséna · 3 rue Darmesteter · 75013 Paris</p>', 'rgba(255,255,255,0.35)', 13),
                w_spacer(16),
                el_widget('social-icons', [
                    'social_icon_list' => [
                        ['_id' => uid(), 'social_icon' => ['value' => 'fab fa-instagram', 'library' => 'fa-brands'], 'link' => ['url' => 'https://www.instagram.com/', 'is_external' => 'on'], 'item_icon_color' => 'custom', 'icon_primary_color' => RED, 'icon_secondary_color' => WHITE],
                        ['_id' => uid(), 'social_icon' => ['value' => 'fab fa-facebook',  'library' => 'fa-brands'], 'link' => ['url' => 'https://www.facebook.com/',  'is_external' => 'on'], 'item_icon_color' => 'custom', 'icon_primary_color' => RED, 'icon_secondary_color' => WHITE],
                        ['_id' => uid(), 'social_icon' => ['value' => 'fab fa-linkedin',   'library' => 'fa-brands'], 'link' => ['url' => 'https://www.linkedin.com/',   'is_external' => 'on'], 'item_icon_color' => 'custom', 'icon_primary_color' => RED, 'icon_secondary_color' => WHITE],
                        ['_id' => uid(), 'social_icon' => ['value' => 'fab fa-youtube',    'library' => 'fa-brands'], 'link' => ['url' => 'https://www.youtube.com/',    'is_external' => 'on'], 'item_icon_color' => 'custom', 'icon_primary_color' => RED, 'icon_secondary_color' => WHITE],
                    ],
                    'icon_size'  => ['unit' => 'px', 'size' => 20, 'sizes' => []],
                    'shape'      => 'circle',
                    'color_type' => 'custom',
                ]),
            ], ['content_position' => 'top']),
            el_col(50, [
                w_text('<p style="font-family:Inter;font-weight:600;font-size:16px;color:' . WHITE . ';margin:0 0 20px">Envoyez-nous un message</p>', WHITE, 16),
                el_widget('shortcode', ['shortcode' => '[defitim_contact]']),
            ], [
                'content_position' => 'top',
                'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '40', 'isLinked' => false],
            ]),
        ]),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'contact']);

// ════════════════════════════════════════════════════════
// FOOTER
// ════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '32', [
    el_col(50, [
        w_heading('Un Défi pour <span style="color:' . RED . '">Tim</span>', 'div', WHITE, 16, 1.3),
        w_spacer(8),
        w_text('<p>Brigade de Sapeurs-Pompiers de Paris<br>Caserne Masséna · 3 rue Darmesteter · 75013 Paris</p>', 'rgba(255,255,255,0.45)', 13),
    ], ['content_position' => 'middle']),
    el_col(50, [
        w_text('<p style="text-align:right;font-family:Inter;font-size:12px;color:rgba(255,255,255,0.35)">© 2026 Un Défi pour Tim — Association ASASPP<br><a href="/mentions-legales" style="color:rgba(255,255,255,0.35);text-decoration:underline">Mentions légales</a> · <a href="/confidentialite" style="color:rgba(255,255,255,0.35);text-decoration:underline">Confidentialité</a></p>',
            'rgba(255,255,255,0.35)', 12),
    ], ['content_position' => 'middle']),
], [
    'css_classes' => 'dt-footer',
    'padding'     => ['unit' => 'px', 'top' => '32', 'right' => '48', 'bottom' => '32', 'left' => '48', 'isLinked' => false],
]);

// ─── Save to WordPress ────────────────────────────────────────────────────────
$front_page_id = (int) get_option('page_on_front');
if (!$front_page_id) {
    WP_CLI::error('page_on_front is not set.');
    exit;
}

$json = wp_json_encode($page);
update_post_meta($front_page_id, '_elementor_data',          $json);
update_post_meta($front_page_id, '_elementor_edit_mode',     'builder');
update_post_meta($front_page_id, '_elementor_template_type', 'wp-page');
update_post_meta($front_page_id, '_wp_page_template',        'elementor_canvas');
delete_post_meta($front_page_id, '_elementor_css');

if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

WP_CLI::success(sprintf('Page built: %d sections · %d bytes of JSON', count($page), strlen($json)));
WP_CLI::log("Edit in Elementor → https://undefipourtim.com/wp-admin/post.php?post={$front_page_id}&action=elementor");
