<?php
/**
 * Build Elementor front page.
 *
 * Strategy:
 *   - Sections 2, 4, 5, 6 → native Elementor widgets (heading, text-editor, button)
 *     for full visual editing in the Elementor sidebar panel.
 *   - Nav, Hero, Help, Contact, Footer → HTML widgets (interactive / CSS-structural).
 *   - Dynamic sections (défis, progress, sponsors, faq) → shortcode widgets.
 *
 * Run: wp eval-file themes/defitim/scripts/build-elementor-page.php --path=/var/www/html --allow-root
 */
defined('ABSPATH') || exit;

$_used_ids = [];
function uid(): string {
    global $_used_ids;
    $c = 'abcdefghijklmnopqrstuvwxyz0123456789';
    do { $id = ''; for ($i = 0; $i < 7; $i++) $id .= $c[random_int(0, 35)]; }
    while (isset($_used_ids[$id]));
    $_used_ids[$id] = 1;
    return $id;
}

// Full-width section with single 100% column.
function el_wrap(array $widgets, array $section_extra = []): array {
    return [
        'id' => uid(), 'elType' => 'section', 'isInner' => false,
        'settings' => array_merge([
            'stretch_section' => 'section-stretched',
            'layout'          => 'full_width',
            'gap'             => 'no',
            'padding'         => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
        ], $section_extra),
        'elements' => [[
            'id' => uid(), 'elType' => 'column', 'isInner' => false,
            'settings' => [
                '_column_size' => 100,
                'padding'      => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
            ],
            'elements' => $widgets,
        ]],
    ];
}

// HTML widget — raw HTML; editable as code in Elementor.
function w_html(string $html): array {
    return ['id' => uid(), 'elType' => 'widget', 'widgetType' => 'html',
            'settings' => ['html' => $html], 'elements' => []];
}

// Shortcode widget.
function w_sc(string $code): array {
    return ['id' => uid(), 'elType' => 'widget', 'widgetType' => 'shortcode',
            'settings' => ['shortcode' => $code], 'elements' => []];
}

// Native heading widget — editable via Elementor sidebar.
function w_heading(string $text, string $tag = 'h2', array $extra_settings = []): array {
    return [
        'id' => uid(), 'elType' => 'widget', 'widgetType' => 'heading',
        'settings' => array_merge([
            'title'                      => $text,
            'header_size'                => $tag,
            'title_color'                => '#0B1B3D',
            'typography_typography'      => 'custom',
            'typography_font_family'     => 'Archivo Black',
            'typography_font_weight'     => '900',
            'typography_font_size'       => ['unit' => 'px', 'size' => 48],
            'typography_font_size_tablet'=> ['unit' => 'px', 'size' => 36],
            'typography_line_height'     => ['unit' => 'em', 'size' => 1.0],
            'typography_letter_spacing'  => ['unit' => 'px', 'size' => -1],
        ], $extra_settings),
        'elements' => [],
    ];
}

// Native text-editor widget — rich-text editable in Elementor sidebar.
function w_text(string $html, array $extra_settings = []): array {
    return [
        'id' => uid(), 'elType' => 'widget', 'widgetType' => 'text-editor',
        'settings' => array_merge([
            'editor'                => $html,
            'text_color'            => '#1A1A1A',
            'typography_typography' => 'custom',
            'typography_font_size'  => ['unit' => 'px', 'size' => 17],
            'typography_line_height'=> ['unit' => 'em', 'size' => 1.6],
        ], $extra_settings),
        'elements' => [],
    ];
}

