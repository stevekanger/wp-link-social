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
        add_action('wp-link-social-show', [self::class, 'show_links']);
        add_action('wp-link-social-get', [self::class, 'get_links']);
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

    public static function show_links($args = NULL) {
        $links = get_option(PLUGIN_PREFIX . '_social_links');

        if (isset($args['walker'])) {
            call_user_func($args['walker'], $links);
            return;
        }

        if (isset($args['before'])) {
            echo $args['before'];
        }

        foreach ($links as $link) {
            echo '<a class="wp-link-social-' . $link['key'] . '" href="' . $link['url'] . '" title="' . $link['title'] . '" target="_blank" rel="me"><i class="' . $link['icon'] . '"></i></a>';
        }

        if (isset($args['after'])) {
            echo $args['after'];
        }
    }

    public static function get_links() {
        return get_option(PLUGIN_PREFIX . '_social_links');
    }
}
