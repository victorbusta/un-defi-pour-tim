<?php
/**
 * Plugin Name: Défi Tim — HelloAsso
 * Plugin URI:  https://undefipourtim.com
 * Description: HelloAsso checkout integration for Un Défi pour Tim. Configure API keys in Settings → HelloAsso.
 * Version:     1.0.0
 * Author:      Un Défi pour Tim
 * Text Domain: defitim-helloasso
 * License:     GPL-2.0-or-later
 */
defined('ABSPATH') || exit;

define('DTIM_HA_VERSION', '1.0.0');
define('DTIM_HA_DIR',     plugin_dir_path(__FILE__));
define('DTIM_HA_URL',     plugin_dir_url(__FILE__));

/* ============================================================
   AUTOLOAD CLASSES
   ============================================================ */
require DTIM_HA_DIR . 'includes/class-oauth.php';
require DTIM_HA_DIR . 'includes/class-checkout.php';
require DTIM_HA_DIR . 'includes/class-webhook.php';

/* ============================================================
   ADMIN SETTINGS PAGE
   ============================================================ */
add_action('admin_menu', function () {
    add_options_page(
        'HelloAsso — Défi Tim',
        'HelloAsso',
        'manage_options',
        'defitim-helloasso',
        'dtim_ha_settings_page'
    );
});

add_action('admin_init', function () {
    register_setting('dtim_ha', 'dtim_ha_client_id',     ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('dtim_ha', 'dtim_ha_client_secret', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('dtim_ha', 'dtim_ha_org_slug',      ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('dtim_ha', 'dtim_ha_webhook_secret',['sanitize_callback' => 'sanitize_text_field']);
    register_setting('dtim_ha', 'dtim_ha_sandbox',       ['sanitize_callback' => 'rest_sanitize_boolean']);
    register_setting('dtim_ha', 'dtim_ha_return_url',    ['sanitize_callback' => 'esc_url_raw']);
    register_setting('dtim_ha', 'dtim_ha_error_url',     ['sanitize_callback' => 'esc_url_raw']);
    register_setting('dtim_ha', 'dtim_ha_back_url',      ['sanitize_callback' => 'esc_url_raw']);
});

function dtim_ha_settings_page() {
    if (!current_user_can('manage_options')) return;
    $sandbox = get_option('dtim_ha_sandbox', true);
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('HelloAsso — Défi Tim', 'defitim-helloasso'); ?></h1>
        <p><?php esc_html_e('Entrez vos identifiants HelloAsso. Les clés sont stockées dans la base de données WordPress — jamais dans les fichiers de code.', 'defitim-helloasso'); ?></p>

        <?php if ($sandbox) : ?>
        <div class="notice notice-warning inline">
            <p><?php esc_html_e('Mode sandbox actif — les paiements sont simulés. Désactivez avant la mise en production.', 'defitim-helloasso'); ?></p>
        </div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields('dtim_ha'); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="dtim_ha_client_id"><?php esc_html_e('Client ID', 'defitim-helloasso'); ?></label></th>
                    <td><input type="text" id="dtim_ha_client_id" name="dtim_ha_client_id" class="regular-text"
                               value="<?php echo esc_attr(get_option('dtim_ha_client_id')); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="dtim_ha_client_secret"><?php esc_html_e('Client Secret', 'defitim-helloasso'); ?></label></th>
                    <td><input type="password" id="dtim_ha_client_secret" name="dtim_ha_client_secret" class="regular-text"
                               value="<?php echo esc_attr(get_option('dtim_ha_client_secret')); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="dtim_ha_org_slug"><?php esc_html_e('Organisation slug', 'defitim-helloasso'); ?></label></th>
                    <td>
                        <input type="text" id="dtim_ha_org_slug" name="dtim_ha_org_slug" class="regular-text"
                               value="<?php echo esc_attr(get_option('dtim_ha_org_slug')); ?>">
                        <p class="description"><?php esc_html_e('Identifiant de l\'association dans l\'URL HelloAsso.', 'defitim-helloasso'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="dtim_ha_webhook_secret"><?php esc_html_e('Webhook secret', 'defitim-helloasso'); ?></label></th>
                    <td><input type="password" id="dtim_ha_webhook_secret" name="dtim_ha_webhook_secret" class="regular-text"
                               value="<?php echo esc_attr(get_option('dtim_ha_webhook_secret')); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Mode', 'defitim-helloasso'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="dtim_ha_sandbox" value="1" <?php checked($sandbox); ?>>
                            <?php esc_html_e('Sandbox (test) — désactiver pour la production', 'defitim-helloasso'); ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="dtim_ha_return_url"><?php esc_html_e('URL de retour (succès)', 'defitim-helloasso'); ?></label></th>
                    <td><input type="url" id="dtim_ha_return_url" name="dtim_ha_return_url" class="regular-text"
                               value="<?php echo esc_attr(get_option('dtim_ha_return_url', home_url('/?don=merci'))); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="dtim_ha_error_url"><?php esc_html_e('URL d\'erreur', 'defitim-helloasso'); ?></label></th>
                    <td><input type="url" id="dtim_ha_error_url" name="dtim_ha_error_url" class="regular-text"
                               value="<?php echo esc_attr(get_option('dtim_ha_error_url', home_url('/?don=erreur'))); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="dtim_ha_back_url"><?php esc_html_e('URL retour arrière', 'defitim-helloasso'); ?></label></th>
                    <td><input type="url" id="dtim_ha_back_url" name="dtim_ha_back_url" class="regular-text"
                               value="<?php echo esc_attr(get_option('dtim_ha_back_url', home_url('/#help'))); ?>"></td>
                </tr>
            </table>
            <?php submit_button(__('Enregistrer', 'defitim-helloasso')); ?>
        </form>

        <hr>
        <h2><?php esc_html_e('Webhook endpoint', 'defitim-helloasso'); ?></h2>
        <p><?php printf(
            esc_html__('Configurez cette URL dans votre back-office HelloAsso : %s', 'defitim-helloasso'),
            '<code>' . esc_html(rest_url('defitim-helloasso/v1/webhook')) . '</code>'
        ); ?></p>
    </div>
    <?php
}

/* ============================================================
   REST API — WEBHOOK ENDPOINT
   ============================================================ */
add_action('rest_api_init', function () {
    register_rest_route('defitim-helloasso/v1', '/webhook', [
        'methods'             => 'POST',
        'callback'            => 'dtim_ha_webhook_handler',
        'permission_callback' => '__return_true',
    ]);
});

function dtim_ha_webhook_handler(WP_REST_Request $request) {
    $webhook = new DTIM_HA_Webhook();
    return $webhook->handle($request);
}

/* ============================================================
   AJAX — CREATE CHECKOUT INTENT
   ============================================================ */
add_action('wp_ajax_defitim_helloasso_checkout',        'dtim_ha_ajax_checkout');
add_action('wp_ajax_nopriv_defitim_helloasso_checkout', 'dtim_ha_ajax_checkout');

function dtim_ha_ajax_checkout() {
    if (!check_ajax_referer('defitim_contact', 'nonce', false)) {
        wp_send_json_error(['message' => 'Invalid nonce'], 403);
    }

    $amount_cents = absint($_POST['amount_cents'] ?? 5000);
    if ($amount_cents < 100) {
        wp_send_json_error(['message' => 'Minimum donation is €1'], 422);
    }

    $checkout = new DTIM_HA_Checkout();
    $result   = $checkout->create_intent($amount_cents);

    if (is_wp_error($result)) {
        wp_send_json_error(['message' => $result->get_error_message()], 500);
    }

    wp_send_json_success(['redirect_url' => $result]);
}
