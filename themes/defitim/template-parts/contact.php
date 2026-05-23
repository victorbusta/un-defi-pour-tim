<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

// ACF: contact_cards repeater (role, name, tel, mail)
$cards_raw = function_exists('get_field') ? get_field('contact_cards', 'option') : null;
if (!$cards_raw) {
    $cards_raw = $is_en ? [
        ['role' => 'Project lead',       'name' => 'Adjudant-Chef Benjamin GUY', 'tel' => '+33 6 69 65 81 45', 'mail' => 'benjamin.guy@pompiersparis.fr'],
        ['role' => 'Project coordinator','name' => 'Timothé Bernardeau',          'tel' => '+33 6 22 16 24 33', 'mail' => 'bernardeau.t@gmail.com'],
    ] : [
        ['role' => 'Responsable projet',  'name' => 'Adjudant-Chef Benjamin GUY', 'tel' => '06 69 65 81 45', 'mail' => 'benjamin.guy@pompiersparis.fr'],
        ['role' => 'Coordinateur projet', 'name' => 'Timothé Bernardeau',          'tel' => '06 22 16 24 33', 'mail' => 'bernardeau.t@gmail.com'],
    ];
}

$social_ig   = dt_opt('social_instagram', '#');
$social_fb   = dt_opt('social_facebook',  '#');
$social_li   = dt_opt('social_linkedin',  '#');
$social_bspp = dt_opt('social_bspp',      'https://www.pompiersparis.fr');

$nonce = wp_create_nonce('defitim_contact');
?>
<section class="section section-navy section-contact" id="contact">
    <div class="section-inner contact-grid">
        <div class="contact-left">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--brass)"></span>
                <span>Contact</span>
            </div>
            <h2 class="section-title section-title-light">
                <?php echo $is_en ? "We'll reply." : 'On vous répond.'; ?>
            </h2>
            <p class="lede lede-light">
                <?php echo $is_en
                    ? 'For a question, an event idea or a sponsorship pack, two direct contacts inside the collective.'
                    : 'Pour une question, un projet d\'événement ou un dossier de mécénat, deux contacts directs au sein du collectif.'; ?>
            </p>

            <div class="contact-cards">
                <?php foreach ($cards_raw as $c) :
                    $tel  = esc_html($c['tel']);
                    $tel_href = 'tel:' . preg_replace('/\s/', '', $c['tel']);
                ?>
                <div class="contact-card">
                    <div class="contact-card-role"><?php echo esc_html($c['role']); ?></div>
                    <div class="contact-card-name"><?php echo esc_html($c['name']); ?></div>
                    <div class="contact-card-row">
                        <span class="contact-card-l">Tél</span>
                        <a href="<?php echo esc_url($tel_href); ?>"><?php echo $tel; ?></a>
                    </div>
                    <div class="contact-card-row">
                        <span class="contact-card-l">Mail</span>
                        <a href="<?php echo esc_url('mailto:' . $c['mail']); ?>"><?php echo esc_html($c['mail']); ?></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="contact-don">
                <div class="contact-don-label">
                    <?php echo $is_en ? 'Donations by cheque, payable to « ASASPP »' : 'Dons en chèque à l\'ordre de « ASASPP »'; ?>
                </div>
                <div class="contact-don-addr">
                    <?php echo $is_en ? 'BSPP — Caserne Masséna, 3 rue Darmesteter, 75013 Paris' : 'BSPP — Caserne Masséna, 3 rue Darmesteter, 75013 Paris'; ?>
                </div>
            </div>

            <div class="contact-social">
                <div class="contact-direct-label"><?php echo $is_en ? 'Follow the BSPP' : 'Suivre la BSPP'; ?></div>
                <div class="contact-social-row">
                    <a href="<?php echo esc_url($social_ig); ?>" rel="noopener noreferrer" target="_blank" aria-label="Instagram">IG</a>
                    <a href="<?php echo esc_url($social_fb); ?>" rel="noopener noreferrer" target="_blank" aria-label="Facebook">FB</a>
                    <a href="<?php echo esc_url($social_li); ?>" rel="noopener noreferrer" target="_blank" aria-label="LinkedIn">IN</a>
                    <a href="<?php echo esc_url($social_bspp); ?>" rel="noopener noreferrer" target="_blank" aria-label="Site BSPP">BSPP</a>
                </div>
            </div>
        </div>

        <form class="contact-form" id="contact-form" novalidate>
            <?php wp_nonce_field('defitim_contact', 'nonce'); ?>
            <div class="cf-row">
                <label>
                    <span><?php echo $is_en ? 'Name' : 'Nom'; ?></span>
                    <input type="text" name="nom" required
                           placeholder="<?php echo $is_en ? 'Your name' : 'Votre nom'; ?>">
                </label>
                <label>
                    <span>Email</span>
                    <input type="email" name="email" required
                           placeholder="<?php echo $is_en ? 'your@email.com' : 'votre@email.fr'; ?>">
                </label>
            </div>
            <label class="cf-full">
                <span><?php echo $is_en ? 'Subject' : 'Sujet'; ?></span>
                <input type="text" name="sujet"
                       value="<?php echo $is_en ? 'Sponsorship — Un défi pour Tim' : 'Mécénat — Un défi pour Tim'; ?>"
                       required>
            </label>
            <label class="cf-full">
                <span>Message</span>
                <textarea name="message" rows="5" required
                          placeholder="<?php echo $is_en ? 'Your message…' : 'Votre message…'; ?>"></textarea>
            </label>

            <div class="cf-feedback" role="alert" aria-live="polite" hidden></div>

            <button class="btn btn-primary btn-lg" type="submit">
                <?php echo $is_en ? 'Send' : 'Envoyer'; ?>
                <?php echo dt_arrow(); ?>
            </button>
        </form>
    </div>
</section>
