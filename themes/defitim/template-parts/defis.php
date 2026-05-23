<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

// Labels
$lbl = $is_en ? [
    'kicker'       => 'Challenges',
    'title'        => "A calendar that doesn't stop.",
    'lede'         => 'Run, marathon, demo, charity night — each challenge has its format, its pace, its reason. Here is what the collective has done, and what\'s coming.',
    'upcoming'     => 'Upcoming',
    'past'         => 'Past',
    'featured'     => 'Next challenge',
    'relay_title'  => 'The six relay legs',
    'prog_title'   => 'Trip programme',
    'support_cta'  => 'Support this challenge',
    'progress_lbl' => 'Fundraising in progress',
    'source'       => 'Source: Marathon de l\'Espace · finishers.com',
    'type_lbl'     => 'Type',
    'loc_lbl'      => 'Location',
    'who_lbl'      => 'Team',
    'upcoming_tag' => 'UPCOMING',
    'live_tag'     => 'LIVE',
    'past_tag'     => 'COMPLETED',
] : [
    'kicker'       => 'Les Défis',
    'title'        => 'Un calendrier qui ne s\'arrête pas.',
    'lede'         => 'Course, marathon, démonstration, soirée caritative — chaque défi a son format, son rythme, sa raison d\'être. Voici ce que le collectif a mené, et ce qui arrive.',
    'upcoming'     => 'À venir',
    'past'         => 'Passés',
    'featured'     => 'Prochain défi',
    'relay_title'  => 'Les six relais',
    'prog_title'   => 'Programme du séjour',
    'support_cta'  => 'Soutenir ce défi',
    'progress_lbl' => 'Collecte en cours',
    'source'       => 'Source : Marathon de l\'Espace · finishers.com',
    'type_lbl'     => 'Type',
    'loc_lbl'      => 'Lieu',
    'who_lbl'      => 'Qui',
    'upcoming_tag' => 'À VENIR',
    'live_tag'     => 'EN COURS',
    'past_tag'     => 'TERMINÉ',
];

// Query all defis
$query = new WP_Query([
    'post_type'      => 'defi',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_key'       => 'defi_date_iso',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
]);

$upcoming = [];
$past     = [];

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $id     = get_the_ID();
        $status = get_field('defi_status', $id) ?: 'past';
        $defi   = [
            'id'      => $id,
            'status'  => $status,
            'date'    => esc_html(get_field('defi_date_display', $id)),
            'title'   => get_the_title(),
            'kind'    => esc_html(get_field('defi_kind', $id)),
            'loc'     => esc_html(get_field('defi_location', $id)),
            'lede'    => esc_html(get_field('defi_lede', $id)),
            'who'     => esc_html(get_field('defi_who', $id)),
            'goal'    => (int) get_field('defi_goal', $id),
            'raised'  => (int) get_field('defi_raised', $id),
            'relays'  => get_field('defi_relays', $id) ?: [],
            'program' => get_field('defi_program', $id) ?: [],
        ];
        if ($status === 'past') {
            $past[] = $defi;
        } else {
            $upcoming[] = $defi;
        }
    }
    wp_reset_postdata();
}

// Sort past defis newest-first
usort($past, fn($a, $b) => strcmp($b['date'], $a['date']));

