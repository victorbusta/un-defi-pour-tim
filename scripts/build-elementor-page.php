<?php
/**
 * Elementor page builder — Un Défi pour Tim
 * Generates the full home page structure and inserts it into WordPress.
 *
 * Run on server:
 *   wp eval-file /var/www/html/wp-content/themes/defitim/scripts/build-elementor-page.php \
 *     --path=/var/www/html --allow-root
 */

// ─── Palette ────────────────────────────────────────────────────────────────
define('NAVY',  '#0B1B3D');
define('RED',   '#E63329');
define('CREAM', '#F4EFE6');
define('BRASS', '#C8965A');
define('WHITE', '#FFFFFF');

// ─── ID factory ─────────────────────────────────────────────────────────────
$_used_ids = [];
function uid() {
    global $_used_ids;
    $c = 'abcdefghijklmnopqrstuvwxyz0123456789';
    do { $id = ''; for ($i = 0; $i < 7; $i++) $id .= $c[random_int(0, 35)]; }
    while (isset($_used_ids[$id]));
    $_used_ids[$id] = 1;
    return $id;
}

// ─── Structural helpers ──────────────────────────────────────────────────────
function el_section(string $bg, string $pv, array $cols, array $extra = []): array {
    return array_merge([
        'id'       => uid(),
        'elType'   => 'section',
        'isInner'  => false,
        'settings' => array_merge([
            'stretch_section'  => 'section-stretched',
            'content_width'    => ['unit' => 'px', 'size' => 1200],
            'gap'              => 'no',
            'background_background' => 'classic',
            'background_color' => $bg,
            'padding'          => ['unit' => 'px', 'top' => $pv, 'right' => '0', 'bottom' => $pv, 'left' => '0', 'isLinked' => false],
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

// ─── Widget shortcuts ────────────────────────────────────────────────────────
function w_heading(string $text, string $tag, string $color, int $px, float $lh = 1.1): array {
    return el_widget('heading', [
        'title'                       => $text,
        'header_size'                 => $tag,
        'title_color'                 => $color,
        'typography_typography'       => 'custom',
        'typography_font_family'      => 'Archivo Black',
        'typography_font_weight'      => '400',
        'typography_font_size'        => ['unit' => 'px', 'size' => $px, 'sizes' => []],
        'typography_line_height'      => ['unit' => 'em', 'size' => $lh, 'sizes' => []],
    ]);
}

function w_text(string $html, string $color = NAVY, int $px = 18): array {
    return el_widget('text-editor', [
        'editor'                   => $html,
        'text_color'               => $color,
        'typography_typography'    => 'custom',
        'typography_font_family'   => 'Inter',
        'typography_font_weight'   => '400',
        'typography_font_size'     => ['unit' => 'px', 'size' => $px, 'sizes' => []],
        'typography_line_height'   => ['unit' => 'em', 'size' => 1.6, 'sizes' => []],
    ]);
}

function w_kicker(string $text): array {
    return w_text(
        '<p style="font-family:Inter;font-weight:500;font-size:12px;text-transform:uppercase;letter-spacing:2px;color:' . BRASS . '">' . $text . '</p>',
        BRASS, 12
    );
}

function w_spacer(int $px): array {
    return el_widget('spacer', ['space' => ['unit' => 'px', 'size' => $px, 'sizes' => []]]);
}

function w_button(string $label, string $url, string $bg = RED, string $size = 'md', string $align = 'left'): array {
    return el_widget('button', [
        'text'                         => $label,
        'link'                         => ['url' => $url, 'is_external' => '', 'nofollow' => ''],
        'size'                         => $size,
        'align'                        => $align,
        'button_background_color'      => $bg,
        'button_text_color'            => WHITE,
        'border_radius'                => ['unit' => 'px', 'top' => 4, 'right' => 4, 'bottom' => 4, 'left' => 4, 'isLinked' => true],
        'typography_typography'        => 'custom',
        'typography_font_family'       => 'Inter',
        'typography_font_weight'       => '700',
        'typography_font_size'         => ['unit' => 'px', 'size' => 13, 'sizes' => []],
        'typography_letter_spacing'    => ['unit' => 'px', 'size' => 1, 'sizes' => []],
        'typography_text_transform'    => 'uppercase',
    ]);
}

function w_counter(int $end, string $label, string $suffix = '', string $prefix = ''): array {
    return el_widget('counter', [
        'starting_number'                   => 0,
        'ending_number'                     => $end,
        'suffix'                            => $suffix,
        'prefix'                            => $prefix,
        'title'                             => $label,
        'number_color'                      => RED,
        'title_color'                       => NAVY,
        'typography_typography'             => 'custom',
        'typography_font_family'            => 'Archivo Black',
        'typography_font_weight'            => '400',
        'typography_font_size'              => ['unit' => 'px', 'size' => 40, 'sizes' => []],
        'title_typography_typography'       => 'custom',
        'title_typography_font_family'      => 'Inter',
        'title_typography_font_size'        => ['unit' => 'px', 'size' => 12, 'sizes' => []],
        'title_typography_font_weight'      => '500',
        'title_typography_text_transform'   => 'uppercase',
        'title_typography_letter_spacing'   => ['unit' => 'px', 'size' => 1, 'sizes' => []],
    ]);
}

function w_shortcode(string $code): array {
    return el_widget('shortcode', ['shortcode' => $code]);
}

function w_image_placeholder(string $note): array {
    return w_text(
        '<p style="text-align:center;padding:48px 24px;background:rgba(200,150,90,0.08);border:2px dashed ' . BRASS . ';border-radius:8px;color:' . BRASS . ';font-family:JetBrains Mono,monospace;font-size:13px;line-height:1.6">' . $note . '</p>',
        BRASS, 13
    );
}

// ─── Build page ──────────────────────────────────────────────────────────────
$menu_obj = wp_get_nav_menu_object('Navigation principale');
$menu_id  = $menu_obj ? (int) $menu_obj->term_id : 0;

$page = [];

// ════════════════════════════════════════════════════════════════════════════
// NAVIGATION (fixed top bar)
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '14', [
    el_col(18, [
        w_heading(
            'Un Défi<br>pour <span style="color:' . RED . '">Tim</span>',
            'div', WHITE, 13, 1.15
        ),
    ], ['content_position' => 'middle']),
    el_col(64, [
        el_widget('nav-menu', [
            'menu'                                  => $menu_id,
            'layout'                                => 'horizontal',
            'pointer'                               => 'none',
            'style_color'                           => WHITE,
            'style_color_hover'                     => RED,
            'style_typography_typography'           => 'custom',
            'style_typography_font_family'          => 'Inter',
            'style_typography_font_size'            => ['unit' => 'px', 'size' => 12, 'sizes' => []],
            'style_typography_font_weight'          => '500',
            'style_typography_text_transform'       => 'uppercase',
            'style_typography_letter_spacing'       => ['unit' => 'px', 'size' => 1, 'sizes' => []],
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

// ════════════════════════════════════════════════════════════════════════════
// HERO
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '100', [
    el_col(55, [
        w_spacer(60),
        w_heading('Un Défi<br>pour <span style="color:' . RED . '">Tim</span>', 'h1', NAVY, 72, 0.95),
        w_spacer(24),
        w_text('<p>Corporal Timothé Bernardeau, sapeur-pompier de Paris, a subi un grave traumatisme lors d\'une démonstration de gymnastique pour des enfants malades. Ses frères d\'armes relèvent des défis sportifs pour lui témoigner leur fraternité et soutenir son accompagnement.</p>', NAVY),
        w_spacer(40),
        el_inner([
            el_col(25, [w_counter(4,  'Défis organisés')]),
            el_col(25, [w_counter(26, 'Participants')]),
            el_col(25, [w_counter(42780, 'À collecter', '€')]),
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
        w_image_placeholder('Portrait de Tim<br>→ Cliquer sur ce bloc dans Elementor<br>→ Remplacer par la photo via la médiathèque'),
    ], ['content_position' => 'middle']),
], ['_element_id' => 'hero']);

// ════════════════════════════════════════════════════════════════════════════
// STORY
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '80', [
    el_col(50, [
        w_kicker('Son histoire'),
        w_spacer(16),
        w_heading('Timothé Bernardeau.', 'h2', NAVY, 40),
        w_spacer(24),
        w_text('<p>Né à Nantes, Timothé rejoint la Brigade de Sapeurs-Pompiers de Paris en septembre 2012. Il intègre la 11<sup>e</sup> compagnie du Marais (4<sup>e</sup> arrondissement) comme conducteur de machine. Présent lors des attentats du 13 novembre 2015, il reçoit de nombreuses citations de ses commandants.</p>', NAVY),
        w_spacer(16),
        w_text('<p>En avril 2015, il rejoint le groupe de gymnastique d\'élite de la BSPP — fondé en 1919 — une équipe acrobatique et artistique qui se produit dans plus de 40 spectacles à travers la France et l\'Europe (cirques, stades, salles de spectacle). Avant son accident, il avait couru le Marathon de New York.</p>', NAVY),
        w_spacer(16),
        w_text('<p>En mai 2018, lors d\'une démonstration de gymnastique pour des enfants malades, il subit un grave traumatisme médullaire : <strong>tétraplégie</strong>. Après 2,5 ans à l\'Institution Nationale des Invalides, il vit aujourd\'hui à domicile avec sa compagne infirmière et leur fille Lyla. Il maintient un lien fort avec sa caserne et ses frères d\'armes.</p>', NAVY),
        w_spacer(24),
        w_text('<blockquote style="border-left:3px solid ' . RED . ';padding-left:20px;margin:0"><p style="font-family:Archivo Black;font-size:20px;color:' . BRASS . ';line-height:1.3">« La solidarité transforme ce qui semblait impossible en aventure collective. »</p></blockquote>', BRASS),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
    el_col(50, [
        w_image_placeholder('Photo principale<br>→ Tim en action ou portrait<br>→ Remplacer via la médiathèque'),
        w_spacer(24),
        w_image_placeholder('Photo secondaire<br>→ Équipe, caserne, gymnastes<br>→ Remplacer via la médiathèque'),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '24', 'bottom' => '0', 'left' => '24', 'isLinked' => false],
    ]),
], ['_element_id' => 'story']);

// ════════════════════════════════════════════════════════════════════════════
// DÉFIS (shortcode — CPT driven)
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '80', [
    el_col(100, [w_shortcode('[defitim_defis]')]),
], ['_element_id' => 'defis']);

// ════════════════════════════════════════════════════════════════════════════
// MEMBRES
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '80', [
    el_col(100, [
        w_kicker('L\'équipe'),
        w_spacer(16),
        w_heading('Qui compose le collectif.', 'h2', NAVY, 40),
        w_spacer(48),
        el_inner([
            el_col(25, [w_counter(12, 'Sapeurs-pompiers de Paris')]),
            el_col(25, [w_counter(6,  'Anciens pompiers de Paris')]),
            el_col(25, [w_counter(5,  'Civils &amp; famille Bernardeau')]),
            el_col(25, [w_counter(3,  'Enfants')]),
        ]),
        w_spacer(48),
        w_heading('Le Bureau', 'h3', NAVY, 28),
        w_spacer(16),
        w_text('<p>L\'association est dirigée par l\'<strong>Adjudant-Chef Benjamin GUY</strong> (responsable projet) et coordonnée par <strong>Timothé Bernardeau</strong> lui-même. Leur mission : transformer chaque défi en moment de fraternité et de soutien concret pour Tim et sa famille.</p>', NAVY),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '48', 'isLinked' => false],
    ]),
], ['_element_id' => 'members']);

// ════════════════════════════════════════════════════════════════════════════
// MÉCÉNAT
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '80', [
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
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Transport sur place (PMR + bus)</td><td style="padding:10px 0;text-align:right">2 650 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Inscription + équipement course</td><td style="padding:10px 0;text-align:right">3 350 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Tenues équipe (6 jours)</td><td style="padding:10px 0;text-align:right">4 600 €</td></tr>
<tr style="border-bottom:2px solid ' . NAVY . '"><td style="padding:10px 0;font-weight:700">Total</td><td style="padding:10px 0;text-align:right;font-weight:700">52 780 €</td></tr>
<tr style="border-bottom:1px solid rgba(11,27,61,0.12)"><td style="padding:10px 0">Apport propre</td><td style="padding:10px 0;text-align:right">10 000 €</td></tr>
<tr><td style="padding:10px 0;font-weight:700;color:' . RED . '">Besoin de financement</td><td style="padding:10px 0;text-align:right;font-weight:700;color:' . RED . '">42 780 €</td></tr>
</table>', NAVY, 15),
        w_spacer(24),
        w_text('<p style="font-family:JetBrains Mono,monospace;font-size:12px;color:rgba(11,27,61,0.5)">Don par chèque à l\'ordre de ASASPP<br>BSPP — Caserne Masséna, 75013 Paris</p>', 'rgba(11,27,61,0.5)', 12),
    ], [
        'content_position' => 'top',
        'padding' => ['unit' => 'px', 'top' => '0', 'right' => '48', 'bottom' => '0', 'left' => '24', 'isLinked' => false],
    ]),
], ['_element_id' => 'mecenat']);

// ════════════════════════════════════════════════════════════════════════════
// SENS
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '80', [
    el_col(100, [
        w_kicker('Pourquoi ce défi'),
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

// ════════════════════════════════════════════════════════════════════════════
// HELP — donation section (shortcode)
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '0', [
    el_col(100, [w_shortcode('[defitim_help]')]),
], ['_element_id' => 'help']);

// ════════════════════════════════════════════════════════════════════════════
// PROGRESS — fundraising bar (shortcode)
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '0', [
    el_col(100, [w_shortcode('[defitim_progress]')]),
], ['_element_id' => 'progress']);

// ════════════════════════════════════════════════════════════════════════════
// SPONSORS (shortcode)
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '0', [
    el_col(100, [w_shortcode('[defitim_sponsors]')]),
], ['_element_id' => 'sponsors']);

// ════════════════════════════════════════════════════════════════════════════
// FAQ (shortcode)
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(CREAM, '0', [
    el_col(100, [w_shortcode('[defitim_faq]')]),
], ['_element_id' => 'faq']);

// ════════════════════════════════════════════════════════════════════════════
// CONTACT (shortcode)
// ════════════════════════════════════════════════════════════════════════════
$page[] = el_section(NAVY, '0', [
    el_col(100, [w_shortcode('[defitim_contact]')]),
], ['_element_id' => 'contact']);

// ════════════════════════════════════════════════════════════════════════════
// FOOTER
// ════════════════════════════════════════════════════════════════════════════
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
    'border_top'  => ['unit' => 'px', 'top' => '1', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false],
    'border_color'=> 'rgba(255,255,255,0.1)',
]);

// ─── Save to WordPress ───────────────────────────────────────────────────────
$front_page_id = (int) get_option('page_on_front');
if (!$front_page_id) {
    WP_CLI::error('page_on_front is not set. Run: wp option update page_on_front <ID>');
    exit;
}

$json = wp_json_encode($page);

update_post_meta($front_page_id, '_elementor_data',          $json);
update_post_meta($front_page_id, '_elementor_edit_mode',     'builder');
update_post_meta($front_page_id, '_elementor_template_type', 'wp-page');
update_post_meta($front_page_id, '_wp_page_template',        'elementor_canvas'); // no theme header/footer, Elementor owns everything
delete_post_meta($front_page_id, '_elementor_css');           // force CSS regeneration

if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

WP_CLI::success(sprintf('Page built: %d sections · %d bytes of JSON', count($page), strlen($json)));
WP_CLI::log("Edit in Elementor → https://undefipourtim.com/wp-admin/post.php?post={$front_page_id}&action=elementor");
