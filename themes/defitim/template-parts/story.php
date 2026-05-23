<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

$body_a = dt_opt('story_body_a_' . $lang, $is_en
    ? 'September 2012. Timothé Bernardeau, born in Nantes, joins the Paris Firefighters Brigade (BSPP). He\'s posted to the 11th company in the Marais district, as engine driver. Many large-scale interventions, including the January and November 2015 attacks. Several letters of commendation from command.'
    : "Septembre 2012. Timothé Bernardeau, jeune Nantais, incorpore la Brigade de Sapeurs-Pompiers de Paris. Il rejoint la 11e compagnie d'incendie et de secours, dans le Marais, comme conducteur d'engin-pompe. De nombreuses interventions d'ampleur, dont les attentats de janvier et novembre 2015. Plusieurs lettres de félicitations du commandement.");

$body_b = dt_opt('story_body_b_' . $lang, $is_en
    ? 'April 2015: Tim, an exceptional athlete, joins the Brigade gymnastics group — founded in 1919, the BSPP\'s sporting and artistic ambassador. In three years, over 40 performances across France and Europe.'
    : "Avril 2015 : Tim, sportif d'exception, intègre le groupe de gymnastique de la Brigade — fondé en 1919, ambassadeur sportif et artistique de la BSPP. En trois ans, plus de 40 représentations en France et en Europe.");

$body_c = dt_opt('story_body_c_' . $lang, $is_en
    ? 'May 2018. During a show in support of sick children, Tim falls hard. Tetraplegia. Nearly two and a half years at the Institution Nationale des Invalides, then home — with his partner (a nurse) and their daughter Lyla. At 33, his resilience is unwavering. And the bond with the station has never broken either.'
    : "Mai 2018. Lors d'une représentation au profit d'enfants malades, Tim chute lourdement. Tétraplégie. Près de deux ans et demi à l'Institution Nationale des Invalides, puis le retour à la maison, avec sa compagne infirmière et leur fille Lyla. À 33 ans, sa résilience est sans faille. Le lien avec la caserne, lui non plus, n'a jamais cassé.");

$photo_main = dt_opt('story_photo_main');
$photo_sub  = dt_opt('story_photo_sub');

$bureau = dt_opt('members_bureau_' . $lang, $is_en
    ? 'Association board: Adj-Chef Benjamin GUY (president) · Timothé Bernardeau (coordinator) · founding members from inside the BSPP.'
    : "Bureau de l'association : Adj-Chef Benjamin GUY (président) · Timothé Bernardeau (coordinateur) · membres fondateurs au sein de la BSPP.");

$timeline_fr = [
    ['y' => '2012', 'e' => 'Incorpore la BSPP, 11e compagnie d\'incendie, Marais.'],
    ['y' => '2015', 'e' => 'Rejoint le groupe de gymnastique de la Brigade.'],
    ['y' => '2018', 'e' => 'Chute en représentation. Tétraplégie.'],
    ['y' => '2023', 'e' => 'Court avec ses frères d\'armes sur la Tunnel to Towers (NYC).'],
    ['y' => '2025', 'e' => 'Course au profit du Bleuet de France.'],
    ['y' => '2026', 'e' => 'Marathon de l\'Espace, Kourou. En relais autour de Tim.'],
];
$timeline_en = [
    ['y' => '2012', 'e' => 'Joins the BSPP — 11th company, Marais district.'],
    ['y' => '2015', 'e' => 'Joins the Brigade gymnastics group.'],
    ['y' => '2018', 'e' => 'Fall during a performance. Tetraplegia.'],
    ['y' => '2023', 'e' => 'Runs with his brothers in arms at Tunnel to Towers, NYC.'],
    ['y' => '2025', 'e' => 'Charity run in support of the Bleuet de France.'],
    ['y' => '2026', 'e' => 'Marathon de l\'Espace, Kourou — in relay around Tim.'],
];
$timeline = $is_en ? $timeline_en : $timeline_fr;
?>
<section class="section section-cream" id="story">
    <div class="section-inner story-grid">
        <div class="story-media">
            <div class="story-photo">
                <?php if (!empty($photo_main['url'])) : ?>
                <img src="<?php echo esc_url($photo_main['url']); ?>"
                     alt="<?php echo esc_attr($photo_main['alt'] ?? 'Tim — groupe de gymnastique BSPP'); ?>"
                     loading="lazy">
                <?php else : ?>
                <div class="story-photo-placeholder"></div>
                <?php endif; ?>
            </div>
            <div class="story-photo-sub">
                <?php if (!empty($photo_sub['url'])) : ?>
                <img src="<?php echo esc_url($photo_sub['url']); ?>"
                     alt="<?php echo esc_attr($photo_sub['alt'] ?? 'Équipe — 11e compagnie d\'incendie, Marais'); ?>"
                     loading="lazy">
                <?php else : ?>
                <div class="story-photo-placeholder"></div>
                <?php endif; ?>
            </div>
            <div class="story-stamp">BSPP · 2012—2018</div>
        </div>

        <div class="story-copy">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--accent)"></span>
                <span><?php echo $is_en ? 'The Story' : "L'Histoire"; ?></span>
            </div>

            <h2 class="section-title">
                <?php echo $is_en
                    ? 'A corporal. A gymnastics team. A thread that doesn\'t break.'
                    : 'Un caporal. Une équipe de gym. Un fil qui ne casse pas.'; ?>
            </h2>

            <p class="lede"><?php echo esc_html($body_a); ?></p>
            <p class="lede"><?php echo esc_html($body_b); ?></p>
            <p class="lede"><?php echo esc_html($body_c); ?></p>

            <div class="timeline" aria-label="<?php echo $is_en ? 'Timeline' : 'Chronologie'; ?>">
                <?php foreach ($timeline as $tl) : ?>
                <div class="timeline-row">
                    <div class="timeline-y"><?php echo esc_html($tl['y']); ?></div>
                    <div class="timeline-bar" aria-hidden="true"></div>
                    <div class="timeline-e"><?php echo esc_html($tl['e']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <blockquote class="pull-quote">
                <div class="pull-quote-mark" aria-hidden="true">"</div>
                <div class="pull-quote-text">
                    <?php echo $is_en
                        ? '"The cohesion and brotherhood of the BSPP know no limits. Seven years on, we cross the line with him."'
                        : '« La cohésion et la fraternité de la BSPP sont sans limite. Sept ans après son accident, on franchit la ligne avec lui. »'; ?>
                </div>
                <div class="pull-quote-who"><?php echo $is_en ? '— The Un Défi pour Tim collective' : '— Le collectif Un Défi pour Tim'; ?></div>
            </blockquote>

            <a href="#defis" class="btn btn-outline">
                <?php echo $is_en ? 'See the challenge in detail' : 'Voir le défi en détail'; ?>
                <?php echo dt_arrow(); ?>
            </a>
        </div>
    </div>
</section>
