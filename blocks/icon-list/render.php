<?php
/**
 * Render callback for the Bodyloom Dynamic Icon List block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block content.
 * @var WP_Block $block      Block instance.
 */

use Bodyloom\DynamicIconList\Provider_Factory;
use Bodyloom\DynamicIconList\Renderer;

if (!defined('ABSPATH')) {
    exit;
}

// Map block style attributes to plugin settings format if needed
$settings = $attributes;

// Ensure defaults
$settings['data_type'] = isset($settings['data_type']) ? $settings['data_type'] : 'static';

// Get items from provider
$provider = Provider_Factory::get_provider($settings);
$items = $provider->get_items($settings);

// Render
echo Renderer::render($settings, $items);
