<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

$goal   = (int) dt_opt('progress_goal',   42780);
$raised = (int) dt_opt('progress_raised', 9620);
$donors = (int) dt_opt('progress_donors', 54);
$events = (int) dt_opt('progress_events', 3);
$pct    = $goal ? min(100, round(($raised / $goal) * 100)) : 0;

function _dt_fmt_amount($n) {
    return '€' . number_format($n, 0, ',', ' ');
}
?>
<section class="section section-navy section-progress" id="progress">
    <div class="section-inner">
        <div class="progress-head">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--brass)"></span>
                <span><?php echo $is_en ? 'Progress' : 'Progression'; ?></span>
            </div>
            <h2 class="section-title section-title-light">
                <?php echo $is_en ? 'Kourou 2026 goal' : 'Objectif Kourou 2026'; ?>
            </h2>
        </div>

        <div class="progress-bigrow">
            <div class="progress-big">
                <div class="progress-big-n"><?php echo esc_html(_dt_fmt_amount($raised)); ?></div>
                <div class="progress-big-l">
                    <?php echo $is_en ? 'raised' : 'collectés'; ?>
                    <?php echo $is_en ? ' of ' : ' sur '; ?>
                    <strong><?php echo esc_html(_dt_fmt_amount($goal)); ?></strong>
                </div>
            </div>
            <div class="progress-sub">
                <div><strong><?php echo esc_html($donors); ?></strong> <?php echo $is_en ? 'donors' : 'donateurs'; ?></div>
                <div><strong><?php echo esc_html($events); ?></strong> <?php echo $is_en ? 'fundraising events' : 'événements de collecte'; ?></div>
            </div>
        </div>

        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_attr($pct); ?>" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar-fill" style="width:<?php echo esc_attr($pct); ?>%">
                <div class="progress-bar-flag"><?php echo esc_html($pct); ?>%</div>
            </div>
            <div class="progress-bar-ticks" aria-hidden="true">
                <div class="progress-bar-tick" style="left:0%">€0</div>
                <div class="progress-bar-tick" style="left:25%"></div>
                <div class="progress-bar-tick" style="left:50%"></div>
                <div class="progress-bar-tick" style="left:75%"></div>
                <div class="progress-bar-tick" style="left:100%"><?php echo esc_html(_dt_fmt_amount($goal)); ?></div>
            </div>
        </div>

        <p class="progress-thanks">
            <?php echo $is_en
                ? 'Thanks to the donors, fire stations, alumni groups, clubs and companies making this project possible.'
                : 'Merci aux donateurs, casernes, amicales, clubs et entreprises qui rendent ce projet possible.'; ?>
        </p>
    </div>
</section>
