<?php

namespace WPLinkSocial;

/**
 * @package WPLinkSocial
 * 
 * Plugin Name: WP Link Social
 * Plugin URI: http://github.com/stevekanger/wp-link-social.git
 * Description: Easy social media links. 
 * Version: 0.0.1
 * Author: Steve Kanger
 * Author URI: https://stevekanger.com
 * License: GPLv2 or later
 * Text Domain: wp-link-social
 * 
 * */

defined('ABSPATH') || exit;

const PLUGIN_NAME = 'WP Link Social';
const PLUGIN_PREFIX = 'wp_link_social';
const PLUGIN_API_ROUTE = 'wp-link-social/v1';
const PLUGIN_ROOT_FILE = __FILE__;
const PLUGIN_ROOT_DIR = __DIR__;

require_once __DIR__ . '/src/bootstrap.php';