$featured        = $upcoming[0] ?? null;
$other_upcoming  = array_slice($upcoming, 1);
?>
<section class="section section-navy" id="defis">
    <div class="section-inner">
        <div class="defis-head">
            <div>
                <div class="kicker">
                    <span class="kicker-dot" style="background:var(--brass)"></span>
                    <span><?php echo esc_html($lbl['kicker']); ?></span>
                </div>
                <h2 class="section-title section-title-light"><?php echo esc_html($lbl['title']); ?></h2>
            </div>
            <p class="lede lede-light defis-lede"><?php echo esc_html($lbl['lede']); ?></p>
        </div>

        <?php if ($featured) :
            $pct = $featured['goal'] ? min(100, round(($featured['raised'] / $featured['goal']) * 100)) : 0;
        ?>
        <article class="featured">
            <div class="featured-top">
                <div class="featured-status">
                    <span class="dot dot-up"></span>
                    <?php echo esc_html($lbl['featured']); ?>
                </div>
                <div class="featured-date"><?php echo esc_html($featured['date']); ?></div>
            </div>
            <div class="featured-headrow">
                <h3 class="featured-title"><?php echo esc_html($featured['title']); ?></h3>
                <a href="#help" class="btn btn-primary btn-sm featured-cta">
                    <?php echo esc_html($lbl['support_cta']); ?>
                    <?php echo dt_arrow(); ?>
                </a>
            </div>
            <div class="featured-meta">
                <?php if ($featured['kind']) : ?>
                <div class="featured-meta-item">
                    <div class="cc-l"><?php echo esc_html($lbl['type_lbl']); ?></div>
                    <div class="cc-v"><?php echo esc_html($featured['kind']); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($featured['loc']) : ?>
                <div class="featured-meta-item">
                    <div class="cc-l"><?php echo esc_html($lbl['loc_lbl']); ?></div>
                    <div class="cc-v"><?php echo esc_html($featured['loc']); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($featured['who']) : ?>
                <div class="featured-meta-item">
                    <div class="cc-l"><?php echo esc_html($lbl['who_lbl']); ?></div>
                    <div class="cc-v"><?php echo esc_html($featured['who']); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <p class="lede lede-light featured-lede"><?php echo esc_html($featured['lede']); ?></p>

            <?php if ($featured['goal']) : ?>
            <div class="featured-progress">
                <div class="featured-progress-label"><?php echo esc_html($lbl['progress_lbl']); ?></div>
                <div class="featured-progress-bar">
                    <div class="featured-progress-fill" style="width:<?php echo esc_attr($pct); ?>%"></div>
                </div>
                <div class="featured-progress-row">
                    <span><strong><?php echo dt_amount($featured['raised']); ?></strong> / <?php echo dt_amount($featured['goal']); ?></span>
                    <span><?php echo esc_html($pct); ?>%</span>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($featured['relays'])) : ?>
            <h4 class="featured-sub-title"><?php echo esc_html($lbl['relay_title']); ?></h4>
            <div class="relay-grid">
                <?php $relay_count = count($featured['relays']); ?>
                <?php foreach ($featured['relays'] as $i => $r) :
                    $is_last = ($i === $relay_count - 1);
                ?>
                <article class="relay<?php echo $is_last ? ' relay-last' : ''; ?>">
                    <div class="relay-top">
                        <div class="relay-n"><?php echo esc_html($r['n']); ?></div>
                        <?php if ($is_last) : ?><div class="relay-flag">FINISH</div><?php endif; ?>
                    </div>
                    <div class="relay-km"><?php echo esc_html($r['km']); ?></div>
                    <div class="relay-note"><?php echo esc_html($r['note']); ?></div>
                    <div class="relay-line">
                        <div class="relay-line-fill" style="width:<?php echo $is_last ? '100%' : '70%'; ?>"></div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($featured['program'])) : ?>
            <h4 class="featured-sub-title"><?php echo esc_html($lbl['prog_title']); ?></h4>
            <div class="program-list">
                <?php foreach ($featured['program'] as $p) :
                    $is_race_day = !empty($p['is_race_day']);
                ?>
                <div class="program-row<?php echo $is_race_day ? ' program-row-hl' : ''; ?>">
                    <div class="program-d"><?php echo esc_html($p['d']); ?></div>
                    <div class="program-line" aria-hidden="true"></div>
                    <div class="program-e"><?php echo esc_html($p['e']); ?></div>
                    <?php if ($is_race_day) : ?>
                    <div class="program-tag">JOUR J</div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="challenge-source"><?php echo esc_html($lbl['source']); ?></div>
        </article>
        <?php endif; ?>

        <?php if (!empty($other_upcoming)) : ?>
        <div class="defis-group-label">
            <span class="dot dot-up"></span> <?php echo esc_html($lbl['upcoming']); ?>
        </div>
        <div class="defis-row">
            <?php foreach ($other_upcoming as $d) : ?>
            <article class="dcard dcard-<?php echo esc_attr($d['status']); ?>">
                <div class="dcard-top">
                    <div class="dcard-status dcard-status-<?php echo esc_attr($d['status']); ?>">
                        <span class="dot dot-up"></span>
                        <?php echo esc_html($lbl['upcoming_tag']); ?>
                    </div>
                    <div class="dcard-date"><?php echo esc_html($d['date']); ?></div>
                </div>
                <h3 class="dcard-title"><?php echo esc_html($d['title']); ?></h3>
                <?php if ($d['kind']) : ?><div class="dcard-kind"><?php echo esc_html($d['kind']); ?></div><?php endif; ?>
                <?php if ($d['loc'])  : ?><div class="dcard-loc"><?php echo esc_html($d['loc']); ?></div><?php endif; ?>
                <?php if ($d['lede']) : ?><p class="dcard-lede"><?php echo esc_html($d['lede']); ?></p><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($past)) : ?>
        <div class="defis-group-label">
            <span class="dot dot-past"></span> <?php echo esc_html($lbl['past']); ?>
        </div>
        <div class="defis-row">
            <?php foreach ($past as $d) : ?>
            <article class="dcard dcard-past">
                <div class="dcard-top">
                    <div class="dcard-status dcard-status-past">
                        <span class="dot dot-past"></span>
                        <?php echo esc_html($lbl['past_tag']); ?>
                    </div>
                    <div class="dcard-date"><?php echo esc_html($d['date']); ?></div>
                </div>
                <h3 class="dcard-title"><?php echo esc_html($d['title']); ?></h3>
                <?php if ($d['kind']) : ?><div class="dcard-kind"><?php echo esc_html($d['kind']); ?></div><?php endif; ?>
                <?php if ($d['loc'])  : ?><div class="dcard-loc"><?php echo esc_html($d['loc']); ?></div><?php endif; ?>
                <?php if ($d['lede']) : ?><p class="dcard-lede"><?php echo esc_html($d['lede']); ?></p><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
