<?php

namespace WPLinkSocial\lib;

use WPLinkSocial\lib\Template;
use const WPLinkSocial\PLUGIN_PREFIX;
use const WPLinkSocial\PLUGIN_ROOT_FILE;

class Admin {
    public static function init() {
        add_action('init', [self::class, 'register_settings']);
        add_action('admin_menu', [self::class, 'register_menus']);
        add_action('admin_init', [self::class, 'register_settings_sections']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_scripts']);
    }

    public static function enqueue_scripts($hook) {
        if ($hook === 'toplevel_page_' . PLUGIN_PREFIX) {
            wp_enqueue_style('wp-link-social-admin', plugin_dir_url(PLUGIN_ROOT_FILE) . 'dist/wp-link-social-admin.css', false, '0.0.1', 'all');
            wp_enqueue_script('wp-link-social-admin', plugin_dir_url(PLUGIN_ROOT_FILE) . 'dist/wp-link-social-admin.js', ["jquery", "jquery-ui-sortable"], '0.0.1', true);

            wp_localize_script(
                'wp-link-social-admin',
                'wpData',
                array(
                    'nonce' => wp_create_nonce('wp_rest'),
                    'supportedNetworks' => Data::$supported_profile_networks,
                    'links' => get_option(PLUGIN_PREFIX . '_social_links')
                )
            );
        }
    }

    public static function register_menus() {
        add_menu_page(
            __('Social Links', 'wp-link-social'),
            __('Social Links', 'wp-link-social'),
            'activate_plugins',
            PLUGIN_PREFIX,
            [self::class, 'links_page_callback'],
            'dashicons-groups',
            55.5
        );

        add_submenu_page(
            PLUGIN_PREFIX,
            __('Manage Social Links', 'wp-link-social'),
            __('Manage Social Links', 'wp-link-social'),
            "activate_plugins",
            PLUGIN_PREFIX
        );

        add_submenu_page(
            PLUGIN_PREFIX,
            __('Settings', 'wp-link-social'),
            __('Settings', 'wp-link-social'),
            "activate_plugins",
            PLUGIN_PREFIX . '_settings',
            [self::class, 'settings_page_callback']

        );
    }

    public static function register_settings() {
        register_setting(PLUGIN_PREFIX, PLUGIN_PREFIX . '_enqueue_font_awesome', [
            'type' => 'boolean',
            'default' => true,
            'description' => __('Enqueue Font Awesome CSS', 'wp-link-social'),
            'show_in_rest' => false,
        ]);
    }

    public static function register_settings_sections() {
        add_settings_section(PLUGIN_PREFIX . '_settings', 'Settings', $section['callback'] ?? [self::class, 'settings_section_callback'], PLUGIN_PREFIX, []);
        add_settings_field(
            PLUGIN_PREFIX . '_enqueue_font_awesome',
            __('Enqueue Font Awesome CSS', 'wp-link-social'),
            [self::class, 'settings_callback'],
            PLUGIN_PREFIX,
            PLUGIN_PREFIX . '_settings',
            [
                'id' => PLUGIN_PREFIX . '_enqueue_font_awesome',
                'template' => 'ui/settings_checkbox',
                'value' => get_option(PLUGIN_PREFIX . '_enqueue_font_awesome'),
                'description' => __('Whether or not to include the font awesome css (font awesome brands) in your theme. Uncheck if you are already using it in your theme.', 'wp-link-social'),
            ]
        );
    }

    public static function links_page_callback() {
        Template::include('pages/admin_links');
    }

    public static function settings_page_callback() {
        Template::include('pages/admin_settings');
    }

    public static function settings_section_callback() {
        echo '<p>Social links settings.</p>';
    }

    public static function settings_callback($data) {
        Template::include($data['template'], $data);
    }
}
