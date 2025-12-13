<?php
/**
 * Plugin Name: Bodyloom Dynamic Icon List
 * Description: A versatile icon list plugin for WordPress (Elementor, Gutenberg, Shortcode) supporting static and dynamic content (ACF, Pods, Meta Box).
 * Version: 1.0.1
 * Author: Jimmy Thanki
 * Author URI: https://bodyloom.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bodyloom-dynamic-icon-list
 * Domain Path: /languages
 */

namespace Bodyloom\DynamicIconList;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Plugin Constants
define('BODYLOOM_DYNAMIC_ICON_LIST_VERSION', '1.0.1');
define('BODYLOOM_DYNAMIC_ICON_LIST_PATH', plugin_dir_path(__FILE__));
define('BODYLOOM_DYNAMIC_ICON_LIST_URL', plugin_dir_url(__FILE__));

// Autoloader
spl_autoload_register(function ($class) {
	$prefix = 'Bodyloom\\DynamicIconList\\';
	$base_dir = BODYLOOM_DYNAMIC_ICON_LIST_PATH . 'includes/';

	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		return;
	}

	$relative_class = substr($class, $len);
	$file = $base_dir . 'class-' . str_replace('_', '-', strtolower(str_replace('\\', '-', $relative_class))) . '.php';

	// Special case for interfaces and providers subdirectories
	if (strpos($relative_class, 'Interfaces\\') === 0) {
		$file = $base_dir . 'interfaces/interface-' . str_replace('_', '-', strtolower(substr($relative_class, 11))) . '.php';
	} elseif (strpos($relative_class, 'Providers\\') === 0) {
		$file = $base_dir . 'providers/class-' . str_replace('_', '-', strtolower(substr($relative_class, 10))) . '.php';
	}

	if (file_exists($file)) {
		require $file;
	}
});

// Initialize Plugin
function bodyloom_dynamic_icon_list_init()
{
	Plugin::get_instance();
}
// Activation/Deactivation Hooks
register_activation_hook(__FILE__, function () {
	// Activation logic if needed
});

register_deactivation_hook(__FILE__, function () {
	// Deactivation logic if needed
});

add_action('plugins_loaded', 'Bodyloom\\DynamicIconList\\bodyloom_dynamic_icon_list_init');
