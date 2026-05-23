<?php
$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';
?>
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="brand-mark" aria-hidden="true">
                <span class="brand-mark-bar"></span>
                <span class="brand-mark-bar"></span>
                <span class="brand-mark-bar"></span>
            </span>
            <span class="brand-text">
                <span class="brand-defi">DÉFI</span>
                <span class="brand-tim">TIM</span>
            </span>
        </div>

        <p class="footer-tag">
            <?php echo $is_en
                ? 'Un défi pour Tim — an event initiated by the Paris Firefighters Brigade in support of Corporal Timothé Bernardeau.'
                : 'Un défi pour Tim — événement initié par la Brigade de Sapeurs-Pompiers de Paris en soutien au caporal Timothé Bernardeau.'; ?>
        </p>

        <div class="footer-links">
            <?php
            $legal_page   = get_page_by_path('mentions-legales');
            $privacy_page = get_page_by_path('confidentialite');
            ?>
            <?php if ($legal_page) : ?>
            <a href="<?php echo esc_url(get_permalink($legal_page)); ?>"><?php echo $is_en ? 'Legal' : 'Mentions légales'; ?></a>
            <?php else : ?>
            <a href="#"><?php echo $is_en ? 'Legal' : 'Mentions légales'; ?></a>
            <?php endif; ?>

            <?php if ($privacy_page) : ?>
            <a href="<?php echo esc_url(get_permalink($privacy_page)); ?>"><?php echo $is_en ? 'Privacy' : 'Confidentialité'; ?></a>
            <?php else : ?>
            <a href="#"><?php echo $is_en ? 'Privacy' : 'Confidentialité'; ?></a>
            <?php endif; ?>

            <a href="#contact">Contact</a>
        </div>

        <div class="footer-copy">
            <?php echo $is_en
                ? '© 2026 Un Défi pour Tim collective. Supported by the BSPP.'
                : '© 2026 Collectif Un Défi pour Tim. Soutenu par la BSPP.'; ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
