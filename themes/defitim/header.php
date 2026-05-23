<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$lang     = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en    = $lang === 'en';
$lang_urls = dt_lang_urls();

$nav = $is_en ? [
    'story'   => 'The Story',
    'defis'   => 'Challenges',
    'members' => 'Members',
    'mecenat' => 'Sponsors',
    'faq'     => 'FAQ',
    'contact' => 'Contact',
    'donate'  => 'Donate',
] : [
    'story'   => "L'Histoire",
    'defis'   => 'Les Défis',
    'members' => 'Membres',
    'mecenat' => 'Mécénat',
    'faq'     => 'FAQ',
    'contact' => 'Contact',
    'donate'  => 'Faire un don',
];
?>
<header class="topbar" role="banner">
    <div class="topbar-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="brand">
            <span class="brand-mark" aria-hidden="true">
                <span class="brand-mark-bar"></span>
                <span class="brand-mark-bar"></span>
                <span class="brand-mark-bar"></span>
            </span>
            <span class="brand-text">
                <span class="brand-defi">DÉFI</span>
                <span class="brand-tim">TIM</span>
            </span>
        </a>

        <nav class="nav" aria-label="<?php esc_attr_e('Navigation principale', 'defitim'); ?>">
            <a href="#story"><?php echo esc_html($nav['story']); ?></a>
            <a href="#defis"><?php echo esc_html($nav['defis']); ?></a>
            <a href="#members"><?php echo esc_html($nav['members']); ?></a>
            <a href="#mecenat"><?php echo esc_html($nav['mecenat']); ?></a>
            <a href="#faq"><?php echo esc_html($nav['faq']); ?></a>
            <a href="#contact"><?php echo esc_html($nav['contact']); ?></a>
        </nav>

        <div class="topbar-right">
            <?php if (!empty($lang_urls)) : ?>
            <div class="lang-switch" role="group" aria-label="Language">
                <?php foreach ($lang_urls as $ldata) :
                    $is_current = !empty($ldata['current_lang']);
                    $slug = esc_attr($ldata['slug']);
                ?>
                <a href="<?php echo esc_url($ldata['url']); ?>"
                   class="lang-btn<?php echo $is_current ? ' active' : ''; ?>"
                   <?php if ($is_current) echo 'aria-current="true"'; ?>>
                    <?php echo esc_html(strtoupper($ldata['slug'])); ?>
                </a>
                <?php if (!$is_current) : ?><span class="lang-sep" aria-hidden="true">/</span><?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php else : ?>
            <div class="lang-switch" role="group" aria-label="Language">
                <span class="lang-btn active">FR</span>
            </div>
            <?php endif; ?>

            <a href="#help" class="btn btn-primary btn-sm">
                <?php echo esc_html($nav['donate']); ?>
                <?php echo dt_arrow(); ?>
            </a>

            <button class="nav-toggle" aria-label="<?php esc_attr_e('Menu', 'defitim'); ?>" aria-expanded="false" aria-controls="nav-mobile">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <nav class="nav-mobile" id="nav-mobile" aria-label="<?php esc_attr_e('Menu mobile', 'defitim'); ?>" hidden>
        <a href="#story"><?php echo esc_html($nav['story']); ?></a>
        <a href="#defis"><?php echo esc_html($nav['defis']); ?></a>
        <a href="#members"><?php echo esc_html($nav['members']); ?></a>
        <a href="#mecenat"><?php echo esc_html($nav['mecenat']); ?></a>
        <a href="#faq"><?php echo esc_html($nav['faq']); ?></a>
        <a href="#contact"><?php echo esc_html($nav['contact']); ?></a>
        <a href="#help" class="btn btn-primary"><?php echo esc_html($nav['donate']); ?></a>
    </nav>
</header>
