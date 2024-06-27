<?php

namespace WPLinkSocial;

use WPLinkSocial\lib\Admin;
use WPLinkSocial\lib\Api;
use WPLinkSocial\lib\Plugin;
use WPLinkSocial\lib\Widgets;

defined('ABSPATH') || exit;

require_once __DIR__ . '/lib/Admin.php';
require_once __DIR__ . '/lib/Api.php';
require_once __DIR__ . '/lib/Data.php';
require_once __DIR__ . '/lib/Plugin.php';
require_once __DIR__ . '/lib/Template.php';
require_once __DIR__ . '/lib/Utils.php';
require_once __DIR__ . '/lib/Widgets.php';

Admin::init();
Api::init();
Plugin::init();
Widgets::init();
