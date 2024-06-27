<?php

namespace WPLinkSocial\lib;

use const WPLinkSocial\PLUGIN_ROOT_DIR;

defined('ABSPATH') || exit;

class Template {
    public static function include($template, $data = []) {
        if (!$template) {
            return;
        }

        $file = PLUGIN_ROOT_DIR . '/src/templates/' . $template . '.php';

        if (!file_exists($file)) {
            return;
        }

        include $file;
    }
}
