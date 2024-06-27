<?php

namespace WPLinkSocial\lib;

use const WPLinkSocial\PLUGIN_API_ROUTE;
use const WPLinkSocial\PLUGIN_PREFIX;

defined('ABSPATH') || exit;

class Api {
    public static function init() {
        add_action('rest_api_init', [self::class, 'register_routes']);
    }

    public static function register_routes() {
        register_rest_route(PLUGIN_API_ROUTE, '/social-links', [
            [
                'methods' => "POST",
                'callback' => [self::class, 'update_links_route_cb'],
                'accept_json' => true,
                'permission_callback' => function () {
                    return current_user_can('edit_themes');
                },
            ], [
                'methods' => "GET",
                'callback' => [self::class, 'get_links_route_cb'],
                'accept_json' => true,
                'permission_callback' => function () {
                    return current_user_can('edit_themes');
                },
            ]
        ]);
    }

    public static function get_links_route_cb() {
        $links = get_option(PLUGIN_PREFIX . '_social_links');
        return json_encode([
            'success' => true,
            'msg' => 'Retrieved links successfully.',
            'links' => $links
        ]);
    }

    public static function update_links_route_cb($req) {
        $body = $req->get_body();

        if (!$body) {
            return json_encode([
                'success' => false,
                'msg' => 'No request body found.'
            ]);
        }

        $body = json_decode($body, true);
        $links = $body['links'];

        foreach ($links as $i => $link) {
            $links[$i]['url'] = esc_html($link['url']);
        }

        update_option(PLUGIN_PREFIX . '_social_links', $links);
        return json_encode([
            'success' => true,
            'msg' => 'Updated links successfully.',
        ]);
    }
}
