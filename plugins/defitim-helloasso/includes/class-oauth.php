<?php
defined('ABSPATH') || exit;

class DTIM_HA_OAuth {

    private string $client_id;
    private string $client_secret;
    private bool   $sandbox;
    private string $token_url;

    public function __construct() {
        $this->client_id     = get_option('dtim_ha_client_id', '');
        $this->client_secret = get_option('dtim_ha_client_secret', '');
        $this->sandbox       = (bool) get_option('dtim_ha_sandbox', true);
        $base = $this->sandbox ? 'https://api.helloasso-sandbox.com' : 'https://api.helloasso.com';
        $this->token_url = $base . '/oauth2/token';
    }

    public function get_access_token(): string|WP_Error {
        $cached = get_transient('dtim_ha_access_token');
        if ($cached) return $cached;

        if (!$this->client_id || !$this->client_secret) {
            return new WP_Error('ha_no_credentials', __('HelloAsso credentials not configured.', 'defitim-helloasso'));
        }

        $response = wp_remote_post($this->token_url, [
            'timeout' => 15,
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            'body'    => [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
            ],
        ]);

        if (is_wp_error($response)) return $response;

        $code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if ($code !== 200 || empty($body['access_token'])) {
            return new WP_Error('ha_token_error', sprintf(
                __('HelloAsso token error (HTTP %d): %s', 'defitim-helloasso'),
                $code,
                $body['error_description'] ?? 'Unknown error'
            ));
        }

        $expires_in = (int) ($body['expires_in'] ?? 1800);
        set_transient('dtim_ha_access_token', $body['access_token'], $expires_in - 60);

        return $body['access_token'];
    }

    public function get_base_url(): string {
        return $this->sandbox
            ? 'https://api.helloasso-sandbox.com/v5'
            : 'https://api.helloasso.com/v5';
    }
}
