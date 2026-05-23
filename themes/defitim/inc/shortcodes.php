<?php
/**
 * Shortcodes for dynamic sections — usable inside Elementor via the Shortcode widget.
 *
 * [defitim_defis]    — Challenges list (CPT-powered)
 * [defitim_progress] — Fundraising progress bar (ACF options)
 * [defitim_help]     — Donation section with HelloAsso button (ACF options)
 * [defitim_faq]      — FAQ accordion (ACF options)
 * [defitim_sponsors] — Sponsor logos (ACF options)
 * [defitim_contact]  — Contact form + cards (ACF options)
 */
defined('ABSPATH') || exit;

foreach ([
    'defitim_defis'    => 'defis',
    'defitim_progress' => 'progress',
    'defitim_help'     => 'help',
    'defitim_faq'      => 'faq',
    'defitim_sponsors' => 'sponsors',
    'defitim_contact'  => 'contact',
] as $tag => $part) {
    add_shortcode($tag, function() use ($part) {
        ob_start();
        get_template_part('template-parts/' . $part);
        return ob_get_clean();
    });
}
