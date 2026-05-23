<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

$lede    = dt_opt('hero_lede_' . $lang, $is_en
    ? 'Un Défi pour Tim is a collective that runs sport and culture challenges all year long, around Corporal Timothé Bernardeau, a former Paris firefighter who became tetraplegic in service.'
    : "Un Défi pour Tim, c'est un collectif qui organise toute l'année des défis sportifs et culturels autour du caporal Timothé Bernardeau, ancien sapeur-pompier de Paris devenu tétraplégique en service.");

$portrait = dt_opt('hero_portrait');

// Stats
$stats = [];
for ($i = 1; $i <= 4; $i++) {
    $stats[] = [
        'n' => dt_opt("stat{$i}_n", ['8','120+','38 K€','29.03.26'][$i-1]),
        'l' => dt_opt("stat{$i}_" . ($is_en ? 'l_en' : 'l'), [
            $is_en ? 'Challenges organised' : 'Défis organisés',
            $is_en ? 'Brothers mobilised' : 'Frères d\'armes mobilisés',
            $is_en ? '€38K raised to date' : 'Collectés à ce jour',
            $is_en ? 'Next challenge · Kourou' : 'Prochain défi · Kourou',
        ][$i-1]),
    ];
}

$tag1 = $is_en ? 'Paris Firefighters Brigade' : 'Brigade de Sapeurs-Pompiers de Paris';
$tag2 = 'Sport · Culture · Solidarité';
$tag3 = $is_en ? 'Since 2018' : 'Depuis 2018';
?>
<section class="hero" id="hero">
    <div class="ticker ticker-top" aria-hidden="true">
        <div class="ticker-track">
            <?php for ($i = 0; $i < 8; $i++) : ?>
            <span>
                <?php echo esc_html($tag1); ?>
                <span class="ticker-dot">●</span>
                <?php echo esc_html($tag2); ?>
                <span class="ticker-dot">●</span>
                <?php echo esc_html($tag3); ?>
                <span class="ticker-dot">●</span>
            </span>
            <?php endfor; ?>
        </div>
    </div>

    <div class="hero-inner">
        <div class="hero-left">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--accent)"></span>
                <span><?php echo $is_en ? 'The collective · Since 2018' : 'Le collectif · Depuis 2018'; ?></span>
            </div>

            <h1 class="hero-title">
                <span class="hero-line"><?php echo $is_en ? 'We never' : 'On ne lâche'; ?></span>
                <span class="hero-line"><?php echo $is_en ? 'let Tim go.' : 'pas Tim.'; ?></span>
                <span class="hero-line">
                    <span class="hero-mark"><?php echo $is_en ? 'Ever.' : 'Jamais.'; ?></span>
                </span>
            </h1>

            <p class="hero-lede"><?php echo esc_html($lede); ?></p>

            <div class="hero-ctas">
                <a href="#help" class="btn btn-primary btn-lg">
                    <?php echo $is_en ? 'Support the challenges' : 'Soutenir les défis'; ?>
                    <?php echo dt_arrow(); ?>
                </a>
                <a href="#story" class="btn btn-ghost btn-lg">
                    <?php echo $is_en ? 'Read his story' : 'Lire son histoire'; ?>
                </a>
            </div>

            <div class="hero-meta">
                <div class="hero-meta-chip">
                    <span class="hero-meta-square"></span> <?php echo esc_html($tag1); ?>
                </div>
                <div class="hero-meta-chip">
                    <span class="hero-meta-square hero-meta-square-2"></span> <?php echo esc_html($tag2); ?>
                </div>
                <div class="hero-meta-chip">
                    <span class="hero-meta-square hero-meta-square-3"></span> <?php echo esc_html($tag3); ?>
                </div>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-photo-frame">
                <div class="hero-photo-tag">PORTRAIT · TIM</div>
                <?php if (!empty($portrait['url'])) : ?>
                <img src="<?php echo esc_url($portrait['url']); ?>"
                     alt="<?php echo esc_attr($portrait['alt'] ?? 'Portrait du Caporal Timothé Bernardeau'); ?>"
                     width="<?php echo esc_attr($portrait['width'] ?? ''); ?>"
                     height="<?php echo esc_attr($portrait['height'] ?? ''); ?>"
                     loading="eager">
                <?php else : ?>
                <div class="hero-photo-placeholder" aria-label="Portrait du Caporal Timothé Bernardeau"></div>
                <?php endif; ?>
                <div class="hero-photo-badge">
                    <div class="hero-photo-badge-n">29.03</div>
                    <div class="hero-photo-badge-l">KOUROU 2026</div>
                </div>
            </div>
            <div class="hero-photo-meta">
                <div class="hero-meta-stripe"></div>
                <div class="hero-meta-stripe hero-meta-stripe-r"></div>
                <div class="hero-meta-stripe"></div>
            </div>
        </div>
    </div>

    <div class="stats-strip" aria-label="<?php echo $is_en ? 'Key numbers' : 'Chiffres clés'; ?>">
        <?php foreach ($stats as $stat) : ?>
        <div class="stat">
            <div class="stat-n"><?php echo esc_html($stat['n']); ?></div>
            <div class="stat-l"><?php echo esc_html($stat['l']); ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
