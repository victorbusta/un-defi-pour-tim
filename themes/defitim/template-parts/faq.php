<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

// ACF repeater: faq_items (subfields: q_fr, q_en, a_fr, a_en)
$faq_raw = function_exists('get_field') ? get_field('faq_items', 'option') : null;
$items = [];
if ($faq_raw) {
    foreach ($faq_raw as $row) {
        $items[] = [
            'q' => $row['q_' . $lang] ?? $row['q_fr'] ?? '',
            'a' => $row['a_' . $lang] ?? $row['a_fr'] ?? '',
        ];
    }
} else {
    $items = $is_en ? [
        ['q' => 'How do I donate?',
         'a' => 'By cheque, payable to « ASASPP », posted to BSPP — Caserne Masséna, 3 rue Darmesteter, 75013 Paris. For online giving or corporate sponsorship, contact Adjudant-Chef Benjamin GUY.'],
        ['q' => 'Where does the money actually go?',
         'a' => 'Detailed in the Sponsors section: flights (€25,000), accommodation (€12,000), meals, official outfits, race entry, local transport, visits. On a €52,780 total budget, the section contributes €10,000 — €42,780 left to raise.'],
        ['q' => 'Why Kourou?',
         'a' => 'Kourou is one of the detachments of the Paris Firefighters Brigade. The Marathon de l\'Espace is held there every year since 1991, on the occasion of an Ariane launch.'],
        ['q' => "What's the race format?",
         'a' => 'A 42.195 km marathon in relay. Five legs of 7.5 to 9.4 km, then a final kilometre — 1.775 km exactly — run all together, with Tim, to the finish line.'],
        ['q' => 'Can my company become a sponsor?',
         'a' => 'Yes. Banner, outfits, BSPP gym demos, social media: your brand is visible before, during and after the challenge. Contact Adjudant-Chef Benjamin GUY for the full sponsor pack.'],
        ['q' => 'Does Tim know what\'s happening?',
         'a' => 'Of course. Tim is the project coordinator — he lives every step, reads every message, and will be on the finish line with his brothers in arms.'],
    ] : [
        ['q' => 'Comment faire un don ?',
         'a' => 'Par chèque à l\'ordre de « ASASPP », envoyé par voie postale à la BSPP — Caserne Masséna, 3 rue Darmesteter, 75013 Paris. Pour un don en ligne ou un mécénat d\'entreprise, contactez l\'Adjudant-Chef Benjamin GUY.'],
        ['q' => 'Où va concrètement l\'argent collecté ?',
         'a' => 'Le détail figure dans la section Mécénat : transport (25 000 €), hébergement (12 000 €), restauration, tenues du défi, inscription, transports sur place et visites. Sur 52 780 € de budget total, la section apporte 10 000 € — il reste 42 780 € à collecter.'],
        ['q' => 'Pourquoi Kourou ?',
         'a' => "Kourou est un des détachements de la Brigade de Sapeurs-Pompiers de Paris. Le Marathon de l'Espace y est organisé chaque année, depuis 1991, à l'occasion d'un lancement d'Ariane."],
        ['q' => 'Quel est le format de la course ?',
         'a' => "Un marathon de 42,195 km en relais. Cinq segments de 7,5 à 9,4 km, puis un dernier kilomètre — 1,775 km exactement — couru tous ensemble, avec Tim, jusqu'à la ligne d'arrivée."],
        ['q' => 'Mon entreprise peut-elle devenir mécène ?',
         'a' => "Oui. Banderole, tenues, démonstrations de la gym BSPP, communications réseaux : votre marque est exposée avant, pendant et après le défi. Contactez l'Adjudant-Chef Benjamin GUY pour recevoir le dossier complet."],
        ['q' => 'Tim est-il informé de ce qui se passe ?',
         'a' => 'Évidemment. Tim est coordinateur du projet — il vit chaque étape, lit chaque message, et sera sur la ligne d\'arrivée avec ses frères d\'armes.'],
    ];
}
?>
<section class="section section-cream" id="faq">
    <div class="section-inner faq-inner">
        <div class="faq-head">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--accent)"></span>
                <span><?php echo $is_en ? 'Questions' : 'Questions'; ?></span>
            </div>
            <h2 class="section-title"><?php echo $is_en ? 'You might be wondering…' : 'Vous vous demandez…'; ?></h2>
        </div>

        <div class="faq-list">
            <?php foreach ($items as $i => $item) : ?>
            <div class="faq-item<?php echo $i === 0 ? ' faq-open' : ''; ?>">
                <button class="faq-q"
                        type="button"
                        aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                        aria-controls="faq-a-<?php echo $i; ?>">
                    <span class="faq-q-n">0<?php echo $i + 1; ?></span>
                    <span class="faq-q-t"><?php echo esc_html($item['q']); ?></span>
                    <span class="faq-q-x" aria-hidden="true"><?php echo $i === 0 ? '–' : '+'; ?></span>
                </button>
                <div class="faq-a"
                     id="faq-a-<?php echo $i; ?>"
                     <?php echo $i === 0 ? '' : 'hidden'; ?>>
                    <?php echo esc_html($item['a']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
