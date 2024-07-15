<?php

namespace WPLinkSocial\lib;

use const WPLinkSocial\PLUGIN_PREFIX;

class Functions {
    public static function init() {
        add_action(PLUGIN_PREFIX . '_show_links', [Functions::class, 'show_links']);
        add_action(PLUGIN_PREFIX . '_get_links_raw', [Functions::class, 'get_links_raw']);
    }

    public static function get_links_raw() {
        return get_option(PLUGIN_PREFIX . '_social_links');
    }

    public static function show_links($args = NULL) {
        $links = self::get_links_raw();

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
}
