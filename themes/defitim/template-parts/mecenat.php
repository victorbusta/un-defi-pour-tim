<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

// Benefits repeater (ACF: mec_benefits — subfields: t_fr, t_en, b_fr, b_en)
$benefits_raw = function_exists('get_field') ? get_field('mec_benefits', 'option') : null;
$benefits = [];
if ($benefits_raw) {
    foreach ($benefits_raw as $b) {
        $benefits[] = [
            't' => $b['t_' . $lang] ?? $b['t_fr'] ?? '',
            'b' => $b['b_' . $lang] ?? $b['b_fr'] ?? '',
        ];
    }
} else {
    $benefits = $is_en ? [
        ['t' => 'Sponsor banner',    'b' => 'Made for the challenge, carried throughout the Kourou trip.'],
        ['t' => 'Official outfits',  'b' => 'Logos on the « Un Défi pour Tim » outfits worn over 6 days.'],
        ['t' => 'BSPP gym demos',    'b' => 'Sponsor mentions during demos across France.'],
        ['t' => 'Social media',      'b' => 'Before, during and after the challenge (Instagram, Facebook, LinkedIn).'],
        ['t' => 'Image & values',    'b' => 'Your brand tied to cohesion, brotherhood, resilience.'],
        ['t' => 'Targeted reach',    'b' => 'Heightened visibility with a varied, motivated, engaged audience.'],
    ] : [
        ['t' => 'Banderole mécènes',        'b' => 'Réalisée pour le défi, portée pendant tout le séjour à Kourou.'],
        ['t' => 'Tenues officielles',        'b' => 'Logos sur les tenues « Un Défi pour Tim » portées pendant 6 jours.'],
        ['t' => 'Démonstrations gym BSPP',  'b' => 'Communications lors des représentations à travers la France.'],
        ['t' => 'Réseaux sociaux',           'b' => 'Avant, pendant et après le défi (Instagram, Facebook, LinkedIn).'],
        ['t' => 'Image & valeurs',           'b' => 'Votre marque associée à la cohésion, la fraternité, la résilience.'],
        ['t' => 'Public ciblé',              'b' => 'Une visibilité accrue auprès d\'un public varié, motivé, engagé.'],
    ];
}

// Budget rows repeater (ACF: budget_rows — subfields: k_fr, k_en, n_fr, n_en, v)
$budget_raw = function_exists('get_field') ? get_field('budget_rows', 'option') : null;
$budget_rows = [];
if ($budget_raw) {
    foreach ($budget_raw as $row) {
        $budget_rows[] = [
            'k' => $row['k_' . $lang] ?? $row['k_fr'] ?? '',
            'n' => $row['n_' . $lang] ?? $row['n_fr'] ?? '',
            'v' => $row['v'] ?? '',
        ];
    }
} else {
    $budget_rows = $is_en ? [
        ['k' => 'Flights',           'v' => '€25,000', 'n' => '24 economy + 3 business PRM'],
        ['k' => 'Accommodation',     'v' => '€12,000', 'n' => '26 people + 1 PRM'],
        ['k' => 'Meals',             'v' => '€4,680',  'n' => 'On-site, full trip'],
        ['k' => 'Challenge outfits', 'v' => '€4,600',  'n' => '« Un Défi pour Tim » — 6 days'],
        ['k' => 'Race entry + gear', 'v' => '€3,350',  'n' => 'Running'],
        ['k' => 'Local transport',   'v' => '€2,650',  'n' => 'PRM vehicle + minibuses'],
        ['k' => 'Visits',            'v' => '€500',    'n' => 'Museums, BSPP detachment'],
    ] : [
        ['k' => 'Avion',                    'v' => '25 000 €', 'n' => '24 classe éco + 3 business PMR'],
        ['k' => 'Hébergement',              'v' => '12 000 €', 'n' => '26 personnes + 1 PMR'],
        ['k' => 'Restauration',             'v' => '4 680 €',  'n' => 'Sur place, sur la durée du séjour'],
        ['k' => 'Tenues du défi',           'v' => '4 600 €',  'n' => '« Un Défi pour Tim » — 6 jours'],
        ['k' => 'Inscription + équipement', 'v' => '3 350 €',  'n' => 'Course à pied'],
        ['k' => 'Transports sur place',     'v' => '2 650 €',  'n' => 'Location véhicule PMR + minibus'],
        ['k' => 'Visites',                  'v' => '500 €',    'n' => 'Musées, détachement BSPP'],
    ];
}

