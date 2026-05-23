<?php
defined('ABSPATH') || exit;

/* ============================================================
   AJAX CONTACT FORM
   ============================================================ */
function defitim_handle_contact() {
    if (!check_ajax_referer('defitim_contact', 'nonce', false)) {
        wp_send_json_error(['message' => __('Sécurité : token invalide.', 'defitim')], 403);
    }

    $name    = sanitize_text_field(wp_unslash($_POST['nom']    ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['email']  ?? ''));
    $subject = sanitize_text_field(wp_unslash($_POST['sujet']  ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    if (!$name || !is_email($email) || !$subject || !$message) {
        wp_send_json_error(['message' => __('Tous les champs sont requis.', 'defitim')], 422);
    }

    $to      = dt_opt('contact_email', get_option('admin_email'));
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . esc_html($name) . ' <' . sanitize_email($email) . '>',
        'Reply-To: ' . sanitize_email($email),
    ];
    $body = sprintf(
        "Nom : %s\nEmail : %s\n\nMessage :\n%s",
        $name, $email, $message
    );

    $sent = wp_mail($to, '[Défi Tim] ' . $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => __('Message envoyé.', 'defitim')]);
    } else {
        wp_send_json_error(['message' => __('Erreur lors de l\'envoi. Veuillez nous écrire directement.', 'defitim')], 500);
    }
}
add_action('wp_ajax_defitim_contact',        'defitim_handle_contact');
add_action('wp_ajax_nopriv_defitim_contact', 'defitim_handle_contact');
