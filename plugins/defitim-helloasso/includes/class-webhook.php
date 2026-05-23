<?php
defined('ABSPATH') || exit;

class DTIM_HA_Webhook {

    /**
     * Handle an incoming HelloAsso webhook.
     */
    public function handle(WP_REST_Request $request): WP_REST_Response {
        $secret    = get_option('dtim_ha_webhook_secret', '');
        $signature = $request->get_header('x-helloasso-signature');

        if ($secret && $signature) {
            $expected = base64_encode(hash_hmac('sha256', $request->get_body(), $secret, true));
            if (!hash_equals($expected, $signature)) {
                return new WP_REST_Response(['error' => 'Invalid signature'], 401);
            }
        }

        $payload = $request->get_json_params();
        if (empty($payload)) {
            return new WP_REST_Response(['error' => 'Empty payload'], 400);
        }

        $event_type = $payload['eventType'] ?? '';

        switch ($event_type) {
            case 'Order':
                $this->handle_order($payload);
                break;

            case 'Payment':
                $this->handle_payment($payload);
                break;

            default:
                // Unhandled event type — acknowledge without error
                break;
        }

        return new WP_REST_Response(['status' => 'ok'], 200);
    }

    private function handle_order(array $payload): void {
        $order = $payload['data'] ?? [];
        $amount_cents = (int) ($order['totalAmount'] ?? 0);
        $donor_email  = $order['payer']['email'] ?? '';

        // Update the live raised amount in ACF options if greater than current
        if ($amount_cents > 0 && function_exists('get_field')) {
            $current = (int) get_field('progress_raised', 'option');
            // This is intentionally additive — recalculate from HelloAsso dashboard if needed
            update_field('progress_raised', $current + $amount_cents / 100, 'option');
        }

        do_action('dtim_ha_order_received', $payload, $amount_cents, $donor_email);
    }

    private function handle_payment(array $payload): void {
        do_action('dtim_ha_payment_received', $payload);
    }
}
