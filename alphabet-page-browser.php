<?php
/**
 * Plugin Name:       Alphabet Page Browser
 * Plugin URI:        https://github.com/naglaamossleh2016/alphabet-page-browser
 * Description:       Browse WordPress pages alphabetically with an A–Z sidebar, live search box, and full A–Z listing.
 * Version:           1.2.0
 * Author:            Naglaa Mossleh
 * Author URI:        https://github.com/naglaamossleh2016
 * Text Domain:       alphabet-page-browser
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('APB_PLUGIN_VERSION', '1.2.0');
define('APB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('APB_PLUGIN_URL', plugin_dir_url(__FILE__));

// ملف الشورت كود والمنطق الأساسي
require_once APB_PLUGIN_DIR . 'includes/shortcode.php';
