<?php
defined('ABSPATH') || exit;

class DTIM_HA_Checkout {

    private DTIM_HA_OAuth $oauth;

    public function __construct() {
        $this->oauth = new DTIM_HA_OAuth();
    }

    /**
     * Create a HelloAsso checkout intent.
     *
     * @param int $amount_cents Amount in euro cents (e.g. 5000 = €50).
     * @return string|WP_Error Redirect URL on success, WP_Error on failure.
     */
    public function create_intent(int $amount_cents): string|WP_Error {
        $token = $this->oauth->get_access_token();
        if (is_wp_error($token)) return $token;

        $org_slug = get_option('dtim_ha_org_slug', '');
        if (!$org_slug) {
            return new WP_Error('ha_no_slug', __('HelloAsso organisation slug not configured.', 'defitim-helloasso'));
        }

        $endpoint = sprintf('%s/organizations/%s/checkout-intents',
            $this->oauth->get_base_url(),
            rawurlencode($org_slug)
        );

        $payload = [
            'totalAmount'     => $amount_cents,
            'initialAmount'   => $amount_cents,
            'itemName'        => 'Don — Un défi pour Tim',
            'backUrl'         => get_option('dtim_ha_back_url',   home_url('/#help')),
            'errorUrl'        => get_option('dtim_ha_error_url',  home_url('/?don=erreur')),
            'returnUrl'       => get_option('dtim_ha_return_url', home_url('/?don=merci')),
            'containsDonation'=> true,
        ];

        $response = wp_remote_post($endpoint, [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ],
            'body' => wp_json_encode($payload),
        ]);

        if (is_wp_error($response)) return $response;

        $code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if ($code !== 200 || empty($body['redirectUrl'])) {
            return new WP_Error('ha_checkout_error', sprintf(
                __('HelloAsso checkout error (HTTP %d).', 'defitim-helloasso'),
                $code
            ));
        }

        return $body['redirectUrl'];
    }
}
