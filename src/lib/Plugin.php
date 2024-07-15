<?php

namespace WPLinkSocial\lib;

use const WPLinkSocial\PLUGIN_ROOT_FILE;
use const WPLinkSocial\PLUGIN_PREFIX;

defined('ABSPATH') || exit;

class Plugin {
    public static function init() {
        add_option(PLUGIN_PREFIX . '_social_links', []);
        register_activation_hook(PLUGIN_ROOT_FILE, [Plugin::class, 'activate']);
        register_deactivation_hook(PLUGIN_ROOT_FILE, [Plugin::class, 'deactivate']);
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_scripts']);
    }

    public static function activate() {
        // flush_rewrite_rules();
    }

    public static function deactivate() {
        // flush_rewrite_rules();
    }

    public static function enqueue_scripts() {
        if (get_option(PLUGIN_PREFIX . '_enqueue_font_awesome')) {
            wp_enqueue_style('wp-link-social-app', plugin_dir_url(PLUGIN_ROOT_FILE) . 'dist/wp-link-social-app.css', false, '0.0.1', 'all');
        }
    }
}
