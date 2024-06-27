<?php

namespace WPLinkSocial\lib;

use const WPLinkSocial\PLUGIN_PREFIX;

defined('ABSPATH') || exit;

class Widgets {
    public static function init() {
        add_action('widgets_init', [self::class, 'register_widgets']);
    }

    public static function register_widgets() {
        register_widget(__NAMESPACE__ . '\Widget_Links');
    }
}

class Widget_Links extends \WP_Widget {
    public function __construct() {
        $id = PLUGIN_PREFIX . '_widget_links';

        $options = [
            'classname' => $id,
            'description' => __('Display your social links.', 'wp-link-social'),
        ];

        parent::__construct($id, __('WP Link Social Links', 'wp-link-social'), $options);
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        Plugin::show_links();
        echo $args['after_widget'];
    }

    public function form($instance) {
    }

    public function update($new_instance, $old_instance) {
    }
}
