<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

$bureau = dt_opt('members_bureau_' . $lang,
    $is_en
    ? 'Association board: Adj-Chef Benjamin GUY (president) · Timothé Bernardeau (coordinator) · founding members from inside the BSPP.'
    : "Bureau de l'association : Adj-Chef Benjamin GUY (président) · Timothé Bernardeau (coordinateur) · membres fondateurs au sein de la BSPP."
);

// ACF repeater: members_cards (fields: n, label_fr, label_en, note_fr, note_en)
$cards_raw = function_exists('get_field') ? get_field('members_cards', 'option') : null;

if (!$cards_raw) {
    // Fallback hardcoded content
    $cards_raw = $is_en ? [
        ['n' => '12', 'label' => 'Paris firefighters',   'note' => 'Including 6 members of the Brigade gymnastics group.'],
        ['n' => '6',  'label' => 'Alumni firefighters',  'note' => 'Brothers in arms, still here.'],
        ['n' => '5',  'label' => 'Bernardeau family',    'note' => 'Partner, parents, loved ones.'],
        ['n' => '3',  'label' => 'Children',             'note' => 'Lyla and two friends.'],
    ] : [
        ['n' => '12', 'label' => 'Sapeurs-pompiers de Paris',  'note' => "Dont 6 membres de l'équipe de gymnastique de la Brigade."],
        ['n' => '6',  'label' => 'Anciens sapeurs-pompiers',   'note' => 'Frères d\'armes, toujours là.'],
        ['n' => '5',  'label' => 'Famille Bernardeau',         'note' => 'Compagne, parents, proches.'],
        ['n' => '3',  'label' => 'Enfants',                    'note' => 'Lyla et deux camarades.'],
    ];
    $raw_is_flat = true;
} else {
    $raw_is_flat = false;
}
?>
<section class="section section-cream" id="members">
    <div class="section-inner">
        <div class="team-head">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--accent)"></span>
                <span><?php echo $is_en ? 'Members' : "Membres de l'asso"; ?></span>
            </div>
            <h2 class="section-title"><?php echo $is_en ? 'Who makes the collective.' : 'Qui compose le collectif.'; ?></h2>
            <p class="lede">
                <?php echo $is_en
                    ? "A collective that mixes generations and uniforms. Tim's brothers in arms, alumni, his family, and the children growing up inside this story — including his daughter Lyla."
                    : "Un collectif qui mélange les générations et les uniformes. Les frères d'armes de Tim, les anciens, sa famille, et les enfants qui grandissent dans cette histoire — dont Lyla, la sienne."; ?>
            </p>
        </div>

        <div class="team-grid">
            <?php foreach ($cards_raw as $c) :
                if ($raw_is_flat) {
                    $n     = $c['n'];
                    $label = $c['label'];
                    $note  = $c['note'];
                } else {
                    $n     = esc_html($c['n']);
                    $label = esc_html($c['label_' . $lang] ?? $c['label_fr'] ?? '');
                    $note  = esc_html($c['note_' . $lang] ?? $c['note_fr'] ?? '');
                }
            ?>
            <div class="team-card">
                <div class="team-n"><?php echo esc_html($n); ?></div>
                <div class="team-label"><?php echo esc_html($label); ?></div>
                <div class="team-note"><?php echo esc_html($note); ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if ($bureau) : ?>
        <div class="members-bureau"><?php echo esc_html($bureau); ?></div>
        <?php endif; ?>
    </div>
</section>