// Native button widget — editable in Elementor sidebar.
function w_btn(string $text, string $url, string $style = 'primary', array $extra_settings = []): array {
    $styles = [
        'primary' => [
            'background_color'            => '#E63329',
            'button_text_color'           => '#F4EFE6',
            'button_background_color_hover' => '#C2261D',
            'button_text_color_hover'     => '#F4EFE6',
            'border_border'               => 'none',
        ],
        'outline' => [
            'background_color'            => 'transparent',
            'button_text_color'           => '#0B1B3D',
            'button_background_color_hover' => '#0B1B3D',
            'button_text_color_hover'     => '#F4EFE6',
            'border_border'               => 'solid',
            'border_width'                => ['unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true],
            'border_color'                => '#0B1B3D',
        ],
        'outline-light' => [
            'background_color'            => 'transparent',
            'button_text_color'           => '#F4EFE6',
            'button_background_color_hover' => '#F4EFE6',
            'button_text_color_hover'     => '#0B1B3D',
            'border_border'               => 'solid',
            'border_width'                => ['unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true],
            'border_color'                => '#F4EFE6',
        ],
    ];
    return [
        'id' => uid(), 'elType' => 'widget', 'widgetType' => 'button',
        'settings' => array_merge([
            'text'             => $text,
            'link'             => ['url' => $url, 'is_external' => '', 'nofollow' => ''],
            'align'            => 'left',
            'border_radius'    => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true],
            'typography_typography'   => 'custom',
            'typography_font_family'  => 'Archivo Black',
            'typography_font_weight'  => '900',
            'typography_font_size'    => ['unit' => 'px', 'size' => 14],
            'typography_letter_spacing' => ['unit' => 'em', 'size' => .04],
            'typography_text_transform' => 'uppercase',
            'padding'          => ['unit' => 'px', 'top' => '14', 'right' => '22', 'bottom' => '14', 'left' => '22', 'isLinked' => false],
        ], $styles[$style] ?? $styles['primary'], $extra_settings),
        'elements' => [],
    ];
}

// 2-column Elementor section.
function el_2col(
    array $left, array $right,
    int   $left_pct = 50,
    array $sec = [],
    array $left_col = [],
    array $right_col = []
): array {
    return [
        'id' => uid(), 'elType' => 'section', 'isInner' => false,
        'settings' => array_merge([
            'stretch_section' => 'section-stretched',
            'layout'          => 'full_width',
            'gap'             => 'no',
        ], $sec),
        'elements' => [
            [
                'id' => uid(), 'elType' => 'column', 'isInner' => false,
                'settings' => array_merge(['_column_size' => $left_pct], $left_col),
                'elements' => $left,
            ],
            [
                'id' => uid(), 'elType' => 'column', 'isInner' => false,
                'settings' => array_merge(['_column_size' => 100 - $left_pct], $right_col),
                'elements' => $right,
            ],
        ],
    ];
}

// Set Elementor global container width so boxed sections center at 1320px.
$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();
if ($kit) {
    $kit->update_settings(['container_width' => ['unit' => 'px', 'size' => 1320]]);
}

// ── Shared assets ──────────────────────────────────────────
$arrow = '<svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>';

// ═══════════════════════════════════════════════════════════
// BUILD PAGE
// ═══════════════════════════════════════════════════════════
$page = [];

// ══ 0 — NAV ════════════════════════════════════════════════
$page[] = el_wrap([w_html(
    '<header class="topbar" role="banner">' .
    '<div class="topbar-inner">' .
    '<a href="/" class="brand">' .
    '<span class="brand-mark" aria-hidden="true"><span class="brand-mark-bar"></span><span class="brand-mark-bar"></span><span class="brand-mark-bar"></span></span>' .
    '<span class="brand-text"><span class="brand-defi">DÉFI</span><span class="brand-tim">TIM</span></span>' .
    '</a>' .
    '<nav class="nav" aria-label="Navigation principale">' .
    '<a href="#story">L\'Histoire</a>' .
    '<a href="#defis">Les Défis</a>' .
    '<a href="#members">Membres</a>' .
    '<a href="#mecenat">Mécénat</a>' .
    '<a href="#faq">FAQ</a>' .
    '<a href="#contact">Contact</a>' .
    '</nav>' .
    '<div class="topbar-right">' .
    '<div class="lang-switch" role="group" aria-label="Language"><span class="lang-btn active">FR</span></div>' .
    '<a href="#help" class="btn btn-primary btn-sm">Faire un don ' . $arrow . '</a>' .
    '<button class="nav-toggle" aria-label="Menu" aria-expanded="false" aria-controls="nav-mobile"><span></span><span></span><span></span></button>' .
    '</div>' .
    '</div>' .
    '<nav class="nav-mobile" id="nav-mobile" aria-label="Menu mobile" hidden>' .
    '<a href="#story">L\'Histoire</a>' .
    '<a href="#defis">Les Défis</a>' .
    '<a href="#members">Membres</a>' .
    '<a href="#mecenat">Mécénat</a>' .
    '<a href="#faq">FAQ</a>' .
    '<a href="#contact">Contact</a>' .
    '<a href="#help" class="btn btn-primary">Faire un don</a>' .
    '</nav>' .
    '</header>'
)]);

// ══ 1 — HERO ═══════════════════════════════════════════════
$ticker_chunk = '<span>Brigade de Sapeurs-Pompiers de Paris <span class="ticker-dot">●</span> Sport · Culture · Solidarité <span class="ticker-dot">●</span> Depuis 2018 <span class="ticker-dot">●</span></span>';
$ticker_track = str_repeat($ticker_chunk, 8);

$page[] = el_wrap([w_html(
    '<section class="hero" id="hero">' .
    '<div class="ticker ticker-top" aria-hidden="true"><div class="ticker-track">' . $ticker_track . '</div></div>' .
    '<div class="hero-inner">' .
    '<div class="hero-left">' .
    '<div class="kicker"><span class="kicker-dot" style="background:var(--accent)"></span><span>Le collectif · Depuis 2018</span></div>' .
    '<h1 class="hero-title">' .
    '<span class="hero-line">On ne lâche</span>' .
    '<span class="hero-line">pas Tim.</span>' .
    '<span class="hero-line"><span class="hero-mark">Jamais.</span></span>' .
    '</h1>' .
    '<p class="hero-lede">Un Défi pour Tim, c\'est un collectif qui organise toute l\'année des défis sportifs et culturels autour du caporal Timothé Bernardeau, ancien sapeur-pompier de Paris devenu tétraplégique en service.</p>' .
    '<div class="hero-ctas">' .
    '<a href="#help" class="btn btn-primary btn-lg">Soutenir les défis ' . $arrow . '</a>' .
    '<a href="#story" class="btn btn-ghost btn-lg">Lire son histoire</a>' .
    '</div>' .
    '<div class="hero-meta">' .
    '<div class="hero-meta-chip"><span class="hero-meta-sq"></span> Brigade de Sapeurs-Pompiers de Paris</div>' .
    '<div class="hero-meta-chip"><span class="hero-meta-sq hero-meta-sq-r"></span> Sport · Culture · Solidarité</div>' .
    '<div class="hero-meta-chip"><span class="hero-meta-sq hero-meta-sq-b"></span> Depuis 2018</div>' .
    '</div>' .
    '</div>' .
    '<div class="hero-right">' .
    '<div class="hero-photo-frame">' .
    '<div class="hero-photo-tag">PORTRAIT · TIM</div>' .
    '<div class="hero-photo-placeholder" aria-label="Portrait du Caporal Timothé Bernardeau"></div>' .
    '<div class="hero-photo-badge"><div class="hero-photo-badge-n">29.03</div><div class="hero-photo-badge-l">KOUROU 2026</div></div>' .
    '</div>' .
    '<div class="hero-photo-meta">' .
    '<div class="hero-meta-stripe"></div>' .
    '<div class="hero-meta-stripe hero-meta-stripe-r"></div>' .
    '<div class="hero-meta-stripe"></div>' .
    '</div>' .
    '</div>' .
    '</div>' .
    '<div class="stats-strip" aria-label="Chiffres clés">' .
    '<div class="stat"><div class="stat-n">4</div><div class="stat-l">Défis organisés</div></div>' .
    '<div class="stat"><div class="stat-n">120+</div><div class="stat-l">Frères d\'armes mobilisés</div></div>' .
    '<div class="stat"><div class="stat-n">38 K€</div><div class="stat-l">Collectés à ce jour</div></div>' .
    '<div class="stat"><div class="stat-n">29.03.26</div><div class="stat-l">Prochain défi · Kourou</div></div>' .
    '</div>' .
    '</section>'
)]);

// ══ 2 — STORY  (native widgets — visually editable) ════════
$timeline_rows =
    '<div class="timeline-row"><div class="timeline-y">2012</div><div class="timeline-bar" aria-hidden="true"></div><div class="timeline-e">Incorpore la BSPP, 11e compagnie d\'incendie, Marais.</div></div>' .
    '<div class="timeline-row"><div class="timeline-y">2015</div><div class="timeline-bar" aria-hidden="true"></div><div class="timeline-e">Rejoint le groupe de gymnastique de la Brigade.</div></div>' .
    '<div class="timeline-row"><div class="timeline-y">2018</div><div class="timeline-bar" aria-hidden="true"></div><div class="timeline-e">Chute en représentation. Tétraplégie.</div></div>' .
    '<div class="timeline-row"><div class="timeline-y">2023</div><div class="timeline-bar" aria-hidden="true"></div><div class="timeline-e">Court avec ses frères d\'armes sur la Tunnel to Towers (NYC).</div></div>' .
    '<div class="timeline-row"><div class="timeline-y">2025</div><div class="timeline-bar" aria-hidden="true"></div><div class="timeline-e">Course au profit du Bleuet de France.</div></div>' .
    '<div class="timeline-row"><div class="timeline-y">2026</div><div class="timeline-bar" aria-hidden="true"></div><div class="timeline-e">Marathon de l\'Espace, Kourou. En relais autour de Tim.</div></div>';

$story_media_html =
    '<div class="story-media">' .
    '<div class="story-photo"><div class="story-photo-placeholder"></div></div>' .
    '<div class="story-photo-sub"><div class="story-photo-placeholder"></div></div>' .
    '<div class="story-stamp">BSPP · 2012—2018</div>' .
    '</div>';

$page[] = el_2col(
    // Left — photos (HTML, becomes image widget when photos are ready)
    [w_html($story_media_html)],
    // Right — editable text content
    [
        w_html('<div class="kicker"><span class="kicker-dot" style="background:var(--accent)"></span><span>L\'Histoire</span></div>'),
        w_heading(
            'Un caporal. Une équipe de gym. Un fil qui ne casse pas.',
            'h2',
            ['_margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '28', 'left' => '0', 'isLinked' => false]]
        ),
        w_text('<p>Septembre 2012. Timothé Bernardeau, jeune Nantais, incorpore la Brigade de Sapeurs-Pompiers de Paris. Il rejoint la 11e compagnie d\'incendie et de secours, dans le Marais, comme conducteur d\'engin-pompe. De nombreuses interventions d\'ampleur, dont les attentats de janvier et novembre 2015. Plusieurs lettres de félicitations du commandement.</p>',
            ['_margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '14', 'left' => '0', 'isLinked' => false]]),
        w_text('<p>Avril 2015 : Tim, sportif d\'exception, intègre le groupe de gymnastique de la Brigade — fondé en 1919, ambassadeur sportif et artistique de la BSPP. En trois ans, plus de 40 représentations en France et en Europe.</p>',
            ['_margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '14', 'left' => '0', 'isLinked' => false]]),
        w_text('<p>Mai 2018. Lors d\'une représentation au profit d\'enfants malades, Tim chute lourdement. Tétraplégie. Près de deux ans et demi à l\'Institution Nationale des Invalides, puis le retour à la maison, avec sa compagne infirmière et leur fille Lyla. À 33 ans, sa résilience est sans faille. Le lien avec la caserne, lui non plus, n\'a jamais cassé.</p>',
            ['_margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '24', 'left' => '0', 'isLinked' => false]]),
        w_html('<div class="timeline" aria-label="Chronologie">' . $timeline_rows . '</div>'),
        w_html(
            '<blockquote class="pull-quote">' .
            '<div class="pull-quote-mark" aria-hidden="true">"</div>' .
            '<div class="pull-quote-text">« La cohésion et la fraternité de la BSPP sont sans limite. Sept ans après son accident, on franchit la ligne avec lui. »</div>' .
            '<div class="pull-quote-who">— Le collectif Un Défi pour Tim</div>' .
            '</blockquote>'
        ),
        w_btn('Voir le défi en détail', '#defis', 'outline'),
    ],
    47,
    // Section settings
    [
        '_element_id'           => 'story',
        'background_background' => 'classic',
        'background_color'      => '#F4EFE6',
        'padding' => ['unit' => 'px', 'top' => '100', 'right' => '32', 'bottom' => '100', 'left' => '32', 'isLinked' => false],
        'padding_tablet' => ['unit' => 'px', 'top' => '70', 'right' => '24', 'bottom' => '70', 'left' => '24', 'isLinked' => false],
    ],
    // Left column settings
    ['padding' => ['unit' => 'px', 'top' => '0', 'right' => '40', 'bottom' => '0', 'left' => '0', 'isLinked' => false]],
    // Right column settings
    ['padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '20', 'isLinked' => false]]
);

// ══ 3 — DÉFIS (shortcode — managed via WP admin) ═══════════
$page[] = el_wrap([w_sc('[defitim_defis]')]);

// ══ 4 — MEMBERS  (native heading/text + HTML grid) ═════════
$team_cards =
    '<div class="team-card"><div class="team-n">12</div><div class="team-label">Sapeurs-pompiers de Paris</div><div class="team-note">Dont 6 membres de l\'équipe de gymnastique de la Brigade.</div></div>' .
    '<div class="team-card"><div class="team-n">6</div><div class="team-label">Anciens sapeurs-pompiers</div><div class="team-note">Frères d\'armes, toujours là.</div></div>' .
    '<div class="team-card"><div class="team-n">5</div><div class="team-label">Famille Bernardeau</div><div class="team-note">Compagne, parents, proches.</div></div>' .
    '<div class="team-card"><div class="team-n">3</div><div class="team-label">Enfants</div><div class="team-note">Lyla et deux camarades.</div></div>';

$page[] = el_wrap(
    [
        w_html('<div class="kicker"><span class="kicker-dot" style="background:var(--accent)"></span><span>Membres de l\'asso</span></div>'),
        w_heading('Qui compose le collectif.'),
        w_text('<p>Un collectif qui mélange les générations et les uniformes. Les frères d\'armes de Tim, les anciens, sa famille, et les enfants qui grandissent dans cette histoire — dont Lyla, la sienne.</p>',
            ['_margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '48', 'left' => '0', 'isLinked' => false]]),
        w_html('<div class="team-grid">' . $team_cards . '</div>'),
        w_html('<div class="members-bureau">Bureau de l\'association : Adj-Chef Benjamin GUY (président) · Timothé Bernardeau (coordinateur) · membres fondateurs au sein de la BSPP.</div>'),
    ],
    [
        '_element_id'           => 'members',
        'background_background' => 'classic',
        'background_color'      => '#F4EFE6',
        'padding' => ['unit' => 'px', 'top' => '100', 'right' => '32', 'bottom' => '100', 'left' => '32', 'isLinked' => false],
        'padding_tablet' => ['unit' => 'px', 'top' => '70', 'right' => '24', 'bottom' => '70', 'left' => '24', 'isLinked' => false],
    ]
);

// ══ 5 — MÉCÉNAT  (native intro + HTML benefits/budget) ═════
$mec_benefits =
    '<div class="mec-benefit"><div class="mec-benefit-n">01</div><div class="mec-benefit-t">Banderole mécènes</div><div class="mec-benefit-b">Réalisée pour le défi, portée pendant tout le séjour à Kourou.</div></div>' .
    '<div class="mec-benefit"><div class="mec-benefit-n">02</div><div class="mec-benefit-t">Tenues officielles</div><div class="mec-benefit-b">Logos sur les tenues « Un Défi pour Tim » portées pendant 6 jours.</div></div>' .
    '<div class="mec-benefit"><div class="mec-benefit-n">03</div><div class="mec-benefit-t">Démonstrations gym BSPP</div><div class="mec-benefit-b">Communications lors des représentations à travers la France.</div></div>' .
    '<div class="mec-benefit"><div class="mec-benefit-n">04</div><div class="mec-benefit-t">Réseaux sociaux</div><div class="mec-benefit-b">Avant, pendant et après le défi (Instagram, Facebook, LinkedIn).</div></div>' .
    '<div class="mec-benefit"><div class="mec-benefit-n">05</div><div class="mec-benefit-t">Image & valeurs</div><div class="mec-benefit-b">Votre marque associée à la cohésion, la fraternité, la résilience.</div></div>' .
    '<div class="mec-benefit"><div class="mec-benefit-n">06</div><div class="mec-benefit-t">Public ciblé</div><div class="mec-benefit-b">Une visibilité accrue auprès d\'un public varié, motivé, engagé.</div></div>';

$budget_rows =
    '<div class="budget-row"><div class="budget-k">Avion</div><div class="budget-n">24 classe éco + 3 business PMR</div><div class="budget-v">25 000 €</div></div>' .
    '<div class="budget-row"><div class="budget-k">Hébergement</div><div class="budget-n">26 personnes + 1 PMR</div><div class="budget-v">12 000 €</div></div>' .
    '<div class="budget-row"><div class="budget-k">Restauration</div><div class="budget-n">Sur place, sur la durée du séjour</div><div class="budget-v">4 680 €</div></div>' .
    '<div class="budget-row"><div class="budget-k">Tenues du défi</div><div class="budget-n">« Un Défi pour Tim » — 6 jours</div><div class="budget-v">4 600 €</div></div>' .
    '<div class="budget-row"><div class="budget-k">Inscription + équipement</div><div class="budget-n">Course à pied</div><div class="budget-v">3 350 €</div></div>' .
    '<div class="budget-row"><div class="budget-k">Transports sur place</div><div class="budget-n">Location véhicule PMR + minibus</div><div class="budget-v">2 650 €</div></div>' .
    '<div class="budget-row"><div class="budget-k">Visites</div><div class="budget-n">Musées, détachement BSPP</div><div class="budget-v">500 €</div></div>' .
    '<div class="budget-row budget-row-sum"><div class="budget-k">Total</div><div class="budget-n"></div><div class="budget-v">52 780 €</div></div>' .
    '<div class="budget-row"><div class="budget-k">Apport de la section</div><div class="budget-n"></div><div class="budget-v">− 10 000 €</div></div>' .
    '<div class="budget-row budget-row-need"><div class="budget-k">Besoin de financement</div><div class="budget-n"></div><div class="budget-v">42 780 €</div></div>';

$page[] = el_wrap(
    [
        w_html('<div class="kicker"><span class="kicker-dot" style="background:var(--accent)"></span><span>Mécénat</span></div>'),
        w_heading('Soutenir, et être visible.'),
        w_text('<p>Vos couleurs sur la banderole, sur les tenues du défi, dans nos communications avant-pendant-après. Une démonstration de la gymnastique de la BSPP, des publications réseaux sur toutes nos plateformes — votre image associée à un projet qui rassemble.</p>',
            ['_margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '48', 'left' => '0', 'isLinked' => false]]),
        w_html('<div class="mec-benefits">' . $mec_benefits . '</div>'),
        w_html(
            '<div class="budget">' .
            '<div class="budget-head">' .
            '<h3 class="budget-title">Le budget, ligne à ligne</h3>' .
            '<p class="budget-sub">Total : 52 780 € — 10 000 € apportés par la section « Un Défi pour Tim » — il reste 42 780 € à collecter.</p>' .
            '</div>' .
            '<div class="budget-table">' . $budget_rows . '</div>' .
            '</div>'
        ),
    ],
    [
        '_element_id'           => 'mecenat',
        'background_background' => 'classic',
        'background_color'      => '#F4EFE6',
        'padding' => ['unit' => 'px', 'top' => '100', 'right' => '32', 'bottom' => '100', 'left' => '32', 'isLinked' => false],
        'padding_tablet' => ['unit' => 'px', 'top' => '70', 'right' => '24', 'bottom' => '70', 'left' => '24', 'isLinked' => false],
    ]
);

// ══ 6 — SENS  (native widgets — navy section) ══════════════
$page[] = el_wrap(
    [
        w_html('<div class="kicker"><span class="kicker-dot" style="background:var(--brass)"></span><span>Un projet qui a du sens</span></div>'),
        w_heading(
            'Pourquoi celui-ci, pourquoi maintenant.',
            'h2',
            [
                'title_color' => '#F4EFE6',
                '_margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '48', 'left' => '0', 'isLinked' => false],
            ]
        ),
        w_html('<div class="sens-grid">
            <div class="sens-point">
                <div class="sens-n">01</div>
                <div class="sens-t">Kourou</div>
                <div class="sens-b">Un des détachements de la Brigade de Sapeurs-Pompiers de Paris.</div>
            </div>
            <div class="sens-point">
                <div class="sens-n">02</div>
                <div class="sens-t">Un marathon</div>
                <div class="sens-b">Un défi sportif qui démontrera la condition physique des SPP.</div>
            </div>
            <div class="sens-point">
                <div class="sens-n">03</div>
                <div class="sens-t">Un relais</div>
                <div class="sens-b">20 sapeurs-pompiers se relaient pour franchir la ligne avec Tim.</div>
            </div>
            <div class="sens-point">
                <div class="sens-n">04</div>
                <div class="sens-t">Sept ans après</div>
                <div class="sens-b">La preuve, encore et toujours, que la cohésion et la fraternité de la BSPP sont sans limite.</div>
            </div>
        </div>'),
        w_text(
            '<p>Avant son accident, Tim avait couru le Marathon de New York. Le Marathon de l\'Espace, en relais, dira la même chose autrement : tout est encore possible.</p>',
            [
                'text_color' => 'rgba(244,239,230,0.82)',
                '_margin' => ['unit' => 'px', 'top' => '40', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false],
            ]
        ),
    ],
    [
        'css_classes'           => 'section-navy section-sens',
        'background_background' => 'classic',
        'background_color'      => '#0B1B3D',
        'padding' => ['unit' => 'px', 'top' => '100', 'right' => '32', 'bottom' => '100', 'left' => '32', 'isLinked' => false],
        'padding_tablet' => ['unit' => 'px', 'top' => '70', 'right' => '24', 'bottom' => '70', 'left' => '24', 'isLinked' => false],
    ]
);

// ══ 7 — HELP / DONATE ══════════════════════════════════════
$page[] = el_wrap([w_html(
    '<section class="section section-cream" id="help">' .
    '<div class="section-inner">' .
    '<div class="help-head">' .
    '<div class="kicker"><span class="kicker-dot" style="background:var(--accent)"></span><span>Soutenir Tim</span></div>' .
    '<h2 class="section-title">Trois façons d\'agir.</h2>' .
    '</div>' .
    '<div class="help-grid">' .
    '<div class="help-donate">' .
    '<div class="help-donate-top"><div class="help-donate-num">01</div><h3 class="help-donate-title">Donner</h3></div>' .
    '<p class="help-donate-body">Don en chèque à l\'ordre de « ASASPP » — adressé à la BSPP, Caserne Masséna, 3 rue Darmesteter, 75013 Paris. Ou donnez en ligne via HelloAsso.</p>' .
    '<div class="help-donate-pick">' .
    '<div class="help-donate-pick-label">Don suggéré</div>' .
    '<div class="help-donate-amounts" role="group" aria-label="Montant du don">' .
    '<button class="amt" type="button" data-amount="20" aria-pressed="false">€20</button>' .
    '<button class="amt amt-active" type="button" data-amount="50" aria-pressed="true">€50</button>' .
    '<button class="amt" type="button" data-amount="100" aria-pressed="false">€100</button>' .
    '<button class="amt" type="button" data-amount="250" aria-pressed="false">€250</button>' .
    '<div class="amt amt-custom"><span aria-hidden="true">€</span><input type="number" id="amount-custom" min="1" placeholder="Autre" aria-label="Montant libre en euros"></div>' .
    '</div>' .
    '<div class="help-donate-sub">Don à l\'ordre de « ASASPP ». Reçu fiscal pour les dons éligibles.</div>' .
    '<button class="btn btn-primary btn-lg help-donate-go" id="donate-btn" type="button">Préparer mon don · <span id="donate-amount">€50</span> ' . $arrow . '</button>' .
    '</div>' .
    '</div>' .
    '<div class="help-side">' .
    '<div class="help-card">' .
    '<div class="help-card-num">02</div>' .
    '<h3 class="help-card-title">Devenir mécène</h3>' .
    '<p class="help-card-body">Vous êtes une entreprise, une amicale, un club ? Associez votre nom au projet. Le dossier de mécénat détaille tous les niveaux d\'engagement et les contreparties.</p>' .
    '<a href="#contact" class="help-card-cta">Contacter l\'équipe ' . $arrow . '</a>' .
    '</div>' .
    '<div class="help-card">' .
    '<div class="help-card-num">03</div>' .
    '<h3 class="help-card-title">Partager</h3>' .
    '<p class="help-card-body">Suivez et relayez nos publications avant, pendant et après le séjour. Chaque partage compte autant qu\'un don.</p>' .
    '<button class="help-card-cta" type="button" id="share-btn">Partager la page ' . $arrow . '</button>' .
    '</div>' .
    '</div>' .
    '</div>' .
    '</div>' .
    '</section>'
)]);

// ══ 8 — PROGRESS (shortcode) ═══════════════════════════════
$page[] = el_wrap([w_sc('[defitim_progress]')]);

// ══ 9 — SPONSORS (shortcode) ═══════════════════════════════
$page[] = el_wrap([w_sc('[defitim_sponsors]')]);

// ══ 10 — FAQ (shortcode) ════════════════════════════════════
$page[] = el_wrap([w_sc('[defitim_faq]')]);

// ══ 11 — CONTACT ════════════════════════════════════════════
$contact_cards =
    '<div class="contact-card">' .
    '<div class="contact-card-role">Responsable projet</div>' .
    '<div class="contact-card-name">Adjudant-Chef Benjamin GUY</div>' .
    '<div class="contact-card-row"><span class="contact-card-l">Tél</span><a href="tel:+33669658145">06 69 65 81 45</a></div>' .
    '<div class="contact-card-row"><span class="contact-card-l">Mail</span><a href="mailto:benjamin.guy@pompiersparis.fr">benjamin.guy@pompiersparis.fr</a></div>' .
    '</div>' .
    '<div class="contact-card">' .
    '<div class="contact-card-role">Coordinateur projet</div>' .
    '<div class="contact-card-name">Timothé Bernardeau</div>' .
    '<div class="contact-card-row"><span class="contact-card-l">Tél</span><a href="tel:+33622162433">06 22 16 24 33</a></div>' .
    '<div class="contact-card-row"><span class="contact-card-l">Mail</span><a href="mailto:bernardeau.t@gmail.com">bernardeau.t@gmail.com</a></div>' .
    '</div>';

$page[] = el_wrap([w_html(
    '<section class="section section-navy section-contact" id="contact">' .
    '<div class="section-inner contact-grid">' .
    '<div class="contact-left">' .
    '<div class="kicker"><span class="kicker-dot" style="background:var(--brass)"></span><span>Contact</span></div>' .
    '<h2 class="section-title section-title-light">On vous répond.</h2>' .
    '<p class="lede lede-light">Pour une question, un projet d\'événement ou un dossier de mécénat, deux contacts directs au sein du collectif.</p>' .
    '<div class="contact-cards">' . $contact_cards . '</div>' .
    '<div class="contact-don">' .
    '<div class="contact-don-label">Dons en chèque à l\'ordre de « ASASPP »</div>' .
    '<div class="contact-don-addr">BSPP — Caserne Masséna, 3 rue Darmesteter, 75013 Paris</div>' .
    '</div>' .
    '<div class="contact-social">' .
    '<div class="contact-social-label">Suivre la BSPP</div>' .
    '<div class="contact-social-row">' .
    '<a href="#" rel="noopener noreferrer" target="_blank" aria-label="Instagram">IG</a>' .
    '<a href="#" rel="noopener noreferrer" target="_blank" aria-label="Facebook">FB</a>' .
    '<a href="#" rel="noopener noreferrer" target="_blank" aria-label="LinkedIn">IN</a>' .
    '<a href="https://www.pompiersparis.fr" rel="noopener noreferrer" target="_blank" aria-label="Site BSPP">BSPP</a>' .
    '</div>' .
    '</div>' .
    '</div>' .
    '<form class="contact-form" id="contact-form" novalidate>' .
    '<div class="cf-row">' .
    '<label><span>Nom</span><input type="text" name="nom" required placeholder="Votre nom"></label>' .
    '<label><span>Email</span><input type="email" name="email" required placeholder="votre@email.fr"></label>' .
    '</div>' .
    '<label class="cf-full"><span>Sujet</span><input type="text" name="sujet" value="Mécénat — Un défi pour Tim" required></label>' .
    '<label class="cf-full"><span>Message</span><textarea name="message" rows="5" required placeholder="Votre message…"></textarea></label>' .
    '<div class="cf-feedback" role="alert" aria-live="polite" hidden></div>' .
    '<button class="btn btn-primary btn-lg" type="submit">Envoyer ' . $arrow . '</button>' .
    '</form>' .
    '</div>' .
    '</section>'
)]);

// ══ 12 — FOOTER ════════════════════════════════════════════
$page[] = el_wrap([w_html(
    '<footer class="footer">' .
    '<div class="footer-inner">' .
    '<div class="footer-brand">' .
    '<span class="brand-mark" aria-hidden="true"><span class="brand-mark-bar"></span><span class="brand-mark-bar"></span><span class="brand-mark-bar"></span></span>' .
    '<span class="brand-text"><span class="brand-defi">DÉFI</span><span class="brand-tim">TIM</span></span>' .
    '</div>' .
    '<p class="footer-tag">Un défi pour Tim — événement initié par la Brigade de Sapeurs-Pompiers de Paris en soutien au caporal Timothé Bernardeau.</p>' .
    '<div class="footer-links"><a href="#">Mentions légales</a><a href="#">Confidentialité</a><a href="#contact">Contact</a></div>' .
    '<div class="footer-copy">© 2026 Collectif Un Défi pour Tim. Soutenu par la BSPP.</div>' .
    '</div>' .
    '</footer>'
)]);

// ─────────────────────────────────────────────────────────
//  SAVE TO WORDPRESS
// ─────────────────────────────────────────────────────────
$front_page_id = (int) get_option('page_on_front');
if (!$front_page_id) {
    WP_CLI::error('No front page set in Settings → Reading.');
    exit;
}

$json = wp_json_encode($page);
update_post_meta($front_page_id, '_elementor_data',          wp_slash($json));
update_post_meta($front_page_id, '_elementor_edit_mode',     'builder');
update_post_meta($front_page_id, '_elementor_template_type', 'wp-page');
update_post_meta($front_page_id, '_wp_page_template',        'elementor_canvas');

if (class_exists('\Elementor\Core\Files\CSS\Post')) {
    (new \Elementor\Core\Files\CSS\Post($front_page_id))->delete();
}

WP_CLI::success(sprintf(
    'Front page %d rebuilt — %s bytes, %d sections.',
    $front_page_id,
    number_format(strlen($json)),
    count($page)
));