$budget_total = dt_opt('budget_total', $is_en ? '€52,780' : '52 780 €');
$budget_self  = dt_opt('budget_self',  $is_en ? '− €10,000' : '− 10 000 €');
$budget_need  = dt_opt('budget_need',  $is_en ? '€42,780' : '42 780 €');
?>
<section class="section section-cream" id="mecenat">
    <div class="section-inner">
        <div class="mec-head">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--accent)"></span>
                <span><?php echo $is_en ? 'Sponsors' : 'Mécénat'; ?></span>
            </div>
            <h2 class="section-title"><?php echo $is_en ? 'Support, and be seen.' : 'Soutenir, et être visible.'; ?></h2>
            <p class="lede">
                <?php echo $is_en
                    ? 'Your colours on the banner, on the official outfits, across our communications before, during and after the trip. A live demo by the BSPP gym group, posts across every platform — your brand tied to a project that brings people together.'
                    : "Vos couleurs sur la banderole, sur les tenues du défi, dans nos communications avant-pendant-après. Une démonstration de la gymnastique de la BSPP, des publications réseaux sur toutes nos plateformes — votre image associée à un projet qui rassemble."; ?>
            </p>
        </div>

        <div class="mec-benefits">
            <?php foreach ($benefits as $i => $b) : ?>
            <div class="mec-benefit">
                <div class="mec-benefit-n">0<?php echo $i + 1; ?></div>
                <div class="mec-benefit-t"><?php echo esc_html($b['t']); ?></div>
                <div class="mec-benefit-b"><?php echo esc_html($b['b']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="budget">
            <div class="budget-head">
                <h3 class="budget-title"><?php echo $is_en ? 'The budget, line by line' : 'Le budget, ligne à ligne'; ?></h3>
                <p class="budget-sub">
                    <?php echo $is_en
                        ? 'Total: €52,780 — €10,000 already covered by the « Un Défi pour Tim » section — €42,780 left to raise.'
                        : "Total : 52 780 € — 10 000 € apportés par la section « Un Défi pour Tim » — il reste 42 780 € à collecter."; ?>
                </p>
            </div>
            <div class="budget-table">
                <?php foreach ($budget_rows as $row) : ?>
                <div class="budget-row">
                    <div class="budget-k"><?php echo esc_html($row['k']); ?></div>
                    <div class="budget-n"><?php echo esc_html($row['n']); ?></div>
                    <div class="budget-v"><?php echo esc_html($row['v']); ?></div>
                </div>
                <?php endforeach; ?>
                <div class="budget-row budget-row-sum">
                    <div class="budget-k"><?php echo $is_en ? 'Total' : 'Total'; ?></div>
                    <div class="budget-n"></div>
                    <div class="budget-v"><?php echo esc_html($budget_total); ?></div>
                </div>
                <div class="budget-row">
                    <div class="budget-k"><?php echo $is_en ? 'Section contribution' : "Apport de la section"; ?></div>
                    <div class="budget-n"></div>
                    <div class="budget-v"><?php echo esc_html($budget_self); ?></div>
                </div>
                <div class="budget-row budget-row-need">
                    <div class="budget-k"><?php echo $is_en ? 'Funding needed' : 'Besoin de financement'; ?></div>
                    <div class="budget-n"></div>
                    <div class="budget-v"><?php echo esc_html($budget_need); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
