<?php
defined('ABSPATH') || exit;

$lang  = function_exists('pll_current_language') ? pll_current_language() : 'fr';
$is_en = $lang === 'en';

$helloasso_url = dt_opt('helloasso_url', '');
$presets = [20, 50, 100, 250];
?>
<section class="section section-cream" id="help">
    <div class="section-inner">
        <div class="help-head">
            <div class="kicker">
                <span class="kicker-dot" style="background:var(--accent)"></span>
                <span><?php echo $is_en ? 'Support Tim' : 'Soutenir Tim'; ?></span>
            </div>
            <h2 class="section-title">
                <?php echo $is_en ? 'Three ways to act.' : 'Trois façons d\'agir.'; ?>
            </h2>
        </div>

        <div class="help-grid">
            <div class="help-donate">
                <div class="help-donate-top">
                    <div class="help-donate-num">01</div>
                    <h3 class="help-donate-title"><?php echo $is_en ? 'Give' : 'Donner'; ?></h3>
                </div>
                <p class="help-donate-body">
                    <?php echo $is_en
                        ? 'Cheque payable to « ASASPP » — posted to BSPP, Caserne Masséna, 3 rue Darmesteter, 75013 Paris. Or donate online via HelloAsso.'
                        : 'Don en chèque à l\'ordre de « ASASPP » — adressé à la BSPP, Caserne Masséna, 3 rue Darmesteter, 75013 Paris. Ou donnez en ligne via HelloAsso.'; ?>
                </p>

                <div class="help-donate-pick">
                    <div class="help-donate-pick-label">
                        <?php echo $is_en ? 'Suggested gift' : 'Don suggéré'; ?>
                    </div>
                    <div class="help-donate-amounts" role="group" aria-label="<?php echo $is_en ? 'Donation amount' : 'Montant du don'; ?>">
                        <?php foreach ($presets as $p) : ?>
                        <button class="amt<?php echo $p === 50 ? ' amt-active' : ''; ?>"
                                type="button"
                                data-amount="<?php echo esc_attr($p); ?>"
                                aria-pressed="<?php echo $p === 50 ? 'true' : 'false'; ?>">
                            €<?php echo esc_html($p); ?>
                        </button>
                        <?php endforeach; ?>
                        <div class="amt amt-custom">
                            <span aria-hidden="true">€</span>
                            <input type="number"
                                   id="amount-custom"
                                   min="1"
                                   placeholder="<?php echo $is_en ? 'Other' : 'Autre'; ?>"
                                   aria-label="<?php echo $is_en ? 'Custom amount in euros' : 'Montant libre en euros'; ?>">
                        </div>
                    </div>
                    <div class="help-donate-sub">
                        <?php echo $is_en
                            ? 'Payable to « ASASPP ». Tax receipt issued for eligible donations.'
                            : 'Don à l\'ordre de « ASASPP ». Reçu fiscal pour les dons éligibles.'; ?>
                    </div>

                    <?php if ($helloasso_url) : ?>
                    <a href="<?php echo esc_url($helloasso_url); ?>"
                       class="btn btn-primary btn-lg help-donate-go"
                       id="donate-btn"
                       target="_blank"
                       rel="noopener noreferrer">
                        <?php echo $is_en ? 'Donate now' : 'Faire un don'; ?> · <span id="donate-amount">€50</span>
                        <?php echo dt_arrow(); ?>
                    </a>
                    <?php else : ?>
                    <button class="btn btn-primary btn-lg help-donate-go"
                            id="donate-btn"
                            type="button">
                        <?php echo $is_en ? 'Prepare my donation' : 'Préparer mon don'; ?> · <span id="donate-amount">€50</span>
                        <?php echo dt_arrow(); ?>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="help-side">
                <div class="help-card">
                    <div class="help-card-num">02</div>
                    <h3 class="help-card-title"><?php echo $is_en ? 'Become a sponsor' : 'Devenir mécène'; ?></h3>
                    <p class="help-card-body">
                        <?php echo $is_en
                            ? 'Are you a company, an alumni group, a club? Tie your name to the project. The sponsor pack details every level of commitment and visibility.'
                            : 'Vous êtes une entreprise, une amicale, un club ? Associez votre nom au projet. Le dossier de mécénat détaille tous les niveaux d\'engagement et les contreparties.'; ?>
                    </p>
                    <a href="#contact" class="help-card-cta">
                        <?php echo $is_en ? 'Contact the team' : "Contacter l'équipe"; ?>
                        <?php echo dt_arrow(); ?>
                    </a>
                </div>
                <div class="help-card">
                    <div class="help-card-num">03</div>
                    <h3 class="help-card-title"><?php echo $is_en ? 'Share' : 'Partager'; ?></h3>
                    <p class="help-card-body">
                        <?php echo $is_en
                            ? 'Follow and reshare our posts before, during and after the trip. Every share counts as much as a donation.'
                            : 'Suivez et relayez nos publications avant, pendant et après le séjour. Chaque partage compte autant qu\'un don.'; ?>
                    </p>
                    <button class="help-card-cta" type="button" id="share-btn">
                        <?php echo $is_en ? 'Share the page' : 'Partager la page'; ?>
                        <?php echo dt_arrow(); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
