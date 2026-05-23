<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

$points = $is_en ? [
    ['t' => 'Kourou',        'b' => 'One of the detachments of the Paris Firefighters Brigade.'],
    ['t' => 'A marathon',    'b' => "A sporting challenge that will show the BSPP's physical readiness."],
    ['t' => 'A relay',       'b' => '20 Paris firefighters relay to cross the line with Tim.'],
    ['t' => 'Seven years on','b' => "Proof, again, that the BSPP's cohesion and brotherhood are limitless."],
] : [
    ['t' => 'Kourou',       'b' => 'Un des détachements de la Brigade de Sapeurs-Pompiers de Paris.'],
    ['t' => 'Un marathon',  'b' => 'Un défi sportif qui démontrera la condition physique des SPP.'],
    ['t' => 'Un relais',    'b' => '20 sapeurs-pompiers se relaient pour franchir la ligne avec Tim.'],
    ['t' => 'Sept ans après','b' => "La preuve, encore et toujours, que la cohésion et la fraternité de la BSPP sont sans limite."],
];
?>
<section class="section section-navy section-sens">
    <div class="section-inner">
        <div class="sens-head">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--brass)"></span>
                <span><?php echo $is_en ? 'A project that matters' : 'Un projet qui a du sens'; ?></span>
            </div>
            <h2 class="section-title section-title-light">
                <?php echo $is_en ? 'Why this one, why now.' : 'Pourquoi celui-ci, pourquoi maintenant.'; ?>
            </h2>
        </div>

        <div class="sens-grid">
            <?php foreach ($points as $i => $p) : ?>
            <div class="sens-point">
                <div class="sens-n">0<?php echo $i + 1; ?></div>
                <div class="sens-t"><?php echo esc_html($p['t']); ?></div>
                <div class="sens-b"><?php echo esc_html($p['b']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="sens-ny">
            <?php echo $is_en
                ? "Before his accident, Tim ran the New York Marathon. The Marathon de l'Espace, in relay, will say the same thing differently: anything is still possible."
                : "Avant son accident, Tim avait couru le Marathon de New York. Le Marathon de l'Espace, en relais, dira la même chose autrement : tout est encore possible."; ?>
        </p>
    </div>
</section>
