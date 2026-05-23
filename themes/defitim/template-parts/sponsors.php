<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

// ACF repeater on options: sponsors (subfields: logo (image), name, url)
$sponsors = function_exists('get_field') ? get_field('sponsors', 'option') : null;
?>
<section class="section section-cream sponsors">
    <div class="section-inner">
        <div class="sponsors-head">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--accent)"></span>
                <span><?php echo $is_en ? 'Supporters' : 'Ils nous soutiennent'; ?></span>
            </div>
            <h2 class="section-title"><?php echo $is_en ? 'Partners & sponsors' : 'Partenaires & mécènes'; ?></h2>
        </div>

        <div class="sponsor-grid">
            <?php if (!empty($sponsors)) :
                foreach ($sponsors as $s) :
                    $logo = $s['logo'] ?? null;
                    $name = esc_html($s['name'] ?? '');
                    $url  = esc_url($s['url'] ?? '');
            ?>
            <div class="sponsor">
                <?php if ($url) : ?><a href="<?php echo $url; ?>" rel="noopener noreferrer" target="_blank"><?php endif; ?>
                <?php if (!empty($logo['url'])) : ?>
                    <img src="<?php echo esc_url($logo['url']); ?>"
                         alt="<?php echo $name ?: ($is_en ? 'Sponsor' : 'Mécène'); ?>"
                         loading="lazy">
                <?php else : ?>
                    <div class="sponsor-placeholder"><?php echo $name ?: ($is_en ? 'Sponsor' : 'Mécène'); ?></div>
                <?php endif; ?>
                <?php if ($url) : ?></a><?php endif; ?>
            </div>
            <?php endforeach;
            else : ?>
            <?php for ($i = 1; $i <= 8; $i++) : ?>
            <div class="sponsor">
                <div class="sponsor-placeholder"><?php echo $is_en ? 'Partner ' . $i : 'Partenaire ' . $i; ?></div>
            </div>
            <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
